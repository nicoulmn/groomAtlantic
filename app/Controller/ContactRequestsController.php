<?php

namespace Controller;

use \W\Controller\Controller;
use \Model\ContactRequestsModel;


class ContactRequestsController extends Controller
{

    public function ContactAuthor(){
        $ContactAuthor = new ContactRequestsModel();
        $contactAut = $ContactAuthor->contactAuthorName();
        
        return $contactAut;
    }
}
    