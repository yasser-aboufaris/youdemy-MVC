<?php
namespace App\Model;
use App\Model\Course;
class CourseDAO {
    private $pdo;
    private $course;
    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }


    private function createCourseFromRow($row) {
        $course = new Course();
        $course->setId($row['id_course']);
        $course->setTitle($row['title']);
        $course->setDescription($row['description']);
        $course->setContent($row['content']);
        $course->setTeacher($row['user_name']);
        $course->setCategorie($row['categorie_name']);
        
        if (isset($row['type'])) {
            $course->setType($row['type']);
        }
        
        return $course;
    }


    public function readAll() {
        try {
            $query = "
                SELECT * 
                FROM courses 
                LEFT JOIN categories ON courses.id_categorie = categories.id_categorie
                LEFT JOIN users ON users.id_user = courses.id_teacher
            ";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $courses = [];
            foreach ($rows as $row) {
                $courses[] = $this->createCourseFromRow($row);
            }
            return $courses;
        } catch (Exception $ex) {
            throw new Exception("Error reading courses: " . $ex->getMessage());
        }
    }


    public function readByCategory($categoryId) {
        try {
            $query = "
                SELECT * 
                FROM courses 
                LEFT JOIN categories ON courses.id_categorie = categories.id_categorie
                LEFT JOIN users ON users.id_user = courses.id_teacher
                WHERE courses.id_categorie = :category_id
            ";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':category_id', $categoryId);
            $stmt->execute();
            
            $courses = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $courses[] = $this->createCourseFromRow($row);
            }
            return $courses;
        } catch (Exception $ex) {
            throw new Exception("Error reading courses by category: " . $ex->getMessage());
        }
    }


    
    public function readByTeacher($teacherId) {
        try {
            $query = "
                SELECT * 
                FROM courses 
                LEFT JOIN categories ON courses.id_categorie = categories.id_categorie
                LEFT JOIN users ON users.id_user = courses.id_teacher
                WHERE courses.id_teacher = :teacher_id
            ";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':teacher_id', $teacherId);
            $stmt->execute();
            
            $courses = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $courses[] = $this->createCourseFromRow($row);
            }
            return $courses;
        } catch (Exception $ex) {
            throw new Exception("Error reading courses by teacher: " . $ex->getMessage());
        }
    }

    public function readById($id) {
        try {
            $query = "
                SELECT courses.*, categories.categorie_name, users.user_name 
                FROM courses 
                LEFT JOIN categories ON courses.id_categorie = categories.id_categorie
                LEFT JOIN users ON users.id_user = courses.id_teacher
                WHERE courses.id_course = :id
            ";
            
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':id', $id);
            $stmt->execute();
            
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$row) {
                return null;
            }

            $course = $this->createCourseFromRow($row);
            
            // Fetch tags
            $tagQuery = "
                SELECT tags.tag_name 
                FROM tagspost
                LEFT JOIN tags ON tagspost.id_tag = tags.id_tag
                WHERE id_course = :id
            ";
            $tagStmt = $this->pdo->prepare($tagQuery);
            $tagStmt->bindValue(':id', $id);
            $tagStmt->execute();
            
            $tags = [];
            while ($tagRow = $tagStmt->fetch(PDO::FETCH_ASSOC)) {
                $tags[] = $tagRow['tag_name'];
            }
            $course->setTags($tags);
            
            return $course;
        } catch (Exception $ex) {
            throw new Exception("Error reading course by ID: " . $ex->getMessage());
        }
    }


    public function search($searchTerm) {
        try {
            $query = "
                SELECT * 
                FROM courses 
                LEFT JOIN categories ON courses.id_categorie = categories.id_categorie
                LEFT JOIN users ON users.id_user = courses.id_teacher
                WHERE courses.title LIKE :search_term
            ";
            
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':search_term', "%$searchTerm%");
            $stmt->execute();
            
            $courses = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $courses[] = $this->createCourseFromRow($row);
            }
            return $courses;
        } catch (Exception $ex) {
            throw new Exception("Error searching courses: " . $ex->getMessage());
        }
    }

    public function create(Course $course) {
        try {
            $this->pdo->beginTransaction();
            
            $query = "
                INSERT INTO courses (id_teacher, title, description, content, type, id_categorie)
                VALUES (:teacher, :title, :description, :content, :type, :categorie)
            ";
            
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':teacher', $course->getTeacher());
            $stmt->bindValue(':title', $course->getTitle());
            $stmt->bindValue(':description', $course->getDescription());
            $stmt->bindValue(':content', $course->getContent());
            $stmt->bindValue(':type', $course->getType());
            $stmt->bindValue(':categorie', $course->getCategorie());
            $stmt->execute();
            
            $courseId = $this->pdo->lastInsertId();
            
            foreach ($course->getTags() as $tag) {
                $tagQuery = "INSERT INTO tagsPost (id_tag, id_course) VALUES (:tag, :course)";
                $tagStmt = $this->pdo->prepare($tagQuery);
                $tagStmt->bindValue(':tag', $tag);
                $tagStmt->bindValue(':course', $courseId);
                $tagStmt->execute();
            }
            
            $this->pdo->commit();
            $course->setId($courseId);
        } catch (Exception $ex) {
            $this->pdo->rollBack();
            throw new Exception("Error creating course: " . $ex->getMessage());
        }
    }

    public function update(Course $course) {
        try {
            $query = "
                UPDATE courses 
                SET title = :title,
                    description = :description,
                    content = :content
                WHERE id_course = :id
            ";
            
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':title', $course->getTitle());
            $stmt->bindValue(':description', $course->getDescription());
            $stmt->bindValue(':content', $course->getContent());
            $stmt->bindValue(':id', $course->getId());
            $stmt->execute();
        } catch (Exception $ex) {
            throw new Exception("Error updating course: " . $ex->getMessage());
        }
    }


    public function delete($id) {
        try {
            $query = "DELETE FROM courses WHERE id_course = :id";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':id', $id);
            $stmt->execute();
        } catch (Exception $ex) {
            throw new Exception("Error deleting course: " . $ex->getMessage());
        }
    }


    public function enrollUser($userId, $courseId) {
        try {
            $checkQuery = "
                SELECT COUNT(*) 
                FROM usersInClass 
                WHERE id_user = :user_id AND id_course = :course_id
            ";


            $checkStmt = $this->pdo->prepare($checkQuery);
            $checkStmt->bindValue(':user_id', $userId);
            $checkStmt->bindValue(':course_id', $courseId);
            $checkStmt->execute();
            if ($checkStmt->fetchColumn() > 0) {
                throw new Exception("User is already enrolled in this course");
            }

            
            $query = "INSERT INTO usersInClass (id_user, id_course) VALUES (:user_id, :course_id)";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':user_id', $userId);
            $stmt->bindValue(':course_id', $courseId);
            $stmt->execute();
        } catch (Exception $ex) {
            throw new Exception("Error enrolling user in course: " . $ex->getMessage());
        }
    }
}