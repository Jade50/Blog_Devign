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

            if (!empty($topics)) {
                
                ?>
                    <div class="topics-titles">
                        <p>Sujet</p>
                        <p>Messages</p>
                        <p>Dernier message</p>
                        <p>Créateur</p>
                    </div>

                    <?php
                        foreach ($topics as $topic) {
                    ?>
                            <div class="topics">

                                <div class="blue-topics"></div>

                                <div>
                                    <p class="topic-subject"><a href="/Devign_2/ForumTopics/Topic/<?php echo $topic->getId(); ?>"><?php echo $topic->getSubject(); ?></a></p>
                                </div>

                                <div>
                                    <p class="topic-nb-messages"><?php echo $topic->getNbMessages(); ?></p>
                                </div>

                                <div>
                                    <p>
                                    <?php 
                                        if (!empty($LastMessages)) {
                                            foreach ($LastMessages as $lastMessage) {
                                                if ($lastMessage->getTopic() == $topic->getId()) {
                                                    echo substr($lastMessage->getContent(), 0, 80).'...';
                                                }
                                            }
                                        }
                                        if ($topic->getNbMessages() == 0) {
                                            echo 'Aucun message pour ce topic';
                                        }
                                        ?>
                                    </p>

                                </div>

                                <div class="user-created-topic">
                                    <div>
                                        <p>Par <span><?php echo $topic->getUser()->getFirstName();?></span></p>
                                        <p>Le <?php echo date('d/m/Y', strtotime($topic->getDate()));?></p>
                                    </div>
                                 
                                    <figure class="avatar_user_created-topic">
                                        <img src="assets/img//avatars/<?php echo $topic->getUser()->getAvatar(); ?>" alt="">
                                    </figure>
                                </div>
                            </div>
                                
                                <?php
                            }

            } else {
                ?>
                    <div class="no-topics">
                        <p>Aucun sujet pour cette catégorie</p>
                        <a href="#">Soyez le premier à poster un sujet !</a>
                    </div>
                <?php
            }
            /*------------------------------------------------------------------------------*/
            /*--------------------------FORMULAIRE NOUVEAU TOPIC----------------------------*/
            /*------------------------------------------------------------------------------*/
            if (isset($_SESSION['devign']['userId'])) {
                                   
                ?>
                <p class="new-topic">< Créer un sujet ></p>

                <form class="form-add-topic" action="/Devign_2/ForumCategory/newTopic/" method="POST" novalidate>

                    <input type="text" name="subject" placeholder="Sujet"/>

                    <textarea name="content">Entrez votre demande</textarea>

                    <input type="hidden" name="user" value="<?php echo $_SESSION['devign']['userId']; ?>"/>

                    <input type="hidden" name="subcategory" value="<?php echo $ForumsubCategory->getId(); ?>"/>

                    <input class="submit" type="submit" value="Poster ce sujet">

                </form>
                <?php

                 } else {
                    ?>
                        <div class="msg-no-connect">
                            <p><a href="/Devign_2/User/connexion">Veuillez vous connecter pour poster un sujet</a></p>
                        </div>
                    <?php
                 }
            ?>
            </div>
    
       </main>
       
  </body>
</html>