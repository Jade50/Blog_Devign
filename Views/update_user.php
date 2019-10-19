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

                <h5>MODIFIER LE PROFIL DE <?php echo $userView->getFirstname(); ?></h5>
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

                    <form action="/Devign_2/User/updateUserTreat/" method="POST">
                        <div class="update-form">
                            <div>
                                <input name="user" type="hidden" value="<?php echo $userView->getId(); ?>">
                                <input name="name" type="text" placeholder="<?php echo $userView->getName(); ?>" value="<?php echo $userView->getName(); ?>">
                                <input name="first-name" type="text" placeholder="<?php echo $userView->getFirstname(); ?>" value="<?php echo $userView->getFirstname(); ?>">
                                <input name="mail" type="email" placeholder="<?php echo $userView->getMail(); ?>" value="<?php echo $userView->getMail(); ?>">
                                <input name="mail-confirm" type="email" placeholder="<?php echo $userView->getMail(); ?>" value="<?php echo $userView->getMail(); ?>">
                                <input type="submit" class="submit" value="modifier">
                            </div>
                            <div>
                            <div class="select-profile">
                                <?php
                                    switch ($userView->getRoleId()) {
                                        case '1':
                                            ?><i class="fas fa-key"></i><i class="fas fa-key"></i><?php
                                            break;
                                        case '2':
                                            ?><i class="fas fa-key"></i><?php
                                            break;
                                        case '3':
                                            ?><i class="fas fa-user"></i><?php
                                            break;  
                                     }
                                ?>
                                <select name="role" id="">
                                        <?php
                                            foreach ($roles as $role) {
                                                ?>
                                                    <option <?php if ($userView->getRoleid() == $role['id']) {
                                                        echo "selected";
                                                    } ?> value="<?php echo $role['id']; ?>"><?php echo $role['name']; ?></option>
                                                <?php
                                            }
                                        ?>
                                    </select>
                                </div>           
                                <input name="pwd" type="password" placeholder="Mot de passe">
                                <input name="pwd-confirm" type="password" placeholder="Confirmation de mot de passe">
                                <textarea name="desc" id="" cols="30" rows="4" value="<?php echo $userView->getAbout(); ?>"><?php echo $userView->getAbout(); ?></textarea>
                            </div>
                        </div>
                    </form>

                </div>

                <div class="update-avatar">
                    <figure>
                        <img class="front" src="./assets/img//avatars/<?php echo $userView->getAvatar(); ?>" alt="">
                    </figure>


                    <div class="form-update-avatar">
                    <p class="new-topic">&lt; Modifier l'avatar de <?php echo $userView->getFirstname(); ?> &gt;</p>

                        <form action="/Devign_2/User/changeAvatarUser/<?php echo $userView->getId(); ?>" method="POST" enctype="multipart/form-data">

                        <div class="input-file-container">
                            <input type="file" name="avatar" class="input-file">
                            <label for="my-file" class="input-file-trigger submit" tabindex="0">Charger une nouvelle photo de profil</label>
                            </div>
                            <input class="submit" type="submit" value="modifier l'avatar">
                        </form>

                    </div>
                </div>     
            </div>

        </section>

    </main>
       
  </body>
</html>