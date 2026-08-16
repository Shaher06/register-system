<?php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h2>Register</h2>

    <form action="save.php" method="POST">

        <label for="name">Name</label><br>
        <input
            type="text"
            id="name"
            name="name"
            required
            minlength="3"
            maxlength="50"
        ><br><br>

        <label for="email">Email</label><br>
        <input
            type="email"
            id="email"
            name="email"
            required
        ><br><br>

        <label for="password">Password</label><br>
        <input
            type="password"
            id="password"
            name="password"
            required
            minlength="8"
        ><br><br>

        <button type="submit">Register</button>

    </form>

</body>
</html>