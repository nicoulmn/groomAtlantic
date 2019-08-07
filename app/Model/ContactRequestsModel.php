<?php

namespace Model;

/**
 * Classe requise par l'AuthentificationModel, éventuellement à étendre par le UsersModel de l'appli
 */
class ContactRequestsModel extends \W\Model\Model
{

    /**
     * Contiendra le nombre de notifications non "lues"
     */
    public $totalNotifications = 0;

    // Récupération des commentaires
    public function contactAuthorName(){

        $sql = '

        SELECT c.*, u.* 
        FROM '.$this->table.' 
        AS c 
        INNER JOIN users 
        AS u 
        ON c.id_owner = u.id';

        $select = $this->dbh->prepare($sql);
        if($select->execute()){
            return $select->fetchAll(); // Renvoie les résultats
        }
        return false;
    }

    public function requestDoublon($idOwner, $idGroom){ //select les requetes qui concernnent le groom // On la compare ensuite à celui qui fait la requete (id_owner) pour vérifier s'il ne contacte pas 2 fois la même personne

        $sql = '

        SELECT * 
        FROM '.$this->table.' 
        WHERE id_groom = :id_groom 
        AND id_owner = :id_owner';
        $sth = $this->dbh->prepare($sql);
        // @todo : ordre des variables ?
        $sth->bindValue(':id_groom', $idGroom);
        $sth->bindValue(':id_owner', $idOwner);
        $sth->execute();

        return $sth->fetchAll();
        
    }


    /**
     * Récupère les demandes de contact en attente pour un groom
     * @param $id_groom L'id du groom
     */
    public function showRequestForGroomId($id_groom, $options)
    {

        $sql = 'SELECT SQL_CALC_FOUND_ROWS c.id AS contact_id, c.groom_accept, c.owner_confirm, c.groom_confirm, c.date AS contact_date, c.rent_id, c.message,  groom.id AS groom_id, groom.firstname AS groom_firstname, groom.lastname AS groom_lastname, owner.id AS owner_id, owner.firstname AS owner_firstname, owner.lastname AS owner_lastname, r.title AS rent_title, r.postcode, r.city

            FROM '.$this->table.' AS c 
            JOIN users AS groom ON c.id_groom = groom.id
            JOIN users AS owner ON c.id_owner = owner.id 
            JOIN rentals AS r ON c.rent_id = r.id';


        
        if($options == 'tec')
        {
            // affichage notification si le groom n'a pas encore accepté 
            $sql.= ' WHERE c.id_groom = :id_groom AND c.groom_accept = 0';
        }
        elseif($options == 'tuc')
        {
            // affichage notification si le groom a accepté de transmettre ses coordonnées, que le propriétaire à confirmer avoir travailler avec le groom et que le groom a confirmé avoir, lui aussi, travaillé avec le propriétaire
            $sql.= ' WHERE c.id_groom = :id_groom AND c.groom_accept = 2 AND c.owner_confirm = 1 AND c.groom_confirm = 0';

        }

        


        $sth = $this->dbh->prepare($sql);
        $sth->bindValue(':id_groom', $id_groom, \PDO::PARAM_INT);
        $sth->execute();

        $this->countResult();

        return $sth->fetchAll();
    }


    /**
     * Récupère les demandes de contact accepté pour un proprio
     * @param $id_owner L'id du proprio
     */
    public function showRequestForOwnerId($id_owner, $options)
    {


        $sql = 'SELECT SQL_CALC_FOUND_ROWS c.id AS contact_id, c.groom_accept, c.owner_confirm, c.groom_confirm, c.date AS contact_date, c.rent_id,  groom.id AS groom_id, owner.id AS owner_id, groom.firstname AS groom_firstname, groom.lastname AS groom_lastname, groom.phone AS groom_phone, groom.email AS groom_mail, owner.firstname AS owner_firstname, owner.lastname AS owner_lastname, r.title AS rent_title, r.postcode, r.city

            FROM '.$this->table.' AS c 
            JOIN users AS groom ON c.id_groom = groom.id 
            JOIN users AS owner ON c.id_owner = owner.id 
            JOIN rentals AS r ON c.rent_id = r.id';


        if($options == 'tic')
        {

            // affichage notification si le groom a accepté de transmettre ses coordonnées et que le propriétaire n'a pas encore confirmé s'il avait travaillé ou non avec le groom
            $sql.= ' WHERE c.id_owner = :id_owner AND c.groom_accept = 2 AND c.owner_confirm = 0';

        
        }
        elseif($options == 'tac')
        {
            /// affichage notification si le groom a accepté de transmettre ses coordonnées et que le propriétaire a confirmé avoir travaillé avec le groom et que le groom a confirmé avoir, lui aussi, travaillé avec le propriétaire 
            $sql.= ' WHERE c.id_owner = :id_owner AND c.groom_accept = 2 AND c.owner_confirm = 1 AND c.groom_confirm = 1';

        }
        

        $sth = $this->dbh->prepare($sql);
        $sth->bindValue(':id_owner', $id_owner, \PDO::PARAM_INT);
        $sth->execute();

        $this->countResult();

        return $sth->fetchAll();
    }


    /**
     * Recalcule les notifications pour l'utilisateur
     * @param $id L'id de l'utilisateur
     * @param $type groom ou owner Le type d'utilisateur
     */
    public function recalcNotif($id, $type = 'owner')
    {
        $allowType = ['groom', 'owner'];

        if(!in_array($type, $allowType)){
            return false;
        }

        switch ($type) {
            case 'groom':
                $where = 'id_groom = :id AND groom_accept = 0';
            break;
            case 'owner':
                // 2 => accept | 1 => decline
                $where = 'id_owner = :id  AND groom_accept = 2';
            break;
            default: 
                $where = '';
        }


        $sql = 'SELECT SQL_CALC_FOUND_ROWS id FROM '.$this->table .' WHERE '.$where;
        $sth = $this->dbh->prepare($sql);
        $sth->bindValue(':id', $id, \PDO::PARAM_INT);
        $sth->execute();

        $this->countResult();
    }


    protected function countResult(){
        $sql = 'SELECT FOUND_ROWS() AS nb_result';
        $sth = $this->dbh->prepare($sql);
        $sth->execute();

        $result = $sth->fetch();

        $this->totalNotifications = $result['nb_result'];
    }

    
}

