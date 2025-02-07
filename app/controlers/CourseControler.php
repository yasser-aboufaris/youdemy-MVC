<?php
use App\Controller\CourseController;

namespace App\\Controller;


class CourseControler
{
    public function read(){
        $course = new Course();
        $course->read();
        include_once __DIR__ . '/../views/course/index.php';
    }

    public static function readByPagination(){
        $courses =CoursesDaw::readByPagination();
        include_once __DIR__ . '/../views/course/index.php';
}
    
    public function delete($id){
        $course = new Course();
        $course->setId($id);
        $course->delete();

    }


    public function create(){
        $course = new Course();
        $course->setName($_POST['name']);
        $course->setDuration($_POST['duration']);
        $course->create();
    } 

    public function update($id){
        $course = new Course();
        $course->setId($id);
        $course->setName($_POST['name']);
        $course->setDuration($_POST['duration']);
        $course->update();
    }

    public function createForm(){
        include_once __DIR__ . '/../views/course/create.php';
    }

}