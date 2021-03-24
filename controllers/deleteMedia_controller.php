<?php

require_once('../models/OBJposts.php');
require_once('../models/OBJmedias.php');


// --- GET DATA ---

$idMedia = filter_input(INPUT_POST, "idMedia", FILTER_DEFAULT, FILTER_SANITIZE_NUMBER_INT);

$media = Medias::getMediaByIdMedia($idMedia)[0];


// --- DELETE DATA ---

Medias::deleteMedia($idMedia);

$rep = "../assets/" . explode('/', $media["type"])[0] . '/';
$fileName = $rep .  $media['nom'];

unlink($fileName);
