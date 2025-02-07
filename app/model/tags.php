<?php

class Tag {
    private $id_tag;
    private $name;
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Getters
    public function getId() {
        return $this->id_tag;
    }

    public function getName() {
        return $this->name;
    }

    // Setters
    public function setId($id) {
        $this->id_tag = $id;
        return $this;
    }

    public function setName($name) {
        $this->name = $name;
        return $this;
    }
}