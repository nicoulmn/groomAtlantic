<?php $this->layout('layoutTestNico', ['title' => 'Espace Propriétaire']) ?>

<?php $this->start('css') ?>
<style>
    header {
        display: none;
    }

    body{
        background: #89b5f7;
    }

    .well-notif {
        border:0;
        border-left:5px solid #9e9e9e;
        border-radius:0;
    }
    .nb-notif {
        font-size: 13px;
        font-weight: 700;
        display:  inline-block;
        background: grey;
        border-radius: 50%;
        width: 25px;
        height: 25px;
        line-height: 25px;
    }
    .nb-notif.active {
        background: #296190;
    }
    .fa-default {
        color: inherit;
        font-size: inherit;
        margin-left: 0;
        margin-bottom: 0;

    }
    .fa-coords {
        color: #f06467;
        font-size: inherit;
        margin-left: 0;
        display: inline-block;
        width: 15px;
        margin-right: 3px;
    }
    .confirm-job {
        border-radius: 0;
        padding: 7px 7px;
        border: 1px solid #4cae4c;
        line-height: 14px;
        font-size: 14px;
        display: inline-block;
        vertical-align: middle;
    }
</style>
<?php $this->stop('css') ?>

<?php $this->start('main_content') ?>

<!-- AFFICHAGE DES DONNEES UTILISATEUR -->

