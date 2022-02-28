<!DOCTYPE html>
<html lang="en">
<?php
if (!isset($_SESSION)) {
    session_start();
}
?>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="profile.css">
    <link rel='stylesheet' type='text/css' href='../common/css/header.css'>
    <script src="main.js"></script>
    <title>Profile</title>
</head>

<body style="background-color: #eef0f1;">
    <?php
    require '../controller/member.php';
    if (!isset($_GET['profile'])) {
        header("Location: ../home/home.php");
    }
    $profile = getProfile($_GET['profile']);
    require '../common/header.php';
    ?>


    <div class="container" style="margin-top: 100px;">
        <div class="row mb-5">
            <div class="upperInfo col-12">
                <div class="userAva">
                    <img src="../<?php echo $profile['avatar']; ?>">
                </div>
                <div class="subcribtion">
                    <div class="subNumber">
                        <i class="fas fa-wifi"> </i>
                        <span class="subText"><?php echo $profile['subcribe_count']; ?></span>
                    </div>
                    <div class="subButton">
                        <input type="checkbox" id="subButtonCb" <?php if (isset($_SESSION['user'])) {
                                                                    if (checkSubcribe($_GET['profile'], $_SESSION['user']['member_id']) == 1) {
                                                                        echo "checked";
                                                                    }
                                                                } ?> class="subButtonCb">
                        <label for="subButtonCb">Subcribe</label>
                    </div>
                    <?php if (isset($_SESSION['user'])) {
                        echo '<div id="chat-btn" class="btn btn-outline-primary fs-4 my-0" style="border-radius:20px">
                            <i class="fas fa-comment "></i>
                        </div>';
                    } ?>
                </div>'
                <div class='text-center fs-2 fw-bold'><?php echo $profile['name']; ?></div>
                <div class="d-flex flex-column align-items-center pb-3">
                    <?php
                    if ($profile['description']) {
                        echo '<div class="p-2 fst-italic ">' . $profile['description'] . '</div>';
                    }

                    ?>
                    <div>
                        <div class="d-flex justify-content-center mb-3">
                            <?php
                            if ($profile['place']) {
                                echo '<div class="me-4"><i class="fas fa-map-marker"></i> ' . $profile['place'] . '</div>';
                            }
                            if ($profile['joinDate']) {
                                $jDate = date_create($profile['joinDate']);
                                echo '<div ><i class="fas fa-plug"></i> Joined on ' . date_format($jDate, 'F j, Y') . '</div>';
                            }
                            ?>
                        </div>
                        <div class="d-flex justify-content-around">
                            <?php
                            if ($profile['contacts']) {
                                $countContacts = count($profile['contacts']);
                                for ($i = 0; $i < $countContacts; $i++) {
                                    if ($profile['contacts'][$i]['public'] == 1) {
                                        echo '<a href="' . $profile['contacts'][$i]['value'] . '"><i class="fab fa-' . $profile['contacts'][$i]['type'] . ' fs-4"></i></a>';
                                    }
                                }
                            }
                            ?>

                            <!-- <a href="#"><i class="fab fa-facebook"></i></a>
                            <a href="#"><i class="fab fa-youtube"></i></a>
                            <a href="#"><i class="fab fa-linkedin"></i></a>
                            <a href="#"><i class="fab fa-stack-overflow"></i></a> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-3 ">
                <div class="bg-white border shadow-sm p-3 fs-5 mb-3" style="border-radius:10px">
                    <?php
                    if ($profile['job']) {
                        echo '<div class="my-1">
                    <span class="fw-bold">Job:</span>' . $profile['job'] . '
                    </div>';
                    }
                    if ($profile['dateOfBirth']) {
                        $dob = date_create($profile['dateOfBirth']);
                        echo '<div class="my-1">
                        <span class="fw-bold">Year born:</span> ' . date_format($dob, 'Y') . '
                        </div>';
                    }
                    ?>
                </div>
                <div class="bg-white border shadow-sm p-3" style="border-radius:10px">
                    <div class="my-2">
                        <i class="far fa-file-alt fs-5 me-2"></i><?php echo getUserAllPostsCount($_GET['profile']); ?> posts published
                    </div>
                    <div class="my-2">
                        <i class="far fa-comment-dots fs-5 me-1"></i><?php echo getUserAllCommentsCount($_GET['profile']); ?> comments written
                    </div>
                </div>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary w-100 mx-auto mt-3" data-bs-toggle="modal" data-bs-target="#donate-modal">
                    <i class="fas fa-hand-holding-usd"></i> Support through VNPAY
                </button>

                <div class="modal fade" id="donate-modal" tabindex="-1">
                    <div class="modal-dialog  modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Donate to <?php echo $profile['name']; ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <?php require './payment-form.php' ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-9">
                <div class="postheader">
                    <!-- <div class="sort">
                        <div class="sorticon"></div>
                        <div href="" id='sortNewest' class="sortType">
                            <i class="sortIcon "></i>
                            Newest
                        </div>
                        <div href="" id='sortAz' class="sortType">
                            <i class="sortIcon fa fa-sort"></i>
                            A-Z
                        </div>
                        <div href="" id='sortView' class="sortType">
                            <i class="sortIcon"></i>
                            View
                        </div>
                    </div> -->
                </div>
                <div class="listpost">
                    <!-- code js  -->
                </div>
            </div>
        </div>
    </div>
    <?php require '../common/footer.php'; ?>

</body>

</html>