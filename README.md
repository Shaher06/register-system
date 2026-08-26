# Register System

A clean and modular PHP user registration and management system built with PHP, MySQL, PDO, Bootstrap, HTML, CSS, and JavaScript.

The project focuses on implementing a secure and maintainable backend while providing a simple and responsive user interface.

---

## Features

### User Registration

- Create a new user account.
- Validate all required inputs.
- Validate the user's name using Regex.
- Validate email format.
- Validate password strength.
- Hash passwords before storing them.
- Upload a profile image.
- Validate uploaded images before saving them.
- Prevent duplicate email registration.

### Password Validation

Passwords must contain:

- At least 8 characters.
- At least one uppercase letter.
- At least one lowercase letter.
- At least one digit.
- At least one special character.

Passwords are securely hashed using PHP's built-in:

```php
password_hash()
User Management

The system supports complete CRUD operations:

Create users.
Read users.
Update users.
Delete users.

Users can:

Edit their name.
Edit their email.
Replace their profile image.
Delete their account.
Image Upload

Supported image formats:

JPG
JPEG
PNG
WEBP

The system validates:

File upload status.
File size.
Actual image type.
File extension.

Uploaded images are assigned randomized filenames before being stored.

Validation

The backend uses dedicated reusable validation functions:

isInputEmpty()
validateName()
validateEmail()
validatePassword()
uploadImage()
encryptPassword()
updateUserData()

This keeps validation and business logic separate from the main application flow.

Security

The project uses several basic security practices.

Password Hashing

Passwords are never stored as plain text.

password_hash($password, PASSWORD_DEFAULT);
Prepared Statements

Database queries use PDO prepared statements to reduce the risk of SQL injection.

$stmt = $pdo->prepare("
    SELECT *
    FROM users
    WHERE id = :id
");

$stmt->execute([
    ":id" => $id
]);
Output Escaping

User-generated content is escaped before being displayed:

htmlspecialchars($value)
Randomized Image Names

Uploaded images are stored using randomized filenames to avoid filename conflicts.

Technologies
PHP
MySQL
PDO
HTML5
CSS3
JavaScript
Bootstrap 5
XAMPP
Project Structure
register-system/
│
├── config/
│   └── database.php
│
├── functions/
│   ├── validation.php
│   └── user.php
│
├── uploads/
│   └── .gitkeep
│
├── index.php
├── save.php
├── edit.php
├── update.php
├── delete.php
├── script.js
├── style.css
├── .gitignore
└── README.md
Architecture

The project follows a simple separation of responsibilities.

config/database.php

Responsible for establishing the PDO database connection.

functions/validation.php

Contains reusable validation and file-upload functions:

isInputEmpty()
validateName()
validateEmail()
validatePassword()
encryptPassword()
uploadImage()
functions/user.php

Contains database operations related to users:

getAllUsers()
getUserById()
createUser()
updateUserData()
deleteUser()
index.php

The main user interface.

It contains:

Registration form.
Registered users.
Edit modal.
Delete confirmation.
User actions.
save.php

Handles new user registration:

Validate input
      ↓
Validate image
      ↓
Hash password
      ↓
Insert user
      ↓
Return JSON response
edit.php

Retrieves a specific user's data for editing.

update.php

Handles user information updates and optional image replacement.

delete.php

Handles user deletion and removes the associated profile image.

script.js

Handles frontend interactions and AJAX requests:

Registration requests.
Edit requests.
Update requests.
Delete confirmation.
Bootstrap modals.
Success and error messages.
style.css

Contains the project's custom styling and responsive UI improvements.

Application Flow
Registration
User
 │
 ▼
Registration Form
 │
 ▼
JavaScript
 │
 ▼
save.php
 │
 ├── Input Validation
 ├── Regex Validation
 ├── Password Hashing
 ├── Image Validation
 └── Database Insert
 │
 ▼
JSON Response
 │
 ▼
Bootstrap Success/Error Modal
Update
User
 │
 ▼
Edit
 │
 ▼
edit.php
 │
 ▼
Bootstrap Modal
 │
 ▼
update.php
 │
 ├── Validate Input
 ├── Optional Image Upload
 ├── Update Database
 └── Remove Old Image
 │
 ▼
Success Response
Delete
User
 │
 ▼
Delete
 │
 ▼
Confirmation Modal
 │
 ▼
delete.php
 │
 ├── Delete User
 └── Delete Profile Image
 │
 ▼
Success Response
Database

The project uses a MySQL database named:

register_system

The users table contains:

id
name
email
password
image
created_at

Example schema:

CREATE DATABASE register_system;

USE register_system;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    image VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
Installation
1. Clone the repository
git clone https://github.com/Shaher06/register-system.git
2. Move the project to XAMPP

For Linux:

sudo mv register-system /opt/lampp/htdocs/
3. Start XAMPP
sudo /opt/lampp/lampp start

Make sure Apache and MySQL are running.

4. Create the database

Open phpMyAdmin and create:

register_system

Then create the users table using the SQL schema above.

5. Configure the database

Open:

config/database.php

Update the database credentials if necessary.

6. Open the application
http://localhost/register-system/
Requirements Checklist
 Required input validation
 isInputEmpty()
 Name Regex validation
 Email validation
 Password Regex validation
 Minimum 8-character password
 Uppercase character requirement
 Lowercase character requirement
 Number requirement
 Special character requirement
 Password hashing
 User editing
 User updating
 Image upload
 Image validation
 JPG support
 JPEG support
 PNG support
 WEBP support
 Reusable functions
 PDO
 Prepared Statements
 Responsive UI
 Bootstrap Modals
 AJAX requests
 JSON responses
Project Goal

The main goal of this project is to practice building a complete PHP backend application from scratch while focusing on:

Clean code.
Reusable functions.
Input validation.
Database operations.
CRUD operations.
Password security.
File handling.
Separation of responsibilities.
Communication between frontend and backend.
Author

Shaher

Computer Science Student & Backend Development Learner

GitHub:

https://github.com/Shaher06

License

This project was created for educational and learning purposes.
