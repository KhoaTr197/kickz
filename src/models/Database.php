<?php
class Database {
  const DB_SERVERNAME = 'localhost';
  const DB_USERNAME = 'root';
  const DB_PASSWORD = '';
  const DB_DBNAME = 'test';

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

  public function rows_count($result) {
    return mysqli_num_rows($result);
  }
}

?>