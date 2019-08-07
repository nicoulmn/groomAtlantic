<?php $this->layout('layoutTestNico', ['title' => 'Modifier mon profil']) ?>

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
                    <div class="col-md-12 text-left">
						<?php if(count($errors) > 0): ?>
							<p style="color:red;"><?=implode('<br>', $errors); ?></p>
						<?php endif; ?>
						<form method="POST" enctype="multipart/form-data">
							<div class="form-group">
								<label for="photo"><h4>Ajouter une photo de profil</h4></label>
								<input type="file" name="photo" >
							</div>
							<div class="form-group">
								<label for="firstname"><h4>Prénom</h4></label>
								<input name="firstname" type="text" class="form-control" value="<?=$w_user['firstname']; ?>">
							</div>
							<div class="form-group">
								<label for="lastname"><h4>Nom</h4></label>
								<input name="lastname" type="text" class="form-control" value="<?=$w_user['lastname']; ?>">
							</div>
							<div class="form-group">
								<label for="email"><h4>Email</h4></label>
								<input name="email" type="text" class="form-control" value="<?=$w_user['email']; ?>">
							</div>
							<div class="form-group">
								<label for="phone"><h4>Téléphone</h4></label>
								<input name="phone" type="text" maxlength="10" class="form-control" value="<?=$w_user['phone']; ?>">
							</div>
							<div class="form-group">
								<label for="address"><h4>Adresse</h4></label>
								<input name="address" type="text" class="form-control" value="<?=$w_user['address']; ?>">
							</div>
							<div class="form-group">
								<label for="postcode"><h4>Code postal</h4></label>
								<input name="postcode" type="text" class="form-control" value="<?=$w_user['postcode']; ?>">
							</div>
							<div class="form-group">
								<label for="cityUser"><h4>Ville</h4></label>
								<input name="cityUser" type="text" class="form-control" value="<?=$w_user['cityUser']; ?>">
							</div>
							<div class="form-group text-center">
								<button type="submit" class="btn btn-default">Modifier</button>
							</div>
						</form>
					<div class="form-group text-center">
						<a href="<?= $this->url('users_showowner')?>" class="btn btn-default">Retour</a>
					</div>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php $this->stop('main_content') ?>
