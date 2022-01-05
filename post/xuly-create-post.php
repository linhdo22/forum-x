<?php
require '../controller/post.php';

if (!isset($_SESSION['user'])) {
    header('Location: ../login/login.php');
}

if (isset($_POST['create-post'])) {
    //Kết nối tới database
    $title = $_POST['post-title'];
    $content = addslashes($_POST['textarea']);
    $author = $_SESSION['user']['member_id'];
    $tags = $_POST['tags'];

    $postId = createPost($title, $content, $author, $tags);

    header('Location: ../post/post.php?id=' . $postId);
    die();
}
