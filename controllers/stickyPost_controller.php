<?php

require_once('../models/OBJposts.php');
require_once('../models/OBJmedias.php');


// ---- GET DATA ----

$idPost = filter_input(INPUT_GET, "idPost", FILTER_DEFAULT, FILTER_SANITIZE_NUMBER_INT);

$posts = Posts::getPostById($idPost);
$medias = Medias::getMediasByIdPost($idPost);

// ---- CREATE VAR STICKY ----

extract($posts[0]);
