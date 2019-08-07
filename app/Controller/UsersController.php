<?php

namespace Controller;

use \W\Controller\Controller;
use \Model\UsersModel;
use \W\Security\AuthentificationModel;
use \Model\ResetPasswordModel;
use \Model\CommentsModel;
use \Controller\CommentsController;
use \Controller\ContactRequestsController;
use \Controller\RentalsController;
use Intervention\Image\ImageManagerStatic as Image;
use \Respect\Validation\Validator as v;

class UsersController extends Controller
{

    /**
     * Page d'accueil
     */
    public function home(){
        $post = [];
        $errors = [];
        $formValid = false;
        $deco = false;
        $Userlog = [];

        $usersModel = new UsersModel();
        $ExmplGroom = $usersModel->getExGroom();


        if(!empty($_POST)){
            // Permet de nettoyer les données
            foreach($_POST as $key => $value){
                $post[$key] = trim(strip_tags($value));
            }

            if(!v::notEmpty()->email()->validate($post['email'])){
                $errors[] = 'Cet email n\'est pas valide.';
            }

            if(!v::notEmpty()->stringType()->length(2, 150)->validate($post['password'])){
                $errors[] = 'Le mot de passe doit comporter au moins 2 caractères';
            }

            if(count($errors) === 0){

                $authModel = new \W\Security\AuthentificationModel;
                $connectMatch = $authModel->isValidLoginInfo($post['email'], $post['password']);

                if($connectMatch != 0){

                    $usersModel = new UsersModel();
                    $infoUser = $usersModel->find($connectMatch);                 

                    $authModel->logUserIn($infoUser);

                    if(!empty($authModel->getLoggedUser())){
                        // Ici la session est complétée avec les infos du membre (hors mdp)
                        $formValid = true;
                        if($formValid = true){
                            $this->redirectToRoute('default_home');
                        }
                    }

                }
                else {
                    $this->redirectToRoute($post['current_url']);
                    $this->flash('Le couple identifiant / mot de passe est invalide', 'danger');
                }
            }  
            else {


            } 


        }
        if (isset($_GET['deco'])){
            if ($_GET['deco'] == "1"){

                $authModel = new \W\Security\AuthentificationModel;
                $authModel->logUserOut();
                $deco = true;
                /*$this->redirectToRoute('default_home');*/
            }
        }
        $params = [
            'formValid' => $formValid,
            'errors'    => $errors,
            'mail'      => isset($post['email']),            
            'deco'      => $deco,
            'ExmplGroom' => $ExmplGroom,
        ];
        $this->show('default/home', $params);
    }

    /**
     * Connexion
     */
    public function login(){

        $post = [];
        $errors = [];
        $formValid = false;
        $deco = false;
        $Userlog = [];

        if(!empty($_POST)){
            // Permet de nettoyer les données
            foreach($_POST as $key => $value){
                $post[$key] = trim(strip_tags($value));
            }

            if(!v::notEmpty()->email()->validate($post['email'])){
                $errors[] = 'Cet email n\'est pas valide.';
            }

            if(!v::notEmpty()->stringType()->length(2, 150)->validate($post['password'])){
                $errors[] = 'Le mot de passe doit comporter au moins 2 caractères';
            }

            if(count($errors) === 0){

                $authModel = new \W\Security\AuthentificationModel;
                $connectMatch = $authModel->isValidLoginInfo($post['email'], $post['password']);

                if($connectMatch != 0){

                    $usersModel = new UsersModel();
                    $infoUser = $usersModel->find($connectMatch);                 

                    $authModel->logUserIn($infoUser);

                    if(!empty($authModel->getLoggedUser())){
                        // Ici la session est complétée avec les infos du membre (hors mdp)
                        $this->flash('Vous êtes desormais connecté', 'success');
                        $this->redirectToRoute('default_home');
                    } 
                }
                else {
                    $this->flash('Le couple identifiant / mot de passe est invalide', 'danger');
                }
            }
        }
        if (isset($_GET['deco'])){
            if ($_GET['deco'] == "1"){
                $authModel = new \W\Security\AuthentificationModel;
                $authModel->logUserOut();
                $deco=true;
            }
        }

        $params = [
            'formValid' => $formValid,
            'errors'    => $errors,
            'mail'      => isset($post['email']),
            'deco'      => $deco,
        ];
        $this->show('users/login', $params);

    }

