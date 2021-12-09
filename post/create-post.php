<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post</title>
    <link rel="stylesheet" href="../assets/css/base.css">
    <link rel="stylesheet" href="./create-post.css">
    <script src="../common/js/tinymce/js/tinymce/tinymce.min.js"></script>
</head>

<body>
    <?php require '../common/header.php'; ?>
    <?php require './xuly-create-post.php' ?>

    <!------------------------------------------- col2 ------------------------------------------------------>

    <div class="main-post container">
        <form method="post">
            <div class="row">
                <div class="col">
                    <h3>Create new post</h3>
                    <div class="mb-3">
                        <label for="post-title" class="form-label">Post title</label>
                        <input required class="form-control" name="post-title" id="post-title">
                        <div class="form-text">Title let others find post easier</div>
                    </div>
                </div>
            </div>
            <div class="row pt-5">
                <div class="col-md 8 create-post-content">
                    <textarea id='textarea' style="height:100%" name='textarea'>Next, use our Get Started docs to setup Tiny!</textarea>
                </div>
                <div class="col-md-3 offset-md-1 ">
                    <div class="border shadow  p-4">
                        <button id="create-btn" type="submit" name='create-post' class="w-100 btn btn-outline-primary">Create post</button>
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
    <script src="./create-post.js"></script>
    <?php require '../common/footer.php' ?>
</body>

</html>