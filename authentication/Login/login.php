```php
<?php

session_start();

include "../../config/config.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE username = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows == 1) {

        $user = $result->fetch_assoc();

        if ($password == $user["password"]) {

            $_SESSION["user_id"] = $user["user_id"];
            $_SESSION["firstname"] = $user["firstname"];
            $_SESSION["lastname"] = $user["lastname"];
            $_SESSION["username"] = $user["username"];
            $_SESSION["role"] = $user["role"];

            if ($user["role"] == "admin") {

                header("Location: admin_home.php");
                exit();

            } else {

                header("Location: student_home.php");
                exit();

            }

        } else {

            $message = "Incorrect password.";

        }

    } else {

        $message = "Username not found.";

    }

    $stmt->close();
}

$conn->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>CHECKMATE - Login</title>

    <link rel="stylesheet" href="">

    <style>
        
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

body {
    background: #111111;
    color: white;

    min-height: 100vh;

    display: flex;
    justify-content: center;
    align-items: center;
}

.login-container {
    width: 380px;

    background: #1c1c1c;

    padding: 40px;

    border-radius: 12px;

    box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
}

.logo {
    text-align: center;

    margin-bottom: 10px;

    font-size: 32px;

    font-weight: bold;

    letter-spacing: 2px;
}

.subtitle {
    text-align: center;

    color: #aaaaaa;

    margin-bottom: 30px;

    font-size: 14px;
}

.input-group {
    margin-bottom: 20px;
}

.input-group label {
    display: block;

    margin-bottom: 8px;

    font-size: 14px;
}

.input-group input {
    width: 100%;

    padding: 12px;

    border: 1px solid #444444;

    border-radius: 6px;

    background: #111111;

    color: white;

    outline: none;
}

.input-group input:focus {
    border-color: white;
}

.login-button {
    width: 100%;

    padding: 12px;

    border: none;

    border-radius: 6px;

    background: white;

    color: black;

    font-size: 16px;

    font-weight: bold;

    cursor: pointer;
}

.login-button:hover {
    background: #dddddd;
}

.message {
    text-align: center;

    color: #ff7777;

    margin-bottom: 15px;

    font-size: 14px;
}

.register {
    text-align: center;

    margin-top: 20px;

    color: #aaaaaa;

    font-size: 14px;
}

.register a {
    color: white;

    text-decoration: none;
}

.register a:hover {
    text-decoration: underline;
}
```

    </style>

</head>

<body>

    <div class="login-container">

        <div class="logo">
            CHECKMATE
        </div>

        <div class="subtitle">
            Peer-to-Peer Online Collaboration Platform
        </div>

        <?php if ($message != "") { ?>

            <div class="message">
                <?php echo $message; ?>
            </div>

        <?php } ?>

        <form method="POST" action="">

            <div class="input-group">

                <label>Username</label>

                <input
                    type="text"
                    name="username"
                    placeholder="Enter your username"
                    required
                >

            </div>

            <div class="input-group">

                <label>Password</label>

                <input
                    type="password"
                    name="password"
                    placeholder="Enter your password"
                    required
                >

            </div>

            <button type="submit" class="login-button">
                Login
            </button>

        </form>

        <div class="register">

            Don't have an account?

            <a href="register.php">
                Register
            </a>

        </div>

    </div>


</body>

</html>
```
