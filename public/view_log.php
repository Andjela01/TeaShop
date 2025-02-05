<?php

require_once '../vendor/autoload.php';
require_once '../config/connection.php';


$logFile = '../logs/log.txt';

if (file_exists($logFile)) {
      $logContents = file_get_contents($logFile);

      echo nl2br(htmlspecialchars($logContents));
} else {
      echo 'Log fajl ne postoji.';
}
