<?php

if (!isset($_SESSION['user'])) {
    header('Location: ../login/login.php');
}

if (isset($_POST['create-post'])) {
    echo htmlentities($_POST['textarea']);
    //Kết nối tới database
    require '../controller/post.php';
    $title = $_POST['post-title'];
    $content = addslashes($_POST['textarea']);
    $author = $_SESSION['user']['member_id'];

    createPost($title, $content, $author);

    // header('Location: ../home/home.php');
    die();
}
