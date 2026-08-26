<?php

require_once "config/database.php";
require_once "functions/user.php";

$users = getAllUsers($pdo);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Register System</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="style.css"
    >

</head>

<body>

<div class="container py-5">

    <div class="page-header mb-5">

        <span class="badge text-bg-primary mb-3">
            USER MANAGEMENT
        </span>

        <h1 class="fw-bold">
            Create Account
        </h1>

        <p class="text-secondary">
            Create and manage registered users.
        </p>

    </div>


    <div class="card border-0 shadow-sm mb-5">

        <div class="card-body p-4 p-md-5">

            <form
                id="registerForm"
                enctype="multipart/form-data"
            >

                <div class="row g-4">

                    <div class="col-md-6">

                        <label
                            for="name"
                            class="form-label"
                        >
                            Name
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="name"
                            name="name"
                            placeholder="Enter your name"
                            required
                        >

                    </div>


                    <div class="col-md-6">

                        <label
                            for="email"
                            class="form-label"
                        >
                            Email
                        </label>

                        <input
                            type="email"
                            class="form-control"
                            id="email"
                            name="email"
                            placeholder="Enter your email"
                            required
                        >

                    </div>


                    <div class="col-md-6">

                        <label
                            for="password"
                            class="form-label"
                        >
                            Password
                        </label>

                        <input
                            type="password"
                            class="form-control"
                            id="password"
                            name="password"
                            placeholder="Enter your password"
                            required
                        >

                        <div class="form-text">
                            8+ characters, uppercase,
                            lowercase, number and special character.
                        </div>

                    </div>


                    <div class="col-md-6">

                        <label
                            for="image"
                            class="form-label"
                        >
                            Profile Image
                        </label>

                        <input
                            type="file"
                            class="form-control"
                            id="image"
                            name="image"
                            accept=".jpg,.jpeg,.png,.webp"
                            required
                        >

                        <div class="form-text">
                            JPG, JPEG, PNG or WEBP. Maximum 5MB.
                        </div>

                    </div>

                </div>


                <div class="mt-4">

                    <button
                        type="submit"
                        class="btn btn-primary px-4"
                        id="registerButton"
                    >
                        Create Account
                    </button>

                </div>

            </form>

        </div>

    </div>


    <div class="d-flex justify-content-between align-items-center mb-3">

        <div>

            <span class="section-label">
                DATABASE
            </span>

            <h2 class="fw-bold mb-0">
                Registered Users
            </h2>

        </div>

        <span class="badge rounded-pill text-bg-light border">
            <?= count($users) ?> Users
        </span>

    </div>


    <?php if (empty($users)): ?>

        <div class="empty-state text-center py-5">

            <div class="empty-icon mx-auto mb-3">
                +
            </div>

            <h4>
                No users yet
            </h4>

            <p class="text-secondary mb-0">
                Create your first account using the form above.
            </p>

        </div>

    <?php else: ?>

        <div class="row g-4">

            <?php foreach ($users as $user): ?>

                <div
                    class="col-md-6"
                    id="user-<?= (int) $user["id"] ?>"
                >

                    <div class="card user-card h-100 border-0 shadow-sm">

                        <div class="card-body p-4">

                            <div class="d-flex align-items-center gap-3">

                                <?php if (!empty($user["image"])): ?>

                                    <img
                                        src="uploads/<?= htmlspecialchars($user["image"]) ?>"
                                        alt="Profile image"
                                        class="user-image"
                                    >

                                <?php else: ?>

                                    <div class="user-avatar">

                                        <?= strtoupper(
                                            substr(
                                                $user["name"],
                                                0,
                                                1
                                            )
                                        ) ?>

                                    </div>

                                <?php endif; ?>


                                <div class="flex-grow-1 overflow-hidden">

                                    <h5 class="fw-bold mb-1">

                                        <?= htmlspecialchars(
                                            $user["name"]
                                        ) ?>

                                    </h5>

                                    <p class="text-secondary mb-1 text-truncate">

                                        <?= htmlspecialchars(
                                            $user["email"]
                                        ) ?>

                                    </p>

                                    <small class="text-muted">

                                        Joined
                                        <?= htmlspecialchars(
                                            $user["created_at"]
                                        ) ?>

                                    </small>

                                </div>

                            </div>


                            <div class="d-flex gap-2 mt-4">

                                <button
                                    type="button"
                                    class="btn btn-sm btn-outline-primary edit-button"
                                    data-id="<?= (int) $user["id"] ?>"
                                >
                                    Edit
                                </button>


                                <button
                                    type="button"
                                    class="btn btn-sm btn-outline-danger delete-button"
                                    data-id="<?= (int) $user["id"] ?>"
                                >
                                    Delete
                                </button>

                            </div>

                        </div>

                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    <?php endif; ?>

</div>


<div
    class="modal fade"
    id="editModal"
    tabindex="-1"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 shadow">

            <div class="modal-header">

                <div>

                    <span class="section-label">
                        EDIT USER
                    </span>

                    <h4 class="modal-title fw-bold">
                        Update Account
                    </h4>

                </div>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>

            </div>


            <div class="modal-body p-4">

                <form
                    id="editForm"
                    enctype="multipart/form-data"
                >

                    <input
                        type="hidden"
                        id="editId"
                        name="id"
                    >


                    <div class="mb-3">

                        <label
                            for="editName"
                            class="form-label"
                        >
                            Name
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="editName"
                            name="name"
                            required
                        >

                    </div>


                    <div class="mb-3">

                        <label
                            for="editEmail"
                            class="form-label"
                        >
                            Email
                        </label>

                        <input
                            type="email"
                            class="form-control"
                            id="editEmail"
                            name="email"
                            required
                        >

                    </div>


                    <div class="mb-3">

                        <label
                            for="editImage"
                            class="form-label"
                        >
                            New Profile Image
                        </label>

                        <input
                            type="file"
                            class="form-control"
                            id="editImage"
                            name="image"
                            accept=".jpg,.jpeg,.png,.webp"
                        >

                    </div>


                    <button
                        type="submit"
                        class="btn btn-primary w-100"
                    >
                        Save Changes
                    </button>

                </form>

            </div>

        </div>

    </div>

</div>


<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
></script>

<script src="script.js"></script>

</body>

</html>