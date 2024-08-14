<?php

class Employee {
    private int $id;
    private String $firstName;
    private String $lastName;
    private String $position;
    private String $pictureName;
    private int $taskCount;

    public function __construct($id, $firstName, $lastName, $position, $pictureName, $taskCount = 0) {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->position = $position;
        $this->pictureName = $pictureName;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getFirstName(): String {
        return $this->firstName;
    }

    public function getLastName(): String {
        return $this->lastName;
    }

    public function getPosition(): String {
        return $this->position;
    }

    public function getPictureName(): String {
        return $this->pictureName;
    }

    public function getTaskCount(): int {
        return $this->taskCount;
    }

    public function setTaskCount($taskCount): void {
        $this->taskCount = $taskCount;
    }

}