    /* ESPACE CONCIERGE */
    /**
     * Ajout d'un concierge
     */
    public function addGroom(){
        $post = [];
        $errors = [];
        $formValid = false;

        if(!empty($_POST)){
            // Permet de nettoyer les données
            foreach($_POST as $key => $value){
                $post[$key] = trim(strip_tags($value));
            }

            // vérification si l'email existe déjà en BDD
            $usersModel = new UsersModel();
            $mailExist = $usersModel->emailExists($post['email']);
            if($mailExist == true){
                $errors[] = 'Cet email existe déjà.';
            }

            // on vérifie les champs insérés
            if( $post['password'] != $post['password2']){
                $errors[] = 'Le mot de passe et sa confirmation ne correspondent pas.';
            }

            if(!v::notEmpty()->stringType()->alpha('àâäçéèêîïôûùæœÀÄÂÇÉÈÊÎÏÔÛÙÆŒ-')->length(3, 50)->validate($post['firstname'])){
                $errors[] = 'Le prénom doit comporter au moins 3 lettres.';
            }

            if(!v::notEmpty()->stringType()->alpha('àâäçéèêîïôûùæœÀÄÂÇÉÈÊÎÏÔÛÙÆŒ-')->length(3, 50)->validate($post['lastname'])){
                $errors[] = 'Le nom doit comporter au moins 3 lettres.';
            }

            if(!v::phone()->length(10)->validate($post['phone'])){
                $errors[] = 'Le numéro de téléphone doit être composé de 10 chiffres.';
            }

            if(!v::notEmpty()->email()->validate($post['email'])){
                $errors[] = 'Cet email n\'est pas valide.';
            }

            if(!v::notEmpty()->stringType()->length(5, 100)->validate($post['address'])){
                $errors[] = 'L\'adresse doit comporter au moins 5 caractères.';
            }

            if(!v::notEmpty()->intVal()->length(5)->validate($post['postcode'])){
                $errors[] = 'Le code postal doit comporter 5 chiffres.';
            }

            if(!v::notEmpty()->stringType()->length(2, 50)->validate($post['cityUser'])){
                $errors[] = 'La ville doit comporter au moins 2 caractères.';
            }

            // on comptabiliser les erreurs
            if(count($errors) === 0){
                $authModel = new \W\Security\AuthentificationModel;

                $localisation = new UsersModel;
                $full_address = $post['address'].', '.$post['postcode'].' '.$post['cityUser'];
                $local = $localisation->getXmlCoordsFromAdress($full_address);

                // on crée le tableau de données à insérer
                $data = [
                    'firstname'     => ucfirst($post['firstname']), 
                    'lastname'      => ucfirst($post['lastname']),
                    'email'         => strtolower($post['email']),
                    'phone'         => $post['phone'],
                    'role'          => 'groom',                      
                    'password'      => $authModel->hashPassword($post['password']),
                    'address'       => $post['address'],
                    'postcode'      => $post['postcode'],
                    'cityUser'      => ucfirst($post['cityUser']),
                    'date_creation' => date('Y.m.d'),
                    'lng'           => $local['lon'],
                    'lat'           => $local['lat'],
                ];

                // on insère dans la BDD
                $usersModel = new UsersModel();
                $insert = $usersModel->insert($data);
                //retourne false si une erreur survient ou les nouvelles donnes inseres sous forme de array

                if(!empty($insert)){
                    $formValid = true;


                }
            }
        }
        $params = [
            'formValid' => $formValid,
            'errors'    => $errors,
            'post'      => $post,
        ];
        $this->show('users/addGroom', $params);
    }


