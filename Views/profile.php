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
    <title>Profil</title>

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
    <div class="hide-nav-profile">
    <?php
        include('nav_profile.php');
    ?>
    </div>
    <!--...................PROFILE........................-->
        <div class="user-profile">

            <h5>Profil de <span><?php echo $user->getFirstName(); ?></span></h5>
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
            <div class="profile">

                <div class="avatar">
                    <img class="back" src="./assets/img/rond.png" alt="">
                    <div class="img-avatar"><img class="front" src="./assets/img//avatars/<?php echo $user->getAvatar(); ?>" alt=""></div>
                </div>

                <div class="about">
                    <p>À propos de <?php echo $user->getFirstname(); ?></p>

                    <div class="user-profile-role">
                    <?php
                        switch ($user->getRoleId()) {
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
                        <p><?php echo $user->getRoleName(); ?></p>
                    </div>
                    <p>Inscrit depuis le <?php echo date('d.m.Y', strtotime($user->getInscription())); ?></p>
                    <?php
                    if ($user->getAbout() != NULL) {
                        ?>
                        <p><?php echo $user->getAbout(); ?></p>
                        <?php
                    } else {
                        ?>
                        <p><?php echo $user->getFirstName(); ?> n'a pas encore renseigné de description.</p>
                        <?php
                    }
                    if (isset($_SESSION['devign']['userId'])) {
                        if (empty($conv)) {
                            ?>
                                <form action="/Devign_2/Conversation/CreateConversation" method="POST" class="send-msg">
                                    <input type="hidden" name="usr-from" value="<?php echo $_SESSION['devign']['userId']; ?>">
                                    <input type="hidden" name="usr-to" value="<?php echo $user->getId(); ?>">
                                    <input type="submit" class="submit" value="Démarrer une conversation avec <?php echo $user->getFirstname(); ?>">
                                </form>
                            <?php
                        } else {
                        ?>
                            <a href="/Devign_2/Conversation/showConversation/<?php echo $conv['cov_id']; ?>">
                                <div class="link-send-msg submit">
                                    Voir votre conversation avec <?php echo $user->getFirstname(); ?>
                                </div>
                            </a>
                        <?php
                        }
                    } else {
                        ?>
                        <a href="/Devign_2/User/connexion">
                            <div class="link-send-msg submit">
                                Connectez-vous pour envoyer un message à <?php echo $user->getFirstName(); ?>
                            </div>
                        </a>
                    <?php
                    }
                    ?>                   
                </div>
            </div>

            <div class="icons">
                        <div class="cards-profile">
                            <div>
                                <div class="blue-round"></div>
                                <div class="vertical-delimit"></div>
                            </div>
                            <div>
                                <p class="cards-title">Sujets Postés</p>
                                <div class="nb-cards">
                                    <p><?php echo $nbTopics; ?></p>
                                    <i class="fas fa-laptop-code"></i>
                                </div>
                            </div>
                        </div>

                        <?php
                            if ($user->getRoleId() == 1 || $user->getRoleId() == 2) {
                                ?>
                                    <div class="cards-profile">
                                        <div>
                                            <div class="blue-round"></div>
                                            <div class="vertical-delimit"></div>
                                        </div>
                                        <div>
                                            <p class="cards-title">Articles Postés</p>
                                            <div class="nb-cards">
                                                <p><?php echo $nbArticles; ?></p>
                                                <i class="fas fa-pencil-alt"></i>
                                            </div>
                                        </div>
                                    </div>

                                <?php
                            }
                        ?>
                    </div>
        </div>

        </section>

    </main>
       
  </body>
</html>