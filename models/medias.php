<?php

// DB CONN
require_once('../models/dbConn.php');

class Medias
{
    public static function getMedias()
    {
        try {
            $sql = "SELECT * FROM media";
            $db = DBConnection::prepare($sql);
            $db->execute();
            return $db->fetchAll();
        } catch (PDOException $e) {
            return '<pre>Erreur : ' . $e->getMessage() . '</pre>';
        }
    }

    public static function insertMedia($nom, $type, $idPost)
    {
        $creationDate = date("Y-m-d H:i:s");

        $sql = "INSERT INTO media (nom, type, creationDate, modificationDate, idPost) VALUES (?,?,?)";
        return DBConnection::prepare($sql)->execute([$nom, $type, $creationDate, $creationDate, $idPost]);
    }

    public static function deleteMedia($idMedia)
    {
        $sql = "DELETE FROM media WHERE idMedia = " . $idMedia;
        return DBConnection::prepare($sql)->execute();
    }

    public static function updateMedia($idMedia, $nom, $type, $idPost)
    {
        $modificationDate = date("Y-m-d H:i:s");

        $sql = "UPDATE media SET nom = '$nom', type = '$type', idPost = '$idPost' WHERE idMedia = " . $idMedia;
        return DBConnection::prepare($sql)->execute();
    }
}
