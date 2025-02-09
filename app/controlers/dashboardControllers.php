<?php
namespace App\Controllers;
use App\Model\CategorieDAO;
use App\Model\Categorie;
use App\Model\CourseDAO;
use App\Model\Course;
use App\Model\Connection;
use App\Model\User;

class dashboardController {



    public static function coursesDashboard(){
        $categories = CategorieDAO::getAll();
        $courses = CourseDAO::readAll();
        require_once 'app/views/Coursesdashboard.php';
    }

}
    