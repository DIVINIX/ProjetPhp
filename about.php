<?php
session_start();

require('include/header.php')
?>
<div class="container">
    <div id="margin_bottom">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Qui sommes nous ?
                </h1>
            </div>
        </div>
        <div class="row text-center">
            <div class="col-sm-6"><img class="img-thumbnail" src="img/gauthier.jpg" alt="Generic placeholder image" width="140" height="140"><h2>ABOMNES Gauthier</h2>
                <ul class="list-inline text-center">
                    <li>
                        <a href="https://twitter.com/gabomnes?lang=fr">
                                <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
                                </span>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.facebook.com/AbomnesGauthier?fref=ts">
                                <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
                                </span>
                        </a>
                    </li>
                    <li>
                        <a href="https://bitbucket.org/Gauwan/">
                                <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-bitbucket fa-stack-1x fa-inverse"></i>
                                </span>
                        </a>
                    </li>
                </ul>

            </div>

            <div class="col-sm-6"><img class="img-thumbnail" src="img/yann.jpg" alt="Generic placeholder image" width="140" height="140"><h2>BRETHEAU Yann</h2><ul class="list-inline text-center">
                    <li>
                        <a href="https://twitter.com/YannBretheau?lang=fr">
                                <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
                                </span>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.facebook.com/yann.bretheau">
                                <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
                                </span>
                        </a>
                    </li>
                    <li>
                        <a href="https://bitbucket.org/Divinix/">
                                <span class="fa-stack fa-lg">
                                    <i class="fa fa-circle fa-stack-2x"></i>
                                    <i class="fa fa-bitbucket fa-stack-1x fa-inverse"></i>
                                </span>
                        </a>
                    </li>
                </ul></div>
        </div>

        <br>

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Notre projet web
                    <small>Site de e-commerce</small>
                </h1>
            </div>
        </div>
        <p> Nous avons créé ce site de e-commerce en PHP. Le but était de réaliser un site vitrine en utilisant la base classique_Web.</p>
        <br>
        <p>Nous avons réalisé les fonctionnalités sivantes :</p>
        <ul>
            <li>Un système de recheche dans la base de donnée</li>
            <li>Un système de compte pour les utilisateurs</li>
            <li>Un panier pour pouvoir acheter des albums</li>
            <li>Une redirection vers amazon.</li>
        </ul>

        <br>
    </div>
</div>


<?php require('include/footer.php') ?>
