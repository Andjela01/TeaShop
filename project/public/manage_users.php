<?php


require_once '../vendor/autoload.php';
require_once '../config/connection.php';

use App\Controllers\UserController;
use App\Models\user;

$twig = new \Twig\Environment(new \Twig\Loader\FilesystemLoader('../app/Views'));

$userModel = new user($pdo);
$UserController = new UserController($userModel);




$action = $_GET['action'] ?? null;

switch ($action) {
      case 'add':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                  $username = $_POST['username'];
                  $email = $_POST['email'];
                  $password = password_hash($_POST['password'], PASSWORD_BCRYPT);


                  $UserController->addUser($username, $email, $password);


                  header("Location: ?action=manage&status=added");
                  exit;
            } else {
                  echo $twig->render('add_user.html.twig');
            }
            break;

      case 'edit':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                  $userId = $_POST['id'];
                  $role = $_POST['role'];


                  $UserController->editUserRole($userId, $role);


                  header("Location: ?action=manage");
                  exit;
            } else {
                  $userId = $_GET['id'] ?? '';
                  $user = $UserController->getUserById($userId);
                  echo $twig->render('edit_user.html.twig', ['user' => $user]);
            }
            break;
      case 'delete':
            $userId = $_GET['id'] ?? '';
            if ($userId) {
                  if ($UserController->getUserById($userId)) {
                        $UserController->deleteUser($userId);
                  } else {

                  }
            }

            header("Location: ?action=manage&status=deleted");
            exit;

      default:
            $users = $UserController->getAllUsers();
            echo $twig->render('manage_users.html.twig', ['users' => $users]);
            break;
}
