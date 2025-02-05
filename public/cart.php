<?php
session_start();
require_once '../vendor/autoload.php';
require_once '../config/connection.php';

if (!isset($_SESSION['user_id'])) {
      header("Location: login.php");
      exit;
}

$userId = $_SESSION['user_id'];

$stmt = $pdo->prepare("
    SELECT c.id, t.id AS tea_id, t.name, t.price, c.quantity, (t.price * c.quantity) AS total_price
    FROM cart c
    JOIN teas t ON c.tea_id = t.id
    WHERE c.user_id = :user_id
");
$stmt->execute([':user_id' => $userId]);
$cartItems = $stmt->fetchAll();

$totalAmount = 0;
foreach ($cartItems as $item) {
      $totalAmount += $item['total_price'];
}

if (isset($_POST['remove_item'])) {
      $cartId = $_POST['cart_id'];
      $stmt = $pdo->prepare("DELETE FROM cart WHERE id = :id AND user_id = :user_id");
      $stmt->execute([
            ':id' => $cartId,
            ':user_id' => $userId
      ]);
      header("Location: cart.php");
      exit;
}

if (isset($_POST['update_quantity'])) {
      $cartId = $_POST['cart_id'];
      $newQuantity = (int) $_POST['quantity'];

      $stmt = $pdo->prepare("UPDATE cart SET quantity = :quantity WHERE id = :id AND user_id = :user_id");
      $stmt->execute([
            ':quantity' => $newQuantity,
            ':id' => $cartId,
            ':user_id' => $userId
      ]);
      header("Location: cart.php");
      exit;
}

if (isset($_POST['checkout'])) {
      $address = $_POST['address'];
      $phone = $_POST['phone'];

      foreach ($cartItems as $item) {
            $stmt = $pdo->prepare("SELECT stock_quantity FROM teas WHERE id = :tea_id");
            $stmt->execute([':tea_id' => $item['tea_id']]);
            $stock = $stmt->fetchColumn();

            if ($item['quantity'] > $stock) {
                  $_SESSION['error_message'] = "Nema dovoljno zaliha za čaj " . $item['name'];
                  header("Location: cart.php");
                  exit;
            }
      }

      $stmt = $pdo->prepare("INSERT INTO orders (user_id, total_amount) VALUES (:user_id, :total_amount)");
      $stmt->execute([
            ':user_id' => $userId,
            ':total_amount' => $totalAmount,
      ]);

      $orderId = $pdo->lastInsertId();
      $successfulInsertion = true;

      foreach ($cartItems as $item) {
            try {
                  $stmt = $pdo->prepare("INSERT INTO order_items (order_id, tea_id, quantity, price) VALUES (:order_id, :tea_id, :quantity, :price)");
                  $stmt->execute([
                        ':order_id' => $orderId,
                        ':tea_id' => $item['tea_id'],
                        ':quantity' => $item['quantity'],
                        ':price' => $item['total_price'],
                  ]);
            } catch (PDOException $e) {
                  $successfulInsertion = false;
                  break;
            }
      }

      if ($successfulInsertion) {
            foreach ($cartItems as $item) {
                  $stmt = $pdo->prepare("UPDATE teas SET stock_quantity = stock_quantity - :quantity WHERE id = :tea_id");
                  $stmt->execute([
                        ':quantity' => $item['quantity'],
                        ':tea_id' => $item['tea_id']
                  ]);
            }

            $stmt = $pdo->prepare("DELETE FROM cart WHERE user_id = :user_id");
            $stmt->execute([':user_id' => $userId]);

            $_SESSION['success_message'] = "Uspešna porudžbina, očekujte je na adresi $address kroz 2-3 dana.";
            header("Location: cart.php");
            exit;
      }
}

$twig = new \Twig\Environment(new \Twig\Loader\FilesystemLoader('../app/Views'));

echo $twig->render('cart.html.twig', [
      'cartItems' => $cartItems,
      'totalAmount' => $totalAmount,
      'success_message' => $_SESSION['success_message'] ?? null,
      'error_message' => $_SESSION['error_message'] ?? null,
]);
