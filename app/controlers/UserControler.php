<?php
namespace App\Controlers
class UserController {

    public function signUpAction($pdo, $email, $password) {

        $user = User::signUp($pdo, $email, $password);

        if ($user) {
            return "Sign-up successful, user created with ID: " . $user->getId();
        } else {
            return "Error: User already exists or invalid data.";
        }
    }

    public function loginAction($pdo, $email, $password) {

        $user = User::login($pdo, $email, $password);

        if ($user) {

            return "Login successful, welcome " . $user->getEmail();
        } else {
            // Failure: return an error message
            return "Error: Invalid credentials.";
        }
    }
}
