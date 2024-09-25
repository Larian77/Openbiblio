<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */

/* error is the only required method */
class FatalHandler {
  /* FIXME - Internationalize this stuff */
  function internalError($msg) {
    echo "<h1>Internal Error - You've Probably Found a Bug</h1>\n";
    echo "<p>Please give all the information on this page to your support personnel.</p>\n";
    echo "<p>".H($msg)."</p>\n";
    $this->printBackTrace();
    exit(1);
  }
  function dbError($sql, $msg, $dberror) {
    echo "<h1>Database Query Error - You've Probably Found a Bug</h1>\n";
    echo "<h2>".H($msg)."</h2>\n";
    echo "<p>Please give all the information on this page to your support personnel.</p>\n";
    echo "<p>Query ".H($sql)." failed.  The DBMS said this:</p>\n";
    echo "<pre>".H($dberror)."</pre>";
    $this->printBackTrace();
    exit(1);
  }
  function error($msg) {
    echo "<h1>Fatal Error</h1>\n";
    echo "<h2>".H($msg)."</h2>\n";
    $this->printBackTrace();
    exit(1);
  }
  function printBackTrace() {
    if (function_exists('debug_backtrace')) {
      echo "<h2>Debug Backtrace (most recent call first):</h2>\n";
      echo '<pre>';
      foreach(debug_backtrace() as $frame) {
        # As usual, PHP makes things more complicated.  This time by
        # deciding that all elements of the stack frame are optional.  Sigh.
        if (isset($frame['file'])) {
          echo H($frame['file'].':');
        } else {
          echo '?file?:';
        }
        if (isset($frame['line'])) {
          echo H($frame['line'].' ');
        } else {
          echo '?line? ';
        }
        if (isset($frame['class']) and isset($frame['type'])) {
          echo H($frame['class'].$frame['type']);
        }
        if (isset($frame['function'])) {
          echo H($frame['function'].'(');
          if (isset($frame['args'])) {
            $args = array();
            foreach ($frame['args'] as $a) {
              array_push($args, var_export($a, true));
            }
            //Changes PVD(8.0.x)
            echo H(implode(', ', $args));
          } else {
            echo '???';
          }
          echo ')';
        }
        echo "\n";
      }
      echo '</pre>';
    }
  }
}

?>