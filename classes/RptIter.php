<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
class RptIter extends Iter {
  # These are private.
  var $params;
  var $iter;
  var $subselects;
  //Changes PVD(8.0.x)
  var $q;
  
  # $sqls is a list of tuples of array($code, $subselects).
  # $code contains the code elements which construct a single
  # SQL query.  $subselects is a list of lists of code elements.  Each
  # toplevel list contains the code elements which construct a single
  # SQL subselect query.
  # A code element is an array in one of the following forms:
  #	array('sqlcode', $sql)
  #		$sql is SQL text to be appended to the query
  #	array('value', $name, $conv)
  #		$name is a parameter name whose value should
  #		be substituted into the query using mkSQL conversion
  #		$conv.
  #	array('if_set', $name, $then, $else)
  #		$then and $else are lists of code elements.  $then
  #		is evaluated if the parameter named $name is set,
  #		$else otherwise.
  #	array('if_equal', $name, $value, $then, $else)
  #		$then and $else are lists of code elements.  $then
  #		is evaluated if the first value of the parameter named
  #		$name is equal to the string $value, $else otherwise.
  #	array('if_not_equal', $name, $value, $then, $else)
  #		$then and $else are lists of code elements.  $then
  #		is evaluated if the first value of the parameter named
  #		$name is not equal to the string $value, $else otherwise.
  #	array('foreach_parameter', $name, $block)
  #		For each value in the parameter list named $name,
  #		the list of code elements in $block is evaluated with
  #		the parameter $name set to each successive value of
  #		$name.
  #	array('foreach_word', $name, $block)
  #		Splits the value of the parameter named $name into
  #		words and, for each word, evaluates the list of code
  #		elements in $block with the parameter $name set to
  #		each word in turn.
  #	array('order_by_expr')
  #		An appropriate SQL ORDER BY clause is appended to
  #		the query at this point.

  //Changes PVD(8.0.x)
  function __construct($sqls, $params) {
    $this->params = $params;
    $this->q = new Query();
    foreach ($sqls as $s) {
      list($code, $subs) = $s;
      $sql = $this->_exec($code, $params);
      # I don't like having to differentiate selects here.  It might be
      # better for the Rpt syntax to indicate whether a query is expected
      # to return rows or not.
      if (strncasecmp(trim($sql), 'select', strlen('select')) != 0) {
        $this->q->act($sql);
      } else {
        $this->iter = $this->q->select($sql);
        $this->subselects = $subs;
      }
    }
  }
  function count() {
    return $this->iter->count();
  }
  function skip() {
    return $this->iter->skip();
  }
  function next() {
    $row = $this->iter->next();
    if ($row === NULL) {
      return $row;
    }
    $scope = $this->params->copy();
    foreach ($row as $n => $v) {
      $scope->set($n, 'string', $v);
    }
    foreach ($this->subselects as $name => $sql) {
      if ($sql[0] != 'sql') {
        //Changes PVD(8.0.x)
        (new Fatal)->internalError('Broken RPT code structure');
      }
      $iter = new RptIter(array($sql[1]), $scope);
      $row[$name] = $iter->toArray();
    }
    return $row;
  }
  function _exec($code, $scope) {
    $query = '';
    foreach ($code as $c) {
      switch ($c[0]) {
        case 'sqlcode':
          list( , $sql) = $c;
          $query .= $sql;
          break;
        case 'value':
          list( , $name, $conv) = $c;
          list($type, $value) = $scope->getFirst($name);
          $query .= $this->q->mkSQL($conv, $value);
          break;
        case 'if_set':
          list( , $name, $then, $else) = $c;
          if ($scope->exists($name)) {
            $query .= $this->_exec($then, $scope);
          } else {
            $query .= $this->_exec($else, $scope);
          }
          break;
        case 'if_equal':
          list( , $name, $value, $then, $else) = $c;
          if (!$scope->exists($name)) {
            $query .= $this->_exec($else, $scope);
          } else {
            list($t, $v) = $scope->getFirst($name);
            if ($v == $value) {
              $query .= $this->_exec($then, $scope);
            } else {
              $query .= $this->_exec($else, $scope);
            }
          }
          break;
        case 'if_not_equal':
          list( , $name, $value, $then, $else) = $c;
          if (!$scope->exists($name)) {
            $query .= $this->_exec($then, $scope);
          } else {
            list($t, $v) = $scope->getFirst($name);
            if ($v != $value) {
              $query .= $this->_exec($then, $scope);
            } else {
              $query .= $this->_exec($else, $scope);
            }
          }
          break;
        case 'foreach_parameter':
        case 'foreach_word':
          list($type, $name, $block) = $c;
          if ($type == 'foreach_parameter') {
            $vlist = $scope->getList($name);
          } else {
            include_once("../classes/Search.php");
            list($t, $v) = $scope->getFirst($name);
            if ($t != "string") {
                //Changes PVD(8.0.x)
              (new Fatal)->internalError('$t != "string"');
            }
            $vlist = array();
            //Changes PVD(8.0.x)
            foreach ((new Search)->explodeQuoted($v) as $w) {
              $vlist[] = array('string', $w);
            }
          }
          foreach ($vlist as $v) {
            list($type, $value) = $v;
            $s = $scope->copy();
            $s->set($name, $type, $value);
            $query .= $this->_exec($block, $s);
          }
          break;
        case 'order_by_expr':
          if ($v = $scope->getFirst('order_by')) {
            list($type, $value, $raw) = $v;
            if ($type != "order_by") {
                //Changes PVD(8.0.x)
              (new Fatal)->internalError('$type != "order_by"');
            }
            $query .= 'order by '.$value.' ';
          }
          break;
        default:
        //Changes PVD(8.0.x)
          (new Fatal)->internalError("Can't happen");
          break;
      }
    }
    return $query;
  }
}

?>