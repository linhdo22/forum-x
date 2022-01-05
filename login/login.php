<!DOCTYPE html>
<html>
<?php
if (!isset($_SESSION)) {
    session_start();
}
?>

<head>
    <meta charset='utf-8'>
    <title>login</title>
    <link rel='stylesheet' type='text/css' href='main.css'>
    <script src='main.js'></script>
</head>

<body>
    <?php
    if (isset($_SESSION['user'])) {
        header('Location: ../home/home.php');
    }
    if (isset($_GET['logout'])) {
        unset($_SESSION['user']);
        header('Location: ./login.php');
    }
    require 'xuly.php';
    require '../common/header.php';
     ?>

    <div class="container">
        <div class="row " style="margin:5rem 0;">
            <form method="post" action="login.php" class="loginForm col-md-4 offset-4">
                <h1>Sign in</h1>
                <div class="inputLogin">
                    <input type="text" id="loginUsername" name="username"></input>
                    <label for="loginUsername">Username</label>
                </div>
                <p class='errorHandle usernameError'>Invalid username format</p>
                <div class="inputLogin">
                    <input type="password" id="loginPassword" name="password"></input>
                    <label for="loginPassword">Password</label>
                </div>
                <p class='errorHandle passwordError'>Please enter password</p>
                <input type="submit" value="Login" name="login" class="loginBtn">
                <div class='extended'>
                    <a href="#" class='signup'>Sign up</a>
                    <a href="#" class='forgetpassword'>forget password</a>
                </div>
            </form>
        </div>
    </div>
    <!-- <?php require '../common/footer.php'; ?> -->
</body>

</html>