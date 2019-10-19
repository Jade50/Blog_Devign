<?php

    if (!isset($_SESSION['devign']['userId'])) {
      header('Location: index.php?ctrl=User&action=connexion');
      exit();
    }

?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <base href="/Devign_2/">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="./assets/css/style.css">
    <script src="./assets/js/jquery.min.js"></script>
    <title>Modifier le profil</title>

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
        <section class="globale-profile">

    <!--...................NAV PROFILE.....................-->
    <?php
        include('nav_profile.php');
    ?>
    <!--...................PROFILE........................-->
            <div class="my-profile">

                <h5>MODIFIER MON PROFIL</h5>
                <div class="delimit"></div>
                <?php
                    // -----------------------Affichage des messages d'erreurs--------------------
                    if (isset($_GET['url'])) {
                        $url = explode('/', $_GET['url']);
                        if (isset($url[3])) {
                        ?>
                            <div class="alert-msg" role="alert"> <?= $url[3]; ?></div>
                        <?php
                        }
                    }
                ?>
                <div class="update-my-profile">

                    <form action="/Devign_2/User/updateProfileTreat/" method="POST">
                        <div class="update-form">
                            <div>
                                <input name="user" type="hidden" value="<?php echo $user->getId(); ?>">
                                <input name="name" type="text" placeholder="<?php echo $user->getName(); ?>" value="<?php echo $user->getName(); ?>">
                                <input name="first-name" type="text" placeholder="<?php echo $user->getFirstname(); ?>" value="<?php echo $user->getFirstname(); ?>">
                                <input name="mail" type="email" placeholder="<?php echo $user->getMail(); ?>" value="<?php echo $user->getMail(); ?>">
                                <input name="mail-confirm" type="email" placeholder="<?php echo $user->getMail(); ?>" value="<?php echo $user->getMail(); ?>">
                                <input type="submit" class="submit" value="modifier">
                            </div>
                            <div>
                                <input name="pwd" type="password" placeholder="Mot de passe">
                                <input name="pwd-confirm" type="password" placeholder="Confirmation de mot de passe">
                                <textarea name="desc" id="" cols="30" rows="7" value="<?php echo $user->getAbout(); ?>"><?php echo $user->getAbout(); ?></textarea>
                            </div>
                        </div>
                    </form>

                </div>

                <div class="update-avatar">
                    <figure>
                        <img class="front" src="./assets/img//avatars/<?php echo $user->getAvatar(); ?>" alt="">
                    </figure>


                    <div class="form-update-avatar">
                    <p class="new-topic">&lt; Modifier mon avatar &gt;</p>
                        <form action="/Devign_2/User/changeAvatar/<?php echo $user->getId(); ?>" method="POST" enctype="multipart/form-data">

                        <div class="input-file-container">
                            <input type="file" name="avatar" class="input-file">
                            <label for="my-file" class="input-file-trigger submit" tabindex="0">Charger une nouvelle photo de profil</label>
                            </div>
                            <input class="submit" type="submit" value="modifier ma photo">
                        </form>
                    </div>
                </div>     
            </div>

        </section>

    </main>
       
  </body>
</html>