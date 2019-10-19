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

    <title>Commentaires à valider</title>

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

            <h5>COMMENTAIRES À VALIDER</h5>
            <div class="delimit"></div>
          
            <div class="all-comments-to-validate">

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

                if (!empty($comments)) {
                    foreach ($comments as $comment) {
                        ?>
                            <div class="delete-confirm" id="delete-confirm-<?php echo $comment->getId(); ?>">
                                <p>Êtes vous sûr de vouloir supprimer ce commentaire ? </p>

                                    <a href="/Devign_2/Article/deleteComment/<?php echo $comment->getId(); ?>" class="submit  btn-del">Oui</a>
                                    <button  class="submit btn-del" id="dont-delete-<?php echo $comment->getId(); ?>">Non</button>
                               
                                </form>
                            </div>

                            <div class="comments-to-validate">
                                <div class="blue blue-thin"></div>
                                <div class="message-creator-avatar">
                                    <a href="/Devign_2/User/Profile/<?php echo $comment->getUser()->getId(); ?>">
                                        <div class="img-message-creator-avatar">
                                            <figure><img src="./assets/img/avatars/<?php echo $comment->getUser()->getAvatar(); ?>" alt=""></figure>
                                        </div>
                                    </a>
                                </div>
                                <div class="comment-creator">
                                    <div>
                                        <p>Le <?php echo date('d.m.Y', strtotime($comment->getDate()));?></p>
                                        <p>Par <span><?php echo $comment->getUser()->getFirstName();?></span></p>

                                    </div>
                                    <div>
                                        <p>Article :<?php echo $comment->getArticle()->getTitle();?></p>

                                        <p class="msg-comment" id="comment_<?php echo $comment->getId(); ?>"><?php echo $comment->getContent(); ?></p>
                                    </div>
                                </div>
                                <div class="icons-comments">
                                    <a href="/Devign_2/Article/validComment/<?php echo $comment->getId(); ?>"><i class="fas fa-check-circle"></i></a>
                                    <i class="fas fa-trash delete-comment" id="<?php echo $comment->getId(); ?>"></i>

                                    <i class="fas fa-eye see-comment" id="<?php echo $comment->getId(); ?>"></i>
                                </div>
                            </div>
        
                        <?php
                    }
                } else {
                    ?>
                        <div class="no-topics">
                            <p>Aucun commentaire à valider</p>
                        </div>
                    <?php
                }
               ?>
            </div>
        </div>

        </section>

    </main>
       <script>

        /*....CLICK COMMENTAIRES BEAUTE.......................*/

            // var allComments = document.getElementsByClassName('see-comment');

            // for (let i = 0; i < allComments.length; i++) {    

            //     var id = allComments[i].getAttribute('id');

            //     allComments[i].addEventListener('click', function(){
            //         var id = allComments[i].getAttribute('id');
            //         var comment = document.querySelector('#comment_'+id);
            //         comment.classList.toggle('msg-comment');
            //     });
            // }

             /* DELETE COMMENT */
             
            $(".delete-comment").on("click", function(){
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

            /* SEE COMMENT */
            $(".see-comment").on("click", function(){

                var id = $(this).attr("id");

                if ($("#comment_"+id).is(":visible")) {

                    $("#comment_"+id).slideUp();
                }
                else {
                    $("#comment_"+id).slideDown();
                }
            });

            /* CURSOR */
            // var cursor = document.getElementById('cursor');
            // document.addEventListener('mousemove', function(e){
            //     var x = e.clientX;
            //     var y = e.clientY;
            //     cursor.style.left = x + "px";
            //     cursor.style.top = y + "px";
            // })

       </script>
  </body>
</html>