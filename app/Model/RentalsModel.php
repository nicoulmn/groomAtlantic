<?php

namespace Model;

class RentalsModel extends \W\Model\Model
{

	/**
	 * Récupère une ligne de la table Rentals en fonction d'un identifiant 'users' connecté
	 * @param  integer Identifiant
	 * @return mixed Les données sous forme de tableau associatif
	 */
	public function findRentalsWithId($id_user){
		// Selectionne tous les champs de la table Rentals et l'ID du connecté
		$sql = 'SELECT r.* FROM '.$this->table.' AS r WHERE r.id_owner = :owner_id ORDER BY r.title ASC';

		$select = $this->dbh->prepare($sql);
		$select->bindValue(':owner_id', $id_user);
		if($select->execute()){
			return $select->fetchAll(); // Renvoi les résultats
		}

		return false;
	}

	public function findUpdtRental($id_rental){
		
		$sql = 'SELECT r.* FROM '.$this->table.' AS r WHERE r.id = :rid';
		
		$sth = $this->dbh->prepare($sql);		
		$sth->bindValue(':rid', $id_rental);
		if($sth->execute()){
			return $sth->fetch(); // Renvoi les résultats
		}

		return false;
	}




}
