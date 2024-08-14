<?php

$message = $_GET['message'] ?? null;

require_once 'vendor/tpl.php';
include_once 'task-functions.php';
require_once 'connection.php';
require_once 'Task.php';

$conn = getConnection();
$tasks = getAllTasks($conn);

$data = [
    'tasks' => $tasks,
    'message' => $message
];

print renderTemplate('task-list.html', $data);