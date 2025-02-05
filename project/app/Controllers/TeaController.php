<?php

namespace App\Controllers;

use App\Models\Tea;
use PDO;

class TeaController
{
      private $teaModel;
      private $pdo;

      public function __construct(Tea $teaModel, $pdo)
      {
            $this->teaModel = $teaModel;
            $this->pdo = $pdo;
      }

      public function addTea($name, $description, $price, $categoryId, $stockQuantity = 0)
      {
            $this->teaModel->addTea($name, $description, $price, $categoryId, $stockQuantity);
      }

      public function editTea($teaId, $name, $description, $price, $categoryId, $stockQuantity)
      {
            $this->teaModel->editTea($teaId, $name, $description, $price, $categoryId, $stockQuantity);
      }


      public function deleteTea($teaId)
      {
            $this->teaModel->deleteTea($teaId);
      }

      public function getAllTeas()
      {
            return $this->teaModel->getAllTeas();
      }

      public function getTeaById($teaId)
      {
            return $this->teaModel->getTeaById($teaId);
      }

      public function teaExists($name)
      {
            return $this->teaModel->teaExists($name);
      }

      public function getCategories()
      {
            return $this->teaModel->getCategoriesFromDatabase();
      }
}
