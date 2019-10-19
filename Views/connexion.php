<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <base href="/Devign_2/">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" type="text/css" href="./assets/css/style.css">
    <script src="./assets/js/jquery.min.js"></script>
    <title>Inscription</title>

    <style>
        h1 {
            text-align: center;
        }
    </style>
  </head>
  <body>

    <!--...................NAV........................-->
    <section class="glob-index"></section>
    <?php
        include('nav.php');
    ?>

    
    
    <main>

        <div class="globale">
            <p class="titre-index">CONNEXION</p>
            <div class="container-index">
                <div class="container-form opac-form">

                    <?php
                        // -----------------------Affichage des messages d'erreurs--------------------
                        if (isset($_GET['url'])) {
                            $url = explode('/', $_GET['url']);
                            if (isset($url[2])) {
                            ?>
                                <div class="alert alert-primary" role="alert"> <?= $url[2]; ?></div>
                            <?php
                             }
                        }
                    ?>
                    <form action="/Devign_2/User/connectUser" method="POST" novalidate>
                        <?php
                        //----------------------------------------------------------------------------
                        //--------------------------FORMULAIRE D'INSCRPTION---------------------------
                        //----------------------------------------------------------------------------

                            // inputs et labels générés par les méthodes statics de la class Form
                            echo Form::input('email', 'email', 'email', 'Entrez votre Adresse mail');

                            echo Form::input('password', 'password', 'password', 'Entrez votre mot de passe');

                            echo Form::submit('Inscription', 'submit');

                            
                        ?>
                    </form>
                </div>

                <figure class="logo-small"><img src="./assets/img/logo-small.png" alt=""></figure>
            </div>
        </div>
       </main>
       
  </body>
</html>