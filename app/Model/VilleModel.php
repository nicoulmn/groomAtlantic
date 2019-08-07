<?php

namespace Model;

class VilleModel extends \W\Model\Model
{

	public function findVille($CodePostal)
	{

			$sql = 'SELECT NomVille FROM ' . $this->table . ' WHERE CodePostal = :cp LIMIT 1';
			$sth = $this->dbh->prepare($sql);
			$sth->bindValue(':cp', $CodePostal);
			$sth->execute();

			return $sth->fetch();

	}
		

}
