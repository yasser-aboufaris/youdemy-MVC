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
    ///////////////////////////////////////////////////

    public static function signUp($pdo, $email, $password) {
        try {
            $qry = "SELECT * FROM users WHERE email = :email";
            $stmt = $pdo->prepare($qry);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($data) {
                return "user exists";
            }
    
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
            $qry = "INSERT INTO users (email, password) VALUES (:email, :password)";
            $stmt = $pdo->prepare($qry);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
            $stmt->execute();
    
            $userId = $pdo->lastInsertId();
    
            $user = new self();
            $user->setId($userId);
            $user->setEmail($email);
            $user->setPassword($hashedPassword);
    
            return $user;
        } catch (Exception $ex) {
            throw new Exception("Error in signUp method: " . $ex->getMessage());
        }
    }
    


    public static function signUp($pdo, $email, $password) {
        try {
            $qry = "SELECT * FROM users WHERE email = :email";
            $stmt = $pdo->prepare($qry);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$data || !password_verify($password, $data['password'])) {
                return null; 
            }

            $user = new self(); 
            $user->setId($data['id']);
            $user->setEmail($data['email']);
            $user->setPassword($data['password']);

            return $user;
        } catch (Exception $ex) {
            throw new Exception("Error in login method: " . $ex->getMessage());
        }
    }

    ///////////////////////
    public static function login($pdo, $email, $password) {
        try {
            $qry = "SELECT * FROM users WHERE email = :email";
            $stmt = $pdo->prepare($qry);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$data || !password_verify($password, $data['password'])) {
                return null; 
            }

            $user = new self(); 
            $user->setId($data['id']);
            $user->setEmail($data['email']);
            $user->setPassword($data['password']);

            return $user;
        } catch (Exception $ex) {
            throw new Exception("Error in login method: " . $ex->getMessage());
        }
    }


    // Getters and Setters
    public function getIdUser() {
        return $this->id_user;
    }

    public function setIdUser($id_user) {
        $this->id_user = $id_user;
    }

    public function setUserName($name){
        $this->user_name=$name;
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
}

