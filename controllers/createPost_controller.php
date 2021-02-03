<?php

require_once('../models/posts.php');
require_once('../models/medias.php');


// --- CONST ---

$MAX_SIZE_FILE = 3000000;
$MAX_SIZE_POST = 70000000;


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
        $error = "One of your images exceeds the size limit of" . $MAX_SIZE_FILE;
    }
}

if ($post_size >= $MAX_SIZE_POST) {
    $error = "Your images exceeds the size limit of " . $MAX_SIZE_POST;
}


if ($error != null) {
}


//TODO : Manage error and create post and media
//TODO : download Media in /img/


//$postInserted = json_encode(Posts::insertPost($commentaire));








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
