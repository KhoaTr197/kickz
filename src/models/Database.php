<?php
class Database {
  //Config
  const DB_SERVERNAME = 'localhost';
  const DB_USERNAME = 'root';
  const DB_PASSWORD = '';
  const DB_DBNAME = 'kickz';

  //Biến kết nối
  private $conn;

  //Khoi tao
  public function __construct() {
    $this->connect();
  }

  //Tao ket noi
  public function connect() {
    $this->conn = mysqli_connect(self::DB_SERVERNAME, self::DB_USERNAME, self::DB_PASSWORD, self::DB_DBNAME);

    if($this->conn) {
      //echo 'Connect Succeed!';
    } else {
      exit('Connect Failed!');
    }
  }

  //Ngat ket noi
  public function disconnect() {
    mysqli_close($this->conn);
    echo 'Disconnect Succeed!';
  }

  //Truy van
  public function query($query_str) {
    return mysqli_query($this->conn, $query_str);
  }

  //Truy van nhieu lenh
  public function multi_query($query_str) {
    return mysqli_multi_query($this->conn, $query_str);
  }

  //Fetch ra Array
  public function fetch($result) {
    return mysqli_fetch_assoc($result);
  }

  //Fetch ra Array cua cột
  public function fetch_field($result) {
    return mysqli_fetch_field($result);
  }

  //Dem so dong
  public function rows_count($result) {
    return mysqli_num_rows($result);
  }

  //Chuyen truy van -> mysqli_statement
  public function prepare($query) {
    return mysqli_prepare($this->conn, $query);
  }

  //Thuc thi statement
  public function stmt_execute($stmt) {
    return mysqli_stmt_execute($stmt);
  }

  //Lay id cua lan insert gan nhat
  public function	get_last_id() {
    return mysqli_insert_id($this->conn);
  }

  //Them ki tu escape khi truy van lien quan den chuoi
  public function escape_str($str) {
    return mysqli_real_escape_string($this->conn, $str);
  }
}

?>