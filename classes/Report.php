<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */

require_once("../classes/Params.php");

/* A report should always be created with Report::load() or
 * Report::create_e(), never with new Report().  Create() makes a new
 * report of the given type.  If the report is given a name, it will be
 * saved in the session in a way that does not depend on storing
 * objects in the session.  Load() loads a named report from data
 * stored in the session.
 *
 * Link() returns an URL for linking to the results of a named report.
 * An optional message may be supplied for display on the results
 * page.
 * 
 * Public instance methods:
 *   title(), layouts(), paramDefs(), init(), variant_el(), columns(), columnNames(),
 *   count(), curPage(), row(), each(), table(), and pageTable()
 */
class Report
{
    var $name;
    var $rpt;
    var $params;
    var $iter;
    var $cache;
    var $pointer = 0;
    function link($name, $msg = '', $tab = '')
    {
        $urls = array(
            'Report' => '../reports/run_report.php?type=previous&msg=',
            'BiblioSearch' => '../shared/biblio_search.php?searchType=previous&msg=',
        );
        if (isset($urls[$name])) {
            $url = $urls[$name];
        } else {
            $url = '../reports/index.html?msg=';
        }
        $url .= U($msg);
        if ($tab) {
            $url .= '&tab=' . U($tab);
        }
        return $url;
    }
    function create_e($type, $name = NULL)
    {
        $cache = array('type' => $type);
        $rpt = new Report;
        $err = $rpt->_load_e($name, $cache);
        return array($rpt, $err);
    }
    function load($name)
    {
        if (!isset($_SESSION['rpt_' . $name])) {
            return NULL;
        }
        $rpt = new Report;
        $err = $rpt->_load_e($name, $_SESSION['rpt_' . $name]);
        if ($err) {
            unset($_SESSION['rpt_' . $name]);
            //Changes PVD(8.0.x)
            (new Fatal)->internalError("Couldn't load cached report: $name");
        }
        return $rpt;
    }
    function _load_e($name, $cache)
    {
        $this->name = $name;
        $re = '/^[-_A-Za-z0-9]+$/'; # To avoid quoting distopia.
        assert(preg_match($re, $cache["type"]));
        $fname = '../reports/defs/' . $cache['type'];
        if (is_readable($fname . '.php')) {
            $err = $this->_load_php_e($cache['type'], $fname . '.php');
        } elseif (is_readable($fname . '.rpt')) {
            $err = $this->_load_rpt_e($cache['type'], $fname . '.rpt');
        }
        if ($err) {
            return $err;
        }
        $this->cache = $cache;
        if (array_key_exists('params', $cache) and is_array($cache['params'])) {
            $this->params = new Params;
            $this->params->loadDict($cache['params']);
        }
        return NULL;
    }
    function _load_php_e($type, $fname)
    {
        $classname = $type . '_rpt';
        include_once($fname);
        $this->rpt = new $classname;
        return NULL; # Can't error non-fatally
    }
    function _load_rpt_e($type, $fname)
    {
        require_once('../classes/Rpt.php');
        $rpt = new Rpt;
        $err = $rpt->load_e($fname);
        if ($err) {
            return $err;
        } else {
            $this->rpt = $rpt;
        }
    }
    function type()
    {
        return $this->cache['type'];
    }
    function title()
    {
        return $this->rpt->title();
    }
    function category()
    {
        return $this->rpt->category();
    }
    function layouts()
    {
        return $this->rpt->layouts();
    }
    function paramDefs()
    {
        return $this->rpt->paramDefs();
    }
    function columns()
    {
        return $this->rpt->columns();
    }
    function columnNames()
    {
        //Changes PVD(8.0.x)
        return array_map(function ($x) {
            return $x["name"]; }, $this->columns());
    }
    function init_el($params)
    {
        assert(is_array($params));
        $p = new Params;
        $errs = $p->load_el($this->rpt->paramDefs(), $params);
        if (!empty($errs)) {
            return $errs;
        }
        return $this->_init_el($p);
    }
    function initCgi_el($prefix = 'rpt_')
    {
        $p = new Params;
        $errs = $p->loadCgi_el($this->rpt->paramDefs(), $prefix);
        if (!empty($errs)) {
            return $errs;
        }
        return $this->_init_el($p);
    }
    function _init_el($params)
    {
        unset($this->cache['params']);
        $this->params = $params;
        $this->cache['params'] = $params->dict;
        $this->_save();
        return array();
    }
    function variant_el($newParams, $newName = NULL)
    {
        assert(is_array($this->cache["params"]));
        if ($newName === NULL) {
            $newName = $this->name;
        }
        list($rpt, $err) = Report::create_e($this->cache['type'], $newName);
        if ($err) {
            //Changes PVD(8.0.x)
            (new Fatal)->internalError("Unexpected report creation error: " . $err->toStr());
        }
        $params = new Params;
        $params->loadDict($this->cache['params']);
        $errs = $params->load_el($rpt->rpt->paramDefs(), $newParams);
        if (!empty($errs)) {
            return array(NULL, $errs);
        }
        $errs = $rpt->_init_el($params);
        if (!empty($errs)) {
            return array(NULL, $errs);
        }
        return array($rpt, array());
    }
    function curPage()
    {
        if (isset($this->cache['page']) and $this->cache['page']) {
            return $this->cache['page'];
        } else {
            return 1;
        }
    }
    function _getIter()
    {
        if (isset($this->iter) && $this->iter) {
            return;
        } else {
            $this->iter = new NumberedIter($this->rpt->select($this->params));
        }
    }
    function count()
    {
        if (!isset($this->cache['count']) || $this->cache['count'] === NULL) {
            $this->_getIter();
            $this->cache['count'] = $this->iter->count();
            $this->_save();
        }
        return $this->cache['count'];
    }
    function each()
    {
        $this->_getIter();
        return $this->iter->next();
    }
    function row($num)
    {
        if (isset($this->cache['rows'][$num])) {
            return $this->cache['rows'][$num];
        }
        $first = max(0, $num - floor(OBIB_ITEMS_PER_PAGE / 2));
        $this->_cacheSlice($first);
        if (isset($this->cache['rows'][$num])) {
            return $this->cache['rows'][$num];
        } else {
            return NULL;
        }
    }
    function _cacheSlice($skip, $len = OBIB_ITEMS_PER_PAGE)
    {
        $first = min($skip, $this->count() - 1);
        $last = min($skip + $len - 1, $this->count() - 1);
        if (
            isset($this->cache['rows'])
            and isset($this->cache['rows'][$first])
            and isset($this->cache['rows'][$last])
        ) {
            return;
        }
        $this->iter = NULL;
        $this->_getIter();
        $this->iter = new SliceIter($skip, $len, $this->iter);
        $this->cache['rows'] = array();
        while (($row = $this->iter->next()) !== NULL) {
            $this->cache['rows'][$row['.seqno']] = $row;
        }
        $this->_save();
    }
    function _cachePage($page)
    {
        $this->_cacheSlice(($page - 1) * OBIB_ITEMS_PER_PAGE);
    }
    function _save()
    {
        if ($this->name) {
            $_SESSION['rpt_' . $this->name] = $this->cache;
        }
    }
    function table($table = NULL, $doCols = true)
    {
        if (!$table) {
            require_once('../classes/Table.php');
            $table = new Table;
        }
        if ($doCols) {
            $table->columns($this->columns());
        }
        if ($this->name) {
            $table->parameters(
                array(
                    'rpt' => $this->name,
                    'rpt_colnames' => $this->columnNames()
                )
            );
        }
        $table->start();
        while (($row = $this->each()) !== NULL) {
            $table->row($row);
        }
        $table->end();
    }
    function pageTable($page, $table = NULL, $doCols = true)
    {
        if (!isset($this->cache['page']) or $page != $this->cache['page']) {
            $this->cache['page'] = $page;
            $this->_save();
        }
        $this->_cachePage($page);
        if (!$table) {
            require_once('../classes/Table.php');
            $table = new Table;
        }
        if ($doCols) {
            $table->columns($this->columns());
        }
        if ($this->name) {
            $table->parameters(
                array(
                    'rpt' => $this->name,
                    'rpt_colnames' => $this->columnNames()
                )
            );
        }
        $table->start();
        foreach ($this->cache['rows'] as $row) {
            $table->row($row);
        }
        $table->end();
    }
}

?>