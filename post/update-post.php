<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Post</title>
    <link rel="stylesheet" href="./create-post.css">
    <script src="../common/js/tinymce/js/tinymce/tinymce.min.js"></script>
</head>

<body>
    <?php require '../common/header.php'; ?>
    <?php require '../controller/post.php' ?>

    <?php
    if (!isset($_GET['id'])) {
        header('Location: ../home/home.php');
    }
    $post = getPost($_GET['id']);
    if ($_SESSION['user']['member_id'] != $post['author']) {
        header('Location: ../home/home.php');
    }
    $authorId = $post['author'];
    echo "<script> window.authorId = $authorId </script>";
    ?>

    <div class="main-post container">
        <form action="./xuly-update-post.php" method="post">
            <input name="postId" type="hidden" value="<?php echo $post['post_id']; ?>">
            <div class="row">
                <div class="col">
                    <h3>Update post</h3>
                    <div class="mb-3">
                        <label for="post-title" class="form-label">Post title</label>
                        <input required class="form-control" name="title" id="post-title" value="<?php echo $post['title']; ?>">
                        <div class="form-text">Title let others find post easier</div>
                    </div>
                </div>
            </div>
            <div class="row pt-5">
                <div class="col-md 8 create-post-content">
                    <textarea id='textarea' style="height:100%" name='content'><?php echo $post['content']; ?></textarea>
                </div>
                <div class="col-md-3 offset-md-1 ">
                    <div class="border shadow  p-4">
                        <button id="create-btn" type="submit" name='update-post' class="w-100 btn btn-outline-primary mb-4">Update post</button>
                        <button id="create-btn" onclick="window.location.reload()" class="w-100 btn btn-outline-secondary">Discard change</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script>
        tinymce.init({
            selector: 'textarea',
            plugins: 'advlist link image lists',
            menubar: false,
            toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | ' +
                '| link image | print preview media fullscreen | ' +
                'forecolor backcolor emoticons | help',
            images_upload_url: '../upload-image/upload.php',
        });
    </script>
    <!-- <script src="./update-post.js"></script> -->
    <?php require '../common/footer.php' ?>
</body>

</html>