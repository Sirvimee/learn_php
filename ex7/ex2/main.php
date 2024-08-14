<?php

require_once '../vendor/tpl.php';

$errors = ['Pealkiri peab olema 2 kuni 10 märki', 'Hinne peab olema määratud'];

$data = [
    'errors' => $errors,
    'title' => 'Head First HTML and CSS',
    'gradeValue' => 2,
    'isRead' => false,
    'isEditForm' => true
];

print renderTemplate('form.html', $data);