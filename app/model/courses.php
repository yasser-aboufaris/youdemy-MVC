<?php
namespace App\Model;
class Course {
    private $pdo;
    private $id_course;
    private $title;
    private $description;
    private $content;
    private $type;
    private $categorie;
    private $teacher;
    private $tags;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    

    public static function readCourses($pdo){
        $qry = "
            SELECT * 
            FROM courses 
            left join categories 
            ON courses.id_categorie = categories.id_categorie
            left join users on users.id_user = courses.id_teacher;

        ";
        $stmt = $pdo->prepare($qry);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $courses = [];
        
        foreach($data as $row){
            $object = new self($pdo);
            $object->setId($row['id_course']);
            $object->setTitle($row['title']);
            $object->setDescription($row['description']);
            $object->setContent($row['content']);
            $object->setTeacher($row['user_name']);
            $object->setCategorie($row['categorie_name']);
            array_push($courses, $object);
        }
        return $courses;
    }

    public static function readCoursesByCategorie($pdo, $id_categorie) {
        $qry = "
            SELECT * 
            FROM courses 
            LEFT JOIN categories 
            ON courses.id_categorie = categories.id_categorie
            LEFT JOIN users 
            ON users.id_user = courses.id_teacher
            WHERE courses.id_categorie = :id_categorie
        ";
    
        $stmt = $pdo->prepare($qry);
        $stmt->bindParam(':id_categorie', $id_categorie);
    
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $courses = [];
    
        foreach ($data as $row) {
            $object = new self($pdo); 
            $object->setId($row['id_course']);
            $object->setTitle($row['title']);
            $object->setDescription($row['description']);
            $object->setContent($row['content']);
            $object->setTeacher($row['user_name']);
            $object->setCategorie($row['categorie_name']);
            $object->setType($row['type']);
            array_push($courses, $object);
            
        }
        return $courses;
    }


    public static function searchCourses($pdo, $searchTerm) {
        $qry = "
            SELECT * 
            FROM courses 
            LEFT JOIN categories 
            ON courses.id_categorie = categories.id_categorie
            LEFT JOIN users 
            ON users.id_user = courses.id_teacher
            WHERE courses.title LIKE :searchTerm
        ";
    
        $stmt = $pdo->prepare($qry);
        $searchTerm = "%$searchTerm%";
        $stmt->bindParam(':searchTerm', $searchTerm);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        $courses = [];
    
        foreach ($data as $row) {
            $object = new self($pdo);
            $object->setId($row['id_course']);
            $object->setTitle($row['title']);
            $object->setDescription($row['description']);
            $object->setContent($row['content']);
            $object->setTeacher($row['user_name']);
            $object->setCategorie($row['categorie_name']);
            $object->setType($row['type']);
    

    
            array_push($courses, $object);
        }
    
        return $courses;
    }


    public function insertUserToClass($id_user) {
        try {
            $qryCheck = "SELECT COUNT(*) FROM usersInClass WHERE id_user = :user AND id_course = :course";
            $stmtCheck = $this->pdo->prepare($qryCheck);
            $stmtCheck->bindParam(":user", $id_user);
            $stmtCheck->bindParam(":course", $this->id_course);
            $stmtCheck->execute();
    
            if ($stmtCheck->fetchColumn() > 0) {
                throw new Exception("User {$id_user} is already enrolled in Course {$this->id_course}.");
            }
    
            // Insert the pair into usersInClass
            $qryInsert = "INSERT INTO usersInClass (id_user, id_course) VALUES (:user, :course)";
            $stmtInsert = $this->pdo->prepare($qryInsert);
            $stmtInsert->bindParam(":user", $id_user);
            $stmtInsert->bindParam(":course", $this->id_course);
            $stmtInsert->execute();
    
        } catch (Exception $ex) {
            throw new Exception("Error in insertUserToClass method: " . $ex->getMessage());
        }
    }




    public function signCourse($id_user) {
        try {
            // Validate course exists
            if (empty($this->id_course)) {
                throw new Exception("Course ID not specified");
            }
    
            // Check existing enrollment
            $qryCheck = "SELECT COUNT(*) FROM usersInClass 
                        WHERE id_user = :user_id 
                        AND id_course = :course_id";
            
            $stmtCheck = $this->pdo->prepare($qryCheck);
            $stmtCheck->bindValue(":user_id", $id_user, );
            $stmtCheck->bindValue(":course_id", $this->id_course);
            $stmtCheck->execute();
    
            if ($stmtCheck->fetchColumn() > 0) {
                throw new Exception("You're already enrolled in this course");
            }
    
            // Insert enrollment
            $qryInsert = "INSERT INTO usersInClass (id_user, id_course)
                        VALUES (:user_id, :course_id)";
            
            $stmtInsert = $this->pdo->prepare($qryInsert);
            $stmtInsert->bindValue(":user_id", $id_user);
            $stmtInsert->bindValue(":course_id", $this->id_course);
            
            if (!$stmtInsert->execute()) {
                throw new Exception("Failed to complete enrollment");
            }
    
            return true;
    
        } catch (PDOException $e) {
            throw new Exception("Database error: " . $e->getMessage());
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    
    



    public static function readCoursesByPagination($pdo, $limit = 6, $offset = 0) {
        $qry = "
            SELECT * FROM courses 
            LEFT JOIN 
            categories  ON 
            courses.id_categorie = categories.id_categorie 
            LEFT JOIN users 
            ON users.id_user = courses.id_teacher 
            LIMIT :offset, :limit
        ";
        
        $stmt = $pdo->prepare($qry);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);  
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT); 
        $stmt->execute();
        
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $courses = [];
        foreach ($data as $row) {
            $object = new self($pdo);
            $object->setId($row['id_course']);
            $object->setTitle($row['title']);
            $object->setDescription($row['description']);
            $object->setContent($row['content']);
            $object->setTeacher($row['user_name']);
            $object->setCategorie($row['categorie_name']);
            
            array_push($courses, $object);
        }
        return $courses;
    }


