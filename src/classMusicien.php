<?php
require('classBD.php');

class classMusicien extends connexion
{

    public function __construct($user, $password)
    {
        parent::__construct($user,$password);

    }

    public function musicien($code)
    {
        $pdo= new PDO(parent::getPDOdsn(),parent::getUser(),parent::getPassword());
        $requete = "Select Nom_Musicien, Prénom_Musicien from Musicien Where Code_Musicien = :code ";
        $stmt = $pdo->prepare($requete);
        $stmt->execute(array(':code' =>$code));
        foreach($stmt as $row)
        {
            echo $row['Nom_Musicien'] .'  '. $row[utf8_decode('Prénom_Musicien')];
        }
    }

    public function infoArtiste($codeMusicien){
        $pdo= new PDO(parent::getPDOdsn(),parent::getUser(),parent::getPassword());
        $requete = "Select Nom_Musicien,Prénom_Musicien, Année_Naissance,Année_Mort,Libellé_Abrégé, Nom_Pays
                    from Musicien
                    inner join Genre on Genre.Code_genre = Musicien.Code_Genre
                    inner join Pays on Pays.Code_Pays = Musicien.Code_Pays
                    Where Code_Musicien = :code";
        $stmt = $pdo->prepare($requete);
        $stmt->execute(array(':code' => $codeMusicien));
        foreach ($stmt as $row)
        {
            echo '<div class="row">';
            echo '<div class="col-sm-6 col-md-4">';
            echo '</div>';
            echo '<div class="col-sm-6 col-md-4">';
            echo '<a href="#" class="thumbnail">';
            echo '<img src="image.php?Code='.$codeMusicien.'" height=>';
            echo '</a>';
            echo '</div>';
            echo'</div>';


            $nom = $row['Nom_Musicien'];
            $prenom = $row[utf8_decode('Prénom_Musicien')];
            $naissance = $row[utf8_decode('Année_Naissance')];
            $mort = $row[utf8_decode('Année_Mort')];
            $genre = $row[utf8_decode('Libellé_Abrégé')];
            $pays = $row['Nom_Pays'];

            echo '<table class="table">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>Nom</th>';
            echo '<th>Prénom</th>';
            echo '<th>Naissaince</th>';
            echo '<th>Mort</th>';
            echo '<th>Genre</th>';
            echo '<th>Pays</th>';
            echo '</tr>';
            echo ' </thead>';

            echo '<tbody>';
            echo '<tr>';
            echo '<td>'.$nom.'</td>';
            echo '<td>'.$prenom.'</td>';
            echo '<td>'.$naissance.'</td>';
            echo '<td>'.$mort.'</td>';
            echo '<td>'.$genre.'</td>';
            echo '<td>'.$pays.'</td>';
            echo '</tr>';
            echo '</tbody>';

            echo '</table>';

        }
    }

