<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
  include("../shared/help_header.php");
  
  if (isset($_GET["page"])) {
    $page = $_GET["page"];
  } else {
    $page = "contents";
  }
  if (preg_match('/^[a-zA-Z0-9_]+$/', $page)) {
    include("../locale/".OBIB_LOCALE."/help/".$page.".php");
  }
  include("../shared/help_footer.php");
?>
