<?php
require '../controller/post.php';
require '../controller/member.php';

if (isset($_POST['search'])) {
    $type = $_POST['type'];
    $pattern = $_POST['pattern'];
    if (isset($_POST['tag'])) {
        $tag = $_POST['tag'];
    } else {
        $tag = 'all';
    }
    switch ($type) {
        case 'user':
            $result = searchUser($pattern);
            break;
        case 'post':
            $result = searchPost($pattern, $tag);
            break;
        case 'comment':
            $result = searchComment($pattern);
            break;
        default: // all
            $data = array_merge(searchPost($pattern, $tag), searchComment($pattern));
            // usort($data, function ($a, $b) {
            //     return -strcmp($a['time'], $b['time']);
            // });
            $result = $data;
    }
    die(json_encode($result));
}

if (isset($_POST['postToChangeStatus'])) {
    $result = changeStatus($_POST['postToChangeStatus'], $_POST['status']);

    die(json_encode($result));
}
