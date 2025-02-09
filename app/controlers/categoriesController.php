<?php
namespace App\Controller;

use App\Model\CategorieDAO;

class CategorieController {
    // Display categories dashboard
    public static function categoriesDashboard() {
        $categories = Categorie::getAll();
        require_once 'app/views/categories/dashboard.php';
    }

    // Show create form
    public static function createForm() {
        require_once 'app/views/categories/create.php';
    }

    // Handle category creation
    public static function create() {
        try {
            $name = $_POST['name'];
            $description = $_POST['description'];
            
            $categorie = new Categorie($conn);
            $categorie->setName($name);
            $categorie->setDescription($description);
            $categorie->insert();
            
            $_SESSION['success'] = "Category created successfully";
            header('Location: index.php?action=categoriesDashboard');
        } catch (\Exception $e) {
            $_SESSION['error'] = "Error creating category: " . $e->getMessage();
            require_once 'app/views/categories/categoriesDashboard.php';
        }
    }


    // Handle category update
    public static function update() {
        try {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            
            $categorie = new Categorie();
            $categorie->setId($id);
            $categorie->setName($name);
            $categorie->setDescription($description);
            
            CategorieDAO::update($categorie);
            $_SESSION['success'] = "Category updated successfully";
            header('Location: index.php?action=categoriesDashboard');
        } catch (\Exception $e) {
            $_SESSION['error'] = "Error updating category: " . $e->getMessage();
            require_once 'app/views/categories/edit.php';
        }
    }

    // Handle category deletion
    public static function delete() {
        try {
            $id = $_GET['id'];
            $categorie = new Categorie();
            $categorie->setId($id);
            
            CategorieDAO::delete($categorie);
            $_SESSION['success'] = "Category deleted successfully";
        } catch (\Exception $e) {
            $_SESSION['error'] = "Error deleting category: " . $e->getMessage();
        }
        header('Location: index.php?action=categoriesDashboard');
    }
}