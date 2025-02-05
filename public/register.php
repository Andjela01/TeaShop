<?php
session_start();
require_once '../vendor/autoload.php';
require_once '../config/connection.php';
use App\Models\User;
use App\Controllers\UserController;

$twig = new \Twig\Environment(new \Twig\Loader\FilesystemLoader('../app/views'));

$errors = [];

$userModel = new User($pdo);
$userController = new UserController($userModel);

$result = $userController->register();
$errors = $result['errors'];

echo $twig->render('register.html.twig', [
      'errors' => $errors,
]);
