<?php
class Role {
    private $pdo;
    private $id_role;
    private $role_name;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function readRoles() {
        try {
            $qry = "SELECT * FROM roles";
            $stmt = $this->pdo->prepare($qry);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(Exception $ex) {
            throw new Exception("Error in readRoles method: " . $ex->getMessage());
        }
    }

    public function delete() {
        try {
            $qry = "DELETE FROM roles WHERE id_role = :id_role";
            $stmt = $this->pdo->prepare($qry);
            $stmt->bindParam(":id_role", $this->id_role);
            $stmt->execute();
        } catch(Exception $ex) {
            throw new Exception("Error in delete method: " . $ex->getMessage());
        }
    }   

    public function update() {
        try {
            $qry = "UPDATE roles 
                    SET role_name = :role_name
                    WHERE id_role = :id_role";
            $stmt = $this->pdo->prepare($qry);
            $stmt->bindParam(":role_name", $this->role_name);
            $stmt->bindParam(":id_role", $this->id_role);
            $stmt->execute();
        } catch(Exception $ex) {
            throw new Exception("Error in update method: " . $ex->getMessage());
        }
    }

    public function create() {
        try {
            $qry = "INSERT INTO roles (role_name)
                    VALUES (:role_name)";
            $stmt = $this->pdo->prepare($qry);
            $stmt->bindParam(":role_name", $this->role_name);
            $stmt->execute();
        } catch(Exception $ex) {
            throw new Exception("Error in create method: " . $ex->getMessage());
        }
    }



    
    public function getId() {
        return $this->id_role;
    }

    public function getRoleName() {
        return $this->role_name;
    }





    public function setId($id) {
        $this->id_role = $id;
        return $this;
    }

    public function setRoleName($role_name) {
        $this->role_name = $role_name;
        return $this;
    }
}