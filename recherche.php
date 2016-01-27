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

require('include/header.php');
?>

    <div class="container">
        <div id="margin_bottom">
            <?php if (isset($_POST["Code_Album"])){ ?>
                <div class="alert alert-success" role="alert">Cette albumTOTO à été ajouté dans votre panier.</div>
            <?php } ?>
            <div class="row">
                <div class="col-lg-12">
                    <h2>Rechercher un élément :</h2>
                    <form method="post" action="recherche.php">
                        <input type="text" class="form-control" name="Search" placeholder="Search...">
                        <br>
                        <button type="submit" class="btn btn-primary btn-lg btn-block"> Rechercher</button></div>
                <div class="col-md-4"></div>
            </div>

            </form>
        </div>

        <hr>
        <div id="margin_bottom">
            <?php
            if (isset($_POST["Search"]))
            {
                $recherche = $_POST["Search"];
                $con = new classRecherche("ETD","ETD");
                $con->recherche($recherche);
            }
            else
            {
                echo '<div class="alert alert-danger" role="alert">Il n\'y a rien à rechercher.</div>';
            }
            ?>
        </div>
    </div>
<?php require('include/footer.php') ?>