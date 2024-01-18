<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
class TableFuncs {
  function raw($col, $row, $params) {
    return $row[$col['name']];
  }
  function _link_common($col, $row, $params, $url, $rpt_colname=NULL) {
    if ($rpt_colname and isset($params['rpt']) and isset($params['rpt_colnames'])
        and in_array($rpt_colname, $params['rpt_colnames'])) {
      assert($row[".seqno"] !== NULL);
      $url .= '&amp;rpt='.HURL($params['rpt'])
              . '&amp;seqno='.HURL($row['.seqno']);
    }
    $s = '<a ';
    if (isset($col['link_class'])) {
      $s .= 'class="'.$col['link_class'].'" ';
    }
    $s .= 'href="'.$url.'">'.H($row[$col['name']]).'</a>';
    return $s;
  }
  function item_cart_add($col, $row, $params) {
    global $tab;	# FIXME - get rid of $tab
    $url = '../shared/cart_add.php?name=bibid&amp;id[]='.HURL($row['bibid']).'&amp;tab='.HURL($tab);
    return TableFuncs::_link_common($col, $row, $params, $url);
  }
  function item_cart_del($col, $row, $params) {
    global $tab;	# FIXME - get rid of $tab
    $url = '../shared/cart_del.php?name=bibid&amp;id[]='.HURL($row['bibid']).'&amp;tab='.HURL($tab);
    return TableFuncs::_link_common($col, $row, $params, $url);
  }
  function biblio_link($col, $row, $params) {
    global $tab;	# FIXME - get rid of $tab
    $url = '../shared/biblio_view.php?bibid='.HURL($row['bibid']);
    if ($tab != 'opac') {
      $url .= '&amp;tab=cataloging';
    } else {
      $url .= '&amp;tab=opac';
    }
    return TableFuncs::_link_common($col, $row, $params, $url, 'bibid');
  }
  function subject_link($col, $row, $params) {
    global $tab;	# FIXME - get rid of $tab
    $url = '../shared/biblio_search.php?searchType=subject&amp;exact=1&amp;searchText='.HURL($row['subject']);
    if ($tab != 'opac') {
      $url .= '&amp;tab=cataloging';
    } else {
      $url .= '&amp;tab=opac';
    }
    return TableFuncs::_link_common($col, $row, $params, $url);
  }
  function series_link($col, $row, $params) {
    global $tab;	# FIXME - get rid of $tab
    $url = '../shared/biblio_search.php?searchType=series&amp;exact=1&amp;searchText='.HURL($row['series']);
    if ($tab != 'opac') {
      $url .= '&amp;tab=cataloging';
    } else {
      $url .= '&amp;tab=opac';
    }
    return TableFuncs::_link_common($col, $row, $params, $url);
  }
  function booking_link($col, $row, $params) {
    $url = '../circ/booking_view.php?bookingid='.HURL($row['bookingid']);
    return TableFuncs::_link_common($col, $row, $params, $url, 'bookingid');
  }
  function member_link($col, $row, $params) {
    $url = '../circ/mbr_view.php?mbrid='.HURL($row['mbrid']);
    return TableFuncs::_link_common($col, $row, $params, $url, 'mbrid');
  }
  function site_link($col, $row, $params) {
    $url = '../admin/sites_edit_form.php?siteid='.HURL($row['siteid']);
    return TableFuncs::_link_common($col, $row, $params, $url, 'siteid');
  }
  function calendar_link($col, $row, $params) {
    $url = '../admin/calendar_edit_form.php?calendar='.HURL($row['calendar']);
    return TableFuncs::_link_common($col, $row, $params, $url, 'calendar');
  }
  function checkbox($col, $row, $params) {
    assert($col["checkbox_name"] != NULL);
    assert($col["checkbox_value"] != NULL );
    $s = '<input type="checkbox" ';
    $s .= 'name="'.H($col['checkbox_name']).'" ';
    $s .= 'value="'.H($row[$col['checkbox_value']]).'" ';
    if (isset($col['checkbox_checked']) and $col['checkbox_checked'] === true) {
      $s .= 'checked="checked" ';
    } elseif (is_string($col['checkbox_checked'])) {
      if (strtolower($row[$col['checkbox_checked']]) == 'y') {
        $s .= 'checked="checked" ';
      }
    }
    $s .= '/>';
    return $s;
  }
  function select($col, $row, $params) {
    assert($col["select_name"] != NULL);
    assert($col["select_index"] != NULL);
    assert($col["select_key"] != NULL);
    assert($col["select_value"] != NULL );
    $name = $col['select_name'].'['.$row[$col['select_index']].']';
    $data = array();
    foreach ($row[$col['name']] as $r) {
      $data[$r[$col['select_key']]] = $r[$col['select_value']];
    }
    if (isset($col['select_selected']) and isset($row[$col['select_selected']])) {
      $selected = $row[$col['select_selected']];
    } else {
      $selected = '';
    }
    return inputfield('select', $name, $selected, NULL, $data);
  }
  function member_list($col, $row, $params) {
    $s = '';
    foreach ($row[$col['name']] as $m) {
      $s .= '<a href="../circ/mbr_view.php?mbrid='.HURL($m['mbrid']).'">'
            . H($m['first_name']).' '.H($m['last_name']).' ('.H($m['site_code']).')'
            . '</a>, ';
    }
    return substr($s, 0, -2);  # lose the final ', '
  }
}

?>