    /**
     * Voir les éléments du profil groom
     */
    public function showGroom()
    {
        // limite par défaut à l'utilisateur ayant pour role "groom"
        if(!$this->allowTo(['groom'],['admin'])){
            $this->redirectToRoute('default_home');
        }

        $user_connect = $this->getUser(); // Récupère l'utilisateur connecté, correspond à $w_user dans la vue        

        $usersModel = new UsersModel();
        $showInfos = $usersModel->find($user_connect['id']);

        $groomController = new GroomController();
        $addSkills = $groomController->addServices();

        $voirSer = new GroomController();
        $services = $voirSer->showServices($user_connect['id']);

        $voirPx = new GroomController();
        $prices = $voirPx->showPrices($user_connect['id']);

        $commentsController = new CommentsController();
        $comments = $commentsController->commentList();

        $commentsAut = new CommentsController();
        $commentsA = $commentsAut->commentsAuthor();

        $rentalsPpt = new RentalsController();
        $propositions = $rentalsPpt->showRentals($user_connect['id']);

        $contactRequestsModel = new \Model\ContactRequestsModel();
        $total_notif = 0;
        $notifications1 = $contactRequestsModel->showRequestForGroomId($user_connect['id'], 'tec');
        $total_notif += $contactRequestsModel->totalNotifications;
        $notifications2 = $contactRequestsModel->showRequestForGroomId($user_connect['id'], 'tuc');
        $total_notif += $contactRequestsModel->totalNotifications;


        $params = [
            'showInfos'     => $showInfos,
            'services'      => $services,
            'prices'        => $prices,
            'addSkills'     => $addSkills,
            'comments'      => $comments,
            'commentsA'     => $commentsA,
            'notifications1' => $notifications1,
            'notifications2' => $notifications2,
            'total_notif'   => $total_notif,
        ];

        $this->show('users/groomProfile/showGroom', $params);
    }


