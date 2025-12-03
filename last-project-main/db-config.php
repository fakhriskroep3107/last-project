<?php

try {
  $host = 'localhost';
  $port = 3306;
  $database = 'tugas_akhir';
  $username = 'root';
  $password = '';

  $connection = new PDO("mysql:host=$host:$port;dbname=$database", $username, $password);

  // set error mode
  $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  echo "Koneksi atau query bermasalah : " . $e->getMessage() . "<br/>";
  exit();
}
