<?php

namespace Model;


/**
	UsersModel => table users
	ShopModel => table shop
	MyShopModel => table my_shop
*/
class ServicesInfosModel extends \W\Model\Model
{

	public function findSkillsWithId($id) // Fonction qui récup les compétences du groom en FIND_IN_SET
	{

		$sql = '
		SELECT skills 
		FROM ' . $this->table . ' , groom_services  
		WHERE id_groom  = :id 
		AND FIND_IN_SET(groom_services.id, id_skill) ';

		$sth = $this->dbh->prepare($sql);
		$sth->bindValue(':id', $id);
		$sth->execute();

		return $sth->fetchAll();
	}

	// Fonction qui récup les prix renseignés par le groom
	public function findPricesWithId($id) 
	{

		$sql = 'SELECT * FROM ' . $this->table . ' WHERE id_groom  = :id';
		$sth = $this->dbh->prepare($sql);
		$sth->bindValue(':id', $id);
		$sth->execute();

		return $sth->fetchAll();
	}

	public function searchByCP($search, $order = false, array $searchCompetences = NULL){ // Fonction qui recherche le groom en fonction du CP rentré, jointé avec les infos de users
		
		
/*
u.firstname, u.lastname, u.postcode, u.photo, u.date_creation, u.lat, u.lng, , s.description, s.price, s.id_skill, s.id_groom 


		$searchCompetences = [
			'competence_1' => 1,
			'competence_2' => 2,
			'competence_3' => 3,
			'competence_4' => 4,
		];
*/
        $sql = 'SELECT u.id as user_id, AVG(c.note) as moyenne, u.*, s.* 
        FROM users AS u 
        INNER JOIN services_infos AS s
        ON s.id_groom = u.id
        LEFT JOIN comments AS c
        ON c.id_groom = s.id_groom
        WHERE u.postcode 
        LIKE :city';

        if(is_array($searchCompetences) && !empty($searchCompetences)){

        	$sql.= ' AND (';
        	foreach($searchCompetences as $key => $comp){
        		$sql.= "FIND_IN_SET($comp, s.id_skill) AND ";
        	}
        	$sql = substr($sql, 0, -4);
        	
        	$sql.= ') ';
        }

        $sql.= ' GROUP BY u.id ';

        if($order == true){
        	$sql.= ' ORDER BY moyenne DESC';
        }   

        /*
		if($order == 'tamaman'){
        	$sql.=  ' ORDER BY user_id DESC';
        }   
		*/
        //debug($sql); die;
        
        $sth = $this->dbh->prepare($sql);	
			
		$sth->bindValue(':city', '%'.$search.'%');
	
		if(!$sth->execute()){
			return false;
		}
        return $sth->fetchAll();

       
/*
        
        $sql = 'SELECT s.*, u.* 
        FROM ' . $this->table.' AS s 
        INNER JOIN users AS u 
        ON s.id_groom = u.id 
        WHERE u.postcode 
        LIKE :city';

        $sth = $this->dbh->prepare($sql);	
			
		$sth->bindValue(':city', '%'.$search.'%');
	
		if(!$sth->execute()){
			return false;
		}
        return $sth->fetchAll();

*/
      



	}


	public function groomById($id){ // Fonction qui recherche le groom en fonction du CP rentré, jointé avec les infos de users

		
		
		// TENTATIVE D'INCLURE LE FIND IN SET DANS LA RECHERHE  : $sql = 'SELECT s.*, u.*, g.* FROM groom_services AS g, ' . $this->table.' AS s INNER JOIN users AS u ON s.id_groom = u.id WHERE s.city LIKE :city AND FIND_IN_SET(g.id, id_skill) ';


        $sql = '
        SELECT s.*, u.* 
        FROM ' . $this->table.' AS s 
        INNER JOIN users AS u 
        ON s.id_groom = u.id 
        WHERE s.id_groom = :id_groom';               
		
		$sth = $this->dbh->prepare($sql);	
			
		$sth->bindValue(':id_groom', $id);
	
		if(!$sth->execute()){
			return false;
		}
        return $sth->fetchAll();
	}


    public function infosDoublon($idGroom){ //select les requetes qui concernnent le groom // On la compare ensuite à celui qui fait la requete (id_owner) pour vérifier s'il ne contacte pas 2 fois la même personne

        $sql = '

        SELECT * 
        FROM '.$this->table.' 
        WHERE id_groom = :id_groom';
        $sth = $this->dbh->prepare($sql);
        // @todo : ordre des variables ?
        $sth->bindValue(':id_groom', $idGroom);
        
        $sth->execute();

        return $sth->fetchAll();
        
    }
}


