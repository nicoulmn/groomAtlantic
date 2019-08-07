<?php $this->layout('layoutTestNico', ['title' => 'Résultats de la recherche']) ?>

<?php $this->start('css') ?>

<style>
    header {
        display: none;
    }

    body{
        background: #89b5f7;
    }
    #imgAvatar{
    
    width: 100px;
    height: 100px;
    }

    #details{
        background:rgba(41, 97, 144, 0.7);      
        font-size: 1.5em; 
        border-radius: 30px;
        display: block; 
        margin: auto 4em;
        padding: 10px;
    }

    #details:hover{
        background:rgba(41, 97, 144, 1);
    }

    #map, #map_canvas{
        height: 500px;
        width: 100%;            
        overflow : visible;
    }
    .stars {
        font-size: 3em; 
       color:rgba(41, 97, 144, 1);

    }

    .form-group .form-group{
        background: rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        padding: 5px;
        margin: 5px;
    }

</style>
<?php $this->stop('css') ?>

<?php $this->start('main_content') ?>

<div class="container";>
    <div class="table">
        <div class="header-text">
            <div id="DivFormO" class="row">
                <h2 style="color:#f06467" class="light white">Résultats de vote recherche</h2>
                <?php 

    if(!empty($errors)){

        echo'<p>'.implode('<br>', $errors).'</p>';

    }

                ?>
                <h3 class="light white" style="color:#f06467">Nos Grooms près de : <?= $ville['NomVille'].'('.$fullCp.')'; ?></h3>
            </div>        
            <div class="row">

                <div id="map"></div>            
                <script>


                    function initMap() 
                    {
                        var locations = 
                            [
                                <?php

                                if(!empty($resultSearch))
                                {
                                    foreach($resultSearch as $datas)
                                    {
                                ?>
                                ['<?php echo $datas['firstname'] ?>', <?php echo $datas['lat'] ?>, <?php echo $datas['lng'] ?>, 0, '<?= $this->url('Search_groomDetails', ['id' => $datas['id_groom']])?>'],
                                <?php
                                    }
                                }
                                ?>
                            ];
                        
                        var map = new google.maps.Map(document.getElementById('map'), {
                            zoom: 8,
                            center: new google.maps.LatLng(45.744175, -0.633389),
                            mapTypeId: google.maps.MapTypeId.ROADMAP
                        });

                        var infowindow = new google.maps.InfoWindow();
                        var marker, i;

                        for (i = 0; i < locations.length; i++) {
                            marker = new google.maps.Marker({
                                position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                                map: map,
                                url: locations[i][4],
                                icon: '<?= $this->assetUrl('img/hat3.png') ?>'
                            });

                            google.maps.event.addListener(marker, 'mouseover', (function(marker, i) {
                                return function() {
                                    infowindow.setContent(locations[i][0]);
                                    infowindow.open(map, marker);
                                }
                            })(marker, i));

                            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                                return function() {
                                    infowindow.setContent(locations[i][0]);
                                    infowindow.open(map, marker);
                                    window.location.href = this.url; //a definir sur l'ID du groom
                                }
                            })(marker, i));
                        }
                    }

                </script>

                <script async defer
                        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB0xJoi5c9MwYIYQlwIEfLqLh95hLtcaYA&callback=initMap">
                </script>

                <div id="map canvas"></div>
                <div class="form-inline">
                    <form method="POST" class="form-group text-center">
                    
                        <div class="form-group">
                            <label for="notedesc"><h4>Trier par note</h4></label>
                            <input id="notedesc" type="checkbox" value="true" name="order">
                        </div>
                        <div class="form-group">
                            <label for="comp1"><h4>Accueil voyageurs</h4></label>
                            <input id="comp1" type="checkbox" value="1" name="comp[]">
                        </div>
                        <div class="form-group">
                            <label for="comp2"><h4>Départ voyageurs</h4></label>
                            <input id="comp2" type="checkbox" value="2" name="comp[]">
                        </div>
                        <div class="form-group">
                            <label for="comp3"><h4>Ménage</h4></label>
                            <input id="comp3" type="checkbox" value="3" name="comp[]">
                        </div>
                        <div class="form-group">
                            <label for="comp4"><h4>Entretien espaces verts</h4></label>
                            <input id="comp4" type="checkbox" value="4" name="comp[]">
                        </div>
                        <div class="form-group">
                            <label for="comp5"><h4>Entretien piscine</h4></label>
                            <input id="comp5" type="checkbox" value="5" name="comp[]">
                        </div>
                        <div class="form-group">
                            <label for="comp6"><h4>Bricolage / Réparations</h4></label>
                            <input id="comp6" type="checkbox" value="6" name="comp[]">
                        </div>
                        <div class="form-inline">
                            <button class="btn btn-default" type="submit">Trier</button>
                        </div>
                    </form>
                </div>
                <?php  
                if(!empty($resultSearch)){               

                    foreach ($resultSearch as $datas) {   
                ?>
                <div class="col-md-4">
                    <div class="team text-center">
                        <div class="cover" style="background:url('<?= $this->assetUrl('img/team/cover1.jpg') ?>'); background-size:cover;">
                            <div style="text-align: center" class="overlay text-center">
                                <h5 class="light light-white"></h5>
                                        <?php                                                   
                    foreach ($datas['comp'] as $skill) {
                        
                       if ($skill['skills'] == "Ménage"){
                            ?><img id="skills_img" src="<?= $this->assetUrl('img/icons/cleaner.png') ?>" alt="Preloader image"><?php
                        }
                        if ($skill['skills'] == "Accueil voyageurs"){
                            ?><img id="skills_img" src="<?= $this->assetUrl('img/icons/check-in-marker.png') ?>" alt="Preloader image"><?php
                        }
                        if ($skill['skills'] == "Départ voyageurs"){
                            ?><img id="skills_img" src="<?= $this->assetUrl('img/icons/checkout.png') ?>" alt="Preloader image"><?php
                        }
                        if ($skill['skills'] == "Entretien jardin"){
                            ?><img id="skills_img" src="<?= $this->assetUrl('img/icons/garden.png') ?>" alt="Preloader image"><?php
                        }
                        if ($skill['skills'] == "Entretien piscine"){
                            ?><img id="skills_img" src="<?= $this->assetUrl('img/icons/pool.png') ?>" alt="Preloader image"><?php
                        }
                        if ($skill['skills'] == "Bricolage / Réparation"){
                            ?><img id="skills_img" src="<?= $this->assetUrl('img/icons/wrenchNB.png') ?>" alt="Preloader image"><?php
                        }
                    }
                                        ?>
                            </div>
                        </div> 
                        <?php 
                        if (!empty($datas['photo'])){ ?>
                            <img id="imgAvatar" src="<?= $this->assetUrl('img/profilePict/'), $datas['photo'] ?>" alt="Team Image" class="avatar">
                        <?php
                        }
                        else {?>
                        
                        <img id="imgAvatar" src="<?= $this->assetUrl('img/profilePict/concierge120.png') ?>" alt="Team Image" class="avatar">
                        <?php
                        }
                        ?>
                        <div class="title">
                            <h4><?= ucfirst($datas['firstname']).' '.ucfirst(substr($datas['lastname'], 0, 1)).'.' ?></h4>
                            <h5 class="muted regular">Groom sur 
                                <?php
                                            foreach ($datas['villeAction'] as $city) {
                                                echo ucfirst(strtolower($city));
                                            } 

                                ?>
                            </h5>
                        <?php 

                                        if ($datas['moyenne'] == 5 ){

                                            echo '<p class="stars" class="fullstar">★★★★★</p>';
                                        } 
                                        if ($datas['moyenne'] >= 4 AND $datas['moyenne']<5 ){

                                            echo '<p class="stars" class="fullstar">★★★★☆</p>';
                                        } 
                                        if ($datas['moyenne'] >= 3 AND $datas['moyenne']<4 ){

                                            echo '<p class="stars" class="fullstar">★★★☆☆</p>';
                                        } 
                                        if ($datas['moyenne'] >= 2 AND $datas['moyenne']<3 ){

                                            echo '<p class="stars" class="fullstar">★★☆☆☆</p>';
                                        } 
                                        if ($datas['moyenne'] >= 1 AND $datas['moyenne']<2 ){

                                            echo '<p class="stars" class="fullstar">★☆☆☆☆</p>';
                                        }
                                        elseif(empty($datas['moyenne'])) {
                                            echo '<p class="stars" class="fullstar">Nouveau !</p>';
                                        }
                                       
                            ?>
                        </div>
                        <a id="details" target="_blank" href="<?= $this->url('Search_groomDetails', ['id' => $datas['id_groom']])?>">Fiche détaillée</a>
                    </div>
                </div>
                <?php

                    } //fin du foreach Infosgroom
                } // fin du if resulSearch   
                else{

                ?>
                    <div style="text-align: center; font-size:2em; padding: 1em 0 1em 0;">
                            Malheureusement, nous n'avons pas encore de Grooms inscrits dans les environs..
                    </div>
                    <div class="text-center">
                        <a id="retourAccueil" href="<?= $this->url('default_home') ?>"><button id="" class="btn btn-default">Retourner à l'accueil</button></a><?php
                        }                                
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $this->stop('main_content') ?>
