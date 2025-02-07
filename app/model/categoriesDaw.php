
<?php

namespace App\Model;


class CategorieDAO {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    // Get all categories
    public function getAll() {
        try {
            $stmt = $this->pdo->query("SELECT * FROM categories");
            return $this->createCategoriesFromResult($stmt);
        } catch (Exception $ex) {
            throw new Exception("Error fetching categories: " . $ex->getMessage());
        }
    }

    // Delete a category
    public function delete(Categorie $categorie) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM categories WHERE id_categorie = :id");
            $stmt->execute(['id' => $categorie->getId()]);
        } catch (Exception $ex) {
            throw new Exception("Error deleting category: " . $ex->getMessage());
        }
    }

    // Update a category
    public function update(Categorie $categorie) {
        try {
            $stmt = $this->pdo->prepare("UPDATE categories SET 
                categorie_name = :name, 
                categorie_description = :description 
                WHERE id_categorie = :id");
            
            $stmt->execute([
                'name' => $categorie->getName(),
                'description' => $categorie->getDescription(),
                'id' => $categorie->getId()
            ]);
        } catch (Exception $ex) {
            throw new Exception("Error updating category: " . $ex->getMessage());
        }
    }

    // Create a new category
    public function create(Categorie $categorie) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO categories 
                (categorie_name, categorie_description) 
                VALUES (:name, :description)");
            
            $stmt->execute([
                'name' => $categorie->getName(),
                'description' => $categorie->getDescription()
            ]);
            
            // Set the generated ID
            $categorie->setId($this->pdo->lastInsertId());
        } catch (Exception $ex) {
            throw new Exception("Error creating category: " . $ex->getMessage());
        }
    }

    // Helper method to create Categorie objects from database results
    private function createCategoriesFromResult(PDOStatement $stmt) {
        $categories = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $categorie = new Categorie();
            $categorie->setId($row['id_categorie'])
                      ->setName($row['categorie_name'])
                      ->setDescription($row['categorie_description']);
            $categories[] = $categorie;
        }
        return $categories;
    }
}