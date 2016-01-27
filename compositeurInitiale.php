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
                    <small>Par initiale</small>
                </h1>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-12">
                <h2 class="center">Veuillez séléctionner une lettre</h2>
            </div>
        </div>


        <form method="post" action="compositeurInitiale.php" class="form-signin">

            <select name="lettre" class="form-control">
                <option>A</option>
                <option>B</option>
                <option>C</option>
                <option>D</option>
                <option>E</option>
                <option>F</option>
                <option>G</option>
                <option>H</option>
                <option>I</option>
                <option>J</option>
                <option>K</option>
                <option>L</option>
                <option>M</option>
                <option>N</option>
                <option>O</option>
                <option>P</option>
                <option>Q</option>
                <option>R</option>
                <option>S</option>
                <option>T</option>
                <option>U</option>
                <option>V</option>
                <option>W</option>
                <option>X</option>
                <option>Y</option>
                <option>Z</option>
            </select>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Séléctionner</button>
        </form>

        <div id="margin_bottom"></div>

        <?php
        if (isset($_POST['lettre']))
        {
            $con = new classMusicien("ETD","ETD");
            $lettre = $_POST['lettre'];
            $type=1;
            $con->musicienInitiale("Select distinct Musicien.Code_Musicien,Musicien.Nom_Musicien,Musicien.Prénom_Musicien
                                    from Musicien
                                    Inner Join Composer on Musicien.Code_Musicien = Composer.Code_Musicien
                                    Where Musicien.Nom_Musicien Like '$lettre%' ",$type);
        }
        ?>

    </div>
</div>


<?php require('include/footer.php') ?>
