<?php

namespace App\Controllers;

use App\Models\User;

class UserController
{
      private $userModel;

      public function __construct(User $userModel)
      {
            $this->userModel = $userModel;
      }

      public function register()
      {
            $errors = [];

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                  $username = $_POST['username'];
                  $email = $_POST['email'];
                  $password = $_POST['password'];

                  if (empty($username) || empty($email) || empty($password)) {
                        $errors[] = 'Sva polja su obavezna.';
                  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $errors[] = 'Neispravan format e-pošte.';
                  } else {
                        if ($this->userModel->usernameExists($username)) {
                              $errors[] = 'Korisničko ime već postoji.';
                        }
                  }

                  if (empty($errors)) {
                        try {
                              $this->userModel->register($username, $password, $email, 'customer');
                              header('Location: login.php');
                              exit;
                        } catch (\Exception $e) {
                              $errors[] = 'Greška pri registraciji. Pokušajte ponovo.';
                        }
                  }
            }

            return ['errors' => $errors];
      }






      public function addUser($username, $email, $password, $role = 'customer')
      {
            if ($this->validateUser($username, $email, $password)) {
                  if ($this->userModel->usernameExists($username)) {
                        echo "Korisničko ime već postoji.";
                        return;
                  }
                  $this->userModel->register($username, $password, $email, $role);
                  echo "Korisnik je uspešno registrovan.";
            } else {
                  echo "Greška: Sva polja su obavezna.";
            }
      }

      public function login()
      {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                  $username = $_POST['username'] ?? '';
                  $password = $_POST['password'] ?? '';
                  $loginResult = $this->userModel->login($username, $password);

                  if ($loginResult === true) {
                        $userId = $this->userModel->getUserIdByUsername($username);
                        $_SESSION['user_id'] = $userId;
                        $userRole = $this->userModel->getRoleByUsername($username);
                        $_SESSION['role'] = $userRole;
                        $this->userModel->logAction("Korisnik se prijavio u sistem", $username);

                        switch ($userRole) {
                              case 'admin':
                                    header('Location: admin.php');
                                    break;
                              case 'manager':
                                    header('Location: manager.php');
                                    break;
                              default:
                                    header('Location: ../index.php');
                                    break;
                        }
                        exit;
                  } else {
                        echo $loginResult;
                  }
            }
      }

      public function editUserRole($userId, $role)
      {
            $this->userModel->editUser((int) $userId, $role);
      }

      public function getAllUsers(): array
      {
            return $this->userModel->getAll();
      }

      public function deleteUser($userId)
      {
            if ($this->userModel->deleteUser($userId)) {
                  echo "Korisnik sa ID: $userId je uspešno obrisan.";
            } else {
                  echo "Greška prilikom brisanja korisnika.";
            }
      }

      private function validateUser($username, $email, $password)
      {
            return !empty($username) && !empty($email) && !empty($password);
      }

      public function getUserById($userId)
      {
            return $this->userModel->getUserById($userId);
      }
}
