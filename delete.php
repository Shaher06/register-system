<?php

require_once "config/database.php";
require_once "functions/user.php";

header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo json_encode([
        "success" => false,
        "message" => "Invalid request method."
    ]);

    exit;
}

$id = filter_input(
    INPUT_POST,
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

try {

    $user =
        getUserById($pdo, $id);

    if (!$user) {
        echo json_encode([
            "success" => false,
            "message" => "User not found."
        ]);

        exit;
    }

    deleteUser(
        $pdo,
        $id
    );

    if (!empty($user["image"])) {

        $imagePath =
            __DIR__ .
            "/uploads/" .
            $user["image"];

        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    echo json_encode([
        "success" => true,
        "message" =>
            "User deleted successfully."
    ]);

} catch (PDOException $e) {

    echo json_encode([
        "success" => false,
        "message" =>
            "Unable to delete this user."
    ]);
}