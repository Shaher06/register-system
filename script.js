const registerForm =
    document.getElementById("registerForm");

const editForm =
    document.getElementById("editForm");

const editModalElement =
    document.getElementById("editModal");

const editModal =
    new bootstrap.Modal(editModalElement);


function showSuccess(message) {

    const modal =
        document.getElementById("successModal");

    if (modal) {
        modal.remove();
    }

    document.body.insertAdjacentHTML(
        "beforeend",
        `
        <div
            class="modal fade"
            id="successModal"
            tabindex="-1"
        >
            <div class="modal-dialog modal-dialog-centered">

                <div class="modal-content border-0 shadow">

                    <div class="modal-body text-center p-5">

                        <div class="success-icon mx-auto mb-3">
                            ✓
                        </div>

                        <h4 class="fw-bold mb-2">
                            Success
                        </h4>

                        <p class="text-secondary mb-4">
                            ${message}
                        </p>

                        <button
                            type="button"
                            class="btn btn-primary px-4"
                            data-bs-dismiss="modal"
                        >
                            Continue
                        </button>

                    </div>

                </div>

            </div>
        </div>
        `
    );

    const successModal =
        new bootstrap.Modal(
            document.getElementById("successModal")
        );

    successModal.show();
}


function showError(message) {

    const modal =
        document.getElementById("errorModal");

    if (modal) {
        modal.remove();
    }

    document.body.insertAdjacentHTML(
        "beforeend",
        `
        <div
            class="modal fade"
            id="errorModal"
            tabindex="-1"
        >
            <div class="modal-dialog modal-dialog-centered">

                <div class="modal-content border-0 shadow">

                    <div class="modal-body text-center p-5">

                        <div class="error-icon mx-auto mb-3">
                            !
                        </div>

                        <h4 class="fw-bold mb-2">
                            Something went wrong
                        </h4>

                        <p class="text-secondary mb-4">
                            ${message}
                        </p>

                        <button
                            type="button"
                            class="btn btn-primary px-4"
                            data-bs-dismiss="modal"
                        >
                            Got it
                        </button>

                    </div>

                </div>

            </div>
        </div>
        `
    );

    const errorModal =
        new bootstrap.Modal(
            document.getElementById("errorModal")
        );

    errorModal.show();
}


function showDeleteConfirmation() {

    const modal =
        document.getElementById("deleteModal");

    if (modal) {
        modal.remove();
    }

    document.body.insertAdjacentHTML(
        "beforeend",
        `
        <div
            class="modal fade"
            id="deleteModal"
            tabindex="-1"
        >
            <div class="modal-dialog modal-dialog-centered">

                <div class="modal-content border-0 shadow">

                    <div class="modal-body text-center p-5">

                        <div class="warning-icon mx-auto mb-3">
                            !
                        </div>

                        <h4 class="fw-bold mb-2">
                            Delete User?
                        </h4>

                        <p class="text-secondary mb-4">
                            This action cannot be undone.
                        </p>

                        <div class="d-flex justify-content-center gap-2">

                            <button
                                type="button"
                                class="btn btn-light border"
                                data-bs-dismiss="modal"
                            >
                                Cancel
                            </button>

                            <button
                                type="button"
                                class="btn btn-danger"
                                id="confirmDelete"
                            >
                                Yes, Delete
                            </button>

                        </div>

                    </div>

                </div>

            </div>
        </div>
        `
    );

    return new bootstrap.Modal(
        document.getElementById("deleteModal")
    );
}


registerForm.addEventListener(
    "submit",
    async function (event) {

        event.preventDefault();

        const formData =
            new FormData(registerForm);

        const button =
            document.getElementById(
                "registerButton"
            );

        button.disabled = true;
        button.textContent = "Creating...";

        try {

            const response =
                await fetch(
                    "save.php",
                    {
                        method: "POST",
                        body: formData
                    }
                );

            const result =
                await response.json();

            if (result.success) {

                registerForm.reset();

                showSuccess(
                    result.message
                );

                setTimeout(
                    () => location.reload(),
                    1200
                );

            } else {

                showError(
                    result.message
                );
            }

        } catch (error) {

            showError(
                "Unable to connect to the server."
            );

        } finally {

            button.disabled = false;
            button.textContent = "Create Account";

        }

    }
);


document
    .querySelectorAll(".edit-button")
    .forEach(
        button => {

            button.addEventListener(
                "click",
                async function () {

                    const id =
                        this.dataset.id;

                    try {

                        const response =
                            await fetch(
                                `edit.php?id=${id}`
                            );

                        const result =
                            await response.json();

                        if (!result.success) {

                            showError(
                                result.message
                            );

                            return;
                        }

                        document
                            .getElementById("editId")
                            .value =
                            result.user.id;

                        document
                            .getElementById("editName")
                            .value =
                            result.user.name;

                        document
                            .getElementById("editEmail")
                            .value =
                            result.user.email;

                        document
                            .getElementById("editImage")
                            .value = "";

                        editModal.show();

                    } catch (error) {

                        showError(
                            "Unable to load user data."
                        );

                    }

                }
            );

        }
    );


editForm.addEventListener(
    "submit",
    async function (event) {

        event.preventDefault();

        const formData =
            new FormData(editForm);

        const button =
            editForm.querySelector(
                "button[type='submit']"
            );

        button.disabled = true;
        button.textContent = "Saving...";

        try {

            const response =
                await fetch(
                    "update.php",
                    {
                        method: "POST",
                        body: formData
                    }
                );

            const result =
                await response.json();

            if (result.success) {

                editModal.hide();

                showSuccess(
                    result.message
                );

                setTimeout(
                    () => location.reload(),
                    1200
                );

            } else {

                showError(
                    result.message
                );

            }

        } catch (error) {

            showError(
                "Unable to connect to the server."
            );

        } finally {

            button.disabled = false;
            button.textContent = "Save Changes";

        }

    }
);


document
    .querySelectorAll(".delete-button")
    .forEach(
        button => {

            button.addEventListener(
                "click",
                function () {

                    const id =
                        this.dataset.id;

                    const deleteModal =
                        showDeleteConfirmation();

                    deleteModal.show();

                    document
                        .getElementById(
                            "confirmDelete"
                        )
                        .addEventListener(
                            "click",
                            async function () {

                                this.disabled = true;
                                this.textContent =
                                    "Deleting...";

                                const formData =
                                    new FormData();

                                formData.append(
                                    "id",
                                    id
                                );

                                try {

                                    const response =
                                        await fetch(
                                            "delete.php",
                                            {
                                                method: "POST",
                                                body: formData
                                            }
                                        );

                                    const result =
                                        await response.json();

                                    deleteModal.hide();

                                    if (
                                        result.success
                                    ) {

                                        showSuccess(
                                            result.message
                                        );

                                        setTimeout(
                                            () => location.reload(),
                                            1200
                                        );

                                    } else {

                                        showError(
                                            result.message
                                        );

                                    }

                                } catch (error) {

                                    deleteModal.hide();

                                    showError(
                                        "Unable to connect to the server."
                                    );

                                }

                            }
                        );

                }
            );

        }
    );