<div class="table">
    <div class="header-text">
        <div id="DivFormG" class="row">
            <div class="col-md-12 text-center">
                <section class="profile">
                    <h3 class="strong white text-center">MON PROFIL</h3>
                    <figure id="profile_picture">
                        <img src="<?= $this->assetUrl('img/profilePict/'), $showInfos['photo'] ?>" class="img-circle" alt="photo_de_profil">
                    </figure>
                    <p class="strong white text-center">Bonjour,&nbsp;<?=$showInfos['firstname']; ?>&nbsp;<?=$showInfos['lastname']; ?></p>
                    <p class="light white text-center">Email : <?=$showInfos['email']; ?></p>
                    <p class="light white text-center">Téléphone : <?=$showInfos['phone']; ?></p>
                    <p class="light white text-center">Adresse : <?=$showInfos['address']; ?></p>
                    <p class="light white text-center">Code postal : <?=$showInfos['postcode']; ?></p>
                    <p class="light white text-center">Ville : <?=$showInfos['cityUser']; ?></p>
                    <p class="light white text-center">Date d'inscription : <?=$showInfos['date_creation']; ?></p>
                    <a href="<?= $this->url('change_profileO');?>" class="btn btn-blue">Modifier mon profil</a>
                    <br>
                    <br>
                    <a href="<?= $this->url('delete_profileO');?>" class="btn btn-blue"
                        onClick="if(confirm('Souhaitez-vous supprimer votre compte ?')){return true;}else{return false;}">
                        Me désinscrire</a><br>
                    </section>

                    <!-- AFFICHAGE DES DONNEES UTILISATEUR -->

                    <hr>

                    <!-- AFFICHAGE INFOS LOCATIONS -->

                    <section class="rentals">

                        <h3 class="light white text-center"><?=(count($locations) <= 1) ? 'MA LOCATION' : 'MES LOCATIONS'; ?></h3>

                        <!-- AFFICHAGE DES LOCATIONS -->

                        <?php if(!empty($locations)):?>

                            <?php foreach ($locations as $location): ?>

                                <?php $locs = explode('|', $location['outdoor_fittings']); ?>

                                <article>
                                    <h3><?=$location['title']; ?></h3>
                                    <p><span><?=$location['rooms']; ?>&nbsp;pièces</span>&nbsp;<span><?=$location['area']; ?>&nbsp;m²</span>&nbsp;
                                        <?php foreach ($locs as $loc): ?>
                                            <span><?= $loc; ?></span>
                                        <?php endforeach; ?>
                                    </p>
                                    <p><span><?=$location['street']; ?></span>&nbsp;<span><?=$location['city']; ?></span>&nbsp;
                                    </p>
                                    <a href="<?= $this->url('rentals_change', ['id' => $location['id']]) ?>" class="btn btn-blue" value="change">Modifier</a>
                                    <a href="<?= $this->url('rentals_delete', ['id' => $location['id']]) ?>" class="btn btn-blue" value="delete" onClick="if(confirm('Confirmez vous la suppression de cette location ?')){return true;}else{return false;}">Supprimer</a>
                                </article>
                                <br>
                            <?php endforeach; ?>

                        <?php else: ?>
                            <div class="alert alert-danger">
                                Aucune location renseignée.
                            </div>
                        <?php endif; ?><!-- AFFICHAGE DES LOCATIONS -->

                        <!-- AJOUT D'UNE LOCATION / FENETRE MODALE -->

                        <a href="#" data-toggle="modal" data-target="#modal1" class="btn btn-blue">Ajouter une location</a>
                        <div class="modal fade text-left" id="modal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content modal-popup">
                                    <a href="#" class="close-link"><i class="icon_close_alt2"></i></a>
                                    <h3 class="white">Ajouter une location</h3>
                                    <div><!-- affichage msg d'erreurs --></div>
                                    <form method="POST" action="<?= $this->url('users_showowner') ?>">
                                        <div class="form-group text-center">
                                            <label for="title">Titre</label>
                                            <input type="text" name="title" id="title" placeholder="Le nom de votre maison...">
                                        </div>
                                        <div class="form-group text-center">
                                            <label for="type">Type de location</label>
                                            <select name="type">
                                                <option value="" selected disabled>--Sélectionnez--</option>
                                                <option value="flat">Appartement</option>
                                                <option value="house">Maison</option>
                                                <option value="loft">Loft</option>
                                                <option value="mobilhome">Mobilhome</option>
                                            </select>
                                        </div>
                                        <div class="form-group text-center">
                                            <label for="area">Surface</label>
                                            <input type="text" maxlength="4" name="area" id="area" placeholder="..m²">
                                        </div>
                                        <div class="form-group text-center">
                                            <label for="rooms">Nombre de pièces</label>
                                            <input type="text" name="rooms" maxlength="3" id="rooms">
                                        </div>
                                        <div class="form-group text-center">
                                            <label for="outdoor_fittings">Equipements extérieurs</label>
                                            <label for="jardin">
                                                <input type="checkbox" name="outdoor_fittings[]" value="jardin">Jardin</label>
                                                <label for="terrasse">
                                                    <input type="checkbox" name="outdoor_fittings[]" value="terrasse">Terrasse</label>
                                                    <label for="balcon">
                                                        <input type="checkbox" name="outdoor_fittings[]" value="balcon">Balcon</label>
                                                        <label for="piscine">
                                                            <input type="checkbox" name="outdoor_fittings[]" value="piscine">Piscine</label>
                                                            <label for="jacuzzi">
                                                                <input type="checkbox" name="outdoor_fittings[]" value="jacuzzi">Jacuzzi</label>
                                                            </div>
                                                            <h3 class="white">Adresse</h3>
                                                            <div class="form-group text-center">
                                                                <label for="street">Voie</label>
                                                                <input type="text" name="street" id="street" placeholder="">
                                                            </div>
                                                            <div class="form-group text-center">
                                                                <label for="postcode">Code postal</label>
                                                                <input type="text" name="postcode" maxlength="5" id="postcode" placeholder="">
                                                            </div>
                                                            <div class="form-group text-center">
                                                                <label for="city">Ville</label>
                                                                <input type="text" name="city" id="city" placeholder="">
                                                            </div>
                                                            <button id="subscribe" type="submit" class="btn btn-submit">Ajouter une location</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </section><!-- FIN AJOUT D'UNE LOCATION / FENETRE MODALE -->
                                        <hr>
                                        <!-- AFFICHAGE REDIRECTION VERS LA PAGE DE RECHERCHE -->

                                        <section class="groom_research">
                                            <h3 class="light white text-center">ACCUEIL</h3>
                                            <a href="<?= $this->url('default_home'); ?>" class="btn btn-blue">Rechercher un groom</a>
                                        </section>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- AFFICHAGE REDIRECTION VERS LA PAGE DE RECHERCHE -->
                        <hr>
                        <!-- AFFICHAGE NOTIFICATIONS -->

                        <section class="notifications">

                            <h3 class="light white text-center">
                                NOTIFICATIONS <span id="countNotif" class="nb-notif <?=($total_notif) ? 'active' : '';?>"><?=$total_notif; ?></span>
                            </h3>
                            <div class="container text-left">
                                <div class="row">
                                    <div class="col-md-8 col-md-offset-2">
                                        <?php if(!empty($notifications1) || (!empty($notifications2))): ?>
                                            <?php foreach($notifications1 as $notif): ?>

                                                <!-- AFFICHAGE DES COORDONNEES DU GROOM -->
                                                <div class="well well-sm well-notif" style="">
                                                    <i class="fa fa-bullhorn fa-2x pull-left" aria-hidden="true" style="color:#333;margin-left:0;"></i> 
                                                    Le <?=\DateTime::createFromFormat('Y-m-d H:i:s', $notif['contact_date'])->format('d/m/Y \à H:i'); ?>, <?=$notif['groom_firstname'].' '.$notif['groom_lastname'];?> a accepté votre demande pour la location <?=$notif['rent_title']; ?>
                                                    <address><?=ucwords(mb_strtolower($notif['city'], 'UTF-8')).' - département: '.substr($notif['postcode'], 0,2); ?></address>

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            Voici ses coordonnées :
                                                            <ul class="list-unstyled" style="padding-left: 40px;">
                                                                <li>
                                                                    <i class="fa fa-user fa-coords" aria-hidden="true"></i> <?=$notif['groom_firstname'].' '.$notif['groom_lastname'];?>
                                                                </li>
                                                                <li>
                                                                    <i class="fa fa-phone fa-coords" aria-hidden="true"></i> <?=$notif['groom_phone'];?>
                                                                </li>
                                                                <li>
                                                                    <i class="fa fa-envelope-o fa-coords" aria-hidden="true"></i> <?=$notif['groom_mail'];?>
                                                                </li>
                                                            </ul>
                                                        </div>

                                                        <!-- CONFIRMATION D'INTERACTION -->
                                                        <div class="col-md-6">
                                                            <div class="text-center">
                                                                <h4 style="font-size:16px">Vous avez travaillé avec ce groom ?</h4>

                                                                <br>
                                                                <form method="post" id="confirmJob-<?=$notif['contact_id'];?>">

                                                                    <button type="submit" class="btn-success confirm-job" data-id="<?=$notif['contact_id'];?>">
                                                                        <i class="fa fa-check fa-default" aria-hidden="true"></i> Oui, je confirme avoir fait appel aux services de <?= $notif['groom_firstname'].' '.$notif['groom_lastname']; ?>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>

                                            
                                            <?php foreach($notifications2 as $notif): ?>
                                                <!-- LAISSEZ UN AVIS -->
                                                <div class="well well-sm well-notif" style="">
                                                    <i class="fa fa-bullhorn fa-2x pull-left" aria-hidden="true" style="color:#333;margin-left:0;"></i>

                                                    <h4 style="font-size:16px">Laissez un avis à <?=$notif['groom_firstname'].' '.$notif['groom_lastname'];?></h4>

                                                    <div class="row">
                                                        <form method="post" id="confirmRate-<?=$notif['contact_id'];?>">
                                                            <input type="hidden" name="groom_id" value="<?=$notif['groom_id'];?>">
                                                            <input type="hidden" name="owner_id" value="<?=$notif['owner_id'];?>">
                                                            <div class="col-md-6">
                                                                Note 
                                                                <input type="radio" name="rate" value="1">1
                                                                <input type="radio" name="rate" value="2">2
                                                                <input type="radio" name="rate" value="3">3
                                                                <input type="radio" name="rate" value="4">4
                                                                <input type="radio" name="rate" value="5">5
                                                            </div>
                                                            <br>
                                                            <div class="col-md-6">
                                                                <label for="content"> Commentaires </label>
                                                                <textarea name="content" maxlenght="200" class="form-control"></textarea>
                                                            </div>
                                                            <br>
                                                            <button type="submit" class="btn-success confirm-rate" data-id="<?=$notif['contact_id'];?>">
                                                                <i class="fa fa-check fa-default" aria-hidden="true"></i> Poster
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>

                                        <?php else: ?>

                                            <div class="alert alert-danger">Aucune notification actuellement</div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <!-- AFFICHAGE NOTIFICATIONS -->

                        <!-- AFFICHAGE AVIS LAISSES -->

                        <section class="marks_history">
                            <div class="table">
                                <div class="header-text">
                                    <div id="DivFormG" class="row">
                                        <div class="text-center">
                                            <hr>
                                            <h3 class="light white text-center">MES AVIS LAISSES</h3>
                                            <?php if(!empty($comments)):?>
                                                <?php foreach ($comments as $comment): ?>
                                                    <article>
                                                        <?php foreach ($commentsAd as $commentAd): ?>
                                                            <h3><?=$commentAd['firstname']; ?></h3>
                                                        <?php endforeach; ?>
                                                        <div class="content">
                                                            <?=nl2br($comment['content']); ?>
                                                        </div>
                                                        <p><?=$comment['date']; ?></p>
                                                    </article>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <div class="alert alert-danger">
                                                    <p>Aucun avis laissé.</p>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section><!-- AFFICHAGE AVIS LAISSES -->

                        <?php $this->stop('main_content') ?>


