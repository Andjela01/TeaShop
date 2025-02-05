<?php
session_start();
require_once '../vendor/autoload.php';
require_once '../config/connection.php';

use App\Models\Tea;


$teaModel = new Tea($pdo);
$teas = $teaModel->getAllTeas();
$categories = $teaModel->getCategoriesFromDatabase();


$selectedCategory = $_POST['category'] ?? null;
if ($selectedCategory) {
      $teas = array_filter($teas, function ($tea) use ($selectedCategory) {
            return $tea->category_id == $selectedCategory;
      });
}


if (isset($_POST['add_to_cart'])) {

      if (!isset($_SESSION['user_id'])) {
            header("Location: login.php");
            exit;
      }


      $teaId = $_POST['tea_id'] ?? null;
      if ($teaId === null) {
            echo "Error: Tea ID is not set.";
            exit;
      }


      $userId = $_SESSION['user_id'];
      $stmt = $pdo->prepare("INSERT INTO cart (user_id, tea_id, quantity) VALUES (:user_id, :tea_id, 1)
                            ON DUPLICATE KEY UPDATE quantity = quantity + 1");
      $stmt->execute([':user_id' => $userId, ':tea_id' => $teaId]);


}


$twig = new \Twig\Environment(new \Twig\Loader\FilesystemLoader('../app/Views'));


echo $twig->render('teas.html.twig', [
      'teas' => $teas,
      'categories' => $categories,
      'selectedCategory' => $selectedCategory,
]);
