<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  require_once("../shared/common.php");

  $_SESSION = array();
  session_destroy();

  header("Location: ../home/index.php");
  exit();

?>
