<?php $this->layout('layoutTestNico', [
	'title' => 'Page d\'accueil de Groom Atlantic ', 
	'title2' => 'Groom Atlantic', 
	'title3' => 'Ami manouche bienvenue',
]); ?>

<?php $this->start('css') ?>
    <style>
        
        .fullstar {
            font-size: 2em; 
            color: #ffd700;
        }

        #imgAvatar{
    
        width: 100px;
        height: 100px;
        border-radius: 50%;
        }

    </style>
       
<?php $this->stop('css') ?>


<?php $this->start('header') ?>
     
            <div class="container">               
                <div class="table">
                    <div class="header-text">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <h3 class="light white">Optimisez vos locations saisonnières.</h3>
                                <h1 class="white typed">Choisissez le concierge qui vous convient</h1>
                                <br>
                                <br>
                                <!--<span class="typed-cursor">|</span>-->
                            </div>
                        </div>
                                <?php 
                                    if(!empty($errors)){// AFFICHE MESSAGES ERREURS/ SUCCES

                                         echo'<div  id="error" class="alert alert-danger alert-dismissable fade in ">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.implode('<br>', $errors).'</div>';

                                    }

                                    if($formValid == true){

                                         echo'<div  margin-bottom:50%" class="alert alert-success alert-dismissable fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> Bonjour '.$mail.' Vous êtes connecté, votre session : '.$w_user['firstname'].'</div>';

                                    }

                                    if($deco == true){

                                     echo'<p>Vous êtes déconnecté</p>';		
                                    }
                               ?>
	       
                        <div class="row">
                            <div class="col-sm-6 col-sm-offset-3">
					            <div id="imaginary_container"> 
					                <div class="input-group stylish-input-group">
					                	<form action="<?= $this->url('search_result') ?>">
						                    <input name="postCode" type="text" maxlength="5"class="form-control"  placeholder="Entrez votre code postal ! (ex : 33000)" >
						                     <button data-toggle="modal" data-target="#modal1" class="btn btn-primary">Trouver mon Groom</button>
						                </form>
					                </div>
					            </div>
					        </div>
	                    </div>
	                </div>				
	            </div>
	        </div>
        
<?php $this->stop('header') ?>

