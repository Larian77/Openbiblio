<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  #****************************************************************************
  #*  Reset all form values
  #****************************************************************************
  if (isset($_GET["reset"])){
    unset($_SESSION["postVars"]);
    unset($_SESSION["pageErrors"]);
  }

  #****************************************************************************
  #*  Getting page errors and previous post variables from session.
  #****************************************************************************
  if (isset($_SESSION["postVars"])){
    $postVars = $_SESSION["postVars"];
  } else {
    $postVars = NULL;
  }
  if (isset($_SESSION["pageErrors"])){
    $pageErrors = $_SESSION["pageErrors"];
  } else {
    $pageErrors = NULL;
  }

?>
