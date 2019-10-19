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

    <title>Conversations</title>

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
        <!-- <div id="cursor"></div> -->
    <!--...................NAV PROFILE.....................-->
    <?php
        include('nav_profile.php');
    ?>
        
    <!--...................PROFILE........................-->
        <div class="my-profile">

            <h5>VOS CONVERSATIONS </h5>
            <div class="delimit"></div>
          
            <div class="all-users">

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

                if (!empty($convs)) {
                    ?>

                    <?php
                    foreach ($convs as $conv) {
                        ?>
                        <a href="/Devign_2/Conversation/showConversation/<?php echo $conv->getId(); ?>">
                           <div class="user-view">

                            <div class="view-convs">
                                <div class="blue blue-thin"></div>

                                <div class="userview-avatar">
                                    <div class="img-message-creator-avatar">
                                        <figure><img src="./assets/img/avatars/<?php 
                                        if ($conv->getUserOne()->getId() == $_SESSION['devign']['userId']) {
                                            echo $conv->getUsertwo()->getAvatar();
                                        } else {
                                            echo $conv->getUserone()->getAvatar();
                                        } ?>" alt=""></figure>
                                    </div>
                                </div>

                                <div class="user-pres">
                                    <p class="name"><?php if ($conv->getUserOne()->getId() == $_SESSION['devign']['userId']) {
                                            echo $conv->getUsertwo()->getFirstname();
                                        } else {
                                            echo $conv->getUserone()->getFirstname();
                                        } ?></p>
                                    <div class="delimit"></div>
                                    <p>Inscrit depuis le : <?php if ($conv->getUserOne()->getId() == $_SESSION['devign']['userId']) {
                                            echo date('d.m.Y', strtotime($conv->getUsertwo()->getInscription()));
                                        } else {
                                            echo date('d.m.Y', strtotime($conv->getUserone()->getInscription()));
                                        } ?></p>
                                </div>

                                <div>
                                    <p>Dernier Message</p>
                                    <p>Par : <?php echo $conv->getLastmessage()->getUserfrom()->getFirstname(); ?></p>
                                    <p><?php echo substr($conv->getLastmessage()->getMessage(), 0, 100); ?>...</p>
                                </div>

                                <div>
                                <p><?php echo $conv->getNbmessages(); ?> Messages</p>
                            </div>
                            </div>
                           </div>
                           </a>
                        <?php 
                    }
                } else {
                    ?>
                        <div class="no-topics">
                            <p>Aucune conversation</p>
                        </div>
                    <?php
                }
               ?>
            </div>
        </div>

        </section>

    </main>
       <script>

            $(".delete-user").on("click", function(){
                var id = $(this).attr("id");
                if ($("#delete-confirm-"+id).is(":visible")) {

                    $("#delete-confirm-"+id).slideUp();
                }
                else {
                    $("#delete-confirm-"+id).slideDown();
                    $("#dont-delete-"+id).on("click", function(){
                        $("#delete-confirm-"+id).slideUp();
                    });
                }
            });

       </script>
  </body>
</html>