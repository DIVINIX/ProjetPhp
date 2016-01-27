<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Projet PHP</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

</head>

<body>
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand">Projet PHP</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li><a href="index.php">Accueil</a></li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Musicien <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li class="dropdown-header">Compositeurs</li>
                        <li><a href="compositeurInitiale.php">Initiale</a></li>
                        <li><a href="compositeurAnnee.php">Année</a></li>

                        <li role="separator" class="divider"></li>

                        <li class="dropdown-header">Interpètes</li>
                        <li><a href="interpreteInitiale.php">Initiale</a></li>
                        <li><a href="interpreteAnnee.php">Année</a></li>

                        <li role="separator" class="divider"></li>


                        <li class="dropdown-header">Chef d'orchestre</li>
                        <li><a href="orchestreInitiale.php">Initiale</a></li>
                        <li><a href="orchestreAnnee.php">Année</a></li>

                        <li role="separator" class="divider"></li>

                        <li><a href="rechercheMusicien.php">Recherche</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Album <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="albumGenre.php">Genre</a></li>
                        <li><a href="albumAnnee.php">Année</a></li>

                        <li role="separator" class="divider"></li>

                        <li><a href="rechercheAlbum.php">Recherche</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Oeuvre <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="oeuvreAnnee.php">Année</a></li>

                        <li role="separator" class="divider"></li>

                        <li><a href="rechercheOeuvre.php">Recherche</a></li>
                    </ul>
                </li>
                <li><a href="about.php">A propos</a></li>

            </ul>

            <ul class="nav navbar-nav navbar-right">


                <?php if (isset($_SESSION["NOM_USER"])) { ?>
                    <li><a href="panier.php">Panier <span class="badge">
                                <?php
                                $nombre = 0;
                                foreach ($_SESSION["PANIER"] as $values)
                                    $nombre += $values[1];
                                echo $nombre;
                                ?>
                            </span>
                        </a>
                    </li>

                    <li><a href='profil.php' >Profil </a></li>

                    <div class="navbar-form navbar-right">
                        <li><a href="connexion.php" class="btn btn-danger">Déconnexion</a></li>

                    </div>
                <?php } else{ ?>

                    <div class="navbar-form navbar-right">
                        <li><a href="connexion.php" class="btn btn-success">Connexion</a></li>
                    </div>

                    <div class="navbar-form navbar-right">
                        <li><a href="inscription.php" class="btn btn-primary">Inscription</a></li>
                    </div>

                <?php } ?>
            </ul>
            <form class="navbar-form navbar-right" role="search" method="post" action="recherche.php">
                <div class="form-group">
                    <input type="text" class="form-control" name="Search" placeholder="Search...">
                </div>
                <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span></button>
            </form>
        </div>
    </div>
</nav>