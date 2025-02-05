<?php
session_start();

require_once '../vendor/autoload.php';
require_once '../config/connection.php';

use App\Models\User;
use App\Controllers\UserController;

$twig = new \Twig\Environment(new \Twig\Loader\FilesystemLoader('../app/Views'));

$errors = [];
$successMessage = '';

$userModel = new User($pdo);
$userController = new UserController($userModel);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $userController->login();
}

echo $twig->render('login.html.twig', [
      'errors' => $errors,
      'successMessage' => $successMessage,
]);
