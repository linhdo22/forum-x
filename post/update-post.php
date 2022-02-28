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
    <title>Update Post</title>
    <link rel="stylesheet" href="./create-post.css">
    <script src="../common/js/tinymce/js/tinymce/tinymce.min.js"></script>
</head>

<body>
    <?php
    require '../controller/post.php';
    if (!isset($_GET['id'])) {
        header('Location: ../home/home.php');
    }
    $post = getPost($_GET['id']);
    if ($_SESSION['user']['member_id'] != $post['author']) {
        header('Location: ../home/home.php');
    }
    $authorId = $post['author'];
    echo "<script> window.authorId = $authorId </script>";
    require '../common/header.php';
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
                    <div class="border shadow-sm  p-4 mb-3">
                        <button id="create-btn" type="submit" name='update-post' class="w-100 btn btn-outline-primary mb-4">Update post</button>
                        <div onclick="window.location.reload()" class="w-100 btn btn-outline-secondary">Discard change</div>
                    </div>
                    <div class="border shadow-sm  p-4">
                        <?php
                        $tags = getTags($post['post_id']);
                        ?>
                        <p class="text-center fw-bold fs-5">Post tag </p>
                        <div>
                            <div class="my-2">
                                <input id="art-tag" type="checkbox" name="tags[]" value="art" <?php if (in_array("art", $tags)) echo 'checked'; ?> class="btn-check">
                                <label for="art-tag" class="btn btn-outline-primary rounded-pill">#Art</label>
                            </div>
                            <div class="my-2">
                                <input id="biology-tag" type="checkbox" name="tags[]" value="biology" <?php if (in_array("biology", $tags)) echo 'checked'; ?> class="btn-check">
                                <label for="biology-tag" class="btn btn-outline-primary rounded-pill">#Biology</label>
                            </div>
                            <div class="my-2">
                                <input id="mechanic-tag" type="checkbox" name="tags[]" value="mechanic" <?php if (in_array("mechanic", $tags)) echo 'checked'; ?> class="btn-check">
                                <label for="mechanic-tag" class="btn btn-outline-primary rounded-pill">#Mechanic</label>
                            </div>
                            <div class="my-2">
                                <input id="news-tag" type="checkbox" name="tags[]" value="news" <?php if (in_array("news", $tags)) echo 'checked'; ?> class="btn-check">
                                <label for="news-tag" class="btn btn-outline-primary rounded-pill">#News</label>
                            </div>
                            <div class="my-2">
                                <input id="science-tag" type="checkbox" name="tags[]" value="science" <?php if (in_array("science", $tags)) echo 'checked'; ?> class="btn-check">
                                <label for="science-tag" class="btn btn-outline-primary rounded-pill">#Science</label>
                            </div>
                            <div class="my-2">
                                <input id="social-tag" type="checkbox" name="tags[]" value="social" <?php if (in_array("social", $tags)) echo 'checked'; ?> class="btn-check">
                                <label for="social-tag" class="btn btn-outline-primary rounded-pill">#Social</label>
                            </div>
                            <div class="my-2">
                                <input id="tech-tag" type="checkbox" name="tags[]" value="tech" <?php if (in_array("tech", $tags)) echo 'checked'; ?> class="btn-check">
                                <label for="tech-tag" class="btn btn-outline-primary rounded-pill">#Tech</label>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
    <script>
        tinymce.init({
            selector: '#textarea',
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