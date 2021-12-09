<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/fontawesome-free-5.15.4-web/css/all.min.css">
    <link rel="stylesheet" href="./my-list.css">
    <script src="./my-list.js"></script>
    <title>List Post</title>
</head>

<body style="background-color:#eef0f1;">
    <?php require '../common/header.php'; ?>

    <h3 class="text-center mt-4 "><span class="border border-3 border-primary text-primary rounded-pill py-1 px-3" style="border-style: dashed !important;">Posts manager</span></h3>
    <div class="container my-5">
        <div class="row">
            <div class="col-md-3 ">
                <div class="p-3 border border-3 shadow bg-white" style="border-radius: 20px;">
                    <h3>All post stats</h3>
                    <div class="d-flex justify-content-between">
                        <div>
                            <p title="Flower">Follower:</p>
                            <p title="View">View:</p>
                            <p title="Upvote">Vote:</p>
                            <p title="Post number">Post number:</p>
                        </div>
                        <div>
                            <p><?php echo $_SESSION['user']['subcribe_count'] ?></p>
                            <p id="all-view-count">2</p>
                            <p id="all-vote-count">3</p>
                            <p id="all-posts-count">4</p>
                        </div>
                    </div>
                </div>
                <div class="mt-4 shadow-sm rounded w-75 mx-auto">
                    <a href="./create-post.php">
                        <div class="w-100 btn btn-primary">
                            Create new post
                        </div>

                    </a>


                </div>
            </div>
            <div class="col-md-8 offset-md-1 ">
                <div id="post-list">
                    <!-- <h4>No post created</h4> -->
                    <!-- -->
                    <!-- <div class="post public p-3 my-3">
                        <div class="d-flex justify-content-between">
                            <div class="w-75">
                                <h4 class="text-truncate">Title askdj asd laskjd laksjd klasjdl kjasldk jklsalasjd dasda sd asd lasjdl </h4>
                                <div>
                                    <span class="d-inline-block w-25 text-secondary"><i class="me-1 fas fa-eye"></i>100</span>
                                    <span class="d-inline-block me-4 text-primary"><i class="me-1 far fa-thumbs-up"></i>200</span>
                                    <span class="d-inline-block text-danger"><i class="me-1 fas fa-thumbs-down"></i>300</span>
                                </div>
                                <p class="my-1">Created At</p>
                                <p class="my-1">Updated At</p>
                            </div>
                            <div>
                                <div class="d-flex w-100 mb-5 justify-content-end">
                                    <div class="btn btn-outline-success" title="Click to change private">Public</div>
                                </div>
                                <div class="btn btn-danger">Delete</div>
                                <div class="btn btn-primary ">Update</div>
                            </div>
                        </div>
                    </div> -->
                    <!--  -->
                </div>

                <!-- Modal -->
                <div class="modal fade" id="confirm-status-modal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Confirm change status</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body" id="confirm-status-body">

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" id="confirm-change-btn" class="btn btn-primary">Change</button>
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