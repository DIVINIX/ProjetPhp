<?php
session_start();
require('src/classMusicien.php');

require('include/header.php')
?>

<div class="container">
    <div id="margin_bottom">

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Recherche des oeuvres
                    <small>Par année</small>
                </h1>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <h2 class="center">Veuillez entrer une année de recherche</h2>
            </div>
        </div>


        <form class="form-signin" method="post" action="oeuvreAnnee.php" >

            <label class="sr-only">Année naissance</label>
            <input name="anneeRecherche" type="text" id="inputAnneeRecherche" class="form-control" placeholder="Année recherche" required autofocus>

            <button class="btn btn-lg btn-primary btn-block" type="submit">Envoyer</button>
        </form>

        <div id="margin_bottom"></div>

        <?php
        if (isset($_POST['anneeRecherche']))
        {
            $con = new classMusicien("ETD","ETD");
            $anneeRecherche = $_POST['anneeRecherche'];
            $con->listeOeuvreAnnee($anneeRecherche);
        }
        ?>

    </div>
</div>


<?php require('include/footer.php') ?>
