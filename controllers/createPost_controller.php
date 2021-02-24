<?php

require_once('../models/OBJposts.php');
require_once('../models/OBJmedias.php');
require_once('../models/OBJdbConn.php');


// --- CONST ---

$MAX_SIZE_FILE = 3000000;
$MAX_SIZE_POST = 70000000;

$REP_IMG = "../assets/img/";


// ---GET DATA ---

$commentaire = filter_input(INPUT_POST, "createPostForm_Commentaire", FILTER_DEFAULT, FILTER_SANITIZE_STRING);
$files = null;

if (isset($_FILES['createPostForm_File'])) {
    $files = reArrayFiles($_FILES['createPostForm_File']);
}


// --- FILTRE DATA ---

$error = null;
$post_size = null;

foreach ($files as $f) {
    $post_size += $f['size'];

    if (is_numeric(strpos($f["type"], "image")) == false && is_numeric(strpos($f["type"], "video")) == false && is_numeric(strpos($f["type"], "audio")) == false) {
        $error = "One of your files isn't an image, video or audio, but is an : " . $f["type"];
        break;
    }

    if ($f['size'] >= $MAX_SIZE_FILE) {
        $error = "One of your files exceeds the size limit of " . $MAX_SIZE_FILE . " bytes.";
        break;
    }
}

if ($post_size >= $MAX_SIZE_POST) {
    $error = "Your files exceeds the size limit of " . $MAX_SIZE_POST . " bytes.";
}

// return to post with the error
if ($error != null) {
    header("location: ../views/post.php?error=" . $error);
    exit;
}


// --- CREATE POST & IMG ---

$db = DBConnection::getConnection();
$db->BeginTransaction();

try {
    $postInserted = json_encode(Posts::insertPost($commentaire));

    if ($postInserted) {
        $idPost = Posts::getLastInsertId()[0][0];

        foreach ($files as $key => $value) {
            $fileExtention = '.' . explode('/', $value["type"])[1];
            $filename = uniqid("", true) . $fileExtention;

            $mediaInserted = Medias::insertMedia($filename, $value["type"], $idPost);

            if ($mediaInserted) {
                move_uploaded_file($value["tmp_name"], $REP_IMG . $filename);
            }
        }
    }

    $db->commit();
} catch (PDOException $e) {
    $db->rollBack();
    $result = '<pre>Erreur : ' . $e->getMessage() . '</pre>';
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
