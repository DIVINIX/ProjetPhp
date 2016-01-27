<?php
session_start();
if (isset($_SESSION["NOM_USER"]))
{
    session_destroy();
    header("Location: index.php");
}

require('include/header.php')
?>

<div class="container">
    <div id="margin_bottom">

        <?php
        if (isset($_GET["connex"])) { ?>

            <div class="alert alert-danger" role="alert">
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                <span class="sr-only">Error:</span>
                Login ou mot de passe invalide !
            </div>

            <?php
        }
        ?>

        <div class="row">
            <div class="col-lg-12">
                <h2 class="center">Veuillez entrer vos identifiants</h2>
            </div>
        </div>

        <form class="form-signin" method="post" action="src/traitementConnexion.php" >

            <label class="sr-only">Login</label>
            <input name="Login" type="text" id="inputEmail" class="form-control" placeholder="Login" required autofocus>

            <label for="inputPassword" class="sr-only">Password</label>
            <input name="Password" type="password" id="inputPassword" class="form-control" placeholder="Password" required>


            <button class="btn btn-lg btn-primary btn-block" type="submit">Connexion</button>
        </form>

    </div>
</div>

<?php require('include/footer.php') ?>
