<?php

require_once 'connection.php';
require_once 'Employee.php';
$conn = getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['deleteButton'])) {
        $id = $_POST['id'];
        deleteEmployee($id, $conn);
        header("Location: employee-list.php?message=deleted");

    } else {
        $formData = $_POST;
        $formData['picture'] = $_FILES['picture'] ?? null;
        $result = addEmployee($formData, $conn);

        if (!empty($result['errors'])) {
            $serializedErrors = serialize($result['errors']);
            $queryString = http_build_query(['errors' => $serializedErrors, 'formData' => $result['formData']]);
            header("Location: employee-form.php?$queryString");
            exit;
        } else {
            header("Location: employee-list.php?message=success");
            exit;
        }
    }
}

function addEmployee($formData, $conn): array {
    $errors = [];
    $id = $formData['id'] ?? null;
    $pictureName = ' ';

    if ($id !== null && $id !== '') {
        $pictureName = findEmployeeById($id, $conn)->getPictureName();
    }

    $fname = urlencode($formData['firstName']);
    $lname = urlencode($formData['lastName']);
    $position = $formData['position'];


    if (strlen($fname) < 1 || strlen($fname) > 21) {
        $errors[] = "Eesnime pikkus peab olema 1 kuni 21 märki.";
    }

    if (strlen($lname) < 2 || strlen($lname) > 22) {
        $errors[] = "Perekonnanime pikkus peab olema 2 kuni 22 märki.";
    }

    // Upload picture
    if (isset($formData['picture']) && $formData['picture']['error'] == 0) {
        $date = date('Y-m-d');
        $targetFilePath = __DIR__ . "/" . $date . "-" . basename($formData["picture"]["name"]);

        // Upload file to server
        if (move_uploaded_file($formData["picture"]["tmp_name"], $targetFilePath)) {
            $pictureName = $date . "-" . basename($formData["picture"]["name"]);
        } else {
            $errors[] = 'Pildi üleslaadimisel tekkis viga. Palun proovi uuesti.';
        }
    }

    if (empty($errors)) {
        if ($id !== null && $id !== '') {
            $stmt = $conn->prepare('UPDATE employees SET 
                     first_name = :first_name, 
                     last_name = :last_name, 
                     position = :position, 
                     image = :picture_name WHERE employee_id = :id');
            $stmt->bindValue(':id', $id);
        } else {
            $stmt = $conn->prepare('INSERT INTO employees (first_name, last_name, position, image) VALUES 
                                                                                (:first_name, :last_name, 
                                                                                 :position, :picture_name);');
        }
        $stmt->bindValue(':first_name', $fname);
        $stmt->bindValue(':last_name', $lname);
        $stmt->bindValue(':position', $position);
        $stmt->bindValue(':picture_name', $pictureName);
        $stmt->execute();
    }

    return ['errors' => $errors, 'formData' => $formData];
}

function getAllEmployees($conn): array {
    $stmt = $conn->prepare('SELECT * FROM employees;');
    $stmt->execute();

    $employees = [];
    foreach ($stmt as $row) {
        $id = $row['employee_id'];
        $firstName = urldecode($row['first_name']);
        $lastName = urldecode($row['last_name']);
        $position = $row['position'];
        $pictureName = $row['image'];
        $employees[] = new Employee($id, $firstName, $lastName, $position, $pictureName);
    }

    return $employees;
}

function findEmployeeById($id, $conn): Employee {
    $stmt = $conn->prepare('SELECT * FROM employees WHERE employee_id = :id;');
    $stmt->bindValue(':id', $id);
    $stmt->execute();

    $row = $stmt->fetch();
    $id = $row['employee_id'];
    $firstName = urldecode($row['first_name']);
    $lastName = urldecode($row['last_name']);
    $position = $row['position'];
    $pictureName = $row['image'];
    return new Employee($id, $firstName, $lastName, $position, $pictureName);
}

function deleteEmployee($id, $conn): void {
    $stmt = $conn->prepare('DELETE FROM employees WHERE employee_id = :id;');
    $stmt->bindValue(':id', $id);
    $stmt->execute();
}




