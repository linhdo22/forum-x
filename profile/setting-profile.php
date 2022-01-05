<!DOCTYPE html>
<html lang="en">

<?php
if (!isset($_SESSION)) {
    session_start();
}
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="./setting-profile.js"></script>
    <link rel="stylesheet" href="./setting-profile.css">
    <title>Setting</title>
</head>

<body style="background-color:#eef0f1;">
    <?php
    if (!isset($_SESSION['user'])) {
        header("Location: ../login/login.php");
    }
    require '../common/header.php';
    require '../controller/member.php';
    $profileSetting = getProfile($_SESSION['user']['member_id']);
    ?>
    <h3 class="text-center mt-4 "><span class="border border-3 border-primary text-primary rounded-pill py-1 px-3" style="border-style: dashed !important;">Setting</span></h3>
    <div class="container my-5" style=" min-height:70vh">
        <div class="row">
            <div class="col-md-10 offset-md-1 col-12 bg-white border shadow rounded p-3">
                <div class="d-flex align-items-start">
                    <div class="nav flex-column nav-pills me-3" id="v-pills-tab">
                        <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button">Home</button>
                        <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button">Profile</button>
                        <button class="nav-link" id="v-pills-contacts-tab" data-bs-toggle="pill" data-bs-target="#v-pills-contacts" type="button">Contacts</button>
                        <button class="nav-link" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-settings" type="button">Settings</button>
                    </div>
                    <div class="tab-content w-100  border-start" style="min-height: 200px;" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-home">
                            <div class="p-3">
                                <h4 class="text-center mb-3">Home</h4>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-profile">
                            <div class="p-3">
                                <h4 class="text-center mb-4">Profile</h4>
                                <div class="mb-3">
                                    <img id="avatar-setting" src="../<?php echo $_SESSION['user']['avatar']; ?>" style="cursor: pointer; height: 100px; width: 100px;" class="rounded-circle mx-auto d-block border-primary border border-3" data-bs-toggle="modal" data-bs-target="#change-avatar-modal">
                                </div>
                                <div class="form-text text-info text-center mb-3 ">Click to change Avatar</div>
                                <!-- Modal change ava -->
                                <div class="modal fade" id="change-avatar-modal" tabindex="-1">
                                    <div class="modal-dialog  modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Change avatar</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-4">
                                                    <img id="modal-avatar" src="../<?php echo $_SESSION['user']['avatar']; ?>" style="height: 200px; width: 200px;" class="rounded-circle mx-auto d-block border-primary border border-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                </div>
                                                <div class="input-group mb-1">
                                                    <input type="file" class="form-control" id="input-avatar">
                                                </div>
                                                <div id="avatarHelp" class="form-text text-center mb-3">Only accept file image</div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button id="upload-avatar-btn" type="button" class="btn btn-primary" data-bs-dismiss="modal">Save changes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="input-group mb-3">
                                    <div class="input-group-text">
                                        <input id="info-desc-cb" class="form-check-input mt-0 me-1" type="checkbox" <?php if (!empty($profileSetting['description'])) {
                                                                                                                        echo 'checked';
                                                                                                                    } ?>>
                                        Description
                                    </div>
                                    <textarea id="info-desc-value" class="form-control"><?php if (!empty($profileSetting['description'])) {
                                                                                            echo $profileSetting['description'];
                                                                                        }
                                                                                        ?></textarea>
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-text">
                                        <input id="info-place-cb" class="form-check-input mt-0 me-1" type="checkbox" <?php if (!empty($profileSetting['place'])) {
                                                                                                                            echo 'checked';
                                                                                                                        } ?>>
                                        Place
                                    </div>
                                    <input id="info-place-value" type="text" class="form-control" value="<?php if (!empty($profileSetting['place'])) {
                                                                                                                echo $profileSetting['place'];
                                                                                                            }
                                                                                                            ?>">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-text">
                                        <input id="info-job-cb" class="form-check-input mt-0 me-1" type="checkbox" <?php if (!empty($profileSetting['job'])) {
                                                                                                                        echo 'checked';
                                                                                                                    } ?>>
                                        Job
                                    </div>
                                    <input id="info-job-value" type="text" class="form-control" value="<?php if (!empty($profileSetting['job'])) {
                                                                                                            echo $profileSetting['job'];
                                                                                                        }
                                                                                                        ?>">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-text">
                                        <input id="info-birth-cb" class="form-check-input mt-0 me-1" type="checkbox" <?php if (!empty($profileSetting['dateOfBirth'])) {
                                                                                                                            echo 'checked';
                                                                                                                        } ?>>
                                        Birth Day
                                    </div>
                                    <input id="info-birth-value" type="date" class="form-control" value="<?php if (!empty($profileSetting['dateOfBirth'])) {
                                                                                                                $dateOfBirth = date_create($profileSetting['dateOfBirth']);
                                                                                                                echo date_format($dateOfBirth, "Y-m-d");
                                                                                                            }
                                                                                                            ?>"">
                                </div>
                                <div class=" form-text text-info text-center mb-3 ">Only checked fields are stored</div>
                                <div class=" mx-auto w-25 d-block">
                                    <div id="apply-info-btn" class=" btn btn-primary me-1">Apply</div>
                                    <div onclick="window.location.reload()" class=" btn btn-secondary ">Discard</div>
                                </div>
                                <!-- initialize in js  -->
                                <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
                                    <div id="info-toast" class="toast">
                                        <div class="toast-header bg-success text-white">
                                            <img class="rounded me-2">
                                            <strong class="me-auto">Notification</strong>
                                            <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
                                        </div>
                                        <div class="toast-body">
                                            User info have been updated
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-contacts">
                            <div class="p-3">
                                <h4 class="text-center">Contacts</h4>
                                <?php
                                $contacts = getContacts($_SESSION['user']['member_id']);
                                $facebook = array('value' => "", "public" => 0);
                                $youtube = array('value' => "", "public" => 0);
                                $linkedin = array('value' => "", "public" => 0);
                                $stackOverflow = array('value' => "", "public" => 0);
                                if ($contacts) {
                                    $countContacts = count($contacts);
                                    for ($i = 0; $i < $countContacts; $i++) {
                                        if ($contacts[$i]['type'] == 'facebook') {
                                            $facebook = $contacts[$i];
                                        }
                                        if ($contacts[$i]['type'] == 'youtube') {
                                            $youtube = $contacts[$i];
                                        }
                                        if ($contacts[$i]['type'] == 'linkedin') {
                                            $linkedin = $contacts[$i];
                                        }
                                        if ($contacts[$i]['type'] == 'stack-overflow') {
                                            $stackOverflow = $contacts[$i];
                                        }
                                    }
                                }

                                ?>
                                <!-- facebook -->
                                <div class="input-group mb-3">
                                    <span class="input-group-text fs-4"><i class="fab fa-facebook-square"></i></span>
                                    <input id="contact-facebook-value" type="text" class="form-control" <?php echo 'value="' . $facebook['value'] . '"'; ?>>
                                    <div class="input-group-text">
                                        <input class="form-check-input mt-0 me-1" id="contact-facebook-cb" type="checkbox" <?php if ($facebook['public'] == 1) echo "checked"; ?>>
                                        Public
                                    </div>
                                </div>
                                <!-- youtube -->
                                <div class="input-group mb-3">
                                    <span class="input-group-text fs-4"><i class="fab fa-youtube"></i></span>
                                    <input id="contact-youtube-value" type="text" class="form-control" <?php echo 'value="' . $youtube['value'] . '"'; ?>>
                                    <div class="input-group-text">
                                        <input class="form-check-input mt-0 me-1" id="contact-youtube-cb" type="checkbox" <?php if ($youtube['public'] == 1) echo "checked"; ?>>
                                        Public
                                    </div>
                                </div>
                                <!-- linkedin -->
                                <div class="input-group mb-3">
                                    <span class="input-group-text fs-4"><i class="fab fa-linkedin"></i></span>
                                    <input id="contact-linkedin-value" type="text" class="form-control" <?php echo 'value="' . $linkedin['value'] . '"'; ?>>
                                    <div class="input-group-text">
                                        <input class="form-check-input mt-0 me-1" id="contact-linkedin-cb" type="checkbox" <?php if ($linkedin['public'] == 1) echo "checked"; ?>>
                                        Public
                                    </div>
                                </div>
                                <!-- stackoverflow -->
                                <div class="input-group mb-3">
                                    <span class="input-group-text fs-4"><i class="fab fa-stack-overflow"></i></span>
                                    <input id="contact-stack-overflow-value" type="text" class="form-control" <?php echo 'value="' . $stackOverflow['value'] . '"'; ?>>
                                    <div class="input-group-text">
                                        <input class="form-check-input mt-0 me-1" id="contact-stack-overflow-cb" type="checkbox" <?php if ($stackOverflow['public'] == 1) echo "checked"; ?>>
                                        Public
                                    </div>
                                </div>
                                <div class="form-text text-info text-center mb-3 ">All field are stored but only public checked fields </div>
                                <div class="mx-auto w-25 d-block">
                                    <div id="apply-contacts-btn" class=" btn btn-primary me-1">Apply</div>
                                    <div onclick="window.location.reload()" class=" btn btn-secondary ">Discard</div>
                                </div>
                            </div>
                            <!-- initialize in js  -->
                            <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
                                <div id="contact-toast" class="toast">
                                    <div class="toast-header bg-success text-white">
                                        <img class="rounded me-2">
                                        <strong class="me-auto">Notification</strong>
                                        <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
                                    </div>
                                    <div class="toast-body">
                                        Contacts have been updated
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-settings">
                            <div class="p-3">
                                <h4 class="text-center mb-3">Setting</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require '../common/footer.php' ?>
</body>

</html>