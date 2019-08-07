<?php

namespace Controller;

use \W\Controller\Controller;
use \Model\RentalsModel;
use \Respect\Validation\Validator as v;


class RentalsController extends Controller
{

	// fonction pour ajouter des locations au profil du propriétaire
	public function addRental(){

		if(!$this->allowTo(['owner'],['admin'])){
            $this->redirectToRoute('default_home');
        }

        // on récupère les données de l'utilisateur connecté
		$me = $this->getUser();

		// on crée les variables post et errors
		$post = [];
		$errors = [];


		// on nettoie le tableau POST
		if(!empty($_POST)){

			foreach ($_POST as $key => $value){

				if(is_array($value)){
					$post[$key] = array_map('trim', array_map('strip_tags', $value));
				}
				else {
					$post[$key] = trim(strip_tags($value));
				}
			}

			// on vérifie les champs insérés
			if(!v::notEmpty()->stringType()->length(5, 150)->validate($post['street'])){
				$errors[] = 'La voie doit comporter entre 5 et 150 caractères';
			}

			if(!v::notEmpty()->stringType()->length(5, 50)->validate($post['title'])){
				$errors[] = 'Le nom doit comporter entre 5 et 50 caractères';
			}

			if(!v::notEmpty()->intVal()->length(5)->validate($post['postcode'])){
				$errors[] = 'Le code postal doit contenir 5 chiffres';
			}

			if(!v::notEmpty()->stringType()->length(3, 30)->validate($post['city'])){
				$errors[] = 'La ville doit comporter entre 3 et 30 caractères';
			}

			if(!v::notEmpty()->intVal()->length(2, 4)->validate($post['area'])){
				$errors[] = 'Le surface du bien doit contenir entre 2 et 4 chiffres';
			}

			if(!v::notEmpty()->intVal()->length(1, 15)->validate($post['rooms'])){
				$errors[] = 'Le nombre de pièces doit être compris entre 1 et 15 pièces';
			}

			if(!empty($post['outdoor_fittings'])){

			}

			// si pas d'erreurs
			if(count($errors) === 0){
				
				if(!empty($post['outdoor_fittings'])){

					$data = [
						'title' 			=> strtoupper($post['title']),
						'type'				=> $post['type'],
						'street'   			=> strtolower($post['street']),
						'postcode'    		=> $post['postcode'],
						'city'    			=> strtoupper($post['city']),
						'area'    			=> $post['area'],
						'rooms'    			=> $post['rooms'],
						'outdoor_fittings'  => implode('|', $post['outdoor_fittings']),
						'id_owner'			=> $me['id'],
					];

					// on insère les données tappées par l'utilisateur dans la BDD
					$addRental = new RentalsModel();
					$insertRental = $addRental->insert($data);
					if(!empty($insert)){
						// Ajoute un message "flash" (stocké en session temporairement)
						// Note : il faut toutefois ajouter l'affichage de ce message au layout
						$this->flash('Votre location a été ajoutée', 'success');

						return $insertRental;
					}
				}
				else {

					$data = [
						'title' 			=> strtoupper($post['title']),
						'type'				=> $post['type'],
						'street'   			=> strtolower($post['street']),
						'postcode'    		=> $post['postcode'],
						'city'    			=> strtoupper($post['city']),
						'area'    			=> $post['area'],
						'rooms'    			=> $post['rooms'],
						'id_owner'			=> $me['id'],
					];

					// on insère les données tappées par l'utilisateur dans la BDD
					$addRental = new RentalsModel();
					$insertRental = $addRental->insert($data);
					if(!empty($insert)){
						// Ajoute un message "flash" (stocké en session temporairement)
						// Note : il faut toutefois ajouter l'affichage de ce message au layout
						$this->flash('Votre location a été ajoutée', 'success');

						return $insertRental;
					}
				}
			}

			else {
				$errorsText = implode('<br>', $errors);
				$this->flash($errorsText, 'danger');

			}
		}
	}


	public function showRentals($id_user){
		if(!is_numeric($id_user) || empty($id_user)){
			return false;
		}

		$rentalsModel = new RentalsModel();
		$listRentals = $rentalsModel->findRentalsWithId($id_user);

		return $listRentals;
	}


