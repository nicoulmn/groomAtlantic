<?php

namespace Controller;

use \W\Controller\Controller;
use \W\Model\UsersModel;
use \Model\ServicesInfosModel;
use \Respect\Validation\Validator as v;

class GroomController extends \W\Controller\Controller
{
   
	/*
	* Ajout de services au profil du concierge
	*/
	public function addServices(){

		if(!$this->allowTo(['groom'],['admin'])){
            $this->redirectToRoute('default_home');
        }

        // on récupère les données de l'utilisateur connecté
		$me = $this->getUser();

		// on crée les variables post et errors
		$post = [];
		$errors = [];

		// on nettoie le tableau post
		if(!empty($_POST)){

			foreach ($_POST as $key => $value){

				if(is_array($value)){
					$post[$key] = array_map('trim', array_map('strip_tags', $value));
				}
				else {
					$post[$key] = trim(strip_tags($value));
				}
			}
			
			// on retire les valeurs d'input inférieures à 0
			$tab= array();
			foreach ($post['price'] as $price) {
				if($price){
					// $allPrices = implode(',', $price);
					$tab[]=$price;
				}
			}

			// on vérifie les champs insérés
			if(!empty($tab)){
				foreach ($tab as $price){
					if((!v::intVal()->length(1, 5)->validate($price)) && 
						(!v::floatVal()->length(1, 5)->validate($price)) && 
						$price > 0){
						
						$errors[] = 'Le prix peut être soit un entier soit contenir des décimales après un point.';
					}
				}
			}
			
			if(count($tab) != count($post['id_skill'])){
				$errors[] = 'Un/des couple(s) service/prix est/sont incomplet(s).';
			}

			if(!v::stringType()->length(20,300)->validate($post['description'])){
				$errors[] = 'La description doit comprendre entre 20 et 300 caractères.';
			}

			if(count($errors) === 0){

				$servicesInfosModel = new ServicesInfosModel();
				$doublon = $servicesInfosModel->infosDoublon($me['id']);

				if (!count($doublon)>0) {// Si on a pas de doublons
				
					if(!empty($post['id_skill']) && !empty($post['price'])){

						$data = [
							'id_skill'  => implode(',', $post['id_skill']),
							'price'  	=> implode(',', $tab),
							/*'work_area' => implode(',', $post['work_area']),*/
							'description' => $post['description'],
							'id_groom'	=> $me['id'],
						];

						// on insère les données tappées par l'utilisateur dans la BDD
						$servicesInfosModel = new ServicesInfosModel();
						$addsSkills = $servicesInfosModel->insert($data);
						if(!empty($addSkills)){
							// Ajoute un message "flash" (stocké en session temporairement)
							// Note : il faut toutefois ajouter l'affichage de ce message au layout
							$this->flash('Vos services ont été ajoutés.', 'success');

							return $addSkills;
						}
					}

				}
				else {

				}
			}
			else {
				$errorsText = implode('<br>', $errors);
				$this->flash($errorsText, 'danger');

			}
		}
	}

	/*
	* Affichage des services du concierge
	*/
	public function showServices($id_user){
		if(!is_numeric($id_user) || empty($id_user)){
			return false;
		}

		$servicesInfosModel = new ServicesInfosModel();
		$listServices = $servicesInfosModel->findSkillsWithId($id_user);

		return $listServices;
	}

	/*
	* Affichage des prix du concierge
	*/
	public function showPrices($id_user){
		if(!is_numeric($id_user) || empty($id_user)){
			return false;
		}

		$servicesInfosModel = new ServicesInfosModel();
		$listPrices = $servicesInfosModel->findPricesWithId($id_user);

		return $listPrices;
	}

	/*
	* Modifications des services du profil concierge
	*/
	public function changeServices($id){

		if(!$this->allowTo(['groom'],['admin'])){
            $this->redirectToRoute('default_home');
        }

        // on récupère les données de l'utilisateur connecté
		$me = $this->getUser();

		// on limite l'accès à la page à un utilisateur connecté
		if(empty($me)){
			$this->showNotFound(); // affichera une page 404
		}

		// on crée les variables post et errors
		$post = [];
		$errors = [];

		// on nettoie le tableau post
		if(!empty($_POST)){

			foreach ($_POST as $key => $value){

				if(is_array($value)){
					$post[$key] = array_map('trim', array_map('strip_tags', $value));
				}
				else {
					$post[$key] = trim(strip_tags($value));
				}
			}
			
			// on retire les valeurs d'input inférieures à 0
			$tab= array();
			foreach ($post['price'] as $price) {
				if($price){
					// $allPrices = implode(',', $price);
					$tab[]=$price;
				}
			}

			// on vérifie les champs insérés
			if(!empty($tab)){
				foreach ($tab as $price){
					if((!v::intVal()->length(1, 5)->validate($price)) && 
						(!v::floatVal()->length(1, 5)->validate($price)) && 
						$price > 0){
						
						$errors[] = 'Le prix peut être soit un entier soit contenir des décimales après un point.';
					}
				}
			}
			
			if(count($tab) != count($post['id_skill'])){
				$errors[] = 'Un/des couple(s) service/prix est/sont incomplet(s).';
			}

			if(!v::stringType()->length(20,300)->validate($post['description'])){
				$errors[] = 'La description doit comprendre entre 20 et 300 caractères.';
			}
			
			if(count($errors) === 0){
				
				if(!empty($post['id_skill']) && !empty($post['price'])){

					$data = [
						'id_skill'  => implode(',', $post['id_skill']),
						'price'  	=> implode(',', $tab),
						/*'work_area' => implode(',', $post['work_area']),*/
						'description' => $post['description'],
					];

					// on insère les données tappées par l'utilisateur dans la BDD
					$servicesInfosModel = new ServicesInfosModel();
					$changeSkills = $servicesInfosModel->update($data, $id);
					if(!empty($changeSkills)){
						// Ajoute un message "flash" (stocké en session temporairement)
						// Note : il faut toutefois ajouter l'affichage de ce message au layout

						$this->flash('Vos services ont été modifiés', 'success');
						$this->redirectToRoute('users_showgroom');
					}				
				}
				else {

				}
			}
			else {
				$errorsText = implode('<br>', $errors);
				$this->flash($errorsText, 'danger');

			}
		}

		$voirSer = new GroomController();
        $services = $voirSer->showServices($me['id']);

		$params = [
        'services' => $services,
        'errors' => $errors,
        ];  

		$this->show('users/groomProfile/changeServices', $params);
	}
}
