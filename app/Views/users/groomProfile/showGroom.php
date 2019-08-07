<?php $this->layout('layoutTestNico', ['title' => 'Mon profil']) ?>

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
<div class="table">
    <div class="header-text">
        <div id="DivFormG" class="row">
            <div class="col-md-12 text-center">

                <section class="profile"><!-- AFFICHAGE DES DONNEES UTILISATEUR -->
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
                    <a href="<?= $this->url('change_profile');?>" class="btn btn-blue">Modifier mon profil</a>
                    <br>
                    <br>
                    <a href="<?= $this->url('delete_profile');?>" class="btn btn-blue"
                       onClick="if(confirm('Souhaitez-vous supprimer votre compte ?')){return true;}else{return false;}">
                        Me désinscrire</a><br>
                </section><!-- FIN AFFICHAGE DES DONNEES UTILISATEUR -->


                <hr>

                <h3 class="light white text-center">MES SERVICES</h3><!-- AFFICHAGE DES SERVICES/PRIX -->
                <?php if(!empty($services)):?>
                <?php 
                /*
                    echo '<pre>';
                    print_r($prices);
                    echo '</pre>';
                    */
                ?> 
                <div class="container">
                    <div class="panel panel-default">
                        <h5 class="text-center">Ma Description</h5>
                        <div class="panel-body">
                            <?php foreach ($prices as $price): ?>
                            <?= nl2br($price['description']); ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>


                <section class="tableau1">                 
                    </div>
                <div class="row">
                    <center>
                        <table width=60%>
                            <tbody>
                                <tr align="center">
                                    <td><strong>Compétences</strong></td>
                                    <?php foreach ($services as $service): ?>
                                    <td><?= $service['skills']; ?></td>
                                    <?php endforeach; ?>
                                </tr>
                                <tr align="center">
                                    <td><strong>Prix</strong></td>
                                    <?php $pricesTab = explode(',', $prices[0]['price']); ?>
                                    <?php foreach ($pricesTab as $price): ?>
                                    <td><?= $price ?>€</td>
                                    <?php endforeach; ?>
                                </tr>
                            </tbody>
                        </table>
                    </center>
                    <br>
                </div>

                <!--<?php //if(!empty($prices[0]['id_groom'])): ?>-->
                <?php foreach ($prices as $test): ?>
                <a href="<?= $this->url('services_change', ['id' => $test['id']]) ?>" class="modifServ btn btn-blue" value="change">Modifier mes services</a>
                <?php endforeach; ?>
                <!--<?php //endif; ?>-->
                <br>
                <?php else: ?>
                <div class="alert alert-danger">
                    Aucune service renseigné.<br> <br>
                    Important ! Vous n'apparaitrez en tant que Groom disponible qu'une fois que vous aurez spécifié les services que vous proposez !
                </div>
                <?php endif; ?>


                
            <?php if(empty($prices[0]['id_groom'])): ?>
            <a href="#" data-toggle="modal" data-target="#modal1" class="btn btn-blue">Ajouter des services</a>
            <?php endif; ?>

            </section> <!-- FIN AFFICHAGE DES SERVICES/PRIX -->

            <div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"><!-- AJOUT DE SERVICES / FENETRE MODALE -->
                <div class="modal-dialog">
                    <div class="modal-content modal-popup">
                        <a href="#" class="close-link"><i class="icon_close_alt2"></i></a>
                        <div class="form-group">
                            <h3 class="white">Ajouter des services</h3>
                        </div>
                        <form method="POST" action="<?= $this->url('users_showgroom') ?>">
                            <div class="form-group">
                                <label for="description">Ajouter une description</label>
                                <textarea name="description" maxlength="300"></textarea>
                            </div>
                            <?php
    if(!empty($errorsText)){
        echo '<p style="color:red";>'.implode('<br>', $errorsText);
    }
                            ?>
                            <table>
                                <tr>
                                    <label for="checkIn">
                                        <td>Check-in</td>
                                        <td><input type="checkbox" name="id_skill[]" value="1"></td>
                                        <td><input type="text" name="price[]" value=""></td>
                                    </label>
                                </tr>
                                <br>
                                <tr>
                                    <label for="checkOut">
                                        <td>Check-out</td>
                                        <td><input type="checkbox" name="id_skill[]" value="2"></td>
                                        <td><input type="text" name="price[]"></td>
                                    </label>
                                </tr>
                                <br>
                                <tr>
                                    <label for="cleaning">
                                        <td>Ménage</td>
                                        <td><input type="checkbox" name="id_skill[]" value="3"></td>
                                        <td><input type="text" name="price[]" placeholder="prix au m2"></td>
                                    </label>
                                    <br>
                                </tr>
                                <tr>
                                    <label for="gardenMaintenance">
                                        <td>Entretien espaces verts</td>
                                        <td><input type="checkbox" name="id_skill[]" value="4"></td>
                                        <td><input type="text" name="price[]" placeholder="prix au m2"></td>
                                    </label>
                                    <br>
                                </tr>
                                <tr>
                                    <label for="spMaintenance">
                                        <td>Entretien piscine</td>
                                        <td><input type="checkbox" name="id_skill[]" value="5"></td>
                                        <td><input type="text" name="price[]" placeholder="prix au m2"></td>
                                    </label>
                                    <br>
                                </tr>
                                <tr>
                                    <label for="fixing">`
                                        <td>Petit bricolage / Réparations</td>
                                        <td><input type="checkbox" name="id_skill[]" value="6"></td>
                                        <td><input type="text" name="price[]"></td>
                                    </label>
                                    <br>
                                </tr>
                            </table>
                            <button type="submit" class="btn btn-submit">Ajouter</button>
                        </form>
                    </div>
                </div>
            </div><!-- FIN D'AJOUT DE SERVICES / FENETRE MODALE -->

            <hr>

            <!-- AFFICHAGE DES NOTIFICATIONS -->
            <h3 class="light white text-center">
                NOTIFICATIONS <span id="countNotif" class="nb-notif <?=($total_notif) ? 'active' : '';?>"><?=$total_notif; ?></span>
            </h3>

            <div class="container text-left">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <?php if(!empty($notifications1) || (!empty($notifications2))): ?>
                        <?php foreach($notifications1 as $notif): ?>

                        <!-- DEMANDE DE MISE EN RELATION -->
                        <div class="well well-sm well-notif" style="">
                            <i class="fa fa-bullhorn fa-2x pull-left" aria-hidden="true" style="color:#333;margin-left:0;"></i> 
                            Le <?=\DateTime::createFromFormat('Y-m-d H:i:s', $notif['contact_date'])->format('d/m/Y \à H:i'); ?> vous avez été contacté par <?=$notif['owner_firstname'].' '.$notif['owner_lastname'];?> pour la location <?=$notif['rent_title']; ?>
                            <address><?=ucwords(mb_strtolower($notif['city'], 'UTF-8')).' - département: '.substr($notif['postcode'], 0,2); ?></address>
                            <br>
                            <div><p><?= nl2br($notif['message'])?></p></div>

                            <form id="notif_form_<?=$notif['contact_id'];?>" method="POST" class="request_contact">
                                <div class="text-center">
                                    <p>Êtes vous intéressé(e) ?</p>
                                    <label>
                                        <input type="radio" name="accept_contact" id="cbox_yes_<?=$notif['contact_id'];?>" data-id="<?=$notif['contact_id'];?>" value="yes">&nbsp; Oui
                                    </label>   
                                    <label>
                                        <input type="radio" name="accept_contact" id="cbox_yes_<?=$notif['contact_id'];?>" data-id="<?=$notif['contact_id'];?>" value="no">&nbsp; Non
                                    </label>
                                </div>

                                <div id="notif_conf_<?=$notif['contact_id'];?>"></div>
                            </form>
                        </div>
                        <?php endforeach; ?>

                        <?php foreach($notifications2 as $notif): ?>
                        <!-- CONFIRMATION D'INTERACTION -->
                        <div class="well well-sm well-notif" style="">
                            <div class="row">
                                <div class="col-md-6">

                                    <br><br>
                                    <i class="fa fa-bullhorn fa-2x pull-left" aria-hidden="true" style="color:#333;margin-left:0;"></i>
                                    <?= $notif['owner_firstname'].' '.$notif['owner_lastname']; ?> a confirmé avoir fait appel à vos services pour la location <?=$notif['rent_title']; ?>. 
                                    <br>
                                </div>
                                <div class="col-md-6">

                                    <h4 style="font-size:16px">Avez-vous travaillé pour ce propriétaire ?</h4>

                                    <form method="post" id="confirmJob-<?=$notif['contact_id'];?>">

                                        <button type="submit" class="btn-success confirm-job" data-id="<?=$notif['contact_id'];?>">
                                            <i class="fa fa-check fa-default" aria-hidden="true"></i> Oui, je confirme avoir travailler avec <?= $notif['owner_firstname'].' '.$notif['owner_lastname']; ?>
                                        </button>

                                    </form>
                                </div>

                            </div>
                        </div>
                        <?php endforeach; ?>

                        <!-- NOUVEL AVIS
<div class="well well-sm well-notif" style="">
<i class="fa fa-bullhorn fa-2x pull-left" aria-hidden="true" style="color:#333;margin-left:0;"></i>
<div class="col-md-6">
Vous avez reçu un nouvel avis, vous pouvez le consulter dans la rubrique <strong>Avis Reçus</strong> de votre profil. 
</div>
<div class="clearfix"></div>
</div> -->


                        <?php else: ?>
                        <div class="alert alert-danger">Aucune notification actuellement</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>


            <hr>

            <!-- NOUVEAU COMMENTAIRE DISPONIBLE -->
            <div class="container">
                <div class="table">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <section class="comments">
                                <?php if(!empty($comments)):?>

                                <?php foreach ($comments as $comment): ?>
                                <div>
                                    <?php foreach ($commentsA as $commentA): ?>
                                    <p><?= $commentA['firstname'].' a donné son avis sur votre prestation, vous pouvez le visualiser dans <a href=""><strong>Avis obtenus</strong></a>'; ?></p>
                                    <?php endforeach; ?>
                                </div>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <div class="alert alert-danger">
                                    <p>Pas de dernier commentaire pour le moment.</p>
                                </div>
                                <?php endif; ?>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- AFFICHAGE AVIS OBTENUS -->

<div class="container">
    <div class="table">
        <div class="row">
            <div class="col-md-12 text-center">
                <section class="comments">
                    <?php if(!empty($comments)):?>

                    <?php foreach ($comments as $comment): ?>

                    <article>
                        <?php foreach ($commentsA as $commentA): ?>
                        <h3><?=$commentA['firstname']; ?></h3>
                        <?php endforeach; ?>
                        <div class="content">
                            <?=nl2br($comment['content']); ?>
                        </div>
                        <p><?=$comment['date']; ?></p>
                    </article>
                    <?php endforeach; ?>

                    <?php else: ?>
                    <div class="alert alert-danger">
                        <p>Pas de commentaire pour le moment.</p>
                    </div>
                    <?php endif; ?>

                </section>
            </div>
        </div>
    </div>
</div>

<?php $this->stop('main_content') ?>
<?php $this->start('js') ?>
<script>
    $(document).ready(function(e){

        $('input[name="accept_contact"]').on('click', function(e){

            if($(this).is(':checked')){
                var $currentRadio = $(this).val();
                var $currentId = $(this).data('id');

                $.ajax({
                    url: '<?=$this->url('ajax_validate_contact_request');?>',
                    type: 'post',
                    data: {id_contact: $currentId, choice: $currentRadio},
                    success: function(resPHP){
                        if(resPHP.code === true){
                            $('#notif_form_'+$currentId +' label').fadeOut();
                        }
                        $('#notif_conf_'+$currentId).html(resPHP.message);
                        $('#countNotif').text(resPHP.nbNotifs);
                        if(resPHP.nbNotifs == '0'){
                            $('#countNotif').removeClass('active');
                        }
                    }
                });
            }
        });
    });

    $(function(){

        // classe du bouton dans le form
        $('.confirm-job').on('click', function(e){
            e.preventDefault();

            // id de la contact request
            $idJob = $(this).data('id');

            $.ajax({
                // route vers la méthode AJAX
                url: '<?=$this->url('ajax_confirm_job_groom');?>',
                method: 'post',
                // transmission de l'id de la contact request
                data: {id_contact_request: $idJob },
                success: function(resPHP){
                    // concaténation de l'id du form et de l'id de la contact request
                    $('#confirmJob-'+$idJob).html(resPHP.message);
                }
            });
        });
    });
</script>
<?php $this->stop('js') ?>