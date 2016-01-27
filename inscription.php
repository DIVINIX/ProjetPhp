<?php
session_start();
if (isset($_SESSION["NOM_USER"]))
{
    header("Location: profil.php");
}

require('include/header.php')
?>

<div class="container">
    <div id="margin_bottom">


        <?php
        if(isset($_POST["nom"]) && isset($_POST["prenom"]) && isset($_POST["user"]) && isset($_POST["password"])) {
            $nom = $_POST["nom"];
            $prenom = $_POST["prenom"];
            $login = $_POST["user"];
            $password = $_POST["password"];

            require('src/classAbonne.php');
            $con = new classAbonne("ETD","ETD");
            $con->inscription($nom,$prenom,$login,$password);
        }

        else {
            ?>

            <div class="row">
                <div class="col-lg-12">
                    <h2 class="center">Veuillez renseigner les champs</h2>
                </div>
            </div>

            <form class="form-signin" method="post" action="inscription.php" >


                <label class="sr-only">Nom</label>
                <input name="nom" type="text" id="inputEmail" class="form-control" placeholder="Nom" required autofocus>

                <label class="sr-only">Prénom</label>
                <input name="prenom" type="text" id="inputEmail" class="form-control" placeholder="Prenom" required autofocus>

                <label class="sr-only">Login</label>
                <input name="user" type="text" id="inputEmail" class="form-control" placeholder="Login" required autofocus>

                <label for="inputPassword" class="sr-only">Password</label>
                <input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password" required>


                <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
            </form>

            <?php
        }
        ?>

    </div>
</div>

<?php require('include/footer.php') ?>
