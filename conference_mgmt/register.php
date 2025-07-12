<?php
include 'db.php';
$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (strlen($username) < 4 || strlen($password) < 6) {
        $error = "Username must be at least 4 characters and password at least 6 characters.";
    } else {
        // Check if username exists
        $check = $conn->query("SELECT * FROM users WHERE username='$username'");
        if ($check->num_rows > 0) {
            $error = "Username already taken.";
        } else {
           $hashed = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (username, password, role) VALUES ('$username', '$hashed', 'user')";
            if ($conn->query($sql)) {
                $success = "Registration successful! You can now <a href='login.php'>login</a>.";
            } else {
                $error = "Something went wrong.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register - Conference Management</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .register-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            text-align: center;
            font-family: 'Segoe UI', sans-serif;
        }
        .register-container h2 {
            font-size: 26px;
            margin-bottom: 20px;
            color: #007BFF;
        }
        .register-container input {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            font-size: 16px;
            border-radius: 5px;
        }
        .register-container button {
            width: 100%;
            padding: 12px;
            background: #007BFF;
            color: white;
            border: none;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }
        .register-container button:hover {
            background: #0056b3;
        }
        .message {
            margin-bottom: 15px;
            font-size: 15px;
        }
    </style>
</head>
<body>
<div class="register-container">
    <h2>Create a New Account</h2>

    <?php
    if ($error) echo "<p class='message' style='color:red;'>$error</p>";
    if ($success) echo "<p class='message' style='color:green;'>$success</p>";
    ?>

    <form method="POST">
        <input type="text" name="username" placeholder="Choose a username" required><br>
        <input type="password" name="password" placeholder="Choose a password" required><br>
        <button type="submit">Register</button>
    </form>
</div>
</body>
</html>

