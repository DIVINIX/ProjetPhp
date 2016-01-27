<?php
session_start();
if (!isset($_SESSION["NOM_USER"]))
{
    header("Location: connexion.php");
}

require('src/classAlbum.php');
$con = new classAlbum("ETD","ETD");

//Gestion du panier
$panier = $_SESSION["PANIER"];
if (isset($_POST["Code_Album"]))
{
    //Recherche
    $trouve = false;
    $i = 0;
    while(!$trouve && $i<count($panier))
    {
        if ($_POST["Code_Album"] == $panier[$i][0])
        {
            if ($panier[$i][1] > 1)
                $panier[$i][1]--;
            else
            {
                unset($panier[$i]); //On supprime l'article
                $panier = array_values($panier); //On ré-index le panier
            }
            $trouve = true;
        }
        $i++;
    }

    $_SESSION["PANIER"] = $panier;
}
//

require('include/header.php')
?>

<div class="container">
    <br><br><br>
    <?php if (isset($_POST["Code_Album"])) { echo '<div class="alert alert-success" role="alert"> L\'album a bien &eacute;t&eacute; supprim&eacute;e! </div>'; }?>
    <br>
    <?php if (count($panier) > 0) { ?>
    <table class="table">
        <thead>
        <tr>
            <td>Code Album</td>
            <td>Nom</td>
            <td>Quantit&eacute;</td>
            <td>Amazon</td>
            <td>Suppression</td>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($panier as $value)
        {
            echo "<tr>";
            echo "<td>" . $value[0] . "</td>";
            $con->panierAlbum($value[0]);
            echo "<td>" . $value[1] . "</td>";
            $con->amazonASIN($value[0]);
            echo '<td><form method="post" action="panier.php"><input type="hidden" name="Code_Album" value="'.$value[0].'"><button class="btn btn-lg btn-danger btn-block" type="submit">Supprimer</button></form></td>';
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
    <?php } else {?>
    <h2>Il n'y a aucun article dans votre panier.</h2>
    <?php } ?>
</div>

<?php require('include/footer.php') ?>