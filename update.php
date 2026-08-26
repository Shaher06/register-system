<?php

require_once "config/database.php";
require_once "functions/validation.php";
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

$name = trim(
    $_POST["name"] ?? ""
);

$email = trim(
    $_POST["email"] ?? ""
);

if (!$id) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid user ID."
    ]);

    exit;
}

if (
    isInputEmpty($name) ||
    isInputEmpty($email)
) {
    echo json_encode([
        "success" => false,
        "message" => "Please fill in all required fields."
    ]);

    exit;
}

if (!validateName($name)) {
    echo json_encode([
        "success" => false,
        "message" =>
            "Name can contain letters and spaces only."
    ]);

    exit;
}

if (!validateEmail($email)) {
    echo json_encode([
        "success" => false,
        "message" =>
            "Please enter a valid email address."
    ]);

    exit;
}

try {

    $currentUser =
        getUserById($pdo, $id);

    if (!$currentUser) {
        echo json_encode([
            "success" => false,
            "message" => "User not found."
        ]);

        exit;
    }

    $imageName = null;

    if (
        isset($_FILES["image"]) &&
        $_FILES["image"]["error"] !==
        UPLOAD_ERR_NO_FILE
    ) {

        $imageName =
            uploadImage(
                $_FILES["image"]
            );
    }

    updateUserData(
        $pdo,
        $id,
        $name,
        $email,
        $imageName
    );

    if (
        $imageName !== null &&
        !empty($currentUser["image"])
    ) {

        $oldImage =
            __DIR__ .
            "/uploads/" .
            $currentUser["image"];

        if (file_exists($oldImage)) {
            unlink($oldImage);
        }
    }

    echo json_encode([
        "success" => true,
        "message" =>
            "User updated successfully."
    ]);

} catch (PDOException $e) {

    if ($e->getCode() === "23000") {

        echo json_encode([
            "success" => false,
            "message" =>
                "This email address is already registered."
        ]);

        exit;
    }

    echo json_encode([
        "success" => false,
        "message" =>
            "Something went wrong while updating the user."
    ]);

} catch (Exception $e) {

    echo json_encode([
        "success" => false,
        "message" =>
            $e->getMessage()
    ]);
}