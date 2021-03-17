<?php

require_once('../models/OBJposts.php');
require_once('../models/OBJmedias.php');
require_once('../models/OBJdbConn.php');


// --- CONST ---

$MAX_SIZE_FILE = 3000000;
$MAX_SIZE_POST = 70000000;


// ---GET DATA ---

$idPost = filter_input(INPUT_POST, "idPost", FILTER_DEFAULT, FILTER_SANITIZE_NUMBER_INT);
$commentaire = filter_input(INPUT_POST, "updatePostForm_Commentaire", FILTER_DEFAULT, FILTER_SANITIZE_STRING);
$files = null;

if (isset($_FILES['updatePostForm_File'])) {
    $files = reArrayFiles($_FILES['updatePostForm_File']);

    if ($files[0]['name'] == null)
        $files = array();
}


// --- FILTRE DATA ---

$error = null;
$post_size = null;

// file exist


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
    header("location: ../views/updatePost.php?error=" . $error . "&idPost=" . $idPost);
    exit;
}


// --- UPDATE POST & IMG ---

$db = DBConnection::getConnection();
$db->BeginTransaction();

try {

    Posts::updatePost($idPost, $commentaire);

    foreach ($files as $key => $value) {
        $fileExtention = pathinfo($value["name"], PATHINFO_EXTENSION);
        $filename = uniqid("", true) . '.' . $fileExtention;

        $mediaInserted = Medias::insertMedia($filename, $value["type"], $idPost);

        if ($mediaInserted) {
            $rep = "../assets/" . explode('/', $value["type"])[0] . '/';
            move_uploaded_file($value["tmp_name"], $rep . $filename);
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
