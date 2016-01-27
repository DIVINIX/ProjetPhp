<?php
session_start();
if (!isset($_SESSION["NOM_USER"]))
{
    header("Location: connexion.php");
}

require('src/classAbonne.php');
require('include/header.php');
?>
<div class="container" xmlns="http://www.w3.org/1999/html">
    <div id="margin_bottom">

        <h3>Information du profil</h3>

        <div class="row">
            <div class="col-lg-6">
                <?php
                $con = new classAbonne("ETD","ETD");
                $con->infoProfil();
                $profil = $con->arrayProfil();
                ?>
            </div>
            <div class="col-lg-6">
                <form method="post" action="src/traitementProfil.php">
                    <input name="Nom" type="text" class="form-control" placeholder="Nom" value="<?php echo $profil[0]; ?>" required autofocus>
                    <input name="Prénom" type="text" class="form-control" placeholder="Prénom" value="<?php echo $profil[1]; ?>" required >
                    <input name="Login" type="text" class="form-control" placeholder="Login" value="<?php echo $profil[2]; ?>" required >
                    <input name="Password" type="password" class="form-control" placeholder="Password" value="<?php echo $profil[3]; ?>" required>

                    <!-- Bouton -->
                    <button class="btn btn-lg btn-primary" type="reset">Reset</button>
                    <button class="btn btn-lg btn-primary" type="submit">Modifier</button>
                </form>
            </div>
        </div>


    </div>
</div>

<?php require('include/footer.php') ?>
