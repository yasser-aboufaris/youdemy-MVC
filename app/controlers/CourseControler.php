<?php

namespace App\Controller;


use App\Model\Course;

class CourseController {
    private $pdo;
    private $course;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->course = new Course($pdo);
    }

    public function index($page = 1, $limit = 6) {
        try {
            $offset = ($page - 1) * $limit;
            return Course::readCoursesByPagination($this->pdo, $limit, $offset);
        } catch (Exception $e) {
            throw new Exception("Error loading courses: " . $e->getMessage());
        }
    }

    public function show($id) {
        try {
            $courses = Course::readCoursesById($this->pdo, $id);
            if (empty($courses)) {
                throw new Exception("Course not found");
            }
            return $courses[0]; 
        } catch (Exception $e) {
            throw new Exception("Error loading course: " . $e->getMessage());
        }
    }

    public function search($searchTerm) {
        try {
            return Course::searchCourses($this->pdo, $searchTerm);
        } catch (Exception $e) {
            throw new Exception("Error searching courses: " . $e->getMessage());
        }
    }



    public function create($data) {
        try {            
            $this->course->setTitle($data['title']);
            $this->course->setDescription($data['description']);
            $this->course->setContent($data['content']);
            $this->course->setType($data['type']);
            $this->course->setTeacher($data['teacher_id']);
            $this->course->setCategorieId($data['categorie_id']);
            $this->course->setTags($data['tags'] ?? []);
            
            $this->course->insert();
            return true;
        } catch (Exception $e) {
            throw new Exception("Error creating course: " . $e->getMessage());
        }
    }



    public function update($id, $data) {
        try {
            $this->validateCourseData($data);
            
            $this->course->setId($id);
            $this->course->setTitle($data['title']);
            $this->course->setDescription($data['description']);
            $this->course->setContent($data['content']);
            
            $this->course->update();
            return true;
        } catch (Exception $e) {
            throw new Exception("Error updating course: " . $e->getMessage());
        }
    }



    public function delete($id) {
        try {
            $this->course->setId($id);
            $this->course->delete();
            return true;
        } catch (Exception $e) {
            throw new Exception("Error deleting course: " . $e->getMessage());
        }
    }



    public function getCoursesByCategory($categoryId) {
        try {
            return Course::readCoursesByCategorie($this->pdo, $categoryId);
        } catch (Exception $e) {
            throw new Exception("Error loading courses by category: " . $e->getMessage());
        }
    }



    public function getCoursesByTeacher($teacherId) {
        try {
            return Course::readCoursesByTeacher($this->pdo, $teacherId);
        } catch (Exception $e) {
            throw new Exception("Error loading teacher's courses: " . $e->getMessage());
        }
    }



    public function enrollStudent($courseId, $userId) {
        try {
            $this->course->setId($courseId);
            return $this->course->signCourse($userId);
        } catch (Exception $e) {
            throw new Exception("Error enrolling student: " . $e->getMessage());
        }
    }


}