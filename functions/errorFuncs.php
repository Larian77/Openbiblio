<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */
 
/*********************************************************************************
 * Displays the error page
 * @param Query $query Query object containing query error parameters.
 * @return void
 * @access public
 *********************************************************************************
 */
function displayErrorPage($query){
  echo "\n<!-- db_errno = ".H($query->getDbErrno())."-->\n";
  echo "<!-- db_error = ".H($query->getDbError())."-->\n";
  echo "<!-- SQL = ".H($query->getSQL())."-->\n";
  exit($query->getError());
}
?>
