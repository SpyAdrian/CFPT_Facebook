<?php

require_once('../models/OBJposts.php');
require_once('../models/OBJmedias.php');


// --- CONST ---

$MAX_SIZE_FILE = 3000000;
$MAX_SIZE_POST = 70000000;

$REP_IMG = "../assets/img/";


// ---GET DATA ---

$commentaire = filter_input(INPUT_POST, "createPostForm_Commentaire", FILTER_DEFAULT, FILTER_SANITIZE_STRING);
$files = null;

if ($_FILES['createPostForm_File']) {
    $files = reArrayFiles($_FILES['createPostForm_File']);
}


// --- FILTRE DATA ---

$error = null;
$post_size = null;

foreach ($files as $f) {

    $post_size += $f['size'];

    if ($f['size'] >= $MAX_SIZE_FILE) {
        $error = "One of your images exceeds the size limit of " . $MAX_SIZE_FILE . " bytes.";
    }
}

if ($post_size >= $MAX_SIZE_POST) {
    $error = "Your images exceeds the size limit of " . $MAX_SIZE_POST . " bytes.";
}

// return to post with the error
if ($error != null) {
    header("location: ../views/post.php?error=" . $error);
    exit;
}


// --- CREATE POST & IMG ---

$postInserted = json_encode(Posts::insertPost($commentaire));

if ($postInserted) {
    $idPost = Posts::getLastInsertId()[0][0];

    foreach ($files as $key => $value) {
        $mediaInserted = Medias::insertMedia($value["name"], $value["type"], $idPost);

        if ($mediaInserted) {
            $fileExtention = '.' . explode('/', $value["type"])[1];
            $filename = $REP_IMG . uniqid("", true) . $fileExtention;

            move_uploaded_file($value["tmp_name"], $filename);
        }
    }
}


// ------- Return to Home -------

header("location: ../views/home.php");
exit;



// ------- Fonct -------

// credit : php.net
function reArrayFiles($file_post)
{

    $file_ary = array();
    $file_count = count($file_post['name']);
    $file_keys = array_keys($file_post);

    for ($i = 0; $i < $file_count; $i++) {
        foreach ($file_keys as $key) {
            $file_ary[$i][$key] = $file_post[$key][$i];
        }
    }

    return $file_ary;
}
