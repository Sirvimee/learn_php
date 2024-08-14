<?php

require_once 'vendor/tpl.php';
include_once 'employee-functions.php';
require_once 'connection.php';
require_once 'Employee.php';

$errors = $_GET['errors'] ?? '';
$errorsArray = [];
$formData = $_GET['formData'] ?? [];

$id = $_GET['id'] ?? '';
$employee = null;

$conn = getConnection();

if (!empty($errors)) {
    $deserializedErrors = unserialize($errors);
} else {
    $deserializedErrors = [];
}

if ($id) {
    $employee = findEmployeeById($id, $conn);
}

$data = [
    'errors' => $deserializedErrors,
    'formData' => $formData,
    'employee' => $employee
];

print renderTemplate('employee-form.html', $data);