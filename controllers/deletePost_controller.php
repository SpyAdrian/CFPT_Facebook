<?php

require_once('../models/OBJposts.php');
require_once('../models/OBJmedias.php');


// --- GET DATA ---

$idPost = filter_input(INPUT_GET, "idPost", FILTER_DEFAULT, FILTER_SANITIZE_NUMBER_INT);

$medias = Medias::getMediasByIdPost($idPost);


// --- DELETE DATA ---

Posts::deletePost($idPost); // in database

// in server
foreach ($medias as $key => $m) {

    $rep = "../assets/" . explode('/', $m["type"])[0] . '/';
    $fileName = $rep .  $m['nom'];

    unlink($fileName);
}


// ------- Return to Home -------

header("location: ../views/home.php");
exit;
