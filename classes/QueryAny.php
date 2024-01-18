<?php
/* This code is distributed with NO WARRANTY.
 * There is no copyright or paten on this code.
 * Use it any way you like in any work.
 */

class QueryAny
{
    /* Choose the right class to handle database access.
     * .
     */
    function db()
    {
        /* We create only one connection. */
        static $db_code;

        if (!isset($db_code)) {
            require_once("../classes/QueryBase.php");
            if (function_exists('mysqli_connect')) {
                require_once("../classes/QueryMysqli.php");
                $db_code = new QueryMysqli();
            } elseif (function_exists('mysql_connect')) {
                require_once("../classes/QueryMysql.php");
                $db_code = new QueryMysql();
            } elseif (function_exists('PDO')) {
                require_once("../classes/QueryPDO.php");
                $db_code = new QueryPDO();
            } else {
                require_once("../classes/QueryError.php");
                $db_code = new QueryError();
            }
            $db_code->database_name_set(OBIB_DATABASE);
            $db_code->host_set(OBIB_HOST);
            $db_code->username_set(OBIB_USERNAME);
            $db_code->password_set(OBIB_PWD);
        }

        return $db_code;
    }
}
?>