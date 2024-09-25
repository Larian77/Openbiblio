<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */

require_once("../classes/Localize.php");
require_once("../classes/Date.php");

class Form {
  function T($msg, $vars=NULL) {
    # Kludge to adapt 1.0-pre code to 0.6
    static $loc = NULL;
    if ($loc == NULL)
      $loc = new Localize(OBIB_LOCALE, 'classes');
    return $loc->getText($msg, $vars);
  }
  function getCgi_el($fields) {
    $fields = (new Form)->_cleanFields($fields);
    $errors = array();
    $values = array();
    if (isset($_REQUEST['_posted']))
      $values['_posted'] = $_REQUEST['_posted'];
    else
      $values['_posted'] = false;
    foreach ($fields as $f) {
      if ($f['type'] == 'fixed')
        continue;
      if ($f['type'] == 'bool' and (!isset($_REQUEST[$f['name']])
          or $_REQUEST[$f['name']] != 'Y'))
        $_REQUEST[$f['name']] = 'N';
      if ($f['type'] == 'file') {
        if (isset($_FILES[$f['name']]))
          $values[$f['name']] = $_FILES[$f['name']];
        else
          $values[$f['name']] = NULL;
        continue;
      }
      if (isset($_REQUEST[$f['name']]))
        $values[$f['name']] = $_REQUEST[$f['name']];
      else
        $values[$f['name']] = $f['default'];
      if ($f['required'] and $values[$f['name']] == '') {
        $errors[] = new FieldError($f['name'], (new Form)->T("This field must be filled in."));
        continue;
      }
      if ($f['type'] == 'select') {
        if (!isset($f['options'][$values[$f['name']]])) {
          $errors[] = new FieldError($f['name'], (new Form)->T("Choose a valid value from the list."));
        }
      } else if ($f['type'] == 'date') {
        //Changes PVD(8.0.x)
        list($val, $err) = (new Date)->read_e($values[$f['name']]);
        if ($err)
          $errors[] = new FieldError($f['name'], $err->toStr());
        else
          $values[$f['name']] = $val;
      }
    }
    return array($values, $errors);
  }
  function display($params) {
    $defaults = array(
      'title'=>'',
      'name'=>NULL,
      'method'=>'post',
      'enctype'=>NULL,
      'action'=>NULL,
      'submit'=>(new Form)->T('Submit'),
      'cancel'=>NULL,
      'fields'=>array(),
      'values'=>array(),
      'errors'=>array(),
    );
    $params = array_merge($defaults, $params);
    if (!$params['action']) {
        //Changes PVD(8.0.x)
      (new Fatal)->internalError((new Form)->T("No form action"));
    }
    $fields = (new Form)->_cleanFields($params['fields']);
    echo "<form method='".H($params['method'])."' action='".H($params['action'])."'";
    if ($params['name']) {
      echo ' name="'.H($params['name']).'" id="'.H($params['name']).'"';
    }
    if ($params['enctype']) {
      echo ' enctype="'.H($params['enctype']).'"';
    }
    echo ">\n";
    echo '<input type="hidden" name="_posted" value="1" />'."\n";
    //Changes PVD(8.0.x) Addeed Empty Arguments
    list($msg, $errors) = (new FieldError('',''))->listExtract($params['errors']);
    $rows = array();
    foreach ($fields as $f) {
      if (!isset($params['values'][$f['name']])) {
        $f['value'] = $f['default'];
      } else {
        $f['value'] = $params['values'][$f['name']];
      }
      $html = (new Form)->_inputField($f);
      if (isset($errors[$f['name']]))
        $error = $errors[$f['name']];
      else
        $error = NULL;
      if ($f['type'] == 'hidden') {
        if ($error) {
            //Changes PVD(8.0.x)
            (new Fatal)->internalError((new Form)->T("Unexpected hidden field error: %error%", array('error'=>$error)));
        }
        echo $html;
      } else {
        $rows[] = array('title'=>$f['title'], 'html'=>$html, 'error'=>$error);
      }
    }
    echo '<table class="form">';
    echo '<tr><th colspan="2" class="title">'.H($params['title']).'</td></tr>';
    if ($msg) {
      echo '<tr><td colspan="2" class="error">'.H($msg).'</td></tr>';
    }
    foreach ($rows as $r) {
      echo "<tr>";
      echo "<th>".H($r['title'])."</th>";
      if ($r['error']) {
        $err = '<span class="error">'.H($r['error']).'</span><br />';
      } else {
        $err = '';
      }
      echo '<td>'.$err.$r['html']."</td></tr>\n";
    }
    echo "<tr><td></td><td class='buttons'>";
    echo "<input class='button' type='submit' value='".H($params['submit'])."' />\n";
    if ($params['cancel']) {
      echo '<a class="small_button" href="'.H($params['cancel']).'">'.(new Form)->T("Cancel").'</a> ';
    }
    echo '</td></tr></table>';
    echo "</form>\n";
  }
  function _inputField($field) {
    $s = "";
    $attrs = "";
    foreach ($field['attrs'] as $k => $v) {
      $attrs .= H($k).'="'.H($v).'" ';
    }
    switch ($field['type']) {
    // FIXME radio
    case 'select':
      $s .= '<select id="'.H($field['name'])
        . '" name="'.H($field['name']).'" '.$attrs.">\n";
      foreach ($field['options'] as $val => $desc) {
        $s .= '<option value="'.H($val).'" ';
        if ($field['value'] == $val) {
          $s .= ' selected="selected"';
        }
        $s .= ">".H($desc)."</option>\n";
      }
      $s .= "</select>\n";
      break;
    case 'textarea':
      $s .= '<textarea name="'.H($field['name']).'" '
        . $attrs.">".H($field['value'])."</textarea>";
      break;
    case 'file':
      $s .= '<input type="file" ';
      $s .= 'name="'.H($field['name']).'" ';
      $s .= $attrs."/>";
      break;
    case 'bool':
      $s .= '<input type="checkbox" ';
      $s .= 'name="'.H($field['name']).'" ';
      $s .= 'value="Y" ';
      if ($field['value'] == 'Y') {
        $s .= 'checked="checked" ';
      }
      $s .= $attrs."/>";
      break;
    case 'fixed':
      $s .= H($field['value']);
      break;
    case 'date':
      $s .= '<input type="text" ';
      $s .= 'name="'.H($field['name']).'" ';
      $s .= 'value="'.H($field['value']).'" ';
      $s .= $attrs."/>";
      break;
    default:
      $s .= '<input type="'.H($field['type']).'" ';
      $s .= 'name="'.H($field['name']).'" ';
      $s .= 'value="'.H($field['value']).'" ';
      $s .= $attrs."/>";
      break;
    }
    if ($field['label']) {
      $s .= ' '.H($field['label']);
    }
    return $s;
  }
  function _cleanFields($fields) {
    $defaults = array(
      'name'=>NULL,
      'title'=>NULL,
      'type'=>'text',
      'default'=>'',
      'attrs'=>array(),
      'options'=>array(),
      'label'=>'',
      'required'=>false,
    );
    for ($i=0; $i<count($fields); $i++) {
      $fields[$i] = array_merge($defaults, $fields[$i]);
      if (!isset($fields[$i]['name'])) {
        //Changes PVD(8.0.x)
        (new Fatal)->internalError((new Form)->T("No name set for form field."));
      }
      if (!$fields[$i]['title']) {
        $fields[$i]['title'] = $fields[$i]['name'];
      }
    }
    return $fields;
  }
}
