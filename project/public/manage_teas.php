<?php

require_once '../vendor/autoload.php';
require_once '../config/connection.php';

use App\Controllers\TeaController;
use App\Models\Tea;

$twig = new \Twig\Environment(new \Twig\Loader\FilesystemLoader('../app/Views'));

$teaModel = new Tea($pdo);
$teaController = new TeaController($teaModel, $pdo);

$action = $_GET['action'] ?? null;

switch ($action) {
      case 'add':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                  $name = $_POST['name'];
                  $description = $_POST['description'];
                  $price = $_POST['price'];
                  $categoryId = $_POST['category_id'];
                  $stockQuantity = $_POST['stock_quantity'];


                  if ($teaController->teaExists($name)) {
                        echo "Čaj sa ovim imenom već postoji.";
                        break;
                  }


                  $teaController->addTea($name, $description, $price, $categoryId, $stockQuantity);

                  header("Location: ?action=manage&status=added");
                  exit;
            } else {

                  $categories = $teaController->getCategories();
                  echo $twig->render('add_tea.html.twig', ['categories' => $categories]);
            }
            break;

      case 'edit':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                  $teaId = $_POST['id'];
                  $name = $_POST['name'];
                  $description = $_POST['description'];
                  $price = $_POST['price'];
                  $categoryId = $_POST['category_id'];
                  $stockQuantity = $_POST['stock_quantity'];

                  $teaController->editTea($teaId, $name, $description, $price, $categoryId, $stockQuantity);

                  header("Location: ?action=manage");
                  exit;
            } else {
                  $teaId = $_GET['id'] ?? '';
                  $tea = $teaController->getTeaById($teaId);

                  $categories = $teaController->getCategories();
                  echo $twig->render('edit_tea.html.twig', ['tea' => $tea, 'categories' => $categories]);
            }
            break;


      case 'delete':
            $teaId = $_GET['id'] ?? '';
            if ($teaId) {
                  $teaController->deleteTea($teaId);
            }

            header("Location: ?action=manage&status=deleted");
            exit;

      default:
            $teas = $teaController->getAllTeas();
            echo $twig->render('manage_teas.html.twig', ['teas' => $teas]);
            break;
}
