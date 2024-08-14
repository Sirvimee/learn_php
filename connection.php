<?php

const USERNAME = '';
const PASSWORD = '';

function getConnection(): PDO {
    $host = '';

    $address = sprintf('mysql:host=%s;port=3306;dbname=%s',
        $host, USERNAME);

    return new PDO($address, USERNAME, PASSWORD);
}
