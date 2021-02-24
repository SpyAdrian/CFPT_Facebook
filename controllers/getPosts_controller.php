<?php

require_once('../models/OBJposts.php');
require_once('../models/OBJmedias.php');


// --- CONST ---

$REP_IMG = "../assets/img/";


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
$lastModificationData;

foreach ($posts as $key => $post) {

    $idPost = $post['idPost'];
    $src = $REP_IMG . $post['nom'];
    $type = $post['type'];
    $commentaire = $post['commentaire'];
    $modificationDate = $post['modificationDate'];


    if ($idPost != $lastId) {

        if ($firstLoop == false) {

            // add end of carousel and card
            $result .= '
                </div>
                    <a class="carousel-control-prev" href="#carouselControls_' . $lastId . '" role="button" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselControls_' . $lastId . '" role="button" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </a>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">' . $lastCommentaire . '</p>
                    <p class="card-text"><small class="text-muted">Last Update ' . $lastModificationData . '</small></p>
                </div>
            </div>';
        }

        // add start of card and carousel
        $result .= '<div class="card mb-5" style="width: 750px;">
                        <div id="carouselControls_' . $idPost . '" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner">';

        // add image or video in the carousel
        if (is_numeric(strpos($type, "image"))) {

            $result .= '<div class="carousel-item active">
                            <img src="' . $src . '" width="748">      
                        </div>';
        } else {

            $result .= '<div class="carousel-item active">
                            <video width="750px" autoplay controls loop>
                                <source src="' . $src . '" type="' . $type . '">
                            </video>     
                        </div> ';
        }
    } else {

        // add image or video in the carousel
        if (is_numeric(strpos($type, "image"))) {

            $result .= '<div class="carousel-item">
                            <img src="' . $src . '" width="748">      
                        </div>';
        } else {

            $result .= '<div class="carousel-item">
                            <video width="750px" autoplay controls loop>
                                <source src="' . $src . '" type="' . $type . '">
                            </video>     
                        </div> ';
        }
    }


    $lastId = $idPost;
    $lastCommentaire = $commentaire;
    $lastModificationData = $modificationDate;
    $firstLoop = false;
}

// add last end of carousel and card
$result .= '
    </div>
        <a class="carousel-control-prev" href="#carouselControls_' . $lastId . '" role="button" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselControls_' . $lastId . '" role="button" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </a>
    </div>
    <div class="card-body">
        <h5 class="card-title">Card title</h5>
        <p class="card-text">' . $lastCommentaire . '</p>
        <p class="card-text"><small class="text-muted">Last Update ' . $lastModificationData . '</small></p>
    </div>
</div>';


echo $result;
