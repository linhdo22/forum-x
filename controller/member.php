<?php
require_once __DIR__ . "./connection.php";

function getProfile($memberId)
{
    $connect = connect();
    $query = "select * from member left join member_contact_map on member.member_id = member_contact_map.member_id " .
        "where member.member_id = $memberId ";
    $result = mysqli_query($connect, $query) or die(mysqli_error($connect));
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $data['member_id'] = $row['member_id'];
        $data['joinDate'] = $row['joinDate'];
        $data['job'] = $row['job'];
        $data['place'] = $row['place'];
        $data['dateOfBirth'] = $row['dateOfBirth'];
        $data['name'] = $row['name'];
        $data['description'] = $row['description'];
        $data['subcribe_count'] = $row['subcribe_count'];
        $contacts = array();
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $contacts[] = array(
                'contact_type' => $row['type'],
                'contact_value' => $row['value'],

            );
        }
        $data['contacts'] = $contacts;
    }
    mysqli_close($connect);
    return $data;
}

function subcribe($subcribed, $subcriber)
{
    $connect = connect();
    $query = "insert into user_map (subcribed,subcriber)
    values ($subcribed,$subcriber);
    update member set subcribe_count = (select count(*) from subcribe_count where subcribed = $subcribed and subcriber = $subcriber)
    where member = $subcribed; ";
    $result = mysqli_multi_query($connect, $query) or die(mysqli_error($connect));
    mysqli_close($connect);
    return $result;
}

function unSubcribe($subcribed, $subcriber)
{
    $connect = connect();
    $query = "delete from user_map where subcribed = $subcribed and subcriber = $subcriber ;
    update member set subcribe_count = (select count(*) from subcribe_count where subcribed = $subcribed )
    where member_id = $subcribed; ";
    $result = mysqli_multi_query($connect, $query) or die(mysqli_error($connect));
    mysqli_close($connect);
    return $result;
}

function getUserAllPostsCount($memberId)
{
    $connect = connect();
    $query = "select count(author) from member,post 
    where member_id = author and member_id = $memberId and public = 1 ;";
    $result = mysqli_query($connect, $query) or die(mysqli_error($connect));

    mysqli_close($connect);
    return mysqli_fetch_array($result)[0];
}

function getUserAllCommentsCount($memberId)
{
    $connect = connect();
    $query = "select count(writeBy) from member,comment 
    where member_id = writeBy and member_id = $memberId;";
    $result = mysqli_query($connect, $query) or die(mysqli_error($connect));

    mysqli_close($connect);
    return mysqli_fetch_array($result)[0];
}
