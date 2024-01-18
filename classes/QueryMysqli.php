<?php
/* This code is distributed with NO WARRANTY.
 * There is no copyright or paten on this code.
 * Use it any way you like in any work.
 */

class QueryMysqli extends QueryBase
{
  protected $type = 'mysqli';
  /* Return the database connection type. */
  function connection()
  {
    if (!isset($this->connection)) {
      $this->connection = mysqli_connect($this->host, $this->username, $this->password);
      if ($this->connection_is()) {
        $rc = mysqli_select_db($this->connection, $this->database_name);
        if (!$rc) {
          $this->error = new DbError(
            "Selecting database...",
            "Cannot select database.",
            $this->my_error($this->connection)
          );
        }
      } else {
        $this->error = new DbError(
          "Connecting to database server...",
          "Cannot connect to database server.",
          $this->my_error()
        );
      }
    }
    return $this->connection;
  }
  /* . */
  function data_seek($result, $offset)
  {
    return mysqli_data_seek($result, $offset);
    return false;
  }
  /* . */
  function fetch_assoc($result)
  {
    return mysqli_fetch_assoc($result);
  }
  /* . */
  function fetch_array($result, $result_type)
  {
    return mysqli_fetch_array($result, $result_type);
  }
  /* . */
  function fetch_array_both($result)
  {
    return $this->mysqli_fetch_array($result, MYSQLI_BOTH);
  }
  /* . */
  function fetch_row($result)
  {
    return mysqli_fetch_row($result);
  }
  /* . */
  function get_server_info()
  {
    return mysqli_get_server_info($this->connection);
  }
  /* . */
  function insertID()
  {
    return mysqli_insert_id($this->connection);
  }
  /* Get the MySQL error. */
  function my_error()
  {
    return mysqli_error($this->connection);
  }
  /* . */
  function num_rows($result)
  {
    return mysqli_num_rows($result);
  }
  /* Perform a query. Use connection() to ensure the database is connected. */
  function query($sql)
  {
    return mysqli_query($this->connection(), $sql);
  }
  /* Make strings safe for MySQL. */
  function real_escape_string($string)
  {
    return mysqli_real_escape_string($this->connection(), $string ?: '');

  }
}
?>