<?php

$message = $_GET['message'] ?? null;

require_once 'vendor/tpl.php';
include_once 'employee-functions.php';
require_once 'connection.php';
require_once 'Employee.php';

$conn = getConnection();
$employees = getAllEmployees($conn);

$data = [
    'employees' => $employees,
    'message' => $message
];

print renderTemplate('employee-list.html', $data);