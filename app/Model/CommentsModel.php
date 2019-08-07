<?php

namespace Model;

/**
 * Classe requise par l'AuthentificationModel, éventuellement à étendre par le UsersModel de l'appli
 */
class CommentsModel extends \W\Model\Model
{
    // Récupération des commentaires pour l'espace concierge
    public function showCommentById(){

        $sql = 'SELECT c.*, u.* FROM '.$this->table.' AS c INNER JOIN users AS u ON c.id_groom = u.id ORDER BY date DESC';
        $select = $this->dbh->prepare($sql);
        if($select->execute()){
            return $select->fetchAll(); // Renvoie les résultats
        }
        return false;
    }

    // Récupération des commentaires pour l'espace propriétaire
    public function showCommentsById($id_user){

        $sql = 'SELECT c.* FROM '.$this->table.' AS c WHERE c.id_owner = :cid ORDER BY date DESC';
        $select = $this->dbh->prepare($sql);
        
        $select->bindValue(':cid', $id_user);
        if($select->execute()){
            return $select->fetchAll(); // Renvoie les résultats
        }
        return false;
    }


    // Récupération de l'auteur du commentaire (propriétaire)
    public function commentsAuthorName(){

        $sql = 'SELECT c.*, u.firstname, u.id FROM '.$this->table.' AS c INNER JOIN users AS u ON c.id_owner = u.id';
        $select = $this->dbh->prepare($sql);
        if($select->execute()){
            return $select->fetchAll(); // Renvoie les résultats
        }
        return false;
    }

    // Récupération du destinataire du commentaire (groom)
    public function commentsAddresseeName($idgroom){

        $sql = 'SELECT c.*, u.firstname, u.id FROM '.$this->table.' AS c INNER JOIN users AS u ON c.id_groom = u.id WHERE u.id = :idu';
        $select = $this->dbh->prepare($sql);
        $select->bindValue(':idu', $idgroom);

        if($select->execute()){
            return $select->fetchAll(); // Renvoie les résultats
        }
        return false;
    }


    public function NoteMoyGroom($idgroom){

        $sql = '
        SELECT AVG(note) 
        FROM ' . $this->table.' 
        WHERE id_groom = :id_groom';

        $sth = $this->dbh->prepare($sql);           
        $sth->bindValue(':id_groom', $idgroom);

        if(!$sth->execute()){
            return false;
        }
        return $sth->fetchAll();


    }

    public function ShowComm($idgroom){

        $sql = '
        SELECT c.* 
        FROM ' . $this->table.' AS c
        WHERE id_groom = :id_groom';

        $sth = $this->dbh->prepare($sql);           
        $sth->bindValue(':id_groom', $idgroom);

        if(!$sth->execute()){
            return false;
        }
        return $sth->fetchAll();





    }

}

