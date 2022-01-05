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
    $result = updateSubcribe($_POST['target'], $_POST['subBy'], $_POST['value']);
    die($result[0]);
}

if (isset($_POST['update-info'])) {
    $result = updateInfo($_POST['memberId'], $_POST['desc'], $_POST['place'], $_POST['job'],  $_POST['birth']);
    die(json_encode($result));
}

if (isset($_POST['update-contacts'])) {
    $facebookObj = json_decode($_POST['facebook'], true);
    $youtubeObj = json_decode($_POST['youtube'], true);
    $linkedinObj = json_decode($_POST['linkedin'], true);
    $stackOverflowObj = json_decode($_POST['stackOverflow'], true);

    $result = updateContact($_POST['memberId'], $facebookObj, $youtubeObj, $linkedinObj, $stackOverflowObj);
    die(json_encode($result));
}
