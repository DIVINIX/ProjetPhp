<?php
session_start();
require('src/classRecherche.php');

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
                <h2>Rechercher un album :</h2>
                <form method="post" action="rechercheAlbum.php">
                    <input type="text" class="form-control" name="Search" placeholder="Search...">
                    <br>

                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary btn-lg btn-block"> Rechercher</button></div>
                        <div class="col-md-4"></div>
                    </div>

                </form>
            </div>
        </div>
        <hr>

        <div id="margin_bottom"></div>

        <?php

        if (isset($_POST["Search"]))
        {
            $recherche = $_POST["Search"];
            $con = new classRecherche("ETD","ETD");
            $con->rechercheAlbum($recherche);
        }
        ?>

    </div>
</div>


<?php require('include/footer.php') ?>
