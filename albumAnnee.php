<?php
session_start();
require('src/classAlbum.php');

//Gestion du panier
if (isset($_SESSION["PANIER"]))
{
    $panier = $_SESSION["PANIER"];
    if (isset($_POST["Code_Album"]))
    {
        $trouve = false;
        $i = 0;
        while(!$trouve && $i<count($panier))
        {
            if ($_POST["Code_Album"] == $panier[$i][0])
            {
                $panier[$i][1]++;
                $trouve = true;
            }
            $i++;
        }
        if (!$trouve)
            $panier[] = array($_POST["Code_Album"], 1);
    }
    $_SESSION["PANIER"] = $panier;
}

require('include/header.php')
?>

<div class="container">
    <div id="margin_bottom">

        <?php if (isset($_POST["Code_Album"])){ ?>
            <div class="alert alert-success" role="alert">Cette album à été ajouté dans votre panier.</div>
        <?php } ?>
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Liste des albums
                    <small>Par année</small>
                </h1>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <h2 class="center">Veuillez entrer une année de recherche</h2>
            </div>
        </div>

        <form class="form-signin" method="post" action="albumAnnee.php" >

            <label class="sr-only">Année naissance</label>
            <input name="anneeRecherche" type="text" id="inputAnneeRecherche" class="form-control" placeholder="Année recherche" required autofocus>

            <button class="btn btn-lg btn-primary btn-block" type="submit">Envoyer</button>
        </form>

        <div id="margin_bottom"></div>

        <?php
        if (isset($_POST['anneeRecherche']))
        {
            $con = new classAlbum("ETD","ETD");
            $anneeRecherche = $_POST['anneeRecherche'];
            $con->listeAlbumAnnee($anneeRecherche);
        }
        ?>

    </div>
</div>


<?php require('include/footer.php') ?>
