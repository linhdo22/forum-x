<?php
require '../controller/post.php';

if (isset($_POST['get-lastest-post'])) {
    die(json_encode(getLastestPost()));
}

if (isset($_POST['get-lastest-news'])) {
    die(json_encode(getLastestNews()));
}
