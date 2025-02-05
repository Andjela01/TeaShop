<?php

namespace App\Models;

use PDO;

class Tea
{
      private $pdo;

      public function __construct(PDO $pdo)
      {
            $this->pdo = $pdo;
      }

      public function addTea($name, $description, $price, $categoryId, $stockQuantity = 0)
      {
            try {
                  echo "Podaci za unos: $name, $description, $price, $categoryId, $stockQuantity";

                  $stmt = $this->pdo->prepare("INSERT INTO teas (name, description, price, created_at, category_id, stock_quantity) VALUES (:name, :description, :price, :created_at, :category_id, :stock_quantity)");

                  $createdAt = date('Y-m-d H:i:s');

                  $stmt->execute([
                        ':name' => $name,
                        ':description' => $description,
                        ':price' => $price,
                        ':created_at' => $createdAt,
                        ':category_id' => $categoryId,
                        ':stock_quantity' => $stockQuantity,
                  ]);
            } catch (\PDOException $e) {
                  echo "Greška: " . $e->getMessage();
            }
      }

      public function teaExists($name): bool
      {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM teas WHERE name = :name");
            $stmt->execute([':name' => $name]);
            return $stmt->fetchColumn() > 0;
      }

      public function getAllTeas(): array
      {
            $stmt = $this->pdo->prepare("SELECT * FROM teas");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
      }
      public function getTeaByName($name)
      {
            $sql = "SELECT * FROM teas WHERE name LIKE :name";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':name', "%$name%", PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
      }



      public function getTeaById($id)
      {
            $stmt = $this->pdo->prepare("SELECT * FROM teas WHERE id = :id");
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_OBJ);
      }

      public function editTea($id, $name, $description, $price, $categoryId, $stockQuantity)
      {
            $stmt = $this->pdo->prepare("
        UPDATE teas 
        SET name = :name, description = :description, price = :price, category_id = :category_id, stock_quantity = :stock_quantity 
        WHERE id = :id
    ");
            $stmt->execute([
                  ':name' => $name,
                  ':description' => $description,
                  ':price' => $price,
                  ':category_id' => $categoryId,
                  ':stock_quantity' => $stockQuantity,
                  ':id' => $id,
            ]);
      }


      public function deleteTea($teaId)
      {
            $stmt = $this->pdo->prepare("DELETE FROM teas WHERE id = :id");
            return $stmt->execute([':id' => $teaId]);
      }

      public function getCategoriesFromDatabase(): array
      {
            $stmt = $this->pdo->query("SELECT id, name FROM categories");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
      }
}
