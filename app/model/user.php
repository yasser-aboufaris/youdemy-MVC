<?php
class User {
    protected $pdo;
    protected $id_user;
    protected $user_name;
    protected $email;
    protected $password;
    protected $role;
    protected $activated;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function setSession(){
        $_SESSION['id_user'] = $this->id_user;
        $_SESSION['role'] = $this->role;
    }

    // Getters and Setters
    public function getIdUser() {
        return $this->id_user;
    }

    public function setIdUser($id_user) {
        $this->id_user = $id_user;
    }

    public function setUserName($name){
        $this->user_name = $name;
    }
    public function getUserName() {
        return $this->user_name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getRole() {
        return $this->role;
    }

    public function setRole($role) {
        $this->role = $role;
    }

    public function getActivated() {
        return $this->activated;
    }

    public function setActivated($activated) {
        $this->activated = (bool)$activated;
    }

    // Static Method to Sign Up
    public static function signup($pdo, $user_name, $email, $password, $role ){
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (user_name, email, password, role, activated) VALUES (?, ?, ?, ?, 0)");
        return $stmt->execute([$user_name, $email, $hashedPassword, $role]);
    }

    // Static Method to Log In
    public static function login($pdo, $email, $password) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $userData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($userData && password_verify($password, $userData['password'])) {
            $user = new self($pdo);
            $user->id_user = $userData['id_user'];
            $user->user_name = $userData['user_name'];
            $user->email = $userData['email'];
            $user->role = $userData['role'];
            $user->activated = $userData['activated'];
            
            $user->setSession();
            return $user;
        }
        return null;
    }
}
