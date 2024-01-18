<?php
/* This code is distributed with NO WARRANTY.
 * There is no copyright or paten on this code.
 * Use it any way you like in any work.
 */
class QueryBase
  {
  protected $type = '';
  protected $connection;
  protected $database_name = '';
  protected $error = null;
  protected $host = '';
  protected $password = '';
  protected $username = '';
  /* Get the database connection. */
  function connection()
    {
    if (!isset($this->connection))
      {
      $this->connection = false;
      }
    return $this->connection;
    }
  /* Is there a database connection? */
  function connection_is()
    {
    return isset($this->connection) and $this->connection != false;
    }
  /* Set the database name for the connection. */
  function database_name_set($database_name)
    {
    $this->database_name = $this->string_safe($database_name);
    }
  /* . */
  function data_seek($result, $offset) {
    print '<p>Function data_seek() not created for database type ' . $this->type . '</p>';
    return false;
  }
  /* Return the error if set. */
  function error_get()
    {
    return $this->error;
    }
  /* Is there an error? */
  function error_is()
    {
    return $this->error != null;
    }
  /* . */
  function fetch_assoc($result) {
    print '<p>Function fetch_assoc() not created for database type ' . $this->type . '</p>';
    return false;
  }
  /* . */
  function fetch_array($result, $result_type) {
    print '<p>Function fetch_array() not created for database type ' . $this->type . '</p>';
    return false;
  }
  /* . */
  function fetch_array_both($result) {
    print '<p>Function fetch_array_both() not created for database type ' . $this->type . '</p>';
    return false;
  }
  /* . */
  function fetch_row($result) {
    print '<p>Function fetch_row() not created for database type ' . $this->type . '</p>';
    return false;
  }
  /* . */
  function get_server_info() {
    print '<p>Function get_server_info() not created for database type ' . $this->type . '</p>';
    return false;
  }
  /* Set the host for the connection. */
  function host_set($host)
    {
    $this->host = $this->string_safe($host);
    }
  /* . */
  function insertID() {
    print '<p>Function insertID() not created for database type ' . $this->type . '</p>';
    return false;
  }
  /* . */
  function num_rows($result) {
    print '<p>Function num_rows() not created for database type ' . $this->type . '</p>';
    return false;
  }
  /* Get the MySQL error. */
  function my_error()
    {
    print '<p>Function my_error() not created for database type ' . $this->type . '</p>';
    return false;
    }
  /* Set the password for the connection. */
  function password_set($password)
    {
    $this->password = $this->string_safe($password);
    }
  /* Perform a query. */
  function query($sql)
    {
    print '<p>Function query() not created for database type ' . $this->type . '</p>';
    return false;
    }
  /* Make strings safe for MySQL. */
  function real_escape_string($string)
    {
    print '<p>Function real_escape_string() not created for database type ' . $this->type . '</p>';
    return false;
    }
  /* Make strings safe. */
  function string_safe($string)
    {
    return htmlentities($string);
    }
  /* Return the database interface type. */
  function type() { return $this->type; }
  /* Set the user name for the connection. */
  function username_set($username)
    {
    $this->username = $this->string_safe($username);
    }
  }
?>