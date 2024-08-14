<?php

require_once 'vendor/tpl.php';
include_once 'task-functions.php';
include_once 'employee-functions.php';
require_once 'connection.php';
require_once 'Task.php';

$errors = $_GET['errors'] ?? [];
$errorsArray = [];
$formData = $_GET['formData'] ?? [];

$id = $_GET['id'] ?? '';
$task = null;

$conn = getConnection();
$employees = getAllEmployees($conn);

if (!empty($errors)) {
    $deserializedErrors = unserialize($errors);
} else {
    $deserializedErrors = [];
}

if ($id) {
    $task = findTaskById($id, $conn);
}

$isCompletedChecked = isset($formData['isCompleted']) && $formData['isCompleted'] ===
'closed' ? 'checked' : ($task && $task->getStatus() === 'closed' ? 'checked' : '');

$data = [
    'errors' => $deserializedErrors,
    'formData' => $formData,
    'task' => $task,
    'employees' => $employees,
    'isCompletedChecked' => $isCompletedChecked
];

print renderTemplate('task-form.html', $data);