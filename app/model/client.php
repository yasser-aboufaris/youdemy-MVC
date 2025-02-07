<?php
require_once 'User.php';

class Client extends User {
    public function __construct($pdo) {
        parent::__construct($pdo);
    }

    public static function readClients($pdo) {
        $sql = "SELECT 
        u.id_user,
        u.activated,
        u.user_name,
        u.user_email,
        r.role_name
    FROM users u
    INNER JOIN roles r ON u.id_role = r.id_role
    WHERE u.id_role != 1
    ORDER BY u.user_name";

$stmt = $pdo->prepare($sql);
$stmt->execute();
        
        $users = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $user = new self($pdo);
            $user->setIdUser($row['id_user']);
            $user->setUserName($row['user_name']);
            $user->setEmail($row['user_email']);
            $user->setRole($row['role_name']);
            $user->setActivated($row['activated']); 
            $users[] = $user;
        }
        return $users;
    }
}
