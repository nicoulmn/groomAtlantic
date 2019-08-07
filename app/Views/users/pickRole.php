<?php $this->layout('layoutTestNico', ['title' => 'Connexion / Inscription', 'title2' => 'Groom Atlantic']) ?>

<?php $this->start('header') ?>

            <div class="container">
                <div class="table">
                    <div class="header-text">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <h2 class="light white">Etes-vous:</h2>
                                <a href="<?=  $this->url('users_addGroom') ?>"><button type="button" class="btn btn-link">Groom</button></a>
                                <a href="<?=  $this->url('users_addOwner') ?>"><button type="button" class="btn btn-link">Propriétaire</button></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

<?php $this->stop('header') ?>

<?php $this->start('main_content') ?>

<?php $this->stop('main_content') ?>