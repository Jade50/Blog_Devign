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
    <title>Mon profil</title>

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

            <h5>Bienvenue <span><?php echo $user->getFirstName(); ?></span></h5>
            <div class="delimit-profile"></div>
          
            <div class="profile">

                <div class="avatar">
                    <img class="back" src="./assets/img/rond.png" alt="">
                    <div class="img-avatar"><img class="front" src="./assets/img//avatars/<?php echo $user->getAvatar(); ?>" alt=""></div>
                </div>

                <div class="about">
                    <p>À propos de moi</p>
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
                        <p>Vous n'avez pas encore ajouté votre description !</p>
                        <form action="/Devign_2/User/addDesc/" method="POST" class="add-about">
                        <input name="user" type="hidden" value="<?php echo $user->getId(); ?>">
                            <textarea name="desc" id="desc" cols="45" rows="2"></textarea>
                            <input class="submit" type="submit" value="Ajouter">
                        </form>
                        <?php
                    }
                    ?>                   
                    <!-- <p><?php echo $user->getAbout(); ?></p> -->
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

                        <div class="cards-profile">
                            <div>
                                <div class="blue-round"></div>
                                <div class="vertical-delimit"></div>
                            </div>
                            <div>
                                <p class="cards-title">Conversations</p>
                                <div class="nb-cards">
                                    <p><?php echo $nbConversations; ?></p>
                                    <i class="fas fa-comment-dots"></i>
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

                                    <div class="cards-profile">
                                        <div>
                                            <div class="blue-round"></div>
                                            <div class="vertical-delimit"></div>
                                        </div>
                                        <div>
                                            <p class="cards-title">Communauté</p>
                                            <div class="nb-cards">
                                                <p><?php echo $nbUsers; ?></p>
                                                <i class="fas fa-users"></i>
                                            </div>
                                        </div>
                                    </div>

                                <?php
                            }
                        ?>
                    </div>

                    <div class="creations">
                        <p>Créations</p>
                        <div class="delimit-profile"></div>  

                        <div class="all-creations hide-creations">
                            <div>
                                <figure>
                                    <img src="./assets/img/avatars/sarah.jpg" alt="">
                                </figure>
                            </div>
                            <div>
                                <figure>
                                    <img src="./assets/img/avatars/jade.jpg" alt="">
                                </figure>
                            </div>
                            <div>
                                <figure>
                                    <img src="./assets/img/avatars/malou.jpg" alt="">
                                </figure>
                            </div>
                            <div>
                                <figure>
                                    <img src="./assets/img/avatars/poline.jpg" alt="">
                                </figure>
                            </div>
                            <div>
                                <figure>
                                    <img src="./assets/img/avatars/test.jpg" alt="">
                                </figure>
                            </div>
                            <div>
                                <figure>
                                    <img src="./assets/img/avatars/sarah.jpg" alt="">
                                </figure>
                            </div>
                        </div>
                    </div>
                    <h5 class="more">+</h5>
        </div>

        </section>

    </main>
       
    <script>
        
            /* SEE COMMENT */
            $(".more").on("click", function(){

                // if ($("#comment_"+id).is(":visible")) {

                //     $("#comment_"+id).slideUp();
                // }
                // else {
                //     $("#comment_"+id).slideDown();
                // }
                // $(".all-creations").toggleClass("hide-creations");
                if ($(".all-creations").is(":visible")) {
                $(".all-creations").slideUp();
                } else {
                    $(".all-creations").slideDown();
                }
            });
    </script>
  </body>
</html>