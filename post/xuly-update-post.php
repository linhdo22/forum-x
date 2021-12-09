<?php
require '../controller/post.php';

if (isset($_POST['update-post'])) {
    $result = updatePost($_POST['postId'], addslashes($_POST['title']), addslashes($_POST['content']));
    header("Location: ./my-list.php");
}
