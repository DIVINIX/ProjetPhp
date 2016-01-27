<?php
session_start();
require('src/classAlbum.php');

require('include/header.php')
?>

<div class="container">
    <div id="margin_bottom">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Liste des enregistrements
                    <small><?php
                        $codeMusicien = $_GET["code"];
                        $con = new classAlbum("ETD","ETD");
                        $con->album($codeMusicien);
                        ?>
                    </small>
                </h1>
            </div>
        </div>

        <div id="margin_bottom">
            <?php

            $codeAlbum = $_GET["code"];
            $con = new classAlbum("ETD","ETD");
            $con->listeEnregistrement($codeAlbum);


            ?>
        </div>
    </div>
</div>
<?php require('include/footer.php') ?>