    /**
     * Modifier le profil groom
     */
    public function changeProfile()
    {
        $post = [];
        $errors = [];
        $formValid = false;

        $user_connect = $this->getUser();

        if(!empty($_POST)){
            // Permet de nettoyer les données
            foreach($_POST as $key => $value){
                $post[$key] = trim(strip_tags($value));
            }

            // on vérifie les champs insérés
            if(!v::notEmpty()->stringType()->alpha('àâäçéèêîïôûùæœÀÄÂÇÉÈÊÎÏÔÛÙÆŒ-')->length(3, 50)->validate($post['firstname'])){
                $errors[] = 'Le prénom doit comporter au moins 3 lettres.';
            }

            if(!v::notEmpty()->stringType()->alpha('àâäçéèêîïôûùæœÀÄÂÇÉÈÊÎÏÔÛÙÆŒ-')->length(3, 50)->validate($post['lastname'])){
                $errors[] = 'Le nom doit comporter au moins 3 lettres.';
            }

            if(!v::notEmpty()->phone()->length(10)->validate($post['phone'])){
                $errors[] = 'Le numéro de téléphone doit être composé de 10 chiffres.';
            }

            if(!v::notEmpty()->email()->validate($post['email'])){
                $errors[] = 'Cet email n\'est pas valide.';
            }

            if(!v::notEmpty()->stringType()->length(5, 100)->validate($post['address'])){
                $errors[] = 'L\'adresse doit comporter au moins 5 caractères.';
            }

            if(!v::notEmpty()->intVal()->length(5)->validate($post['postcode'])){
                $errors[] = 'Le code postal doit comporter 5 chiffres.';
            }

            if(!v::notEmpty()->stringType()->length(2, 50)->validate($post['cityUser'])){
                $errors[] = 'La ville doit comporter au moins 2 caractères.';
            }


            if(!empty($_FILES)){

                if(!v::image()->validate($_FILES['photo']['tmp_name'])){
                    $errors[] = 'La photo de profil n\'est pas au bon format.';
                }

                if(!v::size(null, '2MB')->validate($_FILES['photo']['tmp_name'])){
                    $errors[] = 'La taille de la photo de profil ne doit pas dépasser 2 Mo.';
                }
            }


            if(count($errors) === 0){


                // AJOUT PHOTO DE PROFIL
                $maxfilesize = 1048576; 
                if($_FILES['photo']['error'] === 0 AND $_FILES['photo']['size'] < $maxfilesize){

                    // création de la variable $fileinfo qui récupère les infos du fichier uploadé
                    $fileInfo = pathinfo($_FILES['photo']['name']);

                    // création de la variable extension qui récupère l'extension du fichier uploadé
                    $extension = $fileInfo['extension'];

                    // création de la miniature
                    if($extension == 'jpg' OR $extension == 'jpeg'){
                        $newImage = imagecreatefromjpeg($_FILES['photo']['tmp_name']);	
                    }
                    elseif($extension == 'png'){
                        $newImage = imagecreatefrompng($_FILES['photo']['tmp_name']);
                    }
                    else{
                        $newImage = imagecreatefromgif($_FILES['photo']['tmp_name']);
                    }

                    //Calcul des nouvelles dimensions
                    $imageWidth = imagesx($newImage);
                    $imageHeight = imagesy($newImage);
                    $newWidth = 200;
                    $newHeight = ($imageHeight * $newWidth) / $imageWidth;

                    // On crée la nouvelle image
                    $miniature = imagecreatetruecolor($newWidth, $newHeight);

                    imagecopyresampled($miniature, $newImage, 0, 0, 0, 0, $newWidth, $newHeight, $imageWidth, $imageHeight);

                    // création d'un nom unique
                    $nom = md5(uniqid(rand(), true));

                    if($extension == 'jpg' OR $extension == 'jpeg'){
                        imagejpeg($miniature, 'assets/img/profilePict/' . $nom . '.' . $extension);
                    }
                    elseif($extension == 'png'){
                        imagepng($miniature, 'assets/img/profilePict/' . $nom . '.' . $extension);
                    }
                    else{
                        imagegif($miniature, 'assets/img/profilePict/' . $nom . '.' . $extension);
                    }

                    // création du nom du fichier une fois uploadé (à rentrer dans la BDD)
                    $fileName = $nom.'.'.$extension;

                    $data = [
                        'firstname'  => ucfirst($post['firstname']), 
                        'lastname'   => ucfirst($post['lastname']),
                        'email'      => strtolower($post['email']),
                        'address'    => $post['address'],
                        'postcode'   => $post['postcode'],
                        'cityUser'   => ucfirst($post['cityUser']),
                        'phone'      => $post['phone'],
                        // on insère le nom de la photo dans la BDD pour pouvoir la récupérer ultérieurement
                        'photo'      => $fileName,
                        'size'       => $_FILES['photo']['size'],
                    ];

                    $usersModel = new UsersModel();
                    $update = $usersModel->update($data, $user_connect['id']);

                    if(!empty($update)){
                        $formValid = true;

                        $this->flash('Vos informations ont été modifiées', 'success');
                        $this->redirectToRoute('users_showgroom');
                    }
                }
            }
        }

        $params = [
            'formValid' => $formValid,
            'errors'    => $errors,
        ];

        $this->show('/users/groomProfile/changeProfile', $params);
    }

    /**
     * Suppression du compte groom
     */
    public function deleteProfile($id){

        $user_connect = $this->getUser(); // Récupère l'utilisateur connecté, correspond à $w_user dans la vue

        // on limite l'accès à la page à un utilisateur non connecté
        if(empty($user_connect)){
            $this->showNotFound(); // affichera une page 404
        }

        $usersModel = new UsersModel();
        $deleteUser = $usersModel->delete($user_connect['id']);
        if(!empty($deleteUser)){
            $authentificationModel = new AuthentificationModel();
            $logoutUser = $authentificationModel->logUserOut();
        }

        $this->redirectToRoute('default_home');

    }



