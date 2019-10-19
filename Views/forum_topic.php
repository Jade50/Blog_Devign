<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <base href="/Devign_2/">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" type="text/css" href="./assets/css/style.css">
    <script src="./assets/js/jquery.min.js"></script>
    <title>Topic</title>

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

            <div class="main">

                <div class="forum-subcat-title">
                    <figure class="picto-forum-topic"><img src="" alt="">
                        <img src="assets/img/ressources/<?php echo $ForumsubCategory->getPicto(); ?>" alt="">  
                    </figure>
                    <div>
                    <div>
                        <p><?php echo $ForumCategory->getName(); ?> -&nbsp;<span><?php echo $ForumsubCategory->getName(); ?></span></p>
                    </div>
                    <div class="delimit"></div>
                    </div>
                </div>

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
               
                    if (!empty($topic)) {
                        ?>
                            <div class="topic">
                                <p><?php echo $topic->getSubject(); ?></p>
                            </div>

                            <div class="creator-topic">
                                <div class="topic-creator-avatar">
                                    <a href="/Devign_2/User/Profile/<?php echo $topic->getUser()->getId(); ?>">
                                        <img class="back" src="./assets/img/rond.png" alt="">
                                        <div class="img-avatar"><img class="front" src="./assets/img/avatars/<?php echo $topic->getUser()->getAvatar(); ?>" alt=""></div>
                                    </a>
                                </div>

                                <div>
                                    <div>
                                        <p>Par <span><?php echo $topic->getUser()->getFirstName();?></span></p>
                                        <p>Le <?php echo date('d/m/Y', strtotime($topic->getDate()));?></p>
                                    </div>

                                    <p><?php echo $topic->getContent(); ?></p>
                                </div>
                            </div>

                            <?php
                                if (!empty($messages)) {
                                    foreach ($messages as $message) {
                            ?>
                                        <div class="message-topic">
                                            <div class="blue-topics"></div>
                                            <div class="message-creator-avatar">
                                                <a href="/Devign_2/User/Profile/<?php echo $message->getUser()->getId(); ?>">
                                                    <div class="img-message-creator-avatar">
                                                        <figure><img src="./assets/img//avatars/<?php echo $message->getUser()->getAvatar(); ?>" alt=""></figure>
                                                    </div>
                                                </a>
                                            </div>

                                            <div class="message-creator">
                                                <p>Par <span><?php echo $message->getUser()->getFirstName();?></span></p>
                                                <p>Le <?php echo date('d/m/Y', strtotime($message->getDate()));?></p>
                                                <p><?php echo $message->getContent(); ?></p>
                                            </div>
                                                   
                                        </div>
                                        <?php
                                        }
                                } else {
                                    ?>
                                    <div class="msg-no-connect">
                                        <p>Aucune réponse pour ce topic, soyez le premier à poster un message</p>
                                    </div>
                                    <?php
                                }

                            if (isset($_SESSION['devign']['userId'])) {
                                   
                            ?>
    <!------------------------------------------------------------------------------>
    <!--------------------------------FORMULAIRE MESSAGE---------------------------->
    <!------------------------------------------------------------------------------>
                            <p class="new-topic">< Répondre à ce sujet ></p>

                            <form class="form-add-msg" action="/Devign_2/ForumTopics/newMessage" method="POST" novalidate>

                                <input type="text" name="message" placeholder="Entrez votre réponse"/>
                                <input type="hidden" name="user" value="<?php echo $_SESSION['devign']['userId']; ?>"/>
                                
                                <input type="hidden" name="topic" value="<?php echo $topic->getId(); ?>"/>
                                <input class="submit" type="submit" value="Répondre">

                            </form>
                            <?php

                             } else {
                                ?>
                                    <div class="msg-no-connect">
                                        <p><a href="/Devign_2/User/connexion">Veuillez vous connecter pour poster un message</a></p>
                                    </div>
                                <?php
                             }
                    }
                ?>

            </div>
    
       </main>
       
  </body>
</html>