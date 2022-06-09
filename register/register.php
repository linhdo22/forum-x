<!DOCTYPE html>
<html>

<?php
if (!isset($_SESSION)) {
    session_start();
}
?>


<head>
    <meta charset='utf-8'>
    <title>Register</title>
    <link rel='stylesheet' type='text/css' href='main.css'>
    <link rel='stylesheet' type='text/css' href='../common/css/header.css'>
    <script src='../common/js/header.js'></script>
    <script src='main.js'></script>
</head>


<body>
    <?php
    if (isset($_SESSION['user'])) {
        header('Location: ../home/home.html');
    }
    require 'xuly.php';
    require '../common/header.php';
    ?>
    <div class="container">
        <div class="row " style="margin:5rem 0;">
            <form method="post" action="register.php" class="loginForm col-md-4 offset-4">
                <h1>Sign up</h1>
                <div class="inputLogin">
                    <input type="text" id="registerUsername" name="username"></input>
                    <label for="registerUsername">Username</label>
                </div>
                <p class='errorHandle usernameError'>Invalid username format</p>
                <div class="inputLogin">
                    <input type="password" id="registerPassword" name="password"></input>
                    <label for="registerPassword">Password</label>
                </div>
                <p class='errorHandle passwordError'>Please enter password</p>
                <input type="submit" value="Register" name="register" class="loginBtn">
                <div class='extended'>
                    <a href="../login/login.php" class='signin fw-bold'>Sign In</a>
                    <a href="#" class='forgetpassword'>forget password</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>