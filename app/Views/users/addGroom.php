<?php $this->layout('layoutTestNico', ['title' => 'Inscription/Groom']) ?>

<?php $this->start('css') ?>
    <style>
        header {
            display: none;
        }

        body{
            background: #89b5f7;
        }
    </style>
<?php $this->stop('css') ?>

<?php $this->start('main_content') ?>

            <div class="container">
                <div class="table">
                    <div class="header-text">
                        <div id="DivFormG" class="row">
                            <div class="col-md-12 text-center">
                                <h2 class="light white text-center">S'inscrire en tant que Groom</h2>
                            
                                <?php 

                                if(!empty($errors)){

                                    echo'<p>'.implode('<br>', $errors).'</p>';

                                }

                                if($formValid == true){

                                    ?><p style="color : black; text-align: center; font-size:20px;"> Vous êtes inscrit</p>
                                        
                                <?php
                                }
                                
                                else {

                                ?>
                                        <form id="FormAddGroom" method="post" style="text-align:center;">   
                                            <div class="form-group">
                                                <input  name="firstname" type="text" placeholder="Votre prénom" class="form-control" value="<?php if(!empty($post['firstname'])){
                                    echo $post['firstname'];

                                }?>">
                                            </div>
                                            <div class="form-group">
                                                <input  name="lastname" type="text" placeholder="Votre nom" class="form-control" value="<?php if(!empty($post['lastname'])){
                                    echo $post['lastname'];

                                }?>">
                                            </div>
                                            <div class="form-group">
                                                <input  name="email" type="text" placeholder="Votre email" class="form-control" value="<?php if(!empty($post['email'])){
                                    echo $post['email'];

                                }?>">
                                            </div>
                                            <div class="form-group">
                                                <input  type="password" name="password"  placeholder="Votre mot de passe" class="form-control" value="<?php if(!empty($post['password'])){
                                    echo $post['password'];

                                }?>">
                                            </div>
                                            <div class="form-group">
                                                <input  type="password" name="password2"  placeholder="Répétez votre mot de passe" class="form-control" value="<?php if(!empty($post['password2'])){
                                    echo $post['password'];

                                }?>">
                                            </div>
                                            <div class="form-group">
                                                <input  name="phone" type="text" maxlength="10"placeholder="0102030405" class="form-control" value="<?php if(!empty($post['phone'])){
                                    echo $post['phone'];

                                }?>">
                                            </div>
                                            <div class="form-group">
                                                <input  name="address" type="text" placeholder="ex : 9 cours Portal" class="form-control" value="<?php if(!empty($post['address'])){
                                    echo $post['address'];

                                }?>">
                                            </div>
                                            <div class="form-group">
                                                <input  name="postcode" type="text" placeholder="Code postal" class="form-control" value="<?php if(!empty($post['postcode'])){
                                    echo $post['postcode'];

                                }?>">
                                            </div>
                                            <div class="form-group">
                                                <input  name="cityUser" type="text" placeholder="Ville" class="form-control" value="<?php if(!empty($post['cityUser'])){
                                    echo $post['cityUser'];

                                }?>">
                                            </div>
                                            <button type="submit" class="btn btn-default">S'inscrire</button>
                                        </form>
                                <?php
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

<?php $this->stop('main_content') ?>