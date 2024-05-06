<?php
require_once "config.php";

$username = $password = "";
$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT id, username, password FROM users WHERE username = ?";
    
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $user_id, $fetched_username, $fetched_password);
        mysqli_stmt_fetch($stmt);
        
        if ($password == $fetched_password) {
            session_start();
            $_SESSION["user_id"] = $user_id;
            $_SESSION["username"] = $fetched_username;
            header("location: ../index.html");
            exit();
        } else {
            $errorMessage = "Invalid username or password.";
        }

        mysqli_stmt_close($stmt);
    } else {
        $errorMessage = "Oops! Something went wrong. Please try again later.";
    }

    mysqli_close($conn);
}
?>


<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <title>Login Page</title>
</head>
<style>

    @import url('https://fonts.googleapis.com/css?family=Roboto:300');

        body {
            font-family: "Roboto", sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            background-color: #f2f2f2;
        }

    header .header {
        background-color: #fff;
        height: 45px;
    }

    header a img {
        width: 134px;
        margin-top: 4px;
    }

    .login-page {
        width: 360px;
        padding: 8% 0 0;
        margin: auto;
    }

    .login-page .form .login {
        margin-top: -31px;
        margin-bottom: 26px;
    }

    .form {
        position: relative;
        z-index: 1;
        background: #FFFFFF;
        max-width: 360px;
        margin: 0 auto 100px;
        padding: 45px;
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
        -webkit-transition: all 0.3 ease;
        transition: all 0.3 ease;
        cursor: pointer;
    }

    .form .message {
        margin: 15px 0 0;
        color: #b3b3b3;
        font-size: 12px;
    }

    .form .message a {
        color: #4CAF50;
        text-decoration: none;
    }

    .container {
        position: relative;
        z-index: 1;
        max-width: 300px;
        margin: 0 auto;
    }

    body {
        /* background-color: #328f8a;
        background-image: linear-gradient(45deg, #328f8a, #08ac4b); */
        font-family: "Roboto", sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }
</style>


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

    <div class="login-page">
        <div class="form">
            <div class="login">
                <div class="login-header">
                    <h3>LOGIN</h3>
                    <p>Please enter your credentials to login.</p>
                </div>
            </div>
            <form id="loginForm" class="login-form" action="../php_files/login.php" method="post">
                <input type="username" id="username" name="username" placeholder="Username" required>
                <input type="password" id="password" name="password" placeholder="Password" required>
                <button type="submit">Login</button>
                <p class="message">Not registered? <a href="../php_files/register.php">Create an account</a></p>
                
                <?php if (!empty($errorMessage)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $errorMessage; ?>
                    </div>
                <?php endif; ?>
            </form>
        </div>
    </div>
</body>

</html>