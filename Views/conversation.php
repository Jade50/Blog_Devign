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

    <title>Conversation</title>

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

            <h5>CONVERSATION</h5>
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
            <div class="conversation">

               <?php

                if (!empty($messages)) {
                   foreach ($messages as $message) {
                       ?>
                       <div class="msg-container">
                            <div class="message <?php echo $message->getClass(); ?>">

                                <div class="creator-msg">

                                    <div class="usermsg-avatar">
                                        <div class="img-message-avatar">
                                            <figure><img src="./assets/img/avatars/<?php echo $message->getUserfrom()->getAvatar(); ?>" alt=""></figure>
                                        </div>
                                    </div>

                                    <div>
                                        <p><?php echo $message->getUserfrom()->getFirstname(); ?></p>
                                        <p><?php echo date('d.m.Y à H:i', strtotime($message->getDate()));?></p>
                                    </div>
                                </div>

                                <p><?php echo $message->getMessage(); ?></p>
                            </div>
                            </div>
                       <?php
                   }
                } else {

                }
               ?>
            </div>
            <div class="form-msg">
                <form action="/Devign_2/Message/sendMessage" method="POST" class="send-msg">
                    <input type="hidden" name="usr-from" value="<?php echo $_SESSION['devign']['userId']; ?>">
                    <input type="hidden" name="conv" value="<?php echo $conv->getId(); ?>">
                    <textarea name="content" id="" cols="30" rows="2"></textarea>
                    <input type="submit" class="submit" value="Répondre">
                </form>
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