<?php $this->start('js') ?>
<script>
$(function(){

    $('.confirm-job').on('click', function(e){
        e.preventDefault();

        $idJob = $(this).data('id');

        $.ajax({
            url: '<?=$this->url('ajax_confirm_job_owner');?>',
            method: 'post',
            data: {id_contact_request: $idJob },
            success: function(resPHP){
                $('#confirmJob-'+$idJob).html(resPHP.message);
            }
        });
    });
    
    $('.confirm-rate').click(function(e){
        console.log('click');
        e.preventDefault();

        $idJob = $(this).data('id');

        $currentForm = $('#confirmRate-'+$idJob);
        $idGroom = $currentForm.find('input[name="groom_id"]').val();
        $idOwner = $currentForm.find('input[name="owner_id"]').val();
        $groomNote = $currentForm.find('input[name="rate"]:checked').val();
        $groomComment = $currentForm.find('textarea[name="content"]').val();

        $.ajax({
            url: '<?=$this->url('ajax_comment_by_owner');?>',
            method: 'post',
            data: {
                id_groom_rate: $idGroom,
                id_owner : $idOwner,
                note_groom : $groomNote,
                content_groom : $groomComment,
            },
            success: function(resPHP){
                $('#confirmRate-'+$idGroom).html(resPHP.message);
            }
        });
    });
});
</script>
<?php $this->stop('js') ?>
