<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */

/* Most DB errors are fatal, but we sometimes have to catch them. */
class DbError extends ObibError {
  /* The attributes here are public. */
  var $sql;
  var $msg;
  var $dberror;
  //Changes PVD(8.0.x)
  function __construct($sql, $msg, $dberror) {
    $this->sql = $sql;
    $this->msg = $msg;
    $this->dberror = $dberror;
  }
  function toStr() {
    $s = $this->msg.': '.$this->dberror;
    if ($this->sql) {
      $s .= ' -- FULL SQL: '.$this->sql;
    }
    return $s;
  }
}
?>