	public function changeRental($id){

		if(!$this->allowTo(['owner'],['admin'])){
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

		
		// on nettoie le tableau POST
		if(!empty($_POST)){

			foreach ($_POST as $key => $value){

				if(is_array($value)){
					$post[$key] = array_map('trim', array_map('strip_tags', $value));
				}
				else {
					$post[$key] = trim(strip_tags($value));
				}
			}

			// on vérifie les champs insérés
			if(!v::notEmpty()->stringType()->length(5, 150)->validate($post['street'])){
				$errors[] = 'La voie doit comporter entre 5 et 150 caractères';
			}

			if(!v::notEmpty()->stringType()->length(5, 50)->validate($post['title'])){
				$errors[] = 'Le nom doit comporter entre 5 et 50 caractères';
			}


			if(!v::notEmpty()->intVal()->length(5)->validate($post['postcode'])){
				$errors[] = 'Le code postal doit contenir 5 chiffres';
			}

			if(!v::notEmpty()->stringType()->length(3, 30)->validate($post['city'])){
				$errors[] = 'La ville doit comporter entre 3 et 30 caractères';
			}

			if(!v::notEmpty()->intVal()->length(1, 4)->validate($post['area'])){
				$errors[] = 'Le surface doit contenir entre 1 et 4 chiffres';
			}

			if(!v::notEmpty()->intVal()->length(1, 15)->validate($post['rooms'])){
				$errors[] = 'Le nombre de pièces doit être compris entre 1 et 15 pièces';
			}

			// si pas d'erreurs
			if(count($errors) === 0){
				
				if(!empty($post['outdoor_fittings'])){

					$data = [
						'title' 			=> strtoupper($post['title']),
						'type'				=> $post['type'],
						'street'   			=> strtolower($post['street']),
						'postcode'    		=> $post['postcode'],
						'city'    			=> strtoupper($post['city']),
						'area'    			=> $post['area'],
						'rooms'    			=> $post['rooms'],
						'outdoor_fittings'  => implode('|', $post['outdoor_fittings']),
						'id_owner'			=> $me['id'],
					];


					// on insère les données tappées par l'utilisateur dans la BDD
					$rentalsModel = new RentalsModel();
					$changeRental = $rentalsModel->update($data, $id);
					if(!empty($changeRental)){
						// Ajoute un message "flash" (stocké en session temporairement)
						// Note : il faut toutefois ajouter l'affichage de ce message au layout
						$this->flash('Votre location a été modifiée', 'success');
						$this->redirectToRoute('users_showowner');

					}
				}
				else {

					$data = [
						'title' 			=> strtoupper($post['title']),
						'type'				=> $post['type'],
						'street'   			=> strtolower($post['street']),
						'postcode'    		=> $post['postcode'],
						'city'    			=> strtoupper($post['city']),
						'area'    			=> $post['area'],
						'rooms'    			=> $post['rooms'],
						'outdoor_fittings'  => NULL,
						'id_owner'			=> $me['id'],
					];

					// on insère les données tappées par l'utilisateur dans la BDD
					$rentalsModel = new RentalsModel();
					$changeRental = $rentalsModel->update($data, $id);
					if(!empty($changeRental)){
						// Ajoute un message "flash" (stocké en session temporairement)
						// Note : il faut toutefois ajouter l'affichage de ce message au layout
						$this->flash('Votre location a été modifiée', 'success');
						$this->redirectToRoute('users_showowner');

					}

				}

			}

			else {
				$errorsText = implode('<br>', $errors);
				$this->flash($errorsText, 'danger');

			}
		} 
			// affiche les locations du proprio
		$voirLoc = new RentalsController();
        $locations = $voirLoc->showRentals($me['id']);
        	//affiche LA location qu'il veut update :
        $showUpdtLoc = new RentalsModel(); 
        $updtLoc = $showUpdtLoc->findUpdtRental($id);


		$params = [
        'locations' => $locations,
        'errors' => $errors,
        'updtLoc' => $updtLoc,
        ];    

		$this->show('users/ownerProfile/changeRental', $params);
	}


	public function deleteRental($id){

		// on récupère les données de l'utilisateur connecté
		$me = $this->getUser();

		// on limite l'accès à la page à un utilisateur non connecté
		if(empty($me)){
			$this->showNotFound(); // affichera une page 404
		}

		$rentalsModel = new RentalsModel();
		$deleteRental = $rentalsModel->delete($id);

		$this->redirectToRoute('users_showowner');

	}
}

	

