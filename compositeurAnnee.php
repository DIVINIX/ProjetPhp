<?php
session_start();
require('src/classMusicien.php');

require('include/header.php')
?>

<div class="container">
    <div id="margin_bottom">

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Liste des compositeurs
                    <small>Par année</small>
                </h1>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <h2 class="center">Veuillez entrer une année de naissance et de mort</h2>
            </div>
        </div>


        <form class="form-signin" method="post" action="compositeurAnnee.php" >

            <label class="sr-only">Année naissance</label>
            <input name="anneeNaissance" type="text" id="inputAnneeNaissance" class="form-control" placeholder="Année naissance" required autofocus>

            <label class="sr-only">Année mort</label>
            <input name="anneeMort" type="text" id="inputAnneeMort" class="form-control" placeholder="Année mort" required>


            <button class="btn btn-lg btn-primary btn-block" type="submit">Envoyer</button>
        </form>

        <div id="margin_bottom"></div>

        <?php
        if (isset($_POST['anneeNaissance']) && isset($_POST['anneeMort']))
        {
            $con = new classMusicien("ETD","ETD");
            $anneeNaissance = $_POST['anneeNaissance'];
            $anneeMort = $_POST['anneeMort'];
            $con->musicienAnnee($anneeNaissance, $anneeMort,1);
        }
        ?>

    </div>
</div>


<?php require('include/footer.php') ?>
