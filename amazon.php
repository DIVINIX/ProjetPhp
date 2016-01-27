<?php
session_start();

require('src/AmazonECS.php'); //nom de la classe téléchargée
const Aws_ID = "AKIAJ5TGZU744CQHFQFA"; // Identifiant
const Aws_SECRET = "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"; //Secret
const associateTag="190571010520"; // AssociateTag
$client = new AmazonECS(Aws_ID, Aws_SECRET, 'FR', associateTag);

require('include/header.php');
?>
    <div class="container">
        <br><br><br>
        <?php
        $asin = $_GET['ASIN'];
        if($asin != null)
        {
            //$response = $client->responseGroup('Large')->lookup($title);
            $response = $client->responseGroup('Large')->lookup($asin);
            $items = $response->Items;
            if (empty($response->Items->Item))
            {
                echo "Le code ASIN est n'est pas ou plus valable.";
            }
            else
            {
                $item = $items->Item;

                echo '<h2>'.$item->ItemAttributes->Title.'</h2>';
                echo '<p><a href="'.$item->DetailPageURL.'" target="_blank">Lien Amazon</a></p>';
                //
                echo '<div class="row"><div class="col-lg-6">';
                echo '<br><p>Quelques informations:</p><br>';
                if (isset($item->ItemAttributes->Artist)) { echo "<p>Auteur : ".$item->ItemAttributes->Artist."</p>"; } else { echo "<p>Auteur : Aucune information</p>"; }
                if (isset($item->ItemAttributes->ListPrice->FormattedPrice)) { echo "<p>Prix : ".$item->ItemAttributes->ListPrice->FormattedPrice."</p>"; } else { echo "<p>Prix : Aucune information</p>"; }
                if (isset($item->SalesRank)) { echo "<p>Rang : ".$item->SalesRank."</p>"; } else { echo "<p>Rang : Aucune information</p>"; }
                if (isset($item->ItemAttributes->ReleaseDate)) { echo "<p>Date de sortie : ".$item->ItemAttributes->ReleaseDate."</p>"; } else { echo "<p>Date de sortie : Aucune information</p>"; }
                echo '</div><div class="col-lg-6">';
                if (isset($item->LargeImage))
                    echo "<p><img src='".$item->LargeImage->URL."' alt='Pochette' widht='350' height='350'/></p>";
                else
                    echo "<p>Aucune image</p>";
                echo '</div></div>';
            }
        }
        else
            echo "<h3>Il n'y a aucun code ASIN</h3>";
        ?>
    </div>
<?php require('include/footer.php') ?>