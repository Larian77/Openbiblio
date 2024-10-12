<?php
/* This file is part of a copyrighted work; it is distributed with NO WARRANTY.
 * See the file COPYRIGHT.html for more details.
 */

$_Query_lock_depth = 0;
require_once("../classes/QueryAny.php");
require_once("../classes/DbIter.php");
require_once("../classes/DbOld.php");

class Query
{
    var $_link;
    //Changes PVD(8.0.x)
    var $_conn;
    var $_error;


    /* This constructor will never do more than call connect_e() and throw a
     * fatal error if it fails.  If you want to catch the error, subclass Query and
     * call connect_e() yourself.
     */

    //Changes PVD(8.0.x)
    function __construct()
    {
        $e = $this->connect_e();
        if ($e) {
            (new Fatal)->dbError($e->sql, $e->msg, $e->dberror);
        }
    }
    function connect_e()
    {
        list($this->_link, $e) = Query::_connect_e();
        Query::act('SET NAMES UTF8'); //added by pvd for utf8 support
        return $e;
    }
    /* This static method shares the actual DBMS connection
     * with all Query instances.
     */
    function _connect_e()
    {
        //Changes PVD(8.0.x)
        $link = (new QueryAny)->db();
        if ($link->error_is()) {
            return array(NULL, $link->error_get());
        }
        return array($link, NULL);
    }

    function act($sql)
    {
        $results = $this->_act($sql);
        if (!is_bool($results)) {
            //Changes PVD(8.0.x)
            (new Fatal)->dbError($sql, "Action query returned results.", 'No DBMS error.');
        }
    }
    function select($sql)
    {
        $results = $this->_act($sql);
        if (is_bool($results)) {
            //Changes PVD(8.0.x)
            (new Fatal)->dbError($sql, "Select did not return results.", 'No DBMS error.');
        }
        return new DbIter($results);
    }
    function select1($sql)
    {
        $r = $this->select($sql);
        if ($r->count() != 1) {
            //Changes PVD(8.0.x)
            (new Fatal)->dbError(
                $sql,
                'Wrong number of result rows: expected 1, got ' . $r->count(),
                'No DBMS Error'
            );
        } else {
            return $r->next();
        }
    }
    function select01($sql)
    {
        $r = $this->select($sql);
        if ($r->count() == 0) {
            return NULL;
        } else if ($r->count() != 1) {
            //Changes PVD(8.0.x)
            (new Fatal)->dbError(
                $sql,
                'Wrong number of result rows: expected 0 or 1, got ' . $r->count(),
                'No DBMS Error'
            );
        } else {
            return $r->next();
        }
    }
    function _act($sql)
    {
        if (!$this->_link) {
            //Changes PVD(8.0.x)
            $this->connect_e();
            // (new Fatal)->internalError('Tried to make database query before connection.');
        }
        $r = $this->_link->query($sql);
        if ($r === false) {
            //Changes PVD(8.0.x)
            (new Fatal)->dbError($sql, 'Database query failed', $this->_link->my_error());
        }
        return $r;
    }

    /* This is not easily portable to many SQL DBMSs.  A better scheme
     * might be something like PEAR::DB's sequences.
     */
    function getInsertID()
    {
        return $this->_link->insertID();
    }

    /* Locking functions
     *
     * Besides switching to InnoDB for transactions, I haven't been able to
     * come up with a good way to do locking reliably.  For now, we'll get
     * and release one big advisory lock around every sensitive transaction
     * and every database write except per-session data.  This should make
     * everything work, even if it is heavy-handed.
     *
     * Calls to lock/unlock may be nested, but must be paired.
     */
    function lock()
    {
        //Changes PVD(8.0.x)
        //2 global constants defined here because they have not defined elsewhere
        if (!defined('OBIB_LOCK_NAME')){define('OBIB_LOCK_NAME', 'openbiblio_lock');}
        if (!defined('OBIB_LOCK_TIMEOUT')){define('OBIB_LOCK_TIMEOUT', '10');}
        global $_Query_lock_depth;
        if ($_Query_lock_depth < 0) {
            //Changes PVD(8.0.x)
            (new Fatal)->internalError('Negative lock depth');
        }
        if ($_Query_lock_depth == 0) {
            $row = $this->select1(
                $this->mkSQL(
                    'select get_lock(%Q, %N) as locked',
                    OBIB_LOCK_NAME,
                    OBIB_LOCK_TIMEOUT
                )
            );
            if (!isset($row['locked']) or $row['locked'] != 1) {
                //Changes PVD(8.0.x)
                (new Fatal)->cantLock();
            }
        }
        $_Query_lock_depth++;
    }
    function unlock()
    {
        global $_Query_lock_depth;
        if ($_Query_lock_depth <= 0) {
            //Changes PVD(8.0.x)
            (new Fatal)->internalError('Tried to unlock an unlocked database.');
        }
        $_Query_lock_depth--;
        if ($_Query_lock_depth == 0) {
            $this->act(
                $this->mkSQL(
                    'do release_lock(%Q)',
                    OBIB_LOCK_NAME
                )
            );
        }
    }

