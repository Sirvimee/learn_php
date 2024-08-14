<?php

require_once 'vendor/tpl.php';
include_once 'employee-functions.php';
include_once 'task-functions.php';
require_once 'connection.php';
require_once 'Employee.php';
require_once 'Task.php';

$conn = getConnection();
$employees = getAllEmployees($conn);
$tasks = getAllTasks($conn);

function countEmployeeTasks($getId, PDO $conn) {
    $stmt = $conn->prepare('SELECT COUNT(*) FROM tasks WHERE assigned_to = :id;');
    $stmt->bindValue(':id', $getId);
    $stmt->execute();
    return $stmt->fetchColumn();
}

foreach ($employees as $employee) {
    $employee->setTaskCount(countEmployeeTasks($employee->getId(), $conn));
}

$data = [
    'employees' => $employees,
    'tasks' => $tasks
];

print renderTemplate('dashboard.html', $data);


