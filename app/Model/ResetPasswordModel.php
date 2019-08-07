<?php

namespace Model;


/**
	UsersModel => table users
	ShopModel => table shop
	MyShopModel => table my_shop
*/
class ResetPasswordModel extends \W\Model\Model
{
    	public function findToken($idUser, $token)
	{
		

		$sql = 'SELECT * FROM ' . $this->table . ' WHERE id_user = :idUser AND token = :token';
		$sth = $this->dbh->prepare($sql);		
		$sth->bindValue(':idUser', $idUser);
		$sth->bindValue(':token', $token);

		$sth->execute();

		return $sth->fetchall();


	}

		public function deleteToken($idUser, $token)
	{
		

		$sql = 'DELETE FROM ' . $this->table . ' WHERE id_user = :idUser AND token = :token';
		$sth = $this->dbh->prepare($sql);
		$sth->bindValue(':token', $token);
		$sth->bindValue(':idUser', $idUser);
		$sth->execute();



	}





}






/*
$reponse = $bdd->prepare('DELETE FROM reset_password WHERE idUser = :idUser AND token = :token');
		$reponse->bindValue(':token', $_GET['token'], PDO::PARAM_STR);
		$reponse->bindValue(':idUser', $_GET['idUser'], PDO::PARAM_INT);
		$reponse->execute();

	*/

