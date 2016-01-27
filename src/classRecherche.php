<?php
require('classBD.php');

class classRecherche extends connexion
{

    public function __construct($user, $password)
    {
        parent::__construct($user,$password);

    }

    public function recherche($recherche)
    {
        $this->rechercheAlbum($recherche);

        echo '<br><br>';

        $this->rechercheMusicien($recherche);

        echo '<br><br>';

        $this->rechercheOeuvre($recherche);
    }

    public function rechercheMusicien($recherche)
    {
        $pdo= new PDO(parent::getPDOdsn(),parent::getUser(),parent::getPassword());
        $requeteMusicien = "SELECT Code_Musicien,Nom_Musicien FROM Musicien WHERE Nom_Musicien LIKE '%".$recherche."%'";

        $reqeteTestCompositeur = " Select count(*) AS cpt
                                    from Musicien
                                    Inner Join Composer on Musicien.Code_Musicien = Composer.Code_Musicien
                                    Where Musicien.Code_Musicien=:code";
        $requeteTestInterprete = "Select distinct count(*) AS cpt
                                from Interpréter
                                inner join Musicien on Musicien.Code_Musicien = Interpréter.Code_Musicien
                                inner join Instrument on Instrument.Code_Instrument = Interpréter.Code_Instrument
                                inner join Enregistrement on Enregistrement.Code_Morceau = Interpréter.Code_Morceau
                                where Musicien.Code_Musicien = :code";
        $requeteTestOrchestre = "select count(*) AS cpt from Musicien
                                    inner join Direction on Direction.COde_Musicien = Musicien.Code_Musicien
                                    where Musicien.Code_Musicien=:code";

        $stmtM = $pdo->prepare($requeteMusicien);
        $stmtM->execute();
        echo '<h1>Recherche dans les musiciens:</h1>';

        if ($stmtM->rowCount() == 0)
            echo '<div class="alert alert-danger" role="alert">Aucun musicien trouvé pour cette recherche.</div>';
        else
        {
            echo '<table class="table">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Code</th>';
            echo '<th>Nom</th>';
            echo '<th>Informations</th>';
            echo '<th>Ses Albums</th>';
            echo '</tr>';
            echo ' </thead>';

            foreach ($stmtM as $row) {
                $type = 0;
                $stmt1 = $pdo->prepare($reqeteTestCompositeur);
                $stmt1->execute(array($row["Code_Musicien"]));

                $stmt2 = $pdo->prepare($requeteTestInterprete);
                $stmt2->execute(array(':code'=>$row["Code_Musicien"]));

                $stmt3 = $pdo->prepare($requeteTestOrchestre);
                $stmt3->execute(array(':code'=>$row["Code_Musicien"]));

                $data1 = $stmt1->fetch();
                $cpt1 = $data1['cpt'];

                $data2 = $stmt2->fetch();
                $cpt2 = $data2['cpt'];

                $data3 = $stmt3->fetch();
                $cpt3 = $data3['cpt'];

                if ($cpt1 > 0 )
                    $type = 1;
                elseif($cpt2 >0)
                    $type = 2;
                elseif($cpt3 >0)
                    $type = 3;
                else
                    $type = -1;
                $code = $row["Code_Musicien"];

                echo '<tbody>';
                echo '<tr>';
                echo '<td>'.$row["Code_Musicien"].'</td>';
                echo '<td>'.$row["Nom_Musicien"].'</td>';
                echo '<td><a href="infosArtiste.php?code=' . $code . '&type='.$type.'" class="btn btn-default" role="button">Infos artiste</a></td>';
                if($type == -1)
                    echo '<td>Aucun album</td>';
                else
                    echo '<td><a href="listeAlbum.php?code=' . $code.'&type='.$type.'" class="btn btn-primary" role="button">Albums</a></td>';

                echo '</tr>';
                echo '</tbody>';
            }
            echo '</table>';
        }
    }

    public function rechercheAlbum($recherche)
    {
        $pdo= new PDO(parent::getPDOdsn(),parent::getUser(),parent::getPassword());
        $requeteAlbum = "SELECT Code_Album,Titre_Album FROM Album WHERE Titre_Album like '%" . $recherche . "%' ";

        $stmtA = $pdo->prepare($requeteAlbum);
        $stmtA->execute();
        echo '<h1>Recherche dans les albums:</h1>';

        if ($stmtA->rowCount() == 0)
            echo '<div class="alert alert-danger" role="alert">Aucun album trouvé pour cette recherche.</div>';
        else {
            echo '<table class="table">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Code</th>';
            echo '<th>Titre</th>';
            echo '<th>D&eacute;tails</th>';
            echo '<th>Acheter</th>';
            echo '</tr>';
            echo ' </thead>';

            foreach ($stmtA as $row) {
                echo '<tbody>';
                echo '<tr>';
                echo '<td>' . $row["Code_Album"] . '</td>';
                echo '<td>' . $row['Titre_Album'] . '</td>';
                echo '<td><a href="listeEnregistrement.php?code=' . $row['Code_Album'] . '" class="btn btn-primary" role="button">Détails</a></td>';
                if (isset($_SESSION["NOM_USER"]))
                    echo '<td><form method="post" action="rechercheAlbum.php"><input type="hidden" name="Search" value="' . $recherche . '"><input type="hidden" name="Code_Album" value="' . $row['Code_Album'] . '"><button class="btn btn-success" type="submit">Ajouter</button></form></td>';
                else
                    echo '<td><a href="connexion.php" class="btn btn-success">Se connecter pour acheter</a><td>';
                echo '</tr>';
                echo '</tbody>';
            }
            echo '</table>';
        }
    }

    public function rechercheOeuvre($recherche)
    {
        $pdo= new PDO(parent::getPDOdsn(),parent::getUser(),parent::getPassword());
        $requeteOeuvre = "SELECT Code_Oeuvre,Titre_Oeuvre, Année,Libellé_Type
                          FROM Oeuvre
                          INNER JOIN Type_Morceaux on Type_Morceaux.Code_type = Oeuvre.Code_Type
                          WHERE Titre_Oeuvre like '%".$recherche."%'";
        $stmt = $pdo->prepare($requeteOeuvre);
        $stmt->execute();

        if ($stmt->rowCount() == 0)
            echo '<div class="alert alert-danger" role="alert">Aucune oeuvre trouvée pour cette année</div>';

        else
        {
            echo '<table class="table">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Code</th>';
            echo '<th>Nom</th>';
            echo '<th>Année</th>';
            echo '<th>Type</th>';
            echo '</tr>';
            echo ' </thead>';

            foreach ($stmt as $row) {
                echo '<tbody>';
                echo '<tr>';
                echo '<td>'.$row["Code_Oeuvre"].'</td>';
                echo '<td>'.$row["Titre_Oeuvre"].'</td>';
                echo '<td>'.$row[utf8_decode("Année")].'</td>';
                echo '<td>'.$row[utf8_decode("Libellé_Type")].'</td>';
                echo '</tr>';
                echo '</tbody>';
            }
            echo '</table>';
        }
        $pdo = null;
    }
}