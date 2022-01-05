<?php

require '../controller/member.php';


if (isset($_FILES['avatar'])) {

    $new_name = 'avatar-' . $_POST['userId'] . '.' . 'jpg';

    move_uploaded_file($_FILES['avatar']['tmp_name'], 'avatar/' . $new_name);

    $updateResult = uploadAvatar($_POST['userId'], 'upload-image/avatar/' . $new_name);

    $data = array(
        'image_source' => 'upload-image/avatar/' . $new_name,
        'status' => "success",
        'updata_result' => $updateResult
    );

    echo json_encode($data);
}
