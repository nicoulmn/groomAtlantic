<?php

namespace Model;

class Groom_servicesModel extends \W\Model\Model
{
	public function showGroom_services(){

		$groom_servicesModel = new Groom_servicesModel();
		$gservice = $groom_servicesModel->find();

		var_dump($gservice);
        
		// return

	}
}
