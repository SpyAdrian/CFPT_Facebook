<?php

require_once('../models/OBJposts.php');
require_once('../models/OBJmedias.php');


// --- GET DATA ---

$result = "";
$posts = Posts::getPostsWithMediaNameByNewest();

if ($posts == array()) die();


// --- CONVERT TO HTML CARD ---

// This loop allows to put multiple image in one post.
// Like that we dont have duplicate post with different image (what sql return me).

$firstLoop = true;
$lastId = -1;
$lastCommentaire;
$lastModificationDate;

foreach ($posts as $key => $post) {

    $idPost = $post['idPost'];
    $rep = "../assets/" . explode('/', $post["type"])[0] . '/';
    $src = $rep . $post['nom'];
    $type = $post['type'];
    $commentaire = $post['commentaire'];
    $modificationDate = $post['modificationDate'];

    $active = ($idPost != $lastId) ? "active" : "";

    if ($idPost != $lastId) {

        if ($firstLoop == false) {

            // add end of carousel and card
            $result .= GetEndCarouselCard($lastId, $lastCommentaire, $lastModificationDate);
        }

        // add start of card and carousel
        $result .= '<div class="card mb-5" style="width: 750px;">
                        <div id="carouselControls_' . $idPost . '" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">';
    }

    // add image or video in the carousel
    if (is_numeric(strpos($type, "image"))) {

        $result .= '<div class="carousel-item ' . $active . '">
                        <img src="' . $src . '" width="748">      
                    </div>';
    } elseif (is_numeric(strpos($type, "video"))) {

        $result .= '<div class="carousel-item ' . $active . '">
                        <video width="750px" autoplay controls loop>
                            <source src="' . $src . '" type="' . $type . '">
                        </video>     
                    </div> ';
    } else {

        $result .= '<div class="carousel-item d-flex justify-content-center ' . $active . '">
                        <audio class="w-50 mt-5" controls>
                            <source src="' . $src . '" type="' . $type . '">
                        </audio>  
                    </div>';
    }

    $lastId = $idPost;
    $lastCommentaire = $commentaire;
    $lastModificationDate = $modificationDate;
    $firstLoop = false;
}

// add last end of carousel and card
$result .= GetEndCarouselCard($lastId, $lastCommentaire, $lastModificationDate);

echo $result;


// --- FUNCTION ---

function GetDeleteButton($idPost)
{
    $deleteButton = '<a href="../controllers/deletePost_controller.php?idPost=' . $idPost . '">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="red" class="bi bi-x-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                        </svg>
                    </a>';

    return $deleteButton;
}

function GetEndCarouselCard($id, $commentaire, $date)
{
    // Control previous
    $endCarousel = '</div>
                    <a class="carousel-control-prev" href="#carouselControls_' . $id . '" role="button" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </a>';
    // Control next
    $endCarousel .= '<a class="carousel-control-next" href="#carouselControls_' . $id . '" role="button" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </a>
                </div>';
    // Body Card
    $endCarousel .= '<div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text">' . $commentaire . '</p>
                        <div class="d-flex justify-content-between">
                            <p class="card-text"><small class="text-muted">Last Update ' . $date . '</small></p>
                            ' . GetDeleteButton($id) . '
                        </div>
                    </div>
                </div>';

    return $endCarousel;
}
