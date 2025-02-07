<?php

include "user.php";

class Admine {
    
    public static function banTeacher($pdo, $id_teacher) {
        $qry = "UPDATE users
                SET activated = 0
                WHERE id_user = :id_user;";
        
        $stmt = $pdo->prepare($qry);
        $stmt->bindParam(':id_user', $id_teacher, PDO::PARAM_INT);
        $stmt->execute();
    }

    public static function activateTeacher($pdo, $id_teacher) {
        $qry = "UPDATE users
                SET activated = 1
                WHERE id_user = :id_user;";
        
        $stmt = $pdo->prepare($qry);
        $stmt->bindParam(':id_user', $id_teacher, PDO::PARAM_INT);
        $stmt->execute();
    }
}
