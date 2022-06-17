<?php
require_once __DIR__ . "/connection.php";

function getTagId($tag)
{
    $connect = connect();
    $query = "select tag_id from post_tag where value = '$tag';";
    $result = mysqli_query($connect, $query) or die(mysqli_error($connect));
    return mysqli_fetch_array($result)[0];
}

function createPost($title, $content, $userId, $tags)
{
    $connect = connect();
    $query = "INSERT INTO post (author, title, content, createdAt, updatedAt) VALUES ('$userId', '$title', '$content', now(), now());";
    mysqli_query($connect, $query) or die(mysqli_error($connect));
    $lastPostId = mysqli_insert_id($connect);
    if (count($tags) > 0) {
        $queryTag = "";
        foreach ($tags as $tag) {
            $tagId = getTagId($tag);
            $queryTag .= "insert into post_tag_map (post_id,tag_id) values ($lastPostId, $tagId);";
        }
        mysqli_multi_query($connect, $queryTag) or die(mysqli_error($connect));
    }
    mysqli_close($connect);
    return $lastPostId;
}  

function updatePost($postId, $title, $content, $tags)
{
    $connect = connect();
    $query = "Update post set title = '$title', content = '$content', updatedAt = now() where post_id = $postId;";
    $result = mysqli_query($connect, $query) or die(mysqli_error($connect));

    $queryTag = "delete from post_tag_map where post_id = $postId; ";
    foreach ($tags as $tag) {
        $tagId = getTagId($tag);
        $queryTag .= "insert into post_tag_map (post_id,tag_id) values ($postId, $tagId);";
    }
    mysqli_multi_query($connect, $queryTag) or die(mysqli_error($connect));
    mysqli_close($connect);
    return $result;
}

function searchPost($pattern, $tag)
{
    $connect = connect();
    if ($tag == 'all') {
        $query = "SELECT author,name,avatar,post_id,title,updatedAt as time, title, view,
        REGEXP_SUBSTR(content,'[^<>\;]*" . $pattern . "[^<>\;]+')as content 
        FROM post, member
        where member.member_id = author and public = 1
        and (regexp_like(content,'[^<>\;]*" . $pattern . "[^<>\;]+') or regexp_like(title,'[^<>\;]*" . $pattern . "[^><\;]+'))
        order by (updatedAt) desc limit 5;";
    } else {
        $tagId = getTagId($tag);
        $query = "SELECT author,name,avatar,post.post_id as post_id,title,updatedAt as time, title,view, 
        REGEXP_SUBSTR(content,'[^<>\;]*" . $pattern . "[^<>\;]+')as content 
        FROM post, member,post_tag_map
        where member.member_id = author and post_tag_map.post_id = post.post_id and tag_id = $tagId and public = 1
        and (regexp_like(content,'[^<>\;]*" . $pattern . "[^<>\;]+') or regexp_like(title,'[^<>\;]*" . $pattern . "[^><\;]+'))
        order by (updatedAt) desc limit 5;";
    }
    $result = mysqli_query($connect, $query) or die(mysqli_error($connect));
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $tags = getTags($row['post_id']);
            $data[] = array(
                'post_id' => $row['post_id'],
                'title' => $row['title'],
                'content' => $row['content'],
                'user_id' => $row['author'],
                'name' => $row['name'],
                'avatar' => $row['avatar'],
                'time' => $row['time'],
                'view' => $row['view'],
                'tags' => $tags,
                'type' => 'post',

            );
        }
    }
    return $data;
}

function searchComment($pattern)
{
    $connect = connect();
    $query = "SELECT writeBy,avatar,name,comment.post_id as post_id,title,comment.createdAt, REGEXP_SUBSTR(comment.content,'[^<>\;]*" . $pattern . "[^<>\;]+')as content 
    FROM comment, member, post
    where member.member_id = writeBy and comment.post_id = post.post_id and public = 1
    and regexp_like(comment.content,'[^<>\;]*" . $pattern . "[^<>\;]+') order by (createdAt) desc limit 5;";
    $result = mysqli_query($connect, $query) or die(mysqli_error($connect));
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $data[] = array(
                'post_id' => $row['post_id'],
                'title' => $row['title'],
                'content' => $row['content'],
                'user_id' => $row['writeBy'],
                'name' => $row['name'],
                'avatar' => $row['avatar'],
                'time' => $row['createdAt'],
                'type' => 'comment',

            );
        }
    }
    return $data;
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

function getTags($postId)
{
    $connect = connect();
    $query = "select post_tag.value as tag from post, post_tag, post_tag_map " .
        "where post.post_id = $postId and post_tag_map.post_id = post.post_id " .
        " and post_tag_map.tag_id = post_tag.tag_id";
    $result = mysqli_query($connect, $query) or die(mysqli_error($connect));
    $tags = array();
    while ($row = mysqli_fetch_array($result)) {
        $tags[] = $row[0];
    }
    mysqli_close($connect);
    return $tags;
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


function getLastestPost()
{
    $connect = connect();
    $query = "select member_id,name,post_id,title,updatedAt, " .
        "REGEXP_SUBSTR (content ,'upload-image/store/[^\"<>]+') as preImg " .
        "from post,member where public = 1 and post.author = member.member_id 
        order by (updatedAt) desc limit 5;";

    $result = mysqli_query($connect, $query) or die(mysqli_error($connect));
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $data[] = array(
                'post_id' => $row['post_id'],
                'title' => $row['title'],
                'image' => $row['preImg'],
                'member_id' => $row['member_id'],
                'name' => $row['name'],
                'time' => $row['updatedAt'],
            );
        }
    }
    return $data;
}

function getLastestNews()
{
    $connect = connect();
    $query = "select member_id,name,post.post_id,title,updatedAt, " .
        "REGEXP_SUBSTR (content ,'upload-image/store/[^\"<>]+') as preImg " .
        " FROM post, member,post_tag_map
        where member.member_id = author and post_tag_map.post_id = post.post_id and tag_id = 4 and public = 1
        order by (updatedAt) desc limit 5;";

    $result = mysqli_query($connect, $query) or die(mysqli_error($connect));
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $data[] = array(
                'post_id' => $row['post_id'],
                'title' => $row['title'],
                'image' => $row['preImg'],
                'member_id' => $row['member_id'],
                'name' => $row['name'],
                'time' => $row['updatedAt'],

            );
        }
    }
    return $data;
}

function getTopViewPost()
{
    $connect = connect();
    $query = "select member_id,name,post.post_id,title,updatedAt,view " .
        " FROM post, member
        where member.member_id = author and public = 1
        order by (view) desc limit 5;";

    $result = mysqli_query($connect, $query) or die(mysqli_error($connect));
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $data[] = array(
                'post_id' => $row['post_id'],
                'title' => $row['title'],
                'member_id' => $row['member_id'],
                'name' => $row['name'],
                'time' => $row['updatedAt'],
                'view' => $row['view'],


            );
        }
    }
    return $data;
}

function getTopVotePost()
{
    $connect = connect();
    $query = "select member_id,name,post.post_id,title,updatedAt,vote " .
        " FROM post, member
        where member.member_id = author and public = 1
        order by (vote) desc limit 5;";

    $result = mysqli_query($connect, $query) or die(mysqli_error($connect));
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $data[] = array(
                'post_id' => $row['post_id'],
                'title' => $row['title'],
                'member_id' => $row['member_id'],
                'name' => $row['name'],
                'time' => $row['updatedAt'],
                'vote' => $row['vote'],

            );
        }
    }
    return $data;
}
