<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */

require_once("../classes/TableFuncs.php");
require_once("../functions/inputFuncs.php");

class Table
{
  var $_cols;
  var $_params;
  var $_rown;
  var $_echolink;
  var $_checkbox;
  var $_idcol;
  var $_loc;
  var $_checked = false;

  //Changes PVD(8.0.x)
  function __construct($echolink = NULL, $checkbox = false)
  {
    $this->_echolink = $echolink;
    $this->_checkbox = $checkbox;
    $this->_cols = array();
    $this->_params = array();
    $this->_loc = new Localize(OBIB_LOCALE, "reports");
  }
  function columns($cols)
  {
    $this->_cols = array_merge($this->_cols, $cols);
  }
  function parameters($params)
  {
    $this->_params = array_merge($this->_params, $params);
    if (isset($this->_params['idcol'])) {
      $this->_idcol = $this->_params['idcol'];
    }
  }
  function start()
  {
    $echolink = $this->_echolink;
    $this->_rown = 1;
    echo "<table class='results'>\n";
    echo "<tr>\n";
    if ($this->_checkbox) {
      foreach ($this->_cols as $col) {
        if (!$this->_idcol and $col['checkbox']) {
          $this->_idcol = $col['name'];
          if (isset($col['checked']) and $col['checked'] === true) {
            $this->_checked = true;
          }
        }
      }
      echo '<td valign="middle" align="center" class="primary">';
      echo '<font class="small">';
      echo '<b>All</b><br />';
      echo '<input type="checkbox" name="all" value="all" onclick="setCheckboxes()" ';
      if ($this->_checked) {
        echo 'checked="checked" ';
      }
      echo '/>';
      echo '</font>';
    }
    foreach ($this->_cols as $col) {
      if (isset($col['hidden']) and $col['hidden']) {
        continue;
      }
      if (!isset($col['title']) or !$col['title']) {
        $col['title'] = $col['name'];
      }
      echo '<td valign="middle" align="center" class="primary">';
      echo '<font class="small"><b>' . $this->_loc->getText($col['title']) . '</b></font>';
      if (isset($col['sort']) and $col['sort'] and $echolink) {
        echo "<br><nobr>";
        $echolink(
          1,
          "<img border='0' src='../images/down.png' alt='&darr;'>",
          $col['sort']
        );
        $echolink(
          1,
          "<img border='0' src='../images/up.png' alt='&uarr;'>",
          $col['sort'] . '!r'
        );
        echo "</nobr>";
      }
      echo "</td>\n";
    }
    echo "</tr>\n";
  }
  function row($row)
  {
    $class = array('primary', 'alt1');
    echo "<tr>\n";
    if ($this->_checkbox) {
      echo '<td class="' . H($class[$this->_rown % 2]) . '" align="center">';
      if ($this->_idcol) {
        echo '<input type="checkbox" name="id[]" ';
        echo 'value="' . H($row[$this->_idcol]) . '" ';
        if ($this->_checked) {
          echo 'checked="checked" ';
        }
        echo '/>';
      }
      echo "</td>\n";
    }
    foreach ($this->_cols as $col) {
      if (isset($col['hidden']) and $col['hidden']) {
        continue;
      }
      echo '<td class="' . H($class[$this->_rown % 2]) . '"';
      if (isset($col['align'])) {
        echo 'align="' . H($col['align']) . '"';
      }
      echo '>';
      if (isset($col['func']) and in_array($col['func'], get_class_methods('TableFuncs'))) {
        $func_name = $col['func'];
        echo (new TableFuncs)->$func_name($col, $row, $this->_params);
      } else {
        if(isset($row[$col['name']]))
          echo H($row[$col['name']]);
      }
      echo "</td>\n";
    }
    echo "</tr>\n";
    $this->_rown++;
  }
  function end()
  {
    echo "</table>\n";
  }
}

?>