    /* ESPACE PROPRIETAIRE */
    /**
     * Ajouter propriétaire
     */
    public function addOwner(){


        $post = [];
        $errors = [];
        $formValid = false;


        if(!empty($_POST)){
            // Permet de nettoyer les données
            foreach($_POST as $key => $value){
                $post[$key] = trim(strip_tags($value));
            }

            // vérification si l'email existe déjà en BDD
            $usersModel = new UsersModel();
            $mailExist = $usersModel->emailExists($post['email']);
            if($mailExist == true){
                $errors[] = 'Cet email existe déjà.';
            }

            // on vérifie les champs insérés
            if( $post['password'] != $post['password2']){
                $errors[] = 'Le mot de passe et sa confirmation ne correspondent pas.';
            }

            if(!v::notEmpty()->stringType()->alpha('àâäçéèêîïôûùæœÀÄÂÇÉÈÊÎÏÔÛÙÆŒ-')->length(3, 50)->validate($post['firstname'])){
                $errors[] = 'Le prénom doit comporter au moins 3 lettres.';
            }

            if(!v::notEmpty()->stringType()->alpha('àâäçéèêîïôûùæœÀÄÂÇÉÈÊÎÏÔÛÙÆŒ-')->length(3, 50)->validate($post['lastname'])){
                $errors[] = 'Le nom doit comporter au moins 3 lettres.';
            }

            if(!v::phone()->length(10)->validate($post['phone'])){
                $errors[] = 'Le numéro de téléphone doit être composé de 10 chiffres.';
            }

            if(!v::notEmpty()->email()->validate($post['email'])){
                $errors[] = 'Cet email n\'est pas valide.';
            }

            if(!v::notEmpty()->stringType()->length(5, 100)->validate($post['address'])){
                $errors[] = 'L\'adresse doit comporter au moins 5 caractères.';
            }

            if(!v::notEmpty()->intVal()->length(5)->validate($post['postcode'])){
                $errors[] = 'Le code postal doit comporter 5 chiffres.';
            }

            if(!v::notEmpty()->stringType()->alpha()->length(2, 50)->validate($post['cityUser'])){
                $errors[] = 'La ville doit comporter au moins 2 caractères.';
            }


            // on compatabilise les erreurs
            if(count($errors) === 0){
                $authModel = new \W\Security\AuthentificationModel;

                $localisation = new UsersModel;
                $local = $localisation->getXmlCoordsFromAdress($post['address']);

                // on crée le tableau de données à insérer
                $data = [
                    'firstname'     => ucfirst($post['firstname']), 
                    'lastname'      => strtoupper($post['lastname']),
                    'email'         => strtolower($post['email']),
                    'phone'         => $post['phone'],
                    'role'          => 'owner',                      
                    'password'      => $authModel->hashPassword($post['password']),
                    'address'       => strtolower($post['address']),
                    'postcode'      => $post['postcode'],
                    'cityUser'      => strtoupper($post['cityUser']),
                    'date_creation' => date('Y.m.d'),
                    'lng'           => $local['lon'],
                    'lat'           => $local['lat'],
                ];

                // on insère dans la BDD
                $usersModel = new UsersModel();
                $insert = $usersModel->insert($data);
                //retourne false si une erreur survient ou les nouvelles données inseres sous forme de array

                if(!empty($insert)){
                    $formValid = true;

                    $this->flash('Vous êtes desormais inscrit', 'success');
                    $this->redirectToRoute('default_home');
                }
            }
        }
        $params = [
            'formValid' => $formValid,
            'errors'    => $errors,
            'post'      => $post,
        ];
        $this->show('users/addOwner', $params);
    }



