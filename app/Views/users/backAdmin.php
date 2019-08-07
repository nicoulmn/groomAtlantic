<?php $this->layout('layoutTestNico', ['title' => 'Espace administrateur']) ?>

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
                    <h2 class="light white text-center">Espace Administrateur</h2>
                    <table>
                        <tr>
                            <th>ID</th>
                            <th>Prénom</th>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Addresse</th>
                            <th>Code Postal</th>
                            <th>Ville</th>
                            <th>Date d'inscription</th>
                            <th>Role</th>
                            <th>Exclusion</th>
                        </tr>
                        <?php
                        foreach($usersList as $user){
                        ?>
                        <tr>
                            <td><?= $user['id']; ?></td>
                            <td><?= $user['firstname']; ?></td>
                            <td><?= $user['lastname']; ?></td>
                            <td><?= $user['email']; ?></td>
                            <td><?= $user['phone']; ?></td>
                            <td><?= $user['address']; ?></td>
                            <td><?= $user['postcode']; ?></td>
                            <td><?= $user['cityUser']; ?></td>
                            <td><?= $user['date_creation']; ?></td>
                            <td><?= $user['role']; ?></td>                           
                            <td>    
                            <form method="POST">
                                <input type="hidden" name="banned" value="<?php if($user['banned'] == '0'){ echo '1'; } else { echo '0'; } ?>" >
                                <input type="hidden" name="id" value="<?=$user['id'];?>" >
                                <button type="submit" class="btn btn-default" name="je_le_banni"><?php if($user['banned'] == '0'){ echo 'bannir'; } else { echo 'Dé-bannir'; } ?></button>
                            </form>
                            </td>
                        </tr>
                    <?php
                    }
                        ?>
                    </table>
                <br><br>
                <button type="submit" class="btn btn-default">Valider</button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->stop('main_content') ?>
