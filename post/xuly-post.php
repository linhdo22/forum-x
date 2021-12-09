<?php
require '../controller/post.php';

if (isset($_POST['add-comment'])) {
    $result = addComment($_POST['postId'], $_POST['writeBy'], $_POST['content']);
    if (!$result) {
        die(json_encode($result));
    }
    $response = array();
    $response[] = $_POST['postId'];
    $response[] = $_POST['writeBy'];
    $response[] = $_POST['content'];
    die(json_encode($response));
}

if (isset($_POST['get-comments'])) {
    $result = getComments($_POST['postId'], $_POST['page']);
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $data[] = array(
                'content' => $row['content'],
                'name' => $row['name'],
                'createdAt' => $row['createdAt'],
                'writeBy' => $row['writeBy'],
            );
        }
    }
    die(json_encode($data));
}

if (isset($_POST['get-count-comments'])) {
    $result = getCountComments($_POST['postId']);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);


        die(json_encode($row['count']));
    }
}

if (isset($_POST['update-view'])) {
    $result = updateView($_POST['postId']);
    die(json_encode($result));
}

if (isset($_POST['update-vote'])) {
    $result = updateVote($_POST['postId'], $_POST['userId'], $_POST['value']);
    die(json_encode($result));
}
