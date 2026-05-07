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
    if ($this->isUninitializedDatabase($msg, $dberror)) {
      $this->redirectToInstall();
    }
    echo "<h1>Database Query Error - You've Probably Found a Bug</h1>\n";
    echo "<h2>".H($msg)."</h2>\n";
    echo "<p>Please give all the information on this page to your support personnel.</p>\n";
    echo "<p>Query ".H($sql)." failed.  The DBMS said this:</p>\n";
    echo "<pre>".H($dberror)."</pre>";
    $this->printBackTrace();
    exit(1);
  }
  function isUninitializedDatabase($msg, $dberror) {
    $connectionErrors = array(
      'Cannot connect to database server',
      'Cannot select database',
      'Access denied',
      'Unknown database',
      'No such file or directory',
      'Connection refused',
      'doesn\'t exist',
      'Table',
      'settings'
    );
    foreach ($connectionErrors as $errorPattern) {
      if (stripos($msg, $errorPattern) !== false || stripos($dberror, $errorPattern) !== false) {
        return true;
      }
    }
    if ((stripos($msg, 'table') !== false || stripos($dberror, 'table') !== false) &&
        (stripos($msg, 'exist') !== false || stripos($dberror, 'exist') !== false)) {
      return true;
    }
    if ((stripos($msg, 'settings') !== false || stripos($dberror, 'settings') !== false) &&
        (stripos($msg, 'Error accessing') !== false)) {
      return true;
    }
    return false;
  }
  function isDockerEnvironment() {
    return file_exists('/.dockerenv') || 
           getenv('DOCKER_CONTAINER') !== false ||
           (getenv('DB_HOST') !== false && getenv('DB_NAME') !== false);
  }
  function showDatabaseConnectivityError($errorMsg) {
    $isDocker = $this->isDockerEnvironment();
    echo "<!DOCTYPE html>\n";
    echo "<html>\n<head>\n";
    echo "<meta charset=\"UTF-8\">\n";
    echo "<title>OpenBiblio - Database Connection Error / Datenbankverbindungsfehler</title>\n";
    echo "<style>\n";
    echo "body { font-family: Arial, sans-serif; margin: 40px; background-color: #f5f5f5; }\n";
    echo ".container { max-width: 700px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }\n";
    echo "h1 { color: #d9534f; margin-top: 0; }\n";
    echo "h2 { color: #333; font-size: 1.2em; margin-top: 20px; }\n";
    echo "p { line-height: 1.6; color: #333; }\n";
    echo "ul { line-height: 1.8; color: #333; }\n";
    echo "code { background: #f4f4f4; padding: 2px 6px; border-radius: 3px; font-family: monospace; }\n";
    echo ".language-section { margin-bottom: 30px; padding-bottom: 30px; border-bottom: 1px solid #e0e0e0; }\n";
    echo ".language-section:last-of-type { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }\n";
    echo ".error-details { background: #fff3cd; border-left: 4px solid #ffc107; padding: 10px 15px; margin: 15px 0; }\n";
    echo "</style>\n";
    echo "</head>\n<body>\n";
    echo "<div class=\"container\">\n";
    echo "<div class=\"language-section\">\n";
    echo "<h1>Database Connection Error</h1>\n";
    echo "<div class=\"error-details\"><strong>Error:</strong> ".H($errorMsg)."</div>\n";
    echo "<p>OpenBiblio cannot connect to the database server.</p>\n";
    if ($isDocker) {
      echo "<h2>Possible causes:</h2>\n";
      echo "<ul>\n";
      echo "<li>The database container is not running</li>\n";
      echo "<li>The database container is not accessible from the web container</li>\n";
      echo "</ul>\n";
      echo "<h2>What to do:</h2>\n";
      echo "<ul>\n";
      echo "<li>Start all containers: <code>docker-compose up -d</code></li>\n";
      echo "<li>Check container status: <code>docker-compose ps</code></li>\n";
      echo "<li>View database logs: <code>docker-compose logs db</code></li>\n";
      echo "<li>Restart the stack: <code>docker-compose restart</code></li>\n";
      echo "</ul>\n";
    } else {
      echo "<h2>Possible causes:</h2>\n";
      echo "<ul>\n";
      echo "<li>The database server is not running</li>\n";
      echo "<li>The database hostname is incorrect in <code>database_constants.php</code></li>\n";
      echo "<li>Network connectivity issues</li>\n";
      echo "</ul>\n";
      echo "<h2>What to do:</h2>\n";
      echo "<ul>\n";
      echo "<li>Ensure the database service is running (e.g., <code>systemctl status mysql</code>)</li>\n";
      echo "<li>Verify the database hostname in <code>database_constants.php</code></li>\n";
      echo "<li>Check firewall settings and network connectivity</li>\n";
      echo "</ul>\n";
    }
    echo "</div>\n";
    echo "<div class=\"language-section\">\n";
    echo "<h1>Datenbankverbindungsfehler</h1>\n";
    echo "<div class=\"error-details\"><strong>Fehler:</strong> ".H($errorMsg)."</div>\n";
    echo "<p>OpenBiblio kann keine Verbindung zum Datenbankserver herstellen.</p>\n";
    if ($isDocker) {
      echo "<h2>Mögliche Ursachen:</h2>\n";
      echo "<ul>\n";
      echo "<li>Der Datenbank-Container läuft nicht</li>\n";
      echo "<li>Der Datenbank-Container ist vom Web-Container nicht erreichbar</li>\n";
      echo "</ul>\n";
      echo "<h2>Was zu tun ist:</h2>\n";
      echo "<ul>\n";
      echo "<li>Starten Sie alle Container: <code>docker-compose up -d</code></li>\n";
      echo "<li>Prüfen Sie den Container-Status: <code>docker-compose ps</code></li>\n";
      echo "<li>Zeigen Sie Datenbank-Logs: <code>docker-compose logs db</code></li>\n";
      echo "<li>Starten Sie den Stack neu: <code>docker-compose restart</code></li>\n";
      echo "</ul>\n";
    } else {
      echo "<h2>Mögliche Ursachen:</h2>\n";
      echo "<ul>\n";
      echo "<li>Der Datenbankserver läuft nicht</li>\n";
      echo "<li>Der Datenbank-Hostname in <code>database_constants.php</code> ist falsch</li>\n";
      echo "<li>Netzwerkverbindungsprobleme</li>\n";
      echo "</ul>\n";
      echo "<h2>Was zu tun ist:</h2>\n";
      echo "<ul>\n";
      echo "<li>Stellen Sie sicher, dass der Datenbankdienst läuft (z.B. <code>systemctl status mysql</code>)</li>\n";
      echo "<li>Überprüfen Sie den Datenbank-Hostnamen in <code>database_constants.php</code></li>\n";
      echo "<li>Prüfen Sie Firewall-Einstellungen und Netzwerkverbindung</li>\n";
      echo "</ul>\n";
    }
    echo "</div>\n";
    echo "</div>\n";
    echo "</body>\n</html>\n";
    exit(0);
  }
  function redirectToInstall() {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    $scriptPath = dirname($_SERVER['SCRIPT_NAME']);
    $installPath = preg_replace('#/(admin|catalog|circ|home|opac|reports|shared).*$#', '/install/index.php', $scriptPath);
    if ($installPath === $scriptPath) {
      $installPath = rtrim($scriptPath, '/') . '/install/index.php';
    }
    $installUrl = $protocol . '://' . $host . $installPath;
    echo "<!DOCTYPE html>\n";
    echo "<html>\n<head>\n";
    echo "<meta charset=\"UTF-8\">\n";
    echo "<title>OpenBiblio - Installation Required / Installation erforderlich</title>\n";
    echo "<style>\n";
    echo "body { font-family: Arial, sans-serif; margin: 40px; background-color: #f5f5f5; }\n";
    echo ".container { max-width: 700px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }\n";
    echo "h1 { color: #d9534f; margin-top: 0; }\n";
    echo "p { line-height: 1.6; color: #333; }\n";
    echo ".language-section { margin-bottom: 30px; padding-bottom: 30px; border-bottom: 1px solid #e0e0e0; }\n";
    echo ".language-section:last-of-type { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }\n";
    echo ".button { display: inline-block; padding: 12px 24px; background-color: #5cb85c; color: white; text-decoration: none; border-radius: 4px; margin-top: 20px; }\n";
    echo ".button:hover { background-color: #4cae4c; }\n";
    echo "</style>\n";
    echo "</head>\n<body>\n";
    echo "<div class=\"container\">\n";
    echo "<div class=\"language-section\">\n";
    echo "<h1>Installation Required</h1>\n";
    echo "<p>It appears that OpenBiblio has not been installed yet or the database connection is not configured properly.</p>\n";
    echo "<p>Please run the installation wizard to set up your OpenBiblio installation.</p>\n";
    echo "<a href=\"".H($installUrl)."\" class=\"button\">Go to Installation Wizard</a>\n";
    echo "</div>\n";
    echo "<div class=\"language-section\">\n";
    echo "<h1>Installation erforderlich</h1>\n";
    echo "<p>Es scheint, dass OpenBiblio noch nicht installiert wurde oder die Datenbankverbindung nicht richtig konfiguriert ist.</p>\n";
    echo "<p>Bitte führen Sie den Installationsassistenten aus, um Ihre OpenBiblio-Installation einzurichten.</p>\n";
    echo "<a href=\"".H($installUrl)."\" class=\"button\">Zum Installationsassistenten</a>\n";
    echo "</div>\n";
    echo "</div>\n";
    echo "</body>\n</html>\n";
    exit(0);
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