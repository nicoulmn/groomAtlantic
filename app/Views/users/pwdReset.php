<?php $this->layout('layoutTestNico', ['title' => 'Inscription/Groom']) ?>

<?php $this->start('header') ?>

            <div class="container">
                <div class="table">
                    <div class="header-text">
                        <div class="row">
                            <h2 class="light white">Mot de passe oublié</h2>
                            <form method="post">
                                <div class="form-group">
                                    <label for="email">Veuillez rentrer voter adresse de messagerie</label>
                                    <input type="email" class="form-control" id="email" placeholder="Votre email" name="email">
                                </div>
                            <button type="submit" class="btn btn-link">Envoyer le lien</button>
                            </form>
                            <?php 
                                        if(!empty($errors)){

                                            echo'<p style="color: red; text-align: center; font-size: 20px;">'.implode('<br>', $errors).'</p>';

                                        }

                                        if($formValid == true){

                                              echo '<p style="color: white; text-align: center; font-size:20px;">Veuillez consulter votre boite email pour modifier votre mot de passe.</p>';
                                            
                                        }
                                    ?>
                        </div>
                    </div>
                </div>
            </div>
<?php $this->stop('header') ?>

<?php $this->start('main_content') ?>

<?php $this->stop('main_content') ?>
