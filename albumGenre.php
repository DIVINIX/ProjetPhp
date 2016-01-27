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
                <h2 class="center">Veuillez séléctionner une lettre</h2>
            </div>
        </div>


        <form method="post" action="albumGenre.php" class="form-signin">

            <select name="genre" class="form-control">
                <option>Moyen Age</option>
                <option>Renaissance</option>
                <option>Baroque</option>
                <option>Classique</option>
                <option>Romantique</option>
                <option>Moderne</option>
                <option>Contemporain</option>
                <option>Jazz</option>
                <option>Rock</option>
                <option>Pop</option>
                <option>Acid Rock</option>
                <option>Chanson française</option>
                <option>Opera</option>
                <option>Latin</option>
                <option>Salsa</option>
                <option>Afrique</option>
                <option>Rai</option>
                <option>Rap</option>
                <option>Hip-Hop</option>
                <option>Musique Sacrée</option>
                <option>Soundtrack</option>
                <option>Otario</option>
                <option>Comedy</option>
                <option>Musique ancienne</option>
                <option>Inconnu</option>
            </select>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Séléctionner</button>
        </form>

        <div id="margin_bottom"></div>

        <?php
        if (isset($_POST['genre']))
        {
            $con = new classAlbum("ETD","ETD");
            $genre = $_POST['genre'];
            $con->listeAlbumGenre($genre);
        }
        ?>

    </div>
</div>


<?php require('include/footer.php') ?>