    public static function readCoursesByTeacher($pdo,$id_teacher){
        $qry = "
            SELECT * 
            FROM courses 
            left join categories 
            ON courses.id_categorie = categories.id_categorie
            left join users on users.id_user = courses.id_teacher
            where id_teacher = :id_teacher
            ;

        ";
        $stmt = $pdo->prepare($qry);
        $stmt->bindParam(":id_teacher",$id_teacher);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $courses = [];
        
        foreach($data as $row){
            $object = new self($pdo);
            $object->setId($row['id_course']);
            $object->setTitle($row['title']);
            $object->setDescription($row['description']);
            $object->setContent($row['content']);
            $object->setTeacher($row['user_name']);
            $object->setCategorie($row['categorie_name']);
            array_push($courses, $object);
        }
        return $courses;
    }



    public static function readCoursesById($pdo, $id) {
        // First query for course details
        $qry = "
            SELECT courses.*, categories.categorie_name, users.user_name 
            FROM courses 
            LEFT JOIN categories ON courses.id_categorie = categories.id_categorie
            LEFT JOIN users ON users.id_user = courses.id_teacher
            WHERE courses.id_course = :id_course
        ";
    
        // Second query for tags
        $qry2 = "
            SELECT tags.* 
            FROM tagspost
            LEFT JOIN tags ON tagspost.id_tag = tags.id_tag
            WHERE id_course = :id_course
        ";
    
        // Prepare and execute first statement
        $stmt = $pdo->prepare($qry);
        $stmt->bindParam(":id_course", $id, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // Prepare and execute second statement
        $stmt2 = $pdo->prepare($qry2);
        $stmt2->bindParam(":id_course", $id, PDO::PARAM_INT);
        $stmt2->execute();
        $tags = $stmt2->fetchAll(PDO::FETCH_ASSOC);
    
        $courses = [];
        
        foreach($data as $row) {
            $object = new self($pdo);
            $object->setId($row['id_course']);
            $object->setTitle($row['title']);
            $object->setDescription($row['description']);
            $object->setContent($row['content']);
            $object->setTeacher($row['user_name']);
            $object->setCategorie($row['categorie_name']);
            $object->setType($row['type']);
            
            $courseTags = [];
            foreach($tags as $tag) {
                $courseTags[] = $tag['tag_name']; 
            }
            $object->setTags($courseTags);
            
            $courses[] = $object;
        }
        
        return $courses;
    }
    
    

    public function delete() {
        try {
            $qry = "DELETE FROM courses WHERE id_course = :id_course";
            $stmt = $this->pdo->prepare($qry);
            $stmt->bindParam(":id_course", $this->id_course);
            $stmt->execute();
        } catch(Exception $ex) {
            throw new Exception("Error in delete method: " . $ex->getMessage());
        }
    }   



    public function update() {
        try {
            $qry = "UPDATE courses 
                    SET course_title = :title,
                        course_description = :description,
                        course_content = :content
                    WHERE id_course = :id_course";
            $stmt = $this->pdo->prepare($qry);
            $stmt->bindParam(":title", $this->title);
            $stmt->bindParam(":description", $this->description);
            $stmt->bindParam(":content", $this->content);
            $stmt->bindParam(":id_course", $this->id_course);
            $stmt->execute();
        } catch(Exception $ex) {
            throw new Exception("Error in update method: " . $ex->getMessage());
        }
    }




    public function insert() {
        try {            
            $qry = "INSERT INTO courses (id_teacher, title,description, 
                    content,type, id_categorie)
                    VALUES (:teacher, :title, :description, :content, :type, :categorie)";
            
            $stmt = $this->pdo->prepare($qry);
            $stmt->bindParam(":teacher", $this->teacher);
            $stmt->bindParam(":title", $this->title);
            $stmt->bindParam(":description", $this->description);
            $stmt->bindParam(":content", $this->content);
            $stmt->bindParam(":type", $this->type);
            $stmt->bindParam(":teacher", $this->teacher);
            $stmt->bindParam(":categorie", $this->categorie);
            $stmt->execute();
    
            $courseId = $this->pdo->lastInsertId();
            
            foreach ($this->tags as $tag) {
                $qryTag = "INSERT INTO tagsPost (id_tag, id_course) VALUES (:tag, :course)";
                $stmtTag = $this->pdo->prepare($qryTag);
                $stmtTag->bindParam(":tag", $tag);
                $stmtTag->bindParam(":course", $courseId);
                $stmtTag->execute();
            }
    
        } catch(Exception $ex) {
            throw new Exception("Error in insert method: " . $ex->getMessage());
        }
    }



//µ///////////////////////////////////////////////
    public function getId() {
        return $this->id_course;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getDescription() {
        return $this->description;
    }

    public function getContent() {
        return $this->content;
    }

    public function getType() {
        return $this->type;
    }


////////////////////////////////////////////////////////////////////////////////
    public function setId($id) {
        $this->id_course = $id;
    }

    public function setTags($tags) {
        $this->tags = $tags;
    }

    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function setContent($content) {
        $this->content = $content;
    }

    public function setType($type) {
        $this->type = $type;
}



public function getCategorie() {
    return $this->categorie;
}


public function setCategorie($categorie) {
    $this->categorie = $categorie;
}



public function getTeacher() {
    return $this->teacher;
}


public function setTeacher($teacher) {
    $this->teacher = $teacher;
}
}