    public function musicienInitiale($requete,$type){
        $pdo= new PDO(parent::getPDOdsn(),parent::getUser(),parent::getPassword());

        $stmt = $pdo->query($requete);
        if ($stmt->rowCount() == 0)
        {
            if($type == 1)
                echo '<div class="alert alert-danger" role="alert">Aucun compositeur trouvé pour cette initiale.</div>';

            elseif($type == 2)
                echo '<div class="alert alert-danger" role="alert">Aucun interpréte trouvé pour cette initiale.</div>';


            else
                echo '<div class="alert alert-danger" role="alert">Aucun chef d\'orchestre trouvé pour cette initiale.</div>';
        }

        else {
            foreach ($stmt as $row) {

                $nom = $row["Nom_Musicien"];
                $prenom = $row[utf8_decode('Prénom_Musicien')];
                $code = $row['Code_Musicien'];
                echo ' <div class="col-xs-6 col-md-3">';
                echo '<div class="thumbnail">';
                echo '<img src="image.php?Code=' . $row['Code_Musicien'] . '" height=>' . '<br>';
                echo '<div class="caption">';
                echo '<p><h4>' . $nom . '  ' . $prenom . '</h4></p>';
                echo '<p><a href="listeAlbum.php?code=' . $code.'&type='.$type. '" class="btn btn-primary" role="button">Albums</a> <a href="infosArtiste.php?code=' .$code.'&type='.$type.'" class="btn btn-default" role="button">Infos artiste</a></p>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        }
        $pdo = null;
    }

    public function musicienAnnee($anneeDebut, $anneeFin,$type){
        $pdo= new PDO(parent::getPDOdsn(),parent::getUser(),parent::getPassword());

        if($type == 1)
        {
            $requete = "Select distinct Musicien.Code_Musicien,Musicien.Nom_Musicien, Musicien.Prénom_Musicien
                        from Musicien
                        Inner Join Composer on Musicien.Code_Musicien = Composer.Code_Musicien
                        Where Musicien.Année_Naissance >= :anneeDebut and Musicien.Année_Mort <= :anneeFin";
        }

        elseif($type == 2)
        {
            $requete = "Select distinct Musicien.Code_Musicien,Musicien.Nom_Musicien, Musicien.Prénom_Musicien, Nom_Instrument
                        from Interpréter
                        inner join Musicien on Musicien.Code_Musicien = Interpréter.Code_Musicien
                        inner join Instrument on Instrument.Code_Instrument = Interpréter.Code_Instrument
                        inner join Enregistrement on Enregistrement.Code_Morceau = Interpréter.Code_Morceau
                        Where Musicien.Année_Naissance >= :anneeDebut and Musicien.Année_Mort <= :anneeFin";
        }

        else
        {
            $requete = "Select distinct Musicien.Code_Musicien,Musicien.Nom_Musicien, Musicien.Prénom_Musicien
                        from Musicien
                        Inner Join Direction on Direction.Code_Musicien = Musicien.Code_Musicien
                        Where Musicien.Année_Naissance >= :anneeDebut and Musicien.Année_Mort <= :anneeFin";
        }

        $stmt = $pdo->prepare($requete);

        $stmt->execute(array(':anneeDebut' => $anneeDebut,':anneeFin' => $anneeFin));
        if ($stmt->rowCount() == 0)
        {
            if($type == 1)
                echo '<div class="alert alert-danger" role="alert">Aucun compositeur trouvé pour cette période.</div>';


            elseif($type == 2)
                echo '<div class="alert alert-danger" role="alert">Aucun interpréte trouvé pour cette période.</div>';


            else
                echo '<div class="alert alert-danger" role="alert">Aucun chef d\'orchestre trouvé pour cette période.</div>';
        }

        else {
            foreach ($stmt as $row) {

                $nom = $row["Nom_Musicien"];
                $prenom = $row[utf8_decode('Prénom_Musicien')];
                $code = $row['Code_Musicien'];
                echo ' <div class="col-xs-6 col-md-3">';
                echo '<div class="thumbnail">';
                echo '<img src="image.php?Code=' . $row['Code_Musicien'] . '" height=>' . '<br>';
                echo '<div class="caption">';
                echo '<p><h4>' . $nom . '  ' . $prenom . '</h4></p>';
                echo '<p><a href="listeAlbum.php?code=' . $code.'&type='.$type. '" class="btn btn-primary" role="button">Albums</a> <a href="infosArtiste.php?code=' .$code.'&type='.$type.'" class="btn btn-default" role="button">Infos artiste</a></p>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
        }
        $pdo = null;
    }

    public function listeOeuvreAnnee($annee)
    {
        $pdo= new PDO(parent::getPDOdsn(),parent::getUser(),parent::getPassword());
        $requeteOeuvre = "SELECT Code_Oeuvre,Titre_Oeuvre, Année,Libellé_Type
                          FROM Oeuvre
                          INNER JOIN Type_Morceaux on Type_Morceaux.Code_type = Oeuvre.Code_Type
                          WHERE Année = :annee";
        $stmt = $pdo->prepare($requeteOeuvre);
        $stmt->execute(array(':annee' => $annee));

        if ($stmt->rowCount() == 0)
            echo '<div class="alert alert-danger" role="alert">Aucune oeuvre trouvé pour cette année</div>';

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