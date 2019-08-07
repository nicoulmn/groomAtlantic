<?php

namespace Controller;

use \W\Controller\Controller;



class InfosController extends Controller
{
    public function infosPratiques(){

        $this->show('infos/infosPratiques');

    }

    public function mentionsLegales(){

   		$this->show('infos/MentionsLegales');
    }

    public function quiSommesNous(){

   		$this->show('infos/QuiSommesNous');
   }
	
}

	

