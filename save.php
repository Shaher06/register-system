<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "config/connection.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Invalid request method");
}

$name = trim($_POST["name"] ?? "");
$email = trim($_POST["email"] ?? "");
$password = $_POST["password"] ?? "";

$errors = [];

if ($name === "") {
    $errors[] = "Name is required";
} elseif (strlen($name) < 3) {
    $errors[] = "Name must be at least 3 characters";
} elseif (strlen($name) > 50) {
    $errors[] = "Name must not exceed 50 characters";
}

if ($email === "") {
    $errors[] = "Email is required";
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email";
}

if ($password === "") {
    $errors[] = "Password is required";
} elseif (strlen($password) < 8) {
    $errors[] = "Password must be at least 8 characters";
}

if (!empty($errors)) {
    foreach ($errors as $error) {
        echo $error . "<br>";
    }

    exit;
}

$checkEmail = "SELECT id FROM users WHERE email = :email";

$stmt = $pdo->prepare($checkEmail);

$stmt->execute([
    ":email" => $email
]);

if ($stmt->fetch()) {
    die("Email already exists");
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO users(name, email, password)
        VALUES(:name, :email, :password)";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ":name" => $name,
    ":email" => $email,
    ":password" => $hashedPassword
]);

header("Location: success.php");
exit;