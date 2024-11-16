<?php
class Database {
  const DB_SERVERNAME = 'localhost';
  const DB_USERNAME = 'root';
  const DB_PASSWORD = '';
  const DB_DBNAME = 'kickz';

  private $conn;

  public function __construct() {
    $this->connect();
  }

  public function connect() {
    $this->conn = mysqli_connect(self::DB_SERVERNAME, self::DB_USERNAME, self::DB_PASSWORD, self::DB_DBNAME);

    if($this->conn) {
      //echo 'Connect Succeed!';
    } else {
      exit('Connect Failed!');
    }
  }

  public function disconnect() {
    mysqli_close($this->conn);
    echo 'Disconnect Succeed!';
  }

  public function query($query_str) {
    return mysqli_query($this->conn, $query_str);
  }

  public function fetch($result) {
    return mysqli_fetch_assoc($result);
  }

  public function fetch_field($result) {
    return mysqli_fetch_field($result);
  }

  public function rows_count($result) {
    return mysqli_num_rows($result);
  }

  public function prepare($query) {
    return mysqli_prepare($this->conn, $query);
  }

  public function stmt_execute($stmt) {
    return mysqli_stmt_execute($stmt);
  }

  public function	get_last_id() {
    return mysqli_insert_id($this->conn);
  }

  public function escape_str($str) {
    return mysqli_real_escape_string($this->conn, $str);
  }
}

?>