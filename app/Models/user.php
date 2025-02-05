<?php

namespace App\Models;
use PDOException;
use PDO;

class user
{
      private $pdo;

      public function __construct(PDO $pdo)
      {
            $this->pdo = $pdo;
      }

      public function register($username, $password, $email, $role = 'customer')
      {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            $stmt = $this->pdo->prepare("INSERT INTO users (username, password, role, email, created_at) VALUES (:username, :password, :role, :email, :created_at)");

            $createdAt = date('Y-m-d H:i:s');

            $stmt->execute([
                  ':username' => $username,
                  ':password' => $hashedPassword,
                  ':role' => $role,
                  ':email' => $email,
                  ':created_at' => $createdAt,
            ]);
      }

      public function usernameExists($username)
      {
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE username = :username");
            $stmt->execute([':username' => $username]);
            return $stmt->fetchColumn() > 0;
      }

      public function login($username, $password)
      {
            if (empty($username) || empty($password)) {
                  return 'Sva polja su obavezna.';
            }

            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = :username");
            $stmt->execute([':username' => $username]);
            $user = $stmt->fetch(PDO::FETCH_OBJ);

            if (!$user) {
                  return 'Korisnik ne postoji.';
            }

            if ($user->role === 'admin' || $user->role === 'manager') {
                  if ($password === $user->password) {
                        return true;
                  } else {
                        return 'Pogrešna lozinka.';
                  }
            } else {
                  if (password_verify($password, $user->password)) {
                        return true;
                  } else {
                        return 'Pogrešna lozinka.';
                  }
            }
      }

      function logAction($action, $username)
      {
            $logMessage = date("Y-m-d H:i:s", strtotime('+ 2 hours')) . "-" . $username . "-" . $action . PHP_EOL;
            file_put_contents('../logs/log.txt', $logMessage, FILE_APPEND);
      }

      public function getRoleByUsername($username)
      {
            $stmt = $this->pdo->prepare("SELECT role FROM users WHERE username = :username");
            $stmt->execute([':username' => $username]);
            return $stmt->fetchColumn();
      }

      public function getAll(): array
      {
            $stmt = $this->pdo->prepare("SELECT * FROM users");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
      }

      public function getUserById($id)
      {
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_OBJ);
      }
      public function editUser($id, $role)
      {
            // Pripremi upit
            $stmt = $this->pdo->prepare("UPDATE users SET role = :role WHERE id = :id");
            $stmt->bindParam(':role', $role);
            $stmt->bindParam(':id', $id);

            $stmt->execute();
      }


      public function deleteUser($userId)
      {
            $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = :id");
            return $stmt->execute([':id' => $userId]);
      }

      public function getUserIdByUsername($username)
      {
            $stmt = $this->pdo->prepare("SELECT id FROM users WHERE username = :username");
            $stmt->execute([':username' => $username]);
            return $stmt->fetchColumn();
      }

}

