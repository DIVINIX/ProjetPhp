<?php
require('classBD.php');

class classAlbum extends connexion
{

    public function __construct($user, $password)
    {
        parent::__construct($user,$password);
    }

    public function album($code)
    {
        $pdo= new PDO(parent::getPDOdsn(),parent::getUser(),parent::getPassword());
        $requete = "Select Titre_Album from Album Where Code_Album = :code ";
        $stmt = $pdo->prepare($requete);
        $stmt->execute(array(':code' =>$code));
        foreach($stmt as $row)
        {
            echo $row['Titre_Album'];
        }
    }

    public function panierAlbum($codeAlbum)
    {
        $pdo= new PDO(parent::getPDOdsn(),parent::getUser(),parent::getPassword());
        $requete = "SELECT DISTINCT Code_Album,Titre_Album FROM Album WHERE Code_Album = :code";
        $stmt = $pdo->prepare($requete);
        $stmt->execute(array(':code' => $codeAlbum));
        $resultat = $stmt->fetch();

        echo "<td>" . $resultat['Titre_Album'] . "</td>";

        $pdo = null;
    }

    public function amazonASIN($codeAlbum)
    {
        $pdo = new PDO(parent::getPDOdsn(),parent::getUser(),parent::getPassword());
        $requete = "SELECT DISTINCT Code_Album,Titre_Album,ASIN FROM Album WHERE Code_Album = :code";
        $stmt = $pdo->prepare($requete);
        $stmt->execute(array(':code' => $codeAlbum));
        $resultat = $stmt->fetch();

        if ($resultat['ASIN'] != null)
            echo '<td><a href="amazon.php?ASIN=' .$resultat['ASIN'].'">Info Amazon</a></td>';
        else
            echo '<td>Aucun lien disponible</td>';

        $pdo = null;

    }

    public function listeAlbum($codeMusicien,$type)
    {
        $pdo = new PDO(parent::getPDOdsn(), parent::getUser(), parent::getPassword());

        if ($type == 1) {
            $requete = "SELECT DISTINCT Album.Code_Album,Album.Titre_Album
                        FROM Album INNER JOIN Disque ON Disque.Code_Album = Album.Code_Album
                        INNER JOIN Composition_Disque ON Composition_Disque.Code_Disque = Disque.Code_Disque
                        INNER JOIN Enregistrement ON Enregistrement.Code_Morceau = Composition_Disque.Code_Morceau
                        INNER JOIN Composition ON Composition.Code_Composition = Enregistrement.Code_Composition
                        INNER JOIN Composition_Oeuvre ON Composition_Oeuvre.Code_Composition = Composition.Code_Composition
                        INNER JOIN Oeuvre ON Oeuvre.Code_Oeuvre = Composition_Oeuvre.Code_Oeuvre
                        INNER JOIN Composer ON Composer.Code_Oeuvre = Oeuvre.Code_Oeuvre
                        INNER JOIN Musicien ON Musicien.Code_Musicien = Composer.Code_Musicien
                        WHERE Musicien.Code_Musicien = :code";
        } elseif ($type == 2) {
            $requete = "SELECT DISTINCT Album.Code_Album,Album.Titre_Album
                        FROM Album
                        INNER JOIN Disque ON Disque.Code_Album = Album.Code_Album
                        INNER JOIN Composition_Disque ON Composition_Disque.Code_Disque = Disque.Code_Disque
                        INNER JOIN Enregistrement ON Enregistrement.Code_Morceau = Composition_Disque.Code_Morceau
                        INNER JOIN Interpréter on Interpréter.Code_Morceau = Enregistrement.Code_Morceau
                        INNER JOIN Musicien on Interpréter.Code_Musicien = Musicien.Code_Musicien
                        WHERE Musicien.Code_Musicien = :code";
        } elseif ($type == 3) {
            $requete = "SELECT DISTINCT Album.Code_Album,Album.Titre_Album
                        FROM Album
                        INNER JOIN Disque ON Disque.Code_Album = Album.Code_Album
                        INNER JOIN Composition_Disque ON Composition_Disque.Code_Disque = Disque.Code_Disque
                        INNER JOIN Enregistrement on Enregistrement.Code_Morceau = Composition_Disque.Code_Morceau
                        INNER JOIN Direction on Direction.Code_Morceau = Enregistrement.Code_Morceau
                        INNER JOIN Musicien on Direction.Code_Musicien = Musicien.Code_Musicien
                        WHERE Musicien.Code_Musicien = :code";
        } else
            echo '<div class="alert alert-danger" role="alert">Aucun album trouvé pour ce musicien</div>';

        if ($type != -1) {
            $stmt = $pdo->prepare($requete);
            $stmt->execute(array(':code' => $codeMusicien));

            if ($stmt->rowCount() == 0)
                echo '<div class="alert alert-danger" role="alert">Aucun album trouvé pour ce musicien</div>';

            else {
                echo '<table class="table">';
                echo '<thead>';
                echo '<tr>';
                echo '<th>Code Album</th>';
                echo '<th>Titre Album</th>';
                echo '<th>Détail</th>';
                echo '<th>Ajouter au panier</th>';
                echo '<th>Amazon</th>';
                echo '</tr>';
                echo ' </thead>';

                foreach ($stmt as $row) {
                    echo '<tbody>';
                    echo '<tr>';
                    echo '<td>' . $row['Code_Album'] . '</td>';
                    echo '<td>' . $row['Titre_Album'] . '</td>';
                    echo '<td><a href="listeEnregistrement.php?code=' . $row['Code_Album'] . '" class="btn btn-primary" role="button">Détails</a></td>';
                    if (isset($_SESSION["NOM_USER"]))
                        echo '<td><form method="post" action="listeAlbum.php?code=' . $codeMusicien . '&type='.$type.'"><input type="hidden" name="Code_Album" value="' . $row['Code_Album'] . '"><button class="btn btn-success" type="submit">Ajouter</button></form></td>';
                    else
                        echo '<td><a href="connexion.php" class="btn btn-success">Se connecter pour acheter</a><td>';
                    $this->amazonASIN($row['Code_Album']);
                    echo '</tr>';
                    echo '</tbody>';

                }
            }

            echo '</table>';
            $pdo = null;
        }
    }