    /****************************************************************************
     * Makes SQL by interpolating values into a format string.
     * This function works something like printf() for SQL queries.  Format
     * strings contain %-escapes signifying that a value from the argument
     * list should be inserted into the string at that point.  The routine
     * properly quotes or transforms the value to make sure that it will be
     * handled correctly by the SQL server.  The recognized format strings
     * are as follows:
     *  %% - is replaced by a single '%' character and does not consume a
     *       value form the argument list.
     *  %! - inserts the argument in the query unaltered -- BE CAREFUL!
     *  %B - treates the argument as a boolean value and inserts either
     *       'Y' or 'N'as appropriate.
     *  %C - treats the argument as a column reference.  This differs from
     *       %I below only in that it passes the '.' operator for separating
     *       table and column names on to the SQL server unquoted.
     *  %I - treats the argument as an identifier to be quoted.
     *  %i - does the same escaping as %I, but does not add surrounding
     *       quotation marks.
     *  %N - treats the argument as a number and strips off all of it but
     *       an initial numeric string with optional sign and decimal point.
     *  %Q - treats the argument as a string and quotes it.
     *  %q - does the same escaping as %Q, but does not add surrounding
     *       quotation marks.
     * @param string $fmt format string
     * @param string ... optional argument values
     * @return string the result of interpreting $fmt
     * @access public
     ****************************************************************************
     */
    function mkSQL()
    {
        $n = func_num_args();
        if ($n < 1) {
            //Changes PVD(8.0.x)
            (new Fatal)->internalError('Not enough arguments given to mkSQL().');
        }
        $i = 1;
        $SQL = "";
        $fmt = func_get_arg(0);
        while (strlen($fmt)) {
            $p = strpos($fmt, "%");
            if ($p === false) {
                $SQL .= $fmt;
                break;
            }
            $SQL .= substr($fmt, 0, $p);
            if (strlen($fmt) < $p + 2) {
                //Changes PVD(8.0.x)
                (new Fatal)->internalError('Bad mkSQL() format string.');
            }
            //Changes PVD(8.0.x)
            if ($fmt[$p + 1] == '%') {
                $SQL .= "%";
            } else {
                if ($i >= $n) {
                    //Changes PVD(8.0.x)
                    (new Fatal)->internalError('Not enough arguments given to mkSQL().');
                }
                $arg = func_get_arg($i++);
                //Changes PVD(8.0.x)
                switch ($fmt[$p + 1]) {
                    case '!':
                        /* very dangerous, but sometimes very useful -- be careful */
                        $SQL .= $arg;
                        break;
                    case 'B':
                        if ($arg) {
                            $SQL .= "'Y'";
                        } else {
                            $SQL .= "'N'";
                        }
                        break;
                    case 'C':
                        $a = array();
                        foreach (explode('.', $arg) as $ident) {
                            array_push($a, '`' . $this->_ident($ident) . '`');
                        }
                        $SQL .= implode('.', $a);
                        break;
                    case 'I':
                        $SQL .= '`' . $this->_ident($arg) . '`';
                        break;
                    case 'i':
                        $SQL .= $this->_ident($arg);
                        break;
                    case 'N':
                        $SQL .= $this->_numstr($arg);
                        break;
                    case 'Q':
                        //Changes PVD(8.0.x)
                        //Adding this because connection link is empty
                        //on page BiblioSearchQuery query constructor is calling but it is not establiting the connection;
                        $this->connect_e();
                        $SQL .= "'" . $this->_link->real_escape_string($arg) . "'";
                        break;
                    case 'q':
                        //Changes PVD(8.0.x)
                        //Adding this because connection link is empty
                        $this->connect_e();
                        $SQL .= $this->_link->real_escape_string($arg);
                        break;
                    default:
                        //Changes PVD(8.0.x)
                        (new Fatal)->internalError('Bad mkSQL() format string.');
                }
            }
            $fmt = substr($fmt, $p + 2);
        }
        if ($i != $n) {
            //Changes PVD(8.0.x)
            (new Fatal)->internalError('Too many arguments to mkSQL().');
        }
        return $SQL;
    }

    function _ident($i)
    {
        # Because the MySQL manual is unclear on how to include a ` in a `-quoted
        # identifer, we just drop them.  The manual does not say whether backslash
        # escapes are interpreted in quoted identifiers, so I assume they are not.
        return str_replace('`', '', $i);
    }
    function _numstr($n)
    {
        if (preg_match("/^([+-]?[0-9]+(\.[0-9]*)?([Ee][0-9]+)?)/", $n, $subs)) {
            return $subs[1];
        } else {
            return "0";
        }
    }

    /* Everything below is just a compatibility interface
     * for the last few iterations of this design.  Don't use
     * it.  This will be removed as soon as I get time to
     * update everything that depends on this stuff.
     */
    function connect($conn = false)
    {
        return true;
    }
    function close()
    {
        return true;
    }
    function _exec($sql)
    {
        $r = $this->_act($sql);
        $this->_conn = new DbOld($r, $this->getInsertId());
        return $r;
    }
    function exec($sql)
    {
        $r = $this->_exec($sql);
        if (is_bool($r)) {
            return $r;
        } else {
            $rows = array();
            while ($row = $this->_link->fetch_assoc($r)) {
                $rows[] = $row;
            }
            return $rows;
        }
    }
    function eexec($sql)
    {
        return $this->exec($sql);
    }
    function _query($sql, $msg)
    {
        $r = $this->_act($sql);
        $this->_conn = new DbOld($r, $this->getInsertId());
        return $r;
    }
    function _checkSubQuery(&$q, $result)
    {
        return $result;
    }
    function resetResult()
    {
        $this->_conn->resetResult();
    }
    function clearErrors()
    {
        return;
    }
    function errorOccurred()
    {
        return false;
    }
    function getError()
    {
        if (isset($this->_error)) {
            return $this->_error;
        } else {
            return "";
        }
    }
    function getDbErrno()
    {
        return 0;
    }
    function getDbError()
    {
        return "";
    }
    function getSQL()
    {
        return "";
    }
}

?>