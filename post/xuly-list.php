<?php
require '../controller/post.php';
if (isset($_POST['authorId'])) {
    $result = getList($_POST['authorId']);
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $tags = getTags($row['post_id']);
            $data[] = array(
                'post_id' => $row['post_id'],
                'title' => $row['title'],
                'createdAt' => $row['createdAt'],
                'updatedAt' => $row['updatedAt'],
                'public' => $row['public'],
                'view' => $row['view'],
                'vote' => $row['vote'],
                'tags' => $tags,
            );
        }
    }
    die(json_encode($data));
}

if (isset($_POST['postToChangeStatus'])) {
    $result = changeStatus($_POST['postToChangeStatus'], $_POST['status']);

    die(json_encode($result));
}
