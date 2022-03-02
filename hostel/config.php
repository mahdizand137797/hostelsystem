<?php
 define("DBHOST", "localhost");
 define("DBUSER", "root");
 define("DBPASS", "");
 define("DBNAME", "sorena");

 $conn = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
 mysqli_set_charset($conn, "utf8");
 if ($conn->connect_error) {
  die("متاسفانه نمي توان به پايگاه داده متصل شد: " . $conn->connect_error);
} 
?>
