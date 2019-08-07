<?php

namespace Model;

/**
 * Classe requise par l'AuthentificationModel, éventuellement à étendre par le UsersModel de l'appli
 */
class UsersModel extends \W\Model\UsersModel
{
    
    public function nameUser($id)
    {
        $sql = 'SELECT firstname, lastname FROM users WHERE id = :id LIMIT 1';
        $sth = $this->dbh->prepare($sql);
        $sth->bindValue(':id', $id);
        $sth->execute();
                
        return $sth->fetch();
    }

    public function mapMarkers()
    {
        $sql = 'SELECT * FROM users WHERE role = "groom"'; 
        $result = $this->dbh->prepare($sql);
        if($result->execute())
        {
            $donnee = $result->fetchAll();
            return $donnee;
        }
    }
    
    public function getXmlCoordsFromAdress($address)
    {
        $coords=array();
        $base_url="http://maps.googleapis.com/maps/api/geocode/xml?";
        $request_url = $base_url . "address=" . urlencode($address).'&region=fr';
        $xml = simplexml_load_file($request_url) or die("url not loading");
    
        $coords['lat']=$coords['lon']='';
        $coords['status'] = $xml->status ;
        if($coords['status']=='OK')
        {
            $coords['lat'] = $xml->result->geometry->location->lat;
            $coords['lon'] = $xml->result->geometry->location->lng;
        }
        return $coords;
    }

    //$coords=getXmlCoordsFromAdress();

    public function getExGroom()
    {
        $sql = 'SELECT * FROM users WHERE role = "groom" AND id IN (41,18,24,25) LIMIT 4'; 
        $result = $this->dbh->prepare($sql);
        if($result->execute())
        {
            $donnee = $result->fetchAll();
            return $donnee;
        }


    }


  
}