    public function listeAlbumAnnee($anneeRecherche)
    {
        $pdo = new PDO(parent::getPDOdsn(),parent::getUser(),parent::getPassword());

        $requete = "SELECT DISTINCT Album.Code_Album,Album.Titre_Album
                    FROM Album
                    WHERE Album.Année_Album = :anneeRecherche";

        $stmt = $pdo->prepare($requete);
        $stmt->execute(array(':anneeRecherche' => $anneeRecherche));

        if ($stmt->rowCount() == 0)
            echo '<div class="alert alert-danger" role="alert">Aucun album trouvé pour cette année</div>';

        else{
            echo '<table class="table">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Code Album</th>';
            echo '<th>Titre Album</th>';
            echo '<th>Détail</th>';
            echo '<th>Ajouter au panier</th>';
            echo '<th>Amazon</th>';
            echo '</tr>';
            echo ' </thead>';

            foreach ($stmt as $row) {
                echo '<tbody>';
                echo '<tr>';
                echo '<td>'.$row['Code_Album'].'</td>';
                echo '<td>'.$row['Titre_Album'].'</td>';
                echo '<td><a href="listeEnregistrement.php?code=' .$row['Code_Album'].'" class="btn btn-primary" role="button">Détails</a></td>';
                if (isset($_SESSION["NOM_USER"]))
                    echo '<td><form method="post" action="albumAnnee.php"><input type="hidden" name="Code_Album" value="' .$row['Code_Album'].'"><button class="btn btn-success" type="submit">Ajouter</button></form></td>';
                else
                    echo '<td><a href="connexion.php" class="btn btn-success">Se connecter pour acheter</a><td>';
                $this->amazonASIN($row['Code_Album']);
                echo '</tr>';
                echo '</tbody>';
            }
        }

        echo '</table>';
        $pdo = null;
    }

    public function listeAlbumGenre($genre)
    {
        $pdo = new PDO(parent::getPDOdsn(),parent::getUser(),parent::getPassword());

        $requete = "SELECT DISTINCT Album.Code_Album,Album.Titre_Album
                    FROM Album
                    INNER JOIN Genre on Genre.Code_Genre = Album.code_Genre
                    WHERE Genre.Libellé_Abrégé  LIKE '%".$genre."%'";

        $stmt = $pdo->query($requete);

        if ($stmt->rowCount() == 0)
            echo '<div class="alert alert-danger" role="alert">Aucun album trouvé pour ce genre</div>';

        else{
            echo '<table class="table">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Code Album</th>';
            echo '<th>Titre Album</th>';
            echo '<th>Détail</th>';
            echo '<th>Ajouter au panier</th>';
            echo '<th>Amazon</th>';
            echo '</tr>';
            echo ' </thead>';

            foreach ($stmt as $row) {
                echo '<tbody>';
                echo '<tr>';
                echo '<td>'.$row['Code_Album'].'</td>';
                echo '<td>'.$row['Titre_Album'].'</td>';
                echo '<td><a href="listeEnregistrement.php?code=' .$row['Code_Album'].'" class="btn btn-primary" role="button">Détails</a></td>';
                if (isset($_SESSION["NOM_USER"]))
                    echo '<td><form method="post" action="albumGenre.php"><input type="hidden" name="Code_Album" value="' .$row['Code_Album'].'"><button class="btn btn-success" type="submit">Ajouter</button></form></td>';
                else
                    echo '<td><a href="connexion.php" class="btn btn-success">Se connecter pour acheter</a><td>';
                $this->amazonASIN($row['Code_Album']);
                echo '</tr>';
                echo '</tbody>';

            }
        }

        echo '</table>';
        $pdo = null;
    }

    public function listeEnregistrement($codeAlbum)
    {
        $pdo = new PDO(parent::getPDOdsn(),parent::getUser(),parent::getPassword());
        $requete = "SELECT Enregistrement.Code_Morceau,Enregistrement.Titre,Enregistrement.Prix FROM Enregistrement INNER JOIN Composition_Disque ON Composition_Disque.Code_Morceau = Enregistrement.Code_Morceau INNER JOIN Disque ON Disque.Code_Disque = Composition_Disque.Code_Disque INNER JOIN Album ON Album.Code_Album = Disque.Code_Album WHERE Album.Code_Album = :code";
        $stmt = $pdo->prepare($requete);
        $stmt->execute(array(':code' => $codeAlbum));

        echo '<table class="table">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Code Oeuvre</th>';
        echo '<th>Titre oeuvre</th>';
        echo '<th>Prix</th>';
        echo '<th>Extrait</th>';
        echo '</tr>';
        echo ' </thead>';

        foreach ($stmt as $row) {
            echo '<tbody>';
            echo '<tr>';
            echo '<td>'.$row['Code_Morceau'].'</td>';
            echo '<td>'.$row['Titre'].'</td>';
            echo '<td>'.$row['Prix'].'</td>';
            echo '<td><audio controls="controls"><source src="musique.php?Code=' . $row['Code_Morceau'] .'" type="audio/mp3" /> Votre navigateur ne supporte pas le format audio.</audio> </td>';
            echo '</tr>';
            echo '</tbody>';
        }

        echo '</table>';
        $pdo = null;
    }
}