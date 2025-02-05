<?php

$host = "localhost";
$db_username = "root";
$db_password = "";
$database_name = "tea_shop";
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$database_name;charset=$charset";
$options = [
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      PDO::ATTR_EMULATE_PREPARES => false,
];

try {
      $pdo = new PDO($dsn, $db_username, $db_password, $options);
} catch (\PDOException $e) {
      throw new \PDOException($e->getMessage(), (int) $e->getCode());
}


