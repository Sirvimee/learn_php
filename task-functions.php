<?php

require_once 'Task.php';
require_once 'connection.php';

$conn = getConnection();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['deleteButton'])) {
        $id = $_POST['id'];
        deleteTask($id, $conn);
        header("Location: task-list.php?message=deleted");
    } else {
        $formData = $_POST;
        $isCompleted = $_POST['isCompleted'] ?? '';
        $result = addTask($formData, $conn);

        if (!empty($result['errors'])) {
            $serializedErrors = serialize($result['errors']);
            $queryString = http_build_query(['errors' => $serializedErrors, 'formData' => $result['formData']]);
            header("Location: task-form.php?$queryString");
            exit;
        } else {
            header("Location: task-list.php?message=success");
            exit;
        }
    }
}

function addTask($formData, $conn): array {
    $errors = [];
    $id = $formData['id'] ?? null;
    $description = $formData["description"] ?? '';
    $assignedTo = $formData['employeeId'] ?? null;
    $estimate = $formData["estimate"];
    $isCompleted = isset($formData['isCompleted']) && $formData['isCompleted'] === 'closed';
    $status = $isCompleted ? 'closed' : (!empty($assignedTo) ? 'pending' : 'open');

    if (strlen($description) < 5 || strlen($description) > 40) {
        $errors[] = "Kirjeldus peab olema 5 kuni 40 märki.";
    }

    if (!empty($estimate) && !is_numeric($estimate)) {
        $estimate = 1;
    }

    if (empty($errors)) {
        if ($id !== null && $id !== '') {
            $stmt = $conn->prepare("UPDATE tasks SET 
                description = :description, 
                assigned_to = :assignedTo,
                estimate = :estimate,
                status = :status WHERE task_id = :id");
            $stmt->bindValue(':id', $id);
        } else {
            $stmt = $conn->prepare("INSERT INTO tasks (description, assigned_to, estimate, status) VALUES 
                                                           (:description, :assignedTo,:estimate, :status)");
        }
        $stmt->bindValue(':description', $description);
        $stmt->bindValue(':assignedTo', $assignedTo, PDO::PARAM_INT);
        $stmt->bindValue(':estimate', $estimate);
        $stmt->bindValue(':status', $status);
        $stmt->execute();
    }

    return ['errors' => $errors, 'formData' => $formData];
}

function getAllTasks($conn): array {
    $stmt = $conn->prepare("SELECT * FROM tasks;");
    $stmt->execute();

    $tasks = [];
    foreach ($stmt as $row) {
        $id = $row['task_id'];
        $description = $row['description'];
        $assignedTo = $row['assigned_to'] ?? null;
        $estimate = $row['estimate'];
        $status = $row['status'];
        $tasks[] = new Task($id, $description, $assignedTo, $estimate, $status);
    }

    return $tasks;
}

function findTaskById($id, $conn): Task {
    $stmt = $conn->prepare("SELECT * FROM tasks WHERE task_id = :id");
    $stmt->bindValue(':id', $id);
    $stmt->execute();

    $row = $stmt->fetch();
    $id = $row['task_id'];
    $description = $row['description'];
    $assignedTo = $row['assigned_to'] ?? null;
    $estimate = $row['estimate'];
    $status = $row['status'];
    return new Task($id, $description, $assignedTo, $estimate, $status);
}

function deleteTask($id, $conn): void {
    $stmt = $conn->prepare("DELETE FROM tasks WHERE task_id = :id");
    $stmt->bindValue(':id', $id);
    $stmt->execute();
}