<?php $this->layout('layoutTestNico', ['title' => 'Réinitialisation du mot de passe']) ?>

<?php $this->start('header') ?>

            <div class="container">
                <div class="table">
                    <div class="header-text">
                        <div class="row">
                            <h2 class="light white">Réinitialisation du mot de passe</h2>

                            <?php if($formValid == true) {

                                    echo'
                                    <div  margin-bottom:50%" class="alert alert-success alert-dismissable fade in">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> 
                                        Votre mot de passe a bien été réinitialisé
                                    </div>';
                            }?>

                            <?php if(!empty($errors)){// AFFICHE MESSAGES ERREURS/ SUCCES

                                     echo'<div  id="error" class="alert alert-danger alert-dismissable fade in ">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.implode('<br>', $errors).'</div>';

                                }
                            ?>

                            <?php if ($showForm = true){?>

                                <form method="POST">
                                    <div class="form-group">
                                        <label>Entrez votre nouveau mdp</label>
                                        <input type="password" class="form-control" name="password">
                                        <label>Répéter votre mot de passe</label>
                                        <input class="form-control" type="password"  name="password2">
                                        <input type="hidden" name="id" value="<?php echo $_GET['idUser']; ?>">
                                        <button type="submit">Réinitialiser le mdp</button>
                                    </div>
                                </form>                      
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            
<?php $this->stop('header') ?>

<?php $this->start('main_content') ?>

<?php $this->stop('main_content') ?>