<?php
require_once __DIR__ . "./connection.php";
function createPost($title, $content, $userId)
{
    $connect = connect();
    $query = "INSERT INTO post (author, title, content, createdAt, updatedAt) VALUES ('$userId', '$title', '$content', now(), now());";
    mysqli_query($connect, $query) or die(mysqli_error($connect));
    $lastPostId = mysqli_insert_id($connect);
    mysqli_close($connect);
}

function updatePost($postId, $title, $content)
{
    $connect = connect();
    $query = "Update post set title = '$title', content = '$content', updatedAt = now() where post_id = $postId;";
    $result = mysqli_query($connect, $query) or die(mysqli_error($connect));
    mysqli_close($connect);
    return $result;
}

function getPost($postId)
{
    $connect = connect();
    $query = "select * from post,member " .
        "where post_id = $postId and author = member_id ";
    $result = mysqli_query($connect, $query) or die(mysqli_error($connect));
    $row = mysqli_fetch_assoc($result);
    mysqli_close($connect);
    return $row;
}

function getPreview($postId)
{
    $connect = connect();
    $query = "select REGEXP_SUBSTR (content ,'upload-image/store/[^\"<>]+') as preImg ,
    REGEXP_SUBSTR (content ,'>[^\"<>]+</') as preContent 
    from post where post_id = $postId";
    $result = mysqli_query($connect, $query) or die(mysqli_error($connect));
    $row = mysqli_fetch_assoc($result);
    mysqli_close($connect);
    return $row;
}

function getList($authorId)
{
    $connect = connect();
    $query = "select post_id,title,view,vote,public,createdAt,updatedAt from post " .
        "where author = $authorId ";
    $result = mysqli_query($connect, $query) or die(mysqli_error($connect));
    mysqli_close($connect);
    return $result;
}

function getPublicList($authorId)
{
    $connect = connect();
    $query = "select post_id,title,view,vote,updatedAt, " .
        "REGEXP_SUBSTR (content ,'upload-image/store/[^\"<>]+') as preImg, " .
        "REGEXP_SUBSTR (content ,'>[^\"<>]+</') as preContent " .
        "from post where author = $authorId and public = 1;";
    $result = mysqli_query($connect, $query) or die(mysqli_error($connect));
    mysqli_close($connect);
    return $result;
}

function changeStatus($postId, $value)
{
    $connect = connect();
    $query = "update post set public =  $value  where post_id = $postId";
    mysqli_query($connect, $query) or die(mysqli_error($connect));
    mysqli_close($connect);
    return $value;
}

function addComment($postId, $userId, $content)
{
    $connect = connect();
    $query = "insert into comment ( post_id,writeBy,content,createdAt) values($postId, $userId, '$content', now())";
    mysqli_query($connect, $query) or die(mysqli_error($connect));
    mysqli_close($connect);
    return true;
}

function getComments($postId, $page)
{
    $offset = ($page - 1) * 5;
    $connect = connect();
    $query = "select content,name,createdAt,writeBy from comment,member " .
        "where writeBy = member_id and post_id = $postId order by (createdAt) desc limit $offset,5";
    $result = mysqli_query($connect, $query) or die(mysqli_error($connect));
    mysqli_close($connect);
    return $result;
}

function getCountComments($postId)
{
    $connect = connect();
    $query = "select count(*) as count from comment " .
        "where post_id = $postId ";
    $result = mysqli_query($connect, $query) or die(mysqli_error($connect));
    mysqli_close($connect);
    return $result;
}

function updateView($postId)
{
    $connect = connect();
    $query = "update post set view = view+ 1 " .
        "where post_id = $postId ";
    $result = mysqli_query($connect, $query) or die(mysqli_error($connect));
    mysqli_close($connect);
    return $result;
}

function updateVote($postId, $userId, $value)
{
    $connect = connect();
    $query = "insert into user_vote (post_id,user_id,value)
    values ($postId,$userId,$value) ON DUPLICATE KEY UPDATE value = $value;
    update post set vote = (select count(*) from user_vote where value = 1 and post_id = $postId) - (select count(*) from user_vote  where value = -1 and post_id = $postId) 
    where post_id = $postId; ";
    $result = mysqli_multi_query($connect, $query) or die(mysqli_error($connect));
    mysqli_close($connect);
    return $result;
}

function checkUserVote($postId, $userId)
{
    $connect = connect();
    $query = "select value from user_vote where post_id = $postId and user_id = $userId;";
    $result = mysqli_query($connect, $query) or die(mysqli_error($connect));
    mysqli_close($connect);
    $vote = mysqli_fetch_array($result, MYSQLI_ASSOC);
    return $vote['value'];
}
