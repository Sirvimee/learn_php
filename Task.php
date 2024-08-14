<?php

class Task {
    private int $id;
    private String $description;
    private ?int $assignedTo;
    private ?int $estimate;
    private String $status;

    public function __construct($id, $description, ?int $assignedTo, ?int $estimate, $status) {
        $this->id = $id;
        $this->description = $description;
        $this->assignedTo = $assignedTo;
        $this->estimate = $estimate;
        $this->status = $status;
    }

    public function getId(): int {
        return $this->id;
    }

    public function getDescription(): String {
        return $this->description;
    }

    public function getAssignedTo(): int {
        return $this->assignedTo;
    }

    public function getEstimate(): int {
        return $this->estimate ?? 0;
    }

    public function getStatus(): String {
        return $this->status;
    }
}