    /**
     * Voir les éléments du profil proprietaire
     */
    public function showOwner()
    {
        // limite par défaut à l'utilisateur ayant pour role "owner"
        if(!$this->allowTo(['owner'],['admin'])){
            $this->redirectToRoute('default_home');
        }

        $user_connect = $this->getUser(); // Récupère l'utilisateur connecté, correspond à $w_user dans la vue

        $usersModel = new UsersModel();
        $showInfos = $usersModel->find($user_connect['id']);

        $ajouterLoc = new RentalsController();
        $addRental = $ajouterLoc->addRental();

        $voirLoc = new RentalsController();
        $locations = $voirLoc->showRentals($user_connect['id']); 


        $commentsC = new CommentsModel;
        $comments = $commentsC->showCommentsById($user_connect['id']);


        $commentsAddr = new CommentsModel;
        $commentsAd = $commentsAddr->commentsAddresseeName($user_connect['id']);

        $contactRequestsModel = new \Model\ContactRequestsModel;
        $total_notif = 0;
        $notifications1 = $contactRequestsModel->showRequestForOwnerId($user_connect['id'], 'tic');
        $total_notif += $contactRequestsModel->totalNotifications;
        $notifications2 = $contactRequestsModel->showRequestForOwnerId($user_connect['id'], 'tac');
        $total_notif += $contactRequestsModel->totalNotifications;

        $params = [
            'showInfos'     => $showInfos,
            'addRental'     => $addRental,
            'locations'     => $locations,
            'comments'      => $comments,
            'commentsAd'    => $commentsAd,
            'notifications1' => $notifications1,
            'notifications2' => $notifications2,
            'total_notif'   => $total_notif,
        ];  

        $this->show('users/ownerProfile/showOwner', $params);
    }


    /**
     * Modifier le profil propriétaire
     */
    public function changeProfileO()
    {
        $post = [];
        $errors = [];
        $formValid = false;

        $user_connect = $this->getUser();

        if(!empty($_POST)){
            // Permet de nettoyer les données
            foreach($_POST as $key => $value){
                $post[$key] = trim(strip_tags($value));
            }

            // on vérifie les champs insérés
            if(!v::notEmpty()->stringType()->alpha('àâäçéèêîïôûùæœÀÄÂÇÉÈÊÎÏÔÛÙÆŒ-')->length(3, 50)->validate($post['firstname'])){
                $errors[] = 'Le prénom doit comporter au moins 3 lettres.';
            }

            if(!v::notEmpty()->stringType()->alpha('àâäçéèêîïôûùæœÀÄÂÇÉÈÊÎÏÔÛÙÆŒ-')->length(3, 50)->validate($post['lastname'])){
                $errors[] = 'Le nom doit comporter au moins 3 lettres.';
            }

            if(!v::phone()->length(10)->validate($post['phone'])){
                $errors[] = 'Le numéro de téléphone doit être composé de 10 chiffres.';
            }

            if(!v::notEmpty()->email()->validate($post['email'])){
                $errors[] = 'Cet email n\'est pas valide.';
            }

            if(!v::notEmpty()->stringType()->length(5, 100)->validate($post['address'])){
                $errors[] = 'L\'adresse doit comporter au moins 5 caractères.';
            }

            if(!v::notEmpty()->intVal()->length(5)->validate($post['postcode'])){
                $errors[] = 'Le code postal doit comporter 5 chiffres.';
            }

            if(!v::notEmpty()->stringType()->alpha()->length(2, 50)->validate($post['cityUser'])){
                $errors[] = 'La ville doit comporter au moins 2 caractères.';
            }


            if(!empty($_FILES)){

                if(!v::image()->validate($_FILES['photo']['tmp_name'])){
                    $errors[] = 'La photo de profil n\'est pas au bon format.';
                }

                if(!v::size(null, '2MB')->validate($_FILES['photo']['tmp_name'])){
                    $errors[] = 'La taille de la photo de profil ne doit pas dépasser 2 Mo.';
                }
            }


            if(count($errors) === 0){


                // AJOUT PHOTO DE PROFIL
                $maxfilesize = 1048576; 
                if($_FILES['photo']['error'] === 0 AND $_FILES['photo']['size'] < $maxfilesize){

                    // création de la variable $fileinfo qui récupère les infos du fichier uploadé
                    $fileInfo = pathinfo($_FILES['photo']['name']);

                    // création de la variable extension qui récupère l'extension du fichier uploadé
                    $extension = $fileInfo['extension'];

                    // création de la miniature
                    if($extension == 'jpg' OR $extension == 'jpeg'){
                        $newImage = imagecreatefromjpeg($_FILES['photo']['tmp_name']);	
                    }
                    elseif($extension == 'png'){
                        $newImage = imagecreatefrompng($_FILES['photo']['tmp_name']);
                    }
                    else{
                        $newImage = imagecreatefromgif($_FILES['photo']['tmp_name']);
                    }

                    //Calcul des nouvelles dimensions
                    $imageWidth = imagesx($newImage);
                    $imageHeight = imagesy($newImage);
                    $newWidth = 200;
                    $newHeight = ($imageHeight * $newWidth) / $imageWidth;

                    // On crée la nouvelle image
                    $miniature = imagecreatetruecolor($newWidth, $newHeight);

                    imagecopyresampled($miniature, $newImage, 0, 0, 0, 0, $newWidth, $newHeight, $imageWidth, $imageHeight);

                    // création d'un nom unique
                    $nom = md5(uniqid(rand(), true));

                    if($extension == 'jpg' OR $extension == 'jpeg'){
                        imagejpeg($miniature, 'assets/img/profilePict/' . $nom . '.' . $extension);
                    }
                    elseif($extension == 'png'){
                        imagepng($miniature, 'assets/img/profilePict/' . $nom . '.' . $extension);
                    }
                    else{
                        imagegif($miniature, 'assets/img/profilePict/' . $nom . '.' . $extension);
                    }

                    // création du nom du fichier une fois uploadé (à rentrer dans la BDD)
                    $fileName = $nom.'.'.$extension;

                    $data = [
                        'firstname'  => ucfirst($post['firstname']), 
                        'lastname'   => strtoupper($post['lastname']),
                        'email'      => strtolower($post['email']),
                        'address'    => strtolower($post['address']),
                        'postcode'   => $post['postcode'],
                        'cityUser'   => strtoupper($post['cityUser']),
                        'phone'      => $post['phone'],
                        // on insère le nom de la photo dans la BDD pour pouvoir la récupérer ultérieurement
                        'photo'      => $fileName,
                        'size'       => $_FILES['photo']['size'],
                    ];
                    $usersModel = new UsersModel();
                    $update = $usersModel->update($data, $user_connect['id']);

                    if(!empty($update)){
                        $formValid = true;

                        $this->flash('Vos informations ont été modifiées', 'success');
                        $this->redirectToRoute('users_showowner');
                    }
                }
            }
        }

        $params = [
            'formValid' => $formValid,
            'errors'    => $errors,
        ];

        $this->show('users/ownerProfile/changeProfileO', $params);
    }


