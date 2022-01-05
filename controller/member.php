<?php
require_once __DIR__ . "./connection.php";

function getProfile($memberId)
{
    $connect = connect();
    $query = "select * from member " .
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
        $data['avatar'] = $row['avatar'];
        $data['contacts'] = getContacts($row['member_id']);
    }
    mysqli_close($connect);
    return $data;
}
function getContacts($memberId)
{
    $connect = connect();
    $query = "select * from member_contact_map where member_id = '$memberId' ;";
    $result = mysqli_query($connect, $query) or die(mysqli_error($connect));
    $contacts = array();
    while ($row = mysqli_fetch_array($result)) {
        $data = array(
            'type' => $row['type'],
            'value' => $row['value'],
            'public' => $row['public'],
        );
        $contacts[] = $data;
    }
    mysqli_close($connect);
    return $contacts;
}


function searchUser($pattern)
{
    $connect = connect();
    $query = "select name,avatar,member_id,description, joinDate FROM member
        where name like '%" . $pattern . "%' order by (joinDate) desc limit 5;";

    $result = mysqli_query($connect, $query) or die(mysqli_error($connect));
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $data[] = array(
                'member_id' => $row['member_id'],
                'time' => $row['joinDate'],
                'name' => $row['name'],
                'avatar' => $row['avatar'],
                'description' => $row['description'],
                'type' => 'user',
            );
        }
    }
    return $data;
}


function updateSubcribe($subcribed, $subcriber, $value)
{
    $connect = connect();
    $query = "insert into subcribe_map (subcribed,subcriber,value)
    values ($subcribed,$subcriber,$value) ON DUPLICATE KEY UPDATE value = $value;
    update member set subcribe_count = (select count(*) from subcribe_map where subcribed = $subcribed and value = 1)
    where member_id = $subcribed; ";
    $result = mysqli_multi_query($connect, $query) or die(mysqli_error($connect));
    mysqli_close($connect);
    return $result;
}

function checkSubcribe($subcribed, $subcriber)
{
    $connect = connect();
    $query = "select count(*) from subcribe_map where subcribed = $subcribed and subcriber = $subcriber and value =1;";
    $result = mysqli_query($connect, $query) or die(mysqli_error($connect));
    mysqli_close($connect);
    return mysqli_fetch_array($result)[0];
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


function uploadAvatar($memberId, $avatarPath)
{
    $connect = connect();
    $query = "update member set avatar = '$avatarPath' where member_id = $memberId";
    $result = mysqli_query($connect, $query) or die(mysqli_error($connect));
    mysqli_close($connect);
    return $result;
}

function updateInfo($memberId, $desc, $place, $job, $birth)
{
    $date = empty($birth) || $birth == 'null' ? $birth : "'" . $birth . "'";
    $connect = connect();
    $query = "update member set description = '$desc', place = '$place' , job = '$job' , dateOfBirth=$date where member_id = $memberId";
    $result = mysqli_query($connect, $query) or die(mysqli_error($connect));
    mysqli_close($connect);
    return $result;
}

function updateContact($memberId, $facebook, $youtube, $linkedin, $stackOverflow)
{
    $facebookValue = $facebook['value'];
    $facebookPublic = $facebook['public'];
    $facebookTemp = "insert into member_contact_map (member_id,type,value,public)" .
        " values ($memberId,'facebook','$facebookValue','$facebookPublic')" .
        " ON DUPLICATE KEY UPDATE public = $facebookPublic , value = '$facebookValue'; ";
    $youtubeValue = $youtube['value'];
    $youtubePublic = $youtube['public'];
    $youtubeTemp = "insert into member_contact_map (member_id,type,value,public)" .
        " values ($memberId,'youtube','$youtubeValue','$youtubePublic')" .
        " ON DUPLICATE KEY UPDATE public = $youtubePublic , value = '$youtubeValue'; ";
    $linkedinValue = $linkedin['value'];
    $linkedinPublic = $linkedin['public'];
    $linkedinTemp = "insert into member_contact_map (member_id,type,value,public)" .
        " values ($memberId,'linkedin','$linkedinValue','$linkedinPublic')" .
        " ON DUPLICATE KEY UPDATE public = $linkedinPublic , value = '$linkedinValue'; ";
    $stackOverflowValue = $stackOverflow['value'];
    $stackOverflowPublic = $stackOverflow['public'];
    $stackOverflowTemp = "insert into member_contact_map (member_id,type,value,public)" .
        " values ($memberId,'stack-overflow','$stackOverflowValue','$stackOverflowPublic')" .
        " ON DUPLICATE KEY UPDATE public = $stackOverflowPublic , value = '$stackOverflowValue'; ";

    $connect = connect();
    $query = "$facebookTemp $youtubeTemp $linkedinTemp $stackOverflowTemp";
    $result = mysqli_multi_query($connect, $query) or die(mysqli_error($connect));
    mysqli_close($connect);
    return $result;
}


function getTopSubUser()
{
    $connect = connect();
    $query = "select member_id,name,subcribe_count" .
        " FROM member
        order by (subcribe_count) desc limit 5;";

    $result = mysqli_query($connect, $query) or die(mysqli_error($connect));
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $data[] = array(
                'member_id' => $row['member_id'],
                'name' => $row['name'],
                'subcribe' => $row['subcribe_count'],

            );
        }
    }
    return $data;
}
