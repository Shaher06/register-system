<?php

function isInputEmpty(string $value): bool
{
    return trim($value) === "";
}

function validateName(string $name): bool
{
    return preg_match(
        "/^[a-zA-Z\s]+$/",
        $name
    ) === 1;
}

function validateEmail(string $email): bool
{
    return filter_var(
        $email,
        FILTER_VALIDATE_EMAIL
    ) !== false;
}

function validatePassword(string $password): bool
{
    $pattern =
        "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z\d]).{8,}$/";

    return preg_match(
        $pattern,
        $password
    ) === 1;
}

function encryptPassword(string $password): string
{
    return password_hash(
        $password,
        PASSWORD_DEFAULT
    );
}

function uploadImage(array $file): string
{
    if (
        !isset($file["error"]) ||
        $file["error"] !== UPLOAD_ERR_OK
    ) {
        throw new Exception(
            "Please select a valid image."
        );
    }

    $maxSize = 5 * 1024 * 1024;

    if ($file["size"] > $maxSize) {
        throw new Exception(
            "Image size must not exceed 5MB."
        );
    }

    $allowedTypes = [
        "image/jpeg",
        "image/png",
        "image/webp"
    ];

    $imageInfo = getimagesize(
        $file["tmp_name"]
    );

    if ($imageInfo === false) {
        throw new Exception(
            "The uploaded file is not a valid image."
        );
    }

    if (
        !in_array(
            $imageInfo["mime"],
            $allowedTypes,
            true
        )
    ) {
        throw new Exception(
            "Only JPG, JPEG, PNG and WEBP images are allowed."
        );
    }

    $extension = strtolower(
        pathinfo(
            $file["name"],
            PATHINFO_EXTENSION
        )
    );

    $allowedExtensions = [
        "jpg",
        "jpeg",
        "png",
        "webp"
    ];

    if (
        !in_array(
            $extension,
            $allowedExtensions,
            true
        )
    ) {
        throw new Exception(
            "Unsupported image extension."
        );
    }

    $fileName =
        bin2hex(random_bytes(16))
        . "."
        . $extension;

    $uploadDirectory =
        __DIR__ . "/../uploads/";

    if (!is_dir($uploadDirectory)) {
        mkdir(
            $uploadDirectory,
            0755,
            true
        );
    }

    $destination =
        $uploadDirectory . $fileName;

    if (
        !move_uploaded_file(
            $file["tmp_name"],
            $destination
        )
    ) {
        throw new Exception(
            "Failed to upload image."
        );
    }

    return $fileName;
}