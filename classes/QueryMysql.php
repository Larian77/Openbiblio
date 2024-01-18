<?php
/* This code is distributed with NO WARRANTY.
 * There is no copyright or paten on this code.
 * Use it any way you like in any work.
 */
 
class QueryMysql extends QueryBase
  {
  protected $type = 'mysql';
  /* Return the database connection type. */
  function connection()
    {
    if (!isset($this->connection))
      {
      $this->connection = mysql_connect($this->host, $this->username, $this->password);
      if ($this->connection_is())
        {
        $rc = mysql_select_db($this->database_name, $this->connection);
        if (!$rc)
          {
          $this->error = new DbError("Selecting database...",
            "Cannot select database.",
            $this->my_error());
          }
        }
      else
        {
        $this->error = new DbError("Connecting to database server...",
          "Cannot connect to database server.",
          $this->my_error());
        }
      }
    return $this->connection;
    }
  /* . */
  function data_seek($result, $offset) {
    return mysql_data_seek($result, $offset);
    return false;
  }
  /* . */
  function fetch_assoc($result) {
    return mysql_fetch_assoc($result);
  }
  /* . */
  function fetch_array($result, $result_type) {
    return mysql_fetch_array($result, $result_type);
  }
  /* . */
  function fetch_array_both($result) {
    return $this->mysql_fetch_array($result, MYSQL_BOTH);
  }
  /* . */
  function fetch_row($result) {
    return mysql_fetch_row($result);
  }
  /* . */
  function get_server_info() {
    return mysql_get_server_info($this->connection);
  }
  /* . */
  function insertID()
    {
    return mysql_insert_id($this->connection);
    }
  /* Get the MySQL error. */
  function my_error()
    {
    return mysql_error($this->connection);
    }
  /* . */
  function num_rows($result) {
    return mysql_num_rows($result);
  }
  /* Perform a query. Use connection() to ensure the database is connected. */
  function query($sql)
    {
    return mysql_query($sql, $this->connection());
    }
  /* Make strings safe for MySQL. */
  function real_escape_string($string)
    {
    if (!function_exists('mysql_real_escape_string'))
      {
      // PHP < 4.3.0
      return mysql_escape_string($string);
      }
    return mysql_real_escape_string($string, $this->connection());
    }
  }
?>