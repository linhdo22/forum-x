<?php
function logout()
{
    unset($_SESSION['name']);
    header('Location: ../login/login.php');
}
