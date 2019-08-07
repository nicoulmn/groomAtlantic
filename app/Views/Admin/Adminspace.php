

<?php $this->layout('layoutTestNico', ['title' => 'Espace administrateur']) ?>


<?php $this->start('css') ?>
    <style>
        header {
            display: none;
        }        


    </style>
<?php $this->stop('css') ?>

<?php $this->start('main_content') ?>
  
    <div id="DivSearch" class="container";>
        <div class="table">
            <div class="header-text">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h2 style="color:#f06467" class="light white">Admin</h2>
                </div>
            </div>
        </div>
    </div>

<?php $this->stop('main_content') ?>
