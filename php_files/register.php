<?php
require_once "config.php";

$username = $password = $confirm_password = $college = $department = $contact = "";
$username_err = $password_err = $confirm_password_err = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    $confirm_password = trim($_POST["confirm_password"]);
    $college = trim($_POST["college"]);
    $department = trim($_POST["department"]);
    $contact = trim($_POST["contact"]);

    // Validate username
    if (empty($username)) {
        $username_err = "Username cannot be blank";
    } else {
        $sql = "SELECT id FROM users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $param_username);
        $param_username = $username;
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        if (mysqli_stmt_num_rows($stmt) == 1) {
            $username_err = "This username is already taken";
        }
        mysqli_stmt_close($stmt);
    }

    // Validate password
    if (empty($password)) {
        $password_err = "Password cannot be blank";
    } elseif (strlen($password) < 5) {
        $password_err = "Password must be at least 5 characters";
    }

    // Validate password confirmation
    if ($password != $confirm_password) {
        $confirm_password_err = "Passwords do not match";
    }

    // Check for input errors before inserting into database
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
        $sql = "INSERT INTO users (username, password, college, department, contact) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sssss", $param_username, $param_password, $param_college, $param_department, $param_contact);
        $param_username = $username;
        $param_password = $password;
        $param_college = $college;
        $param_department = $department;
        $param_contact = $contact;

        if (mysqli_stmt_execute($stmt)) {
            header("Location: ../index.html");
            exit();
        } else {
            echo "Something went wrong... cannot redirect!";
        }

        mysqli_stmt_close($stmt);
    }

    mysqli_close($conn);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        /* Combined CSS from login page and additional styles for registration form */

        @import url('https://fonts.googleapis.com/css?family=Roboto:300');

        body {
            font-family: "Roboto", sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            background-color: #f2f2f2;
        }

        .form {
            padding: 45px;
            margin: auto;
            position: relative;
            z-index: 1;
            background: #FFFFFF;
            max-width: 500px;
            text-align: center;
            box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
        }

        .form input {
            font-family: "Roboto", sans-serif;
            outline: 0;
            background: #f2f2f2;
            width: 100%;
            border: 0;
            margin: 0 0 15px;
            padding: 15px;
            box-sizing: border-box;
            font-size: 14px;
        }

        .form button {
            font-family: "Roboto", sans-serif;
            text-transform: uppercase;
            outline: 0;
            background-color: #328f8a;
            background-image: linear-gradient(45deg, #328f8a, #08ac4b);
            width: 100%;
            border: 0;
            padding: 15px;
            color: #FFFFFF;
            font-size: 14px;
            -webkit-transition: all 0.3s ease;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .form button:hover,
        .form button:active,
        .form button:focus {
            background-color: #08ac4b;
        }

        .form .message {
            margin: 15px 0 0;
            color: #b3b3b3;
            font-size: 12px;
        }

        .form .message a {
            color: #328f8a;
            text-decoration: none;
        }

        .container {
            position: relative;
            z-index: 1;
            max-width: 300px;
            margin: 0 auto;
        }

        h3 {
            color: #333;
        }

        p {
            color: #666;
        }
    </style>
</head>

<body>

  <section id="navbar">
		<nav class="navbar navbar-expand-lg navbar-light">
			<div class="container-fluid">
				<a class="navbar-brand" href="../index.html">
					<h1><b>WeLink</b></h1>
				</a>
				
			</div>
		</nav>
	</section>
        <div class="form">
            <div class="login">
                <h3>REGISTER</h3>
                <p>Please fill out the form to create an account.</p>
            </div>
            <form class="register-form" action="register.php" method="post">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                <input type="text" name="college" placeholder="College">
                <input type="text" name="department" placeholder="Department">
                <input type="number" name="contact" placeholder="Contact No.">
                <button type="submit">Register</button>
                <p class="message">Already registered? <a href="../php_files/login.php">Login here</a></p>
            </form>
        </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>

</html>
