<?php

function getAllUsers(PDO $pdo): array
{
    $stmt = $pdo->query("
        SELECT
            id,
            name,
            email,
            image,
            created_at
        FROM users
        ORDER BY id DESC
    ");

    return $stmt->fetchAll();
}

function getUserById(
    PDO $pdo,
    int $id
): ?array {
    $stmt = $pdo->prepare("
        SELECT
            id,
            name,
            email,
            image,
            created_at
        FROM users
        WHERE id = :id
    ");

    $stmt->execute([
        ":id" => $id
    ]);

    $user = $stmt->fetch();

    return $user ?: null;
}

function createUser(
    PDO $pdo,
    string $name,
    string $email,
    string $password,
    ?string $image
): bool {
    $stmt = $pdo->prepare("
        INSERT INTO users
        (
            name,
            email,
            password,
            image
        )
        VALUES
        (
            :name,
            :email,
            :password,
            :image
        )
    ");

    return $stmt->execute([
        ":name" => $name,
        ":email" => $email,
        ":password" => $password,
        ":image" => $image
    ]);
}

function updateUserData(
    PDO $pdo,
    int $id,
    string $name,
    string $email,
    ?string $image = null
): bool {

    if ($image !== null) {

        $stmt = $pdo->prepare("
            UPDATE users
            SET
                name = :name,
                email = :email,
                image = :image
            WHERE id = :id
        ");

        return $stmt->execute([
            ":name" => $name,
            ":email" => $email,
            ":image" => $image,
            ":id" => $id
        ]);
    }

    $stmt = $pdo->prepare("
        UPDATE users
        SET
            name = :name,
            email = :email
        WHERE id = :id
    ");

    return $stmt->execute([
        ":name" => $name,
        ":email" => $email,
        ":id" => $id
    ]);
}

function deleteUser(
    PDO $pdo,
    int $id
): bool {
    $stmt = $pdo->prepare("
        DELETE FROM users
        WHERE id = :id
    ");

    return $stmt->execute([
        ":id" => $id
    ]);
}