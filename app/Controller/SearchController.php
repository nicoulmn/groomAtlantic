<?php

namespace Controller;

use \W\Controller\Controller;
use \Model\ServicesInfosModel;
use \Model\VilleModel;
use \Model\UsersModel;
use \Model\CommentsModel;
use \Model\ContactRequestsModel;
use \Model\RentalsModel;


class SearchController extends Controller
{


    public function searchResult() // Les résultats de la recherche NO SHIT?!
    {


        $InfosGroom = [];
        $tabSkill = [];
        $params=[];
        $errors = [];
        $post = [];
        $order = false;
        $searchCompetences = NULL;



        //Code postal entier :



        if (isset($_GET['postCode']) && strlen($_GET['postCode']) == 5){

            $fullCp = $_GET['postCode'];

            $searchVille = new VilleModel(); // On récupère le nom de la ville recherchée à partir du CP
            $ville = $searchVille->findVille($fullCp);

            //Code Dpt utilisé pour la recherche des grooms (Afin d'élargir la recherche au département)
            $shortCp = substr($_GET['postCode'], 0, 2);	


            if(!empty($_POST)){

                foreach ($_POST as $key => $value){

                    if(is_array($value)){
                        $post[$key] = array_map('trim', array_map('strip_tags', $value));
                    }
                    else {
                        $post[$key] = trim(strip_tags($value));
                    }
                }
                if (!empty($post['order']) ){
                $order = $post['order'];

                }
                if (!empty($post['comp']) ){
                $searchCompetences = $post['comp'];
            }

            }
                    
         
          



            $search = new ServicesInfosModel(); // on insère
            $resultSearch = $search->searchByCP($shortCp, $order, $searchCompetences);	


            if (!empty($resultSearch)){
                // Ici j'ajoute au tableau contenant les résultats de la recherche les infos supplémentaires croisées avec les autres tables 
				
                for($i=0;$i<count($resultSearch);$i++){ 

                    foreach ($resultSearch as $result) {

                        $skillJoint = new ServicesInfosModel();            
                        $resultSearch[$i]['comp'] = $skillJoint->findSkillsWithId($resultSearch[$i]['id_groom']); //Va chercher les compétences du groom a partir des valeurs 1,2,3..           
                        $resultSearch[$i]['prix'] = $pricesTab = explode(',',$resultSearch[$i]['price']);  //Va chercher les tarifs
                        $resultSearch[$i]['villeAction'] = $searchVille->findVille($resultSearch[$i]['postcode']); // transforme le CP en nom de commune

                    }
                }
            }



            $affMarkers = new UsersModel();
            $markers = $affMarkers->mapMarkers();

            $params = [
                'resultSearch' => $resultSearch,
                'fullCp'	=> $fullCp,
                'InfosGroom' => $InfosGroom,
                'tabSkill' => $tabSkill,
                'ville' => $ville,
                'markers' => $markers,
                'searchCompetences' => $searchCompetences,
                'order' => $order,

            ];


        }
        else{

            
            

            $this->redirectToRoute('default_home');


        }

        $this->show('searchGroom/searchResult', $params);
    }




    public function groomDetails($id){



		
		$search = new ServicesInfosModel(); // on insère
		$GroomInfos = $search->groomById($id);	
        $erreurDoublon = false;
        $formContact = false;
        $errors = [];


        if (!empty($GroomInfos)){
            /* Ici j'ajoute au tableau contenant les résultats de la recherche les infos supplémentaires croisées avec les autres tables 
				*/
            for($i=0;$i<count($GroomInfos);$i++){ 

                foreach ($GroomInfos as $result) {


                    $noteComm = new CommentsModel();
                    $skillJoint = new ServicesInfosModel();
                    $searchVille = new VilleModel(); 


                    $GroomInfos[$i]['comments'] = $noteComm->ShowComm($GroomInfos[$i]['id_groom']);
                    $GroomInfos[$i]['NoteMoyenne'] = $noteComm->NoteMoyGroom($GroomInfos[$i]['id_groom']);

                    $GroomInfos[$i]['comp'] = $skillJoint->findSkillsWithId($GroomInfos[$i]['id_groom']); //Va chercher les compétences du groom a partir des valeurs 1,2,3..           
                    $GroomInfos[$i]['prix'] = $pricesTab = explode(',',$GroomInfos[$i]['price']);  //Va chercher les tarifs
                    $GroomInfos[$i]['villeAction'] = $searchVille->findVille($GroomInfos[$i]['postcode']); // transforme le CP en nom de commune

                }
            }
        }

        $me = $this->getUser();
        $findRentals = new RentalsModel();
        $locations = $findRentals->findRentalsWithId($me['id']);

        if(!empty($_POST)){

        	
            // Permet de nettoyer les données
            foreach($_POST as $key => $value){
                $post[$key] = trim(strip_tags($value));
            }
        	
            
            $me = $this->getUser();
            $contact = new ContactRequestsModel();
            $doublon = $contact->requestDoublon($id, $me['id']);

                if(count($doublon) != 0){ //Si une requête est déja en cours on affiche une erreur.

                    $erreurDoublon = true;
                }


                elseif(!empty($post['RentTitle'])){ // Sinon on crée la requête

                   
                	$formContact = true;
                    $BoolReqCoord = [

                    'id_groom'      => $id,
                    'date'          =>  date('d.m.y'),
                    'id_owner'      => $me['id'],
                    'rent_id'       => $post['RentTitle'],
                    'message'       => $post['message'],

                    

                    
                    

                    ];

                    $CoordRequest = new ContactRequestsModel();
                    $CoordRequest->insert($BoolReqCoord);

                }
                else {
                    $errors[] = 'Veuillez sélectioner une location';
                }


        }

		$params=[
    		'GroomInfos'    => $GroomInfos,    		
    		'erreurDoublon' => $erreurDoublon,
    		'locations'		=> $locations,
    		'formContact'	=> $formContact,
            'errors'        => $errors,
    		



        ];

        $this->show('searchGroom/groomDetails', $params);

    }










}
