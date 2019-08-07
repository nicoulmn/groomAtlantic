<?php $this->layout('layoutTestNico', ['title' => 'Modifier mes services']) ?>
<?php $this->start('css') ?>
<style>
 header {
    display: none;
}

body{
    background: #89b5f7;
}

.cMonTableauCollapse2 {
          width:600px;
          border-collapse: collapse;
          border: 5px solid #ffffff;
        }

        .cMonTableauCollapse2 th, .cMonTableauCollapse2 td {
          border: 5px solid #ffffff;
        }
</style>
<?php $this->stop('css') ?>
<?php $this->start('main_content') ?>
<div class="table">
    <div class="header-text">
        <div id="DivFormG" class="row">
            <?php if(count($errors) > 0): ?>
                <p style="color:red;"><?=implode('<br>', $errors); ?></p>
            <?php endif; ?>
            <form method="POST">
                <h4 class="light white text-center">Ajouter Ma description</h4>
                    <textarea name="description" rows="10" cols="50"></textarea>
                    <div class="container">
                        <table id="TabComp" class="cMonTableauCollapse2">
                            <tr>
                                <label for="checkIn">
                                    <td>Check-in</td>
                                    <td><input type="checkbox" name="id_skill[]" value="1"></td>
                                    <td><input type="text" name="price[]" value=""></td>
                                </label>
                            </tr>
                            <br>
                            <br>
                            <tr>
                                <label for="checkOut">
                                    <td>Check-out</td>
                                    <td><input type="checkbox" name="id_skill[]" value="2"></td>
                                    <td><input type="text" name="price[]" value=""></td>
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
                            <label for="fixing">
                                    <td>Petit bricolage / Réparations</td>
                                    <td><input type="checkbox" name="id_skill[]" value="6"></td>
                                    <td><input type="text" name="price[]" value=""></td>
                                </label>
                                <br>
                            </tr>
                        </table>
                    <br>
                  <button type="submit" class="btn btn-blue">Modifier mes services</button>  
                </div>
            <br>
            </form>
            <a href="<?= $this->url('users_showgroom')?>" class="btn btn-blue">Retour</a>
        </div>
    </div>
</div>

<?php $this->stop('main_content') ?>
