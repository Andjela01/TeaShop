<?php
session_start();
require_once '../vendor/autoload.php';
require_once '../config/connection.php';

use App\Models\Tea;

$twig = new \Twig\Environment(new \Twig\Loader\FilesystemLoader('../app/Views'));

$search = '';
$teas = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $search = trim($_POST['search']);

      $teaModel = new Tea($pdo);
      $teas = $teaModel->getTeaByName($search);
}

echo $twig->render('search.html.twig', [
      'teas' => $teas,
      'search' => $search,
]);
?>