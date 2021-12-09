<?php
require '../controller/member.php';
require '../controller/post.php';

if (isset($_POST['get-public-posts'])) {
    $result = getPublicList($_POST['user_id']);
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $data[] = array(
                'post_id' => $row['post_id'],
                'title' => $row['title'],
                'updatedAt' => $row['updatedAt'],
                'preImg' => $row['preImg'],
                'preContent' => $row['preContent'],
                'view' => $row['view'],
                'vote' => $row['vote'],
            );
        }
    }
    die(json_encode($data));
}

if (isset($_POST['update-subcribe'])) {
    $result = updateSubcribe($_POST['user_id']);
    die($result[0]);
}
