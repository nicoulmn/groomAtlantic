

<?php $this->layout('layoutTestNico', ['title' => 'Résultats de la recherche']) ?>


<?php $this->start('css') ?>
<style>
    header {
        display: none;
    }

    #retourAccueil {
        color: #fff; 
        text-align: center; 
        display: block; 
        font-size: 1.5em;
        background:rgba(240, 100, 103, 0.8);
        margin:auto 20em;
        border-radius: 30px;
        padding: 5px 0 5px 0px;
    }

    #retourAccueil:hover {
        background:rgba(240, 100, 103, 1);
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
        height: 400px;
        width: 100%;            
        overflow : visible;
    }


</style>
<?php $this->stop('css') ?>

<?php $this->start('main_content') ?>

<div id="DivSearch" class="container";>
    <div class="table">
        <div class="header-text">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h2 style="color:#f06467" class="light white">Résultats de vote recherche</h2>
                    <?php 

    if(!empty($errors)){

        echo'<p>'.implode('<br>', $errors).'</p>';

    }

                    ?>


                    <h3 class="light white" style="color:#f06467">Nos Grooms près de : <?= $ville['NomVille'].'('.$fullCp.')'; ?></h3>
                </div>
            </div>        



            <div class="row">
                <div id="map"></div>
                <script>
                    function initMap() 
                    {
                        var locations = 
                            [
                                <?php
  
                                if(isset($markers) and !empty($markers))
                                {
                                    foreach($markers as $markert)
                                    {
                                ?>
                                ['<?php echo $markert['firstname'] ?>', <?php echo $markert['lat'] ?>, <?php echo $markert['lng'] ?>, 0, 'http://localhost/GIT/groomAtlantic/Public/searchGroom/searchResult<?php echo $markert['id'] ?>'],
                                <?php
                                    }
                                }
                                ?>
                            ];

                        var map = new google.maps.Map(document.getElementById('map'), {
                            zoom: 10,
                            center: new google.maps.LatLng(44.54376, -0.55419999999931),
                            mapTypeId: google.maps.MapTypeId.ROADMAP
                        });

                        var infowindow = new google.maps.InfoWindow();

                        var marker, i;

                        for (i = 0; i < locations.length; i++) {
                            marker = new google.maps.Marker({
                                position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                                map: map,
                                url: locations[i][4]
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


                <?php
              


                if(!empty($resultSearch)){

                ?>


                <?php

                    foreach ($resultSearch as $datas) {   
                ?>



                <div class="col-md-4">
                    <div class="team text-center">
                        <div class="cover" style="background:url('<?= $this->assetUrl('img/team/cover1.jpg') ?>'); background-size:cover;">
                            <div style="text-align: center" class="overlay text-center">
                                <h5 class="white">Mes compétences & tarifs : </h5>
                                <h5 class="light light-white"></h5>
                                <?php 
                    //TEST //
                    /*
                                                        $skillJoint = new
                                                        ServicesInfosModel(); 
                                                        $tabSkill = $skillJoint->findSkillsWithId($datas['id_groom']);
                                                        $pricesTab = explode(',', $datas['price']);  
                                                        */
<<<<<<< HEAD
                                                    ?>
                                                    <table id="TabComp">
                                                        <tr>
                                                            <?php                                                            
                                                                foreach ($datas['comp'] as $skill) {
                                                                    echo ' <th>' .$skill['skills']. '</th>';
                                                                }
                                                            ?>
                                                            
                                                        </tr>
                                                        <tr>
                                                            <?php 

                                                                foreach ($datas['prix'] as $prix) {

                                                                    echo '<td>'.$prix.' €</td>';
                                                                }
                                                            ?>
                                                        </tr>                                                    
                                                       
                                                    </table>
                                            </div>
                                        </div>
                                        <img src="<?= $this->assetUrl('img/team/concierge120.png') ?>" alt="Team Image" class="avatar">
                                        <div class="title">
                                            <h4><?= ucfirst($datas['firstname']).' '.ucfirst(substr($datas['lastname'], 0, 1)).'.' ?></h4>
                                            <h5 class="muted regular">Groom sur 
                                            <?php
                                                foreach ($datas['villeAction'] as $city) {
                                                     echo ucfirst(strtolower($city));
                                                } 

                                             ?></h5>
                                        </div>
                                            
                                        
                                        <a id="details" target="_blank" href="<?= $this->url('Search_groomDetails')?>">Fiche détaillée</a>
                                       
                                        
                                                    
                                    </div>
                                </div>
                            <?php

                        } //fin du foreach Infosgroom

                    } // fin du if resulSearch   
                    else{

                        ?><div style="text-align: center; font-size:2em; padding: 1em 0 1em 0;"> Malheuresement, nous n'avons pas encore de Grooms inscrits dans les environs..</div>
                        <a id="retourAccueil" href="<?= $this->url('default_home') ?>">Retourner à l'accueil</a><?php

                    }                                
=======
                                ?>
                                <table id="TabComp">
                                    <tr>
                                        <?php                                                            
                    foreach ($datas['comp'] as $skill) {
                        echo ' <th>' .$skill['skills']. '</th>';
                    }
                                        ?>

                                    </tr>
                                    <tr>
                                        <?php 

                        foreach ($datas['prix'] as $prix) {

                            echo '<td>'.$prix.' €</td>';
                        }
                                        ?>
                                    </tr>                                                    

                                </table>
                            </div>
                        </div>
                        <img src="<?= $this->assetUrl('img/team/concierge120.png') ?>" alt="Team Image" class="avatar">
                        <div class="title">
                            <h4><?= ucfirst($datas['firstname']).' '.ucfirst(substr($datas['lastname'], 0, 1)).'.' ?></h4>
                            <h5 class="muted regular">Groom sur 
                                <?php
                                            foreach ($datas['villeAction'] as $city) {
                                                echo ucfirst(strtolower($city));
                                            } 

                                ?></h5>
                        </div>


                        <a id="details" target="_blank" href="<?= $this->url('Search_groomDetails', ['id' => $datas['id_groom']])?>">Fiche détaillée</a>
>>>>>>> 3f3825adee2f737fea3427a298796577084c52f0

                    </div>
                </div>
                <?php

                    } //fin du foreach Infosgroom

                } // fin du if resulSearch   
                else{

                ?><div style="text-align: center; font-size:2em; padding: 1em 0 1em 0;"> Malheuresement, nous n'avons pas encore de Grooms inscrits dans les environs..</div>
                <a id="retourAccueil" href="<?= $this->url('default_home') ?>">Retourner à l'accueil</a><?php

                }                                

                ?>
            </div>
        </div>
    </div>
</div>


<?php $this->stop('main_content') ?>
