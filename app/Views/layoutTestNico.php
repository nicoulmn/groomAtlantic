<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= $this->e($title) ?></title>
    <meta name="description" content="Groom Atlantic, première plateforme de mise en relation entre propriétaire de biens saisonners et de concierges" />
	<meta name="keywords" content="location, saisonniere, concierge, femme de menage, contact" />
    <link rel="apple-touch-icon" sizes="57x57" href="<?= $this->assetUrl('img/favicons/apple-touch-icon-57x57.png') ?>">
    <link rel="apple-touch-icon" sizes="60x60" href="<?= $this->assetUrl('img/favicons/apple-touch-icon-60x60.png') ?>">
    <link rel="icon" sizes="32x32" type="image/png" href="<?= $this->assetUrl('img/favicons/favicon-32x32.png') ?>">
    <link rel="icon" sizes="16x16" type="image/png" href="<?= $this->assetUrl('img/favicons/favicon-16x16.png') ?>">
    <link rel="manifest" href="<?= $this->assetUrl('img/favicons/manifest.json') ?>">
    <link rel="shortcut icon" href="<?= $this->assetUrl('img/favicons/favicon.ico') ?>">
    <meta name="msapplication-TileColor" content="#00a8ff">
	<meta name="msapplication-config" content="<?= $this->assetUrl('img/favicons/browserconfig.xml') ?>">
	<meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" type="text/css" href="<?= $this->assetUrl('css/normalize.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= $this->assetUrl('css/bootstrap.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= $this->assetUrl('css/owl.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= $this->assetUrl('css/animate.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= $this->assetUrl('fonts/font-awesome-4.1.0/css/font-awesome.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= $this->assetUrl('fonts/eleganticons/et-icons.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= $this->assetUrl('css/cardio.css') ?>">
    <?=$this->section('css'); ?>
</head>
<body>
    <div class="preloader">
		<img src="<?= $this->assetUrl('img/loader.gif') ?>" alt="Preloader image">
	</div>
	<nav class="navbar">
		<div class="container-fluid">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="<?= $this->url('default_home') ?>"><img src="<?= $this->assetUrl('img/logoDef.png') ?>" data-active-url="<?= $this->assetUrl('img/logoDef.png') ?>" alt="Logo de l'entreprise"></a>
			</div>
			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav navbar-right main-nav">
					<li><a href="<?= $this->url('default_home') ?>" style="color:#f06467;">Accueil</a></li>
					<li><a href="<?= $this->url('default_home') ?>"  style="color:#f06467;">Nos Grooms</a></li>
					<li><a href="<?= $this->url('default_home') ?>"  style="color:#f06467;">Vos Avantages</a></li>
					<?php if(!empty($w_user)){ ?> <!-- Si un utilisateur est connecté-->
                    	
                            <?php if($w_user['role'] == 'owner'){ ?> <!-- Si c'est un proprio on affiche "mon profil" qui pointe le profil proprio-->
                                <li><a href="<?= $this->url('users_showowner') ?>"  style="color:#f06467;">Mon profil</a></li>
                            <?php } ?> 
                            <?php if($w_user['role'] == 'groom'){ ?> <!-- Si c'est un groom on affiche "mon profil" qui pointe le profil groom-->
                                <li><a href="<?= $this->url('users_showgroom') ?>"  style="color:#f06467;">Mon profil</a></li>
                            <?php } ?>
                            <?php if($w_user['role'] == 'admin'){ ?> 
                                <li><a href="<?= $this->url('users_backAdmin') ?>"  style="color:#f06467;">Espace administrateur</a></li>
                            <?php } ?>
                            <!-- Dans tous les cas si un utilisateur est connecté, on affiche la déco -->
                            <li><a href="<?= $this->url('default_home') ?>?deco=1" class="btn btn-blue">Déconnexion</a></li>
                        <?php } 
            
                        else{ ?> <!-- Si on a pas d'utilisateur connecté, on affiche la connexion et l'inscription-->
                            <li><a href="<?= $this->url('users_pickRole') ?>"  style="color:#f06467;">Devenir Membre</a></li>
				            <li><a href="#" data-toggle="modal" data-target="#modal1" class="btn btn-blue">Connexion</a></li>
				        <?php } ?>
				</ul>
			</div>
			<!-- /.navbar-collapse -->
		</div>
		<!-- /.container-fluid -->
	</nav>
    <section>

	    <?=$this->section('errors'); ?>

    </section>
    <header id="intro">

	    <?=$this->section('header'); ?>

    </header>
	<section>
		<?php if(!empty($w_flash_message->message)): ?>
				<div class="alert alert-<?=$w_flash_message->level;?>">
					<?=$w_flash_message->message;?>
				</div>
			<?php endif; ?>
		<?= $this->section('main_content') ?>
    </section>
    <div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content modal-popup">
				<a href="#" class="close-link"><i class="icon_close_alt2"></i></a>
				<h3 class="white">Se Connecter</h3>
				<form id="LoginForm" method="post" class="popup-form" action="<?= $this->url('default_home') ?>">
					<input type="hidden" name="current_url" value="<?=$w_current_route;?>">
					<input name="email" type="text" class="form-control form-white" placeholder="Votre email">
					<input name="password" type="password" class="form-control form-white" placeholder="Votre mot de passe">
					<a href="<?= $this->url('users_pwdReset') ?>">Mot de passe oublié ?</a>
					
                    <!--
                    USELESS MAIS PEUT SERVIR PLUS TARD 
                    <div class="dropdown">
						<button id="dLabel" class="form-control form-white dropdown" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							Pricing Plan
						</button>
						<ul class="dropdown-menu animated fadeIn" role="menu" aria-labelledby="dLabel">
							<li class="animated lightSpeedIn"><a href="#">1 month membership ($150)</a></li>
							<li class="animated lightSpeedIn"><a href="#">3 month membership ($350)</a></li>
							<li class="animated lightSpeedIn"><a href="#">1 year membership ($1000)</a></li>
							<li class="animated lightSpeedIn"><a href="#">Free trial class</a></li>
						</ul>
					</div>
					<div class="checkbox-holder text-left">
						<div class="checkbox">
						<input type="checkbox" value="None" id="squaredOne" name="check" />
							<label for="squaredOne"><span>I Agree to the <strong>Terms &amp; Conditions</strong></span></label>
						</div>
					</div>
                        -->

					<button id="subscribe" type="submit" class="btn btn-submit">Valider</button>
				</form>
				<a  href="<?= $this->url('users_pickRole') ?>" class="blue">
                <button id="subscribe" class="btn btn-submit">
                	Pas encore inscrit ?
                </button>
                </a>
			</div>
		</div>
	</div><!--FIN DE LA FENETRE MODALE -->
	<footer>
		<div class="container">
			<div class="row">
				<div class="col-sm-3 text-center-mobile">
					<h3 class="white">GROOM ATLANTIC</h3>
					<p class="white">Groom Atlantic est la première plateforme de mise en relation entre propriétaires et concierges disponibles pour vous aider à gérer vos locations courte durée partout en Charente Maritime</p>
				</div>
				<div class="col-sm-3 text-center-mobile">
					<h5><a href="<?= $this->url('infos_quisommesnous') ?>">QUI SOMMES NOUS</a></h5><br>
					<h5><a href="<?= $this->url('infos_infospratiques') ?>">INFOS PRATIQUES</a></h5><br>
					<h5><a target="_blank" href="<?= $this->assetUrl('charte-qualite.pdf') ?>">CHARTE DE QUALITE</a></h5><br>
					<h5><a href="<?= $this->url('infos_mentionslegales') ?>">MENTIONS LEGALES </a></h5><br>
				</div>
				<div class="col-sm-3 text-center-mobile">
				<h5 class="white">NOUS SUIVRE</h5>
						<a href="http://www.facebook.com/pages/Codrops/159107397912"><i class="fa fa-facebook"></i></a><br>
						<a href="http://www.twitter.com/codrops"><i class="fa fa-twitter"></i></a><br>
						<a href="https://plus.google.com/101095823814290637419"><i class="fa fa-google-plus"></i></a><br>
				</div>
				<div class="col-md-2 text-center-mobile">
					<h5 class="white">NOUS CONTACTER</h5>
					<p class="white">Tél: 06.06.06.88.59</p>
					<p class="white">
						<a href="mailto:&#99;%6f%6eta%63t&#64;&#97;t%6can&#116;%69%63gro%6f&#109;%2e&#99;%6fm"><button class="btn btn-default" id="send_btn">Nous envoyer un E-mail</button></a>
					</p>
				</div>
				<div class="col-sm-1 text-center-mobile">
					<div id="bt-retour-haut">
						<a class="page-scroll" href="#">
							<i class="fa fa-arrow-up"></i>
						</a>
					</div>
				</div>
			</div>
		</div>       
	</footer>

	<!-- Holder for mobile navigation -->

	<div class="mobile-nav">
		<ul>
		</ul>
		<a href="#" class="close-link"><i class="arrow_up"></i></a>
	</div>

	<!-- Scripts -->

	<script src="<?= $this->assetUrl('js/jquery-1.11.1.min.js') ?>"></script>
	<script src="<?= $this->assetUrl('js/owl.carousel.min.js') ?>"></script>
	<script src="<?= $this->assetUrl('js/bootstrap.min.js') ?>"></script>
	<script src="<?= $this->assetUrl('js/wow.min.js') ?>"></script>
	<script src="<?= $this->assetUrl('js/typewriter.js') ?>"></script>
	<script src="<?= $this->assetUrl('js/jquery.onepagenav.js') ?>"></script>
	<script src="<?= $this->assetUrl('js/main.js') ?>"></script>

	<script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
	<?=$this->section('js');?>
  
</body>
</html>