    /**
     * Suppression du compte propriétaire
     */
    public function deleteProfileO($id){

        $user_connect = $this->getUser(); // Récupère l'utilisateur connecté, correspond à $w_user dans la vue

        // on limite l'accès à la page à un utilisateur non connecté
        if(empty($user_connect)){
            $this->showNotFound(); // affichera une page 404
        }

        $usersModel = new UsersModel();
        $deleteUser = $usersModel->delete($user_connect['id']);
        if(!empty($deleteUser)){
            $authentificationModel = new AuthentificationModel();
            $logoutUser = $authentificationModel->logUserOut();
        }

        $this->redirectToRoute('default_home');

    }


    /**
     * Ajoute role
     */
    public function pickRole(){

        $this->show('users/pickRole');

    }

    /**
     * Reset mot de passe
     */
    public function pwdReset(){


        $post = [];
        $errors = [];
        $formValid = false;


        if(!empty($_POST)){
            // Permet de nettoyer les données
            foreach($_POST as $key => $value){
                $post[$key] = trim(strip_tags($value));
            }

            if(!v::notEmpty()->email()->validate($post['email'])){
                $errors[] = 'Cet email n\'est pas valide.';
            }


            if(count($errors) === 0){

                $usersModel = new UsersModel();                
                $emailExist = $usersModel->emailExists($post['email']);

                if($emailExist = true){ // Si l'email existe 

                    $token = md5(uniqid(rand(), true));// on génère un token

                    $usersModel = new UsersModel();  
                    $userInfo = $usersModel->getUserByUsernameOrEmail($post['email']);        // on va chercher l'id qui correspond au mail

                    $data = [

                        'token'     => $token,
                        'id_user'   => $userInfo['id'],

                    ];

                    $resetPwdModel = new ResetPasswordModel(); // on insère
                    $insert = $resetPwdModel->insert($data);

                    if(!empty($insert)){// si l'insertion s'est bien passé on envoie le mail


                        $mail = new \PHPMailer();

                        $mail->isSMTP();
                        $mail->Host = 'smtp.gmail.com';
                        $mail->SMTPAuth   = true;

                        $mail->Username   = getApp()->getConfig('smtp_email_ident');
                        $mail->Password   = getApp()->getConfig('smtp_email_pass');

                        $mail->SMTPSecure = 'ssl';
                        $mail->Port = 465;

                        $mail->SetFrom('reset.password@email.fr', 'GroomAtlantic');
                        $mail->addAddress($post['email']);
                        $mail->isHTML(true);


                        $mail->Subject = 'Sujet';
                        $mail->Body = '<a href="http://localhost/Back/groomatlantic/public/users/traitementReset?idUser=' . $userInfo['id'] . '&token=' . $token . '">Changer le mot de passe</a>';


                        if(!$mail->Send()){
                            $this->flash('Une erreer est survenue lors de l\'envoi de l\'email', 'danger');
                            //echo 'Erreur : ' . $mail->ErrorInfo; // uniquement pour les dev, l'utilisateur s'en cague :-)
                        }
                        else {
                            $formValid = true;
                        }                      
                    }

                }
            }   
            else {
                $this->flash('Email inconnu', 'danger');
            }
        }

        $params = [
            'formValid' => $formValid,
            'errors'    => $errors,
        ];

        $this->show('users/pwdReset', $params);

    }


