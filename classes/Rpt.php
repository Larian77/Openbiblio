<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
require_once("../classes/Query.php");
require_once("../classes/RptIter.php");
require_once("../classes/RptParser.php");

class Rpt {
    //Changes PVD(8.0.x) **Start
    var $_title;
    var $_category;
    var $_layouts;
    var $_columns;
    var $_paramdefs;
    var $_code;
    var $_interp;
    //Changes PVD(8.0.x) **End
  function load_e($filename) {
    $this->_title = $filename;
    $this->_category = 'Misc.';
    $this->_layouts = array();
    $this->_columns = array();
    $this->_paramdefs = array();
    $this->_code = array();
    $this->_interp = NULL;

    $parser = new RptParser;
    list($decls, $err) = $parser->load_e($filename);
    if ($err) {
      return $err;
    }
    foreach ($decls as $decl) {
      list($name, $value) = $decl;
      switch ($name) {
        case 'title':
          $this->_title = $value;
          break;
        case 'category':
          $this->_category = $value;
          break;
        case 'layout':
          $this->_layouts[] = $value;
          break;
        case 'column':
          $this->_columns[] = $value;
          break;
        case 'parameters':
          $this->_paramdefs = array_merge($this->_paramdefs, $value);
          break;
        case 'sql':
          array_push($this->_code, $value);
          break;
        default:
        //Changes PVD(8.0.x)
        (new Fatal)->internalError("Can't happen");
      }
    }
    return NULL;
  }
  function title() {
    return $this->_title;
  }
  function category() {
    return $this->_category;
  }
  function layouts() {
    return $this->_layouts;
  }
  function paramDefs() {
    return $this->_paramdefs;
  }
  function columns() {
    return $this->_columns;
  }
  function select($params) {
    return new RptIter($this->_code, $params);
  }
}

?>