<?php $this->start('main_content') ?>
    
    <section>
	    <div class="cut cut-top"></div>
			<div class="container">
				<div class="row intro-tables">

				<?php foreach ($ExmplGroom as $key) {?>

					 <div class="col-md-3">
	                    <div class="team text-center">
	                        <div style="height:2em;" class="" ; background-size:cover;">
	                            <div style="text-align: center" class="overlay text-center">
	                                <h5 class="light light-white"></h5>
              
	                            </div>
	                        </div> 
		                        <?php 
		                        if (!empty($key['photo'])){ ?>
		                            <img id="imgAvatar" src="<?= $this->assetUrl('img/profilePict/'), $key['photo'] ?>" alt="Team Image" class="avatar">
		                        <?php
		                        }
		                        else {?>
		                        
		                        <img id="imgAvatar" src="<?= $this->assetUrl('img/profilePict/concierge120.png') ?>" alt="Team Image" class="avatar">
		                        <?php
		                        }
		                        ?>
	                        <div class="title" style="height: 3em;">
	                            <h4><?= ucfirst($key['firstname']).' '.ucfirst(substr($key['lastname'], 0, 1)).'.' ?></h4>
	                          

	                        <span class="fullstar">★★★★★</span>
	                        </div>
                        
                    	</div>
                	</div>
			<?php } ?>

			<!--		<div class="col-md-3">
						<div class="intro-table intro-table-first">
							<h4 class="white heading">Ben Adamson</h4>
							<div class="row">
								<i class="fa fa-star-o" aria-hidden="true"></i>
								<i class="fa fa-star-o" aria-hidden="true"></i>
								<i class="fa fa-star-o" aria-hidden="true"></i>
								<i class="fa fa-star-o" aria-hidden="true"></i>
							</div>
							<h5 class="white heading small-pt">Ronce les Bains</h5>
							<br>
							<a href="#" data-toggle="modal" data-target="#modal1"><h6 class="white heading small-pt" style="text-decoration:underline;">Voir Profil</h6</a>
						</div>
					</div>	
					<div class="col-md-3">
						<div class="intro-table intro-table-second">
							<h4 class="white heading">Ben Adamson</h4>
							<div class="row">
								<i class="fa fa-star-o" aria-hidden="true"></i>
								<i class="fa fa-star-o" aria-hidden="true"></i>
								<i class="fa fa-star-o" aria-hidden="true"></i>
								<i class="fa fa-star-o" aria-hidden="true"></i>	
							</div>
							<h5 class="white heading small-pt">Ronce les Bains</h5>
							<br>
							<a href="#" data-toggle="modal" data-target="#modal1"><h6 class="white heading small-pt" style="text-decoration:underline;">Voir Profil</h6</a>
						</div>
					</div>
					<div class="col-md-3">
						<div class="intro-table intro-table-third">
							<h4 class="white heading">Ben Adamson</h4>
							<div class="row">
								<i class="fa fa-star-o" aria-hidden="true"></i>
								<i class="fa fa-star-o" aria-hidden="true"></i>
								<i class="fa fa-star-o" aria-hidden="true"></i>
								<i class="fa fa-star-o" aria-hidden="true"></i>
							</div>
							<h5 class="white heading small-pt">Ronce les Bains</h5>
							<br>
							<a href="#" data-toggle="modal" data-target="#modal1"><h6 class="white heading small-pt" style="text-decoration:underline;">Voir Profil</h6</a>
						</div>
					</div>
					<div class="col-md-3">
						<div class="intro-table intro-table-four">
							<h4 class="white heading">Ben Adamson</h4>
							<div class="row">
								<i class="fa fa-star-o" aria-hidden="true"></i>
								<i class="fa fa-star-o" aria-hidden="true"></i>
								<i class="fa fa-star-o" aria-hidden="true"></i>
								<i class="fa fa-star-o" aria-hidden="true"></i>
							</div>
							<h5 class="white heading small-pt">Ronce les Bains</h5>
							<br>
							<a href="#" data-toggle="modal" data-target="#modal1"><h6 class="white heading small-pt" style="text-decoration:underline;">Voir Profil</h6</a>
						</div>
					</div> -->
				</div>
			</div>
		</div>
	</section>
	<section id="services" class="section section-padded">
		<div class="container">
			<div class="row text-center title">
				<h2>Nos Services</h2>
			</div>
			<div class="row services">
				<div class="col-md-3">
					<div class="proprietaire">
						<div class="service">
							<div class="icon-holder">
								<img src="<?= $this->assetUrl('img/icons/pont-ile-re.png')?>" alt="" class="icon">
							</div>
							<h4 class="white heading">Propriétaire</h4>
							<p class="description white">Des professionnels à votre service. <br> Maximisez vos revenus locatifs saisonniers.</p>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="concierge">
						<div class="service">
							<div class="icon-holder">
								<img src="<?= $this->assetUrl('img/icons/les-tours-de-la-rochelle.png')?>" alt="" class="icon">
							</div>
							<h4 class="white heading">Concierge</h4>
							<p class="description white">Pourquoi pas vous? <br>Inscrivez vous!</p>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="charte_qualite">
						<div class="service">
							<div class="icon-holder">
								<img src="<?= $this->assetUrl('img/icons/plage-charenteMaritime.png')?>" alt="" class="icon">
							</div>
							<h4 class="white heading">Charte de qualité</h4>
							<p class="description white">Des concierges qui s'engagent pour vous proposer les meilleurs services.</p>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="engagement">
						<div class="service">
							<div class="icon-holder">
								<img src="<?= $this->assetUrl('img/icons/fort-boyard.png')?>" alt="" class="icon">
							</div>
							<h4 class="white heading">Sans engagement</h4>
							<p class="description white">Pourquoi pas vous? <br>Inscrivez vous!</p>
							<p class="description white">Nous proposons de vous mettre en relation avec des concierges de votre secteur géographique, pas d'abonnement!</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	
	<!--<section id="team" class="section">
		<div class="container">
			<div class="row title text-center">
				<h2 class="margin-top">Team</h2>
				<h4 class="light muted">We're a dream team!</h4>
			</div>
			<div class="row">
				<div class="col-md-4">
					<div class="team text-center">
						<div class="cover" style="background:url('img/team/team-cover1.jpg'); background-size:cover;">
							<div class="overlay text-center">
								<h3 class="white">$69.00</h3>
								<h5 class="light light-white">1 - 5 sessions / month</h5>
							</div>
						</div>
						<img src="img/team/team3.jpg" alt="Team Image" class="avatar">
						<div class="title">
							<h4>Ben Adamson</h4>
							<h5 class="muted regular">Ronce les Bains</h5>
							<i class="fa fa-star-o" aria-hidden="true"></i>
							<i class="fa fa-star-o" aria-hidden="true"></i>
							<i class="fa fa-star-o" aria-hidden="true"></i>
							<i class="fa fa-star-o" aria-hidden="true"></i>
						</div>
						<button data-toggle="modal" data-target="#modal1" class="btn btn-primary">Voir Profil</button>
					</div>
				</div>
				<div class="col-md-4">
					<div class="team text-center">
						<div class="cover" style="background:url('img/team/team-cover2.jpg'); background-size:cover;">
							<div class="overlay text-center">
								<h3 class="white">$69.00</h3>
								<h5 class="light light-white">1 - 5 sessions / month</h5>
							</div>
						</div>
						<img src="img/team/team1.jpg" alt="Team Image" class="avatar">
						<div class="title">
							<h4>Eva Williams</h4>
							<h5 class="muted regular">Royan</h5>
							<i class="fa fa-star-o" aria-hidden="true"></i>
							<i class="fa fa-star-o" aria-hidden="true"></i>
							<i class="fa fa-star-o" aria-hidden="true"></i>
							<i class="fa fa-star-o" aria-hidden="true"></i>
						</div>
						<a href="#" data-toggle="modal" data-target="#modal1" class="btn btn-primary">Voir Profil</a>
					</div>
				</div>
				<div class="col-md-4">
					<div class="team text-center">
						<div class="cover" style="background:url('img/team/team-cover3.jpg'); background-size:cover;">
							<div class="overlay text-center">
								<h3 class="white">$69.00</h3>
								<h5 class="light light-white">1 - 5 sessions / month</h5>
							</div>
						</div>
						<img src="img/team/team2.jpg" alt="Team Image" class="avatar">
						<div class="title">
							<h4>John Phillips</h4>
							<h5 class="muted regular">La Rochelle</h5>
							<i class="fa fa-star-o" aria-hidden="true"></i>
							<i class="fa fa-star-o" aria-hidden="true"></i>
							<i class="fa fa-star-o" aria-hidden="true"></i>
							<i class="fa fa-star-o" aria-hidden="true"></i>
							<h4></h4>
						</div>
						<a href="#" data-toggle="modal" data-target="#modal1" class="btn btn-primary">Voir Profil</a>
					</div>
				</div>
			</div>
		</div>
	</section> 
	-->
	
	<section id="pricing" class="section">
		<div id="revenus" class="container">
			<div class="row title text-center">
				<h2 class="margin-top white">Optimisation des revenus</h2>
				<h4 class="light white">Pour toutes vos locations saisonnières !!</h4>
			</div>
			<div class="row no-margin">
				<div class="col-md-7 no-padding col-md-offset-5 pricings text-center">
					<div class="pricing">
						<div class="box-main active">
							<h4 class="white">Vos Avantages</h4>
							<a href="<?= $this->url('users_pickRole') ?>" data-toggle="modal" class="btn btn-white-fill">S'inscrire</a>
							<i class="info-icon icon_question"></i>
						</div>
						<div class="box-second active">
							<ul class="white-list text-left">
								<li>Gain de temps</li>
								<li>Proximité</li>
								<li>Simplicité</li>
								<li>Maximisez vos revenus</li>
								<li>Sans Engagement</li>
							</ul>
						</div>
					</div>
					<div class="pricing">

						<!--<div class="box-main" data-img="img/pricing2.jpg">
							<h4 class="white">Cardio Training</h4>
							<h4 class="white regular light">$100.00 <span class="small-font">/ year</span></h4>
							<a href="#" data-toggle="modal" data-target="#modal1" class="btn btn-white-fill">Sign Up Now</a>
							<i class="info-icon icon_question"></i>
						</div>
						<div class="box-second">
							<ul class="white-list text-left">
								<li>One Personal Trainer</li>
								<li>Big gym space for training</li>
								<li>Free tools &amp; props</li>
								<li>Free locker</li>
								<li>Free before / after shower</li>
							</ul>
						</div>-->

					</div>
				</div>
			</div>
		</div>
	</section>
	
<?php $this->stop('main_content') ?>

<?=$this->start('footer') ?>
  
<?=$this->stop('footer') ?>
