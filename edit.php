<?php

require_once "config/database.php";
require_once "functions/user.php";

header("Content-Type: application/json");

$id = filter_input(
    INPUT_GET,
    "id",
    FILTER_VALIDATE_INT
);

if (!$id) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid user ID."
    ]);

    exit;
}

$user = getUserById($pdo, $id);

if (!$user) {
    echo json_encode([
        "success" => false,
        "message" => "User not found."
    ]);

    exit;
}

echo json_encode([
    "success" => true,
    "user" => $user
]);