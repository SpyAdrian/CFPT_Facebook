<?php

// DB CONN
require_once('../models/dbConn.php');

class Posts
{
    public static function getPosts()
    {
        try {
            $sql = "SELECT * FROM post";
            $db = DBConnection::prepare($sql);
            $db->execute();
            return $db->fetchAll();
        } catch (PDOException $e) {
            return '<pre>Erreur : ' . $e->getMessage() . '</pre>';
        }
    }

    public static function insertPost($commentaire)
    {
        $creationDate = date("Y-m-d H:i:s");

        $sql = "INSERT INTO post (commentaire, creationDate, modificationDate) VALUES (?,?,?)";
        return DBConnection::prepare($sql)->execute([$commentaire, $creationDate, $creationDate]);
    }

    public static function deletePost($idPost)
    {
        $sql = "DELETE FROM post WHERE idPost = " . $idPost;
        return DBConnection::prepare($sql)->execute();
    }

    public static function updatePost($idPost, $commentaire)
    {
        $modificationDate = date("Y-m-d H:i:s");

        $sql = "UPDATE post SET commentaire = '$commentaire', modificationDate = '$modificationDate' WHERE idPost = " . $idPost;
        return DBConnection::prepare($sql)->execute();
    }
}
