<?php
namespace App\Model;

class Course {
    private $id_course;
    private $title;
    private $description;
    private $content;
    private $type;
    private $categorie;
    private $teacher;
    private $tags = [];

    // Getters
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

    public function getCategorie() {
        return $this->categorie;
    }

    public function getTeacher() {
        return $this->teacher;
    }

    public function getTags() {
        return $this->tags;
    }

    // Setters
    public function setId($id) {
        $this->id_course = $id;
        return $this;
    }

    public function setTitle($title) {
        $this->title = $title;
        return $this;
    }

    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    public function setContent($content) {
        $this->content = $content;
        return $this;
    }

    public function setType($type) {
        $this->type = $type;
        return $this;
    }

    public function setCategorie($categorie) {
        $this->categorie = $categorie;
        return $this;
    }

    public function setTeacher($teacher) {
        $this->teacher = $teacher;
        return $this;
    }

    public function setTags($tags) {
        $this->tags = $tags;
        return $this;
    }
}