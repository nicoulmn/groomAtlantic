<?php

namespace Controller;

use \W\Controller\Controller;
use \Model\Groom_ServicesModel;

class Groom_servicesController extends Controller
{
    public function showService(){
        $GroomServModel = new Groom_servicesModel();
        $groomservice = $GroomServModel->findGroom_servicesWithId();

        $params = [
            'groomservice' => $groomservice,
        ];

        $this->show('users/Profile/showService', $params);
    }
}
