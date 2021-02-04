<?php

$error = filter_input(INPUT_GET, "error", FILTER_DEFAULT, FILTER_SANITIZE_STRING);
$errorAlert;

if (isset($error)) {
    $errorAlert = '<div class="alert alert-danger fade show mb-0" role="alert">' . $error . '</div>';
}

?>
<!DOCTYPE html>
<html lang="fr" style="height: 100%;">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

    <!-- Custom style -->
    <link rel="stylesheet" type="text/css" href="../assets/css/styles.css" />

    <title>CFPT Facebook</title>
</head>

<body style="height: 100%;">

    <!-- Nav Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light p-4" style="height: 75px;">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Navbar</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarMain">
                <div class="d-flex justify-content-end w-100">
                    <ul class="navbar-nav me-5">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="home.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="post.php">Post</a>
                        </li>
                    </ul>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                            <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </nav>


    <!-- Main -->

    <!-- Potentiel Error -->
    <?= (isset($errorAlert)) ? $errorAlert : null; ?>

    <!-- Banner -->
    <div class="w-100 h-40 bg-primary d-flex flex-column justify-content-center align-items-center">
        <h1 class="text-center display-1 pb-5">Create Your Own Post !</h1>
        <h1 class="text-center display-6"></h1>
    </div>

    <!-- Form -->
    <div class="d-flex flex-column justify-content-center align-items-center">
        <form action="../controllers/createPost_controller.php" method="POST" enctype="multipart/form-data" class="w-25 mt-5" style="min-width: 275px;">
            <div class="form-group mb-2">
                <label class="mb-1" for="postFormUpload">Choose your Uploads : </label>
                <input name="createPostForm_File[]" type="file" class="form-control" id="postFormUpload" accept="image/*" multiple>
            </div>
            <div class="form-group mb-2">
                <label class="mb-1" for="postFormDescription">Description : </label>
                <textarea name="createPostForm_Commentaire" class="form-control" id="postFormDescription" rows="5"></textarea>
            </div>
            <button name="submit" type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>



</body>

</html>