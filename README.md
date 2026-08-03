# Register System

A simple PHP registration system built using **PHP**, **PDO**, and **MySQL**. This project demonstrates the fundamentals of backend web development, including form handling, database connectivity, and secure data insertion using prepared statements.

## Features

* User registration form
* Store user information in MySQL
* Database connection using PDO
* Secure INSERT queries with prepared statements
* Simple project structure
* Easy to extend with authentication features

## Technologies Used

* PHP
* MySQL
* PDO
* HTML5
* CSS3
* XAMPP

## Project Structure

```text
register-system/
│
├── config/
│   └── database.php
├── register.php
├── save.php
├── success.php
└── style.css
```

## Database

Database Name:

```text
register_system
```

Table:

```text
users
```

Columns:

* id
* name
* email
* password
* created_at

## Installation

1. Clone the repository.

```bash
git clone https://github.com/Shaher06/register-system.git
```

2. Move the project into your web server directory.

3. Create a MySQL database named:

```text
register_system
```

4. Import the SQL table.

5. Update the database credentials inside:

```text
config/database.php
```

6. Start Apache and MySQL.

7. Open your browser:

```text
http://localhost/register-system/register.php
```

## How It Works

1. The user enters their information in the registration form.
2. The form sends the data using the POST method.
3. The application connects to MySQL using PDO.
4. The user data is inserted into the database using prepared statements.
5. After successful registration, the user is redirected to the success page.

## Future Improvements

* Login System
* Password Hashing
* Email Validation
* Duplicate Email Check
* Session Authentication
* Logout Functionality
* Bootstrap UI
* Responsive Design
* Error Handling
* MVC Architecture
* Laravel Version

## Author

**Shaher**

GitHub: https://github.com/Shaher06

---

This project was created for learning PHP backend development and practicing database operations before moving to Laravel.

