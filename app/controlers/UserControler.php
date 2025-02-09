<?php
namespace App\Controllers;
use App\Model\User;
class UserController {
    protected $pdo;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    // Login action with 3 role-based views
    public function login() {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];
    
            $user = User::login($this->pdo, $email, $password);
    
            if ($user) {
                // Store user info in session if needed
                $_SESSION['user'] = $user->getId();
                $_SESSION['role'] = $user->getRole();
    
                switch ($user->getRole()) {
                    case '1':
                        require '../views/admin.php';
                        break;
                    case '2':
                        require '../views/editor.php';
                        break;
                    case '3':
                        require '../views/user.php';
                        break;
                    default:
                        require '<div class="">views/login.php';
                }
            }
        }
        session_write_close();
    }
    
    // Signup action example
    public function signup() {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_name = $_POST['user_name'];
            $email     = $_POST['email'];
            $password  = $_POST['password'];
            $role      = $_POST['role']; // from a select, for example
            
            if (User::signup($this->pdo, $user_name, $email, $password, $role)) {
                echo 'Signup successful!';
            } else {
                echo 'Signup failed!';
            }
        } else {
            require 'views/signup.php';
        }
    }
}