    /**
     * Traitement reset password
     */
    public function traitementReset()
    {

        $post = [];
        $errors = [];
        $formValid = false;
        $showForm = false;

        if(isset($_GET['idUser']) AND isset($_GET['token']) AND !empty($_GET['idUser']) AND !empty($_GET['token']) AND ctype_digit($_GET['idUser'])){

            $resetPwdModel = new ResetPasswordModel();
            $matchToken = $resetPwdModel->findToken($_GET['idUser'], $_GET['token']);

            if(count($matchToken) == 1){ // si le token correspond on affiche le formulaire

                $showForm = true;

                if(!empty($_POST)){
                    // Permet de nettoyer les données
                    foreach($_POST as $key => $value){
                        $post[$key] = trim(strip_tags($value));
                    }
                    //Verifs form
                    if(strlen($post['password']) < 5){
                        $errors[] = 'Le mot de passe doit comporter au moins 5 caractères';
                    }
                    if($post['password'] != $post['password2']){
                        $errors[] = 'Le mot de passe et sa confirmation ne correspondent pas';
                    }

                    //si pas d'erreurs on insère
                    if(count($errors) === 0){ 
                        $authModel = new \W\Security\AuthentificationModel;

                        $data = [
                            'password' => $authModel->hashPassword($post['password']), 
                        ];

                        $usersModel = new UsersModel();
                        $update = $usersModel->update($data, (int) $_GET['idUser']);

                        if(!empty($update)){
                            $resetPwdModel = new ResetPasswordModel();
                            $DelToken = $resetPwdModel->deleteToken($_GET['idUser'], $_GET['token']);

                            $formValid = true;
                        }
                    }                            
                }
            }
        }

        $params = [
            'showForm'  => $showForm,
            'formValid' => $formValid,
            'errors'    => $errors,
        ];

        $this->show('users/traitementReset', $params);
    }


    /**
     * Infos ? :-)
     */
    public function infos() {

        $this->show('users/infos');
    }

    public function backAdmin() {
        
        if(!$this->allowTo(['admin'])){
            $this->redirectToRoute('default_home');
        }

        $usersAdminList = new UsersModel();
        
        
        if(isset($_POST['banned'])) { 
           
            $usersModel = new UsersModel();
            $newData = [
                'banned' => (int) $_POST['banned']
            ];
            $usersModel->update($newData, (int) $_POST['id']);
        }
        
        $usersList = $usersAdminList->findAll();

        
        $params = [
            'usersList' => $usersList,
        ];        
        $this->show('users/backAdmin', $params);
    }
}   