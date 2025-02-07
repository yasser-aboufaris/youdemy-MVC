<?php


class TagDAO {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function readAll() {
        try {
            $qry = "SELECT * FROM tags";
            $stmt = $this->pdo->prepare($qry);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $tags = [];
            
            foreach ($data as $row) {
                $tag = new Tag($this->pdo);
                $tag->setId($row['id_tag']);
                $tag->setName($row['tag_name']);
                $tags[] = $tag;
            }
            return $tags;
        } catch (Exception $ex) {
            throw new Exception("Error in readAll method: " . $ex->getMessage());
        }
    }

    public function readTagsByCourse($id_course) {
        try {
            $qry = "SELECT * FROM tagspost 
                    LEFT JOIN tags ON tagspost.id_tag = tags.id_tag 
                    WHERE id_course = :id_course";
            $stmt = $this->pdo->prepare($qry);
            $stmt->bindParam(':id_course', $id_course, PDO::PARAM_INT);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $tags = [];
            
            foreach ($data as $row) {
                $tag = new Tag($this->pdo);
                $tag->setId($row['id_tag']);
                $tag->setName($row['tag_name']);
                $tags[] = $tag;
            }
            return $tags;
        } catch (Exception $ex) {
            throw new Exception("Error in readTagsByCourse method: " . $ex->getMessage());
        }
    }

    public function findById($id) {
        try {
            $qry = "SELECT * FROM tags WHERE id_tag = :id_tag";
            $stmt = $this->pdo->prepare($qry);
            $stmt->bindParam(":id_tag", $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch(Exception $ex) {
            throw new Exception("Error in findById method: " . $ex->getMessage());
        }
    }

    public function delete(Tag $tag) {
        try {
            $qry = "DELETE FROM tags WHERE id_tag = :id_tag";
            $stmt = $this->pdo->prepare($qry);
            $stmt->bindParam(":id_tag", $tag->getId());
            $stmt->execute();
        } catch(Exception $ex) {
            throw new Exception("Error in delete method: " . $ex->getMessage());
        }
    }

    public function update(Tag $tag) {
        try {
            $qry = "UPDATE tags SET tag_name = :name WHERE id_tag = :id_tag";
            $stmt = $this->pdo->prepare($qry);
            $stmt->bindParam(":name", $tag->getName());
            $stmt->bindParam(":id_tag", $tag->getId());
            $stmt->execute();
        } catch(Exception $ex) {
            throw new Exception("Error in update method: " . $ex->getMessage());
        }
    }

    public function insert(Tag $tag) {
        try {
            $qry = "INSERT INTO tags (tag_name) VALUES (:name)";
            $stmt = $this->pdo->prepare($qry);
            
            if (empty($tag->getName())) {
                throw new Exception("Tag name cannot be empty.");
            }
            
            $stmt->bindParam(":name", $tag->getName());
            $stmt->execute();
        } catch (Exception $ex) {
            throw new Exception("Error in insert method: " . $ex->getMessage());
        }
    }
}