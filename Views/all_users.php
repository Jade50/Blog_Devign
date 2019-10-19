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

    <title>Utilisateurs</title>

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

            <h5>UTILISATEURS</h5>
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

                if (!empty($usersView)) {
                    ?>
                    <div class="research-users">
                        <form action="/Devign_2/User/allUsersResearch/" method="POST">
                            <input id="update_search" type="text" name="research" placeholder="Rechercher parmi les utilisateurs"/>
                            <input type="submit" value="Valider ma recherche"/>
                        </form>
                    </div>
                    <?php
                    foreach ($usersView as $userView) {
                        ?>
                            <div class="delete-confirm delete-confirm-article" id="delete-confirm-<?php echo $userView->getId(); ?>">
                                <p>Êtes vous sûr de vouloir supprimer cet utilisateur ? </p>
                                <a href="/Devign_2/User/deleteUser/<?php echo $userView->getId(); ?>" class="submit  btn-del">Oui</a>
                                <button  class="submit btn-del" id="dont-delete-<?php echo $userView->getId(); ?>">Non</button>
                            </div>
                            
                            <div class="user-view">

                                <div class="view">
                                    <div class="blue blue-thin"></div>

                                    <div class="userview-avatar">
                                        <a href="/Devign_2/User/Profile/<?php echo $userView->getId(); ?>">
                                            <div class="img-message-creator-avatar">
                                                <figure><img src="./assets/img/avatars/<?php echo $userView->getAvatar(); ?>" alt=""></figure>
                                            </div>
                                        <a>
                                    </div>

                                    <div class="user-pres">
                                        <p class="name"><?php echo $userView->getFirstname().' '.$userView->getName(); ?></p>
                                        <div class="delimit"></div>

                                        <div class="user-role">
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
                                            <p><?php echo $userView->getRoleName(); ?></p>
                                        </div>

                                        <div class="user-mail">
                                            <p><?php echo $userView->getMail(); ?></p>
                                            <p>Membre depuis : <?php echo date('d.m.Y', strtotime($userView->getInscription())); ?></p>
                                        </div>
                                    </div>

                    
                                    <div class="user-about-see" id="user-about-see-<?php echo $userView->getId(); ?>">
                                            <p><?php echo $userView->getAbout(); ?></p>

                                        <div class="actions-users">
                                            <a href="/Devign_2/User/updateUser/<?php echo $userView->getId(); ?>" class="submit  btn-update-article">Modifier</a>
                                            <button  class="submit btn-update-article delete-user" id="<?php echo $userView->getId(); ?>">Supprimer</button>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        <?php 
                    }
                } else {
                    ?>
                        <div class="no-topics">
                            <p>Aucun utilisateur</p>
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