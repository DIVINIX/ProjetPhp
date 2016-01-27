<?php
session_start();
require('src/classAlbum.php');

require('src/classMusicien.php');

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
                    <h1 class="page-header">Liste des albums de
                        <small><?php
                            $codeMusicien = $_GET["code"];
                            $con = new classMusicien("ETD","ETD");
                            $con->musicien($codeMusicien);
                            ?>
                        </small>
                    </h1>
                </div>
            </div>

            <div id="margin_bottom">
                <?php

                $codeMusicien = $_GET["code"];
                $type = $_GET["type"];
                $con = new classAlbum("ETD","ETD");
                $con->listeAlbum($codeMusicien,$type);

                $pdo = null;

                ?>
            </div>
        </div>
    </div>
<?php require('include/footer.php') ?>