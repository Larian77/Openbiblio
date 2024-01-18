<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */

/* For when an error applies to a particular form or DB field */
class FieldError extends ObibError
{
  /* public */
  var $field;
  //Changes PVD(8.0.x)
  function __construct($field, $msg)
  {
    // parent::ObibError($msg);
    //Changes PVD(8.0.x) Changed Above Line To Below Line
    (new ObibError($msg));
    $this->field = $field;
  }
  function listExtract($errors)
  {
    $msgs = array();
    $l = array();
    foreach ($errors as $e) {
      if (isset($e->field)) {
        $l[$e->field][] = $e->toStr();
      } else {
        $msgs[] = $e->toStr();
      }
    }
    $msg = implode(' ', $msgs);
    foreach ($l as $k => $v) {
      $l[$k] = implode(' ', $v);
    }
    return array($msg, $l);
  }
  function backToForm($url, $errors)
  {
    list($msg, $fielderrs) = FieldError::listExtract($errors);
    $_SESSION["postVars"] = mkPostVars();
    $_SESSION["pageErrors"] = $fielderrs;
    if (strchr($url, '?')) {
      header("Location: " . $url . "&msg=" . U($msg));
    } else {
      header("Location: " . $url . "?msg=" . U($msg));
    }
    exit();
  }
}

?>