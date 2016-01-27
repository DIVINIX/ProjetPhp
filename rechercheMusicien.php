<?php
session_start();
require('src/classRecherche.php');

require('include/header.php');
?>

    <div class="container">
        <div id="margin_bottom">
            <?php if (isset($_POST["Code_Album"])){ ?>
                <div class="alert alert-success" role="alert">Cette album à été ajouté dans votre panier.</div>
            <?php } ?>
            <div class="row">
                <div class="col-lg-12">
                    <h2>Rechercher un musicien :</h2>
                    <form method="post" action="rechercheMusicien.php">
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
            <div id="margin_bottom">
                <?php
                if (isset($_POST["Search"]))
                {
                    $recherche = $_POST["Search"];
                    $con = new classRecherche("ETD","ETD");
                    $con->rechercheMusicien($recherche);
                }
                ?>
            </div>
        </div>
    </div>
<?php require('include/footer.php') ?>