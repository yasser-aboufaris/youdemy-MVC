<?php

class Categorie {
    private $pdo;
    private $id_categorie;
    private $name;
    private $description;

    public function __construct($pdo="") {
        $this->pdo = $pdo;
    }
    
    public static function readCategories($pdo) {
        try {
            $qry = "SELECT * FROM categories";
            $stmt = $pdo->prepare($qry);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $objects = [];
    
            foreach ($data as $row) { 
                $object = new self();
                $object->setId($row['id_categorie']);
                $object->setName($row['categorie_name']);
                $object->setDescription($row['categorie_description']);
                array_push($objects, $object);
            }
            return $objects;
        } catch (Exception $ex) {
            throw new Exception("Error in readCategories method: " . $ex->getMessage());
        }
    }
    

    


    public function delete() {
        try {
            $qry = "DELETE FROM categories WHERE id_categorie = :id_categorie";
            $stmt = $this->pdo->prepare($qry);
            $stmt->bindParam(":id_categorie", $this->id_categorie);
            $stmt->execute();
        } catch(Exception $ex) {
            throw new Exception("Error in delete method: " . $ex->getMessage());
        }
    }
    
    

    public function update() {
        try {
            $qry = "UPDATE categories 
                    SET categorie_name = :name,
                        categorie_description = :description
                    WHERE id_categorie = :id_categorie";
            $stmt = $this->pdo->prepare($qry);
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":description", $this->description);
            $stmt->bindParam(":id_categorie", $this->id_categorie);
            $stmt->execute();
        } catch(Exception $ex) {
            throw new Exception("Error in update method: " . $ex->getMessage());
        }
    }

    public function insert() {
        try {
            $qry = "INSERT INTO categories (categorie_name, categorie_description)
                    VALUES (:name, :description)";
            $stmt = $this->pdo->prepare($qry);
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":description", $this->description);
            $stmt->execute();
        } catch(Exception $ex) {
            throw new Exception("Error in create method: " . $ex->getMessage());
        }
    }

    // Getters
    public function getId() {
        return $this->id_categorie;
    }

    public function getName() {
        return $this->name;
    }

    public function getDescription() {
        return $this->description;
    }

    // Setters
    public function setId($id) {
        $this->id_categorie = $id;
        return $this;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }
}