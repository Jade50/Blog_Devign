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

    <title>Mes articles</title>

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

            <h5>MES ARTICLES</h5>
            <div class="delimit"></div>
               
                    <?php
                     // -----------------------Affichage des messages d'erreurs--------------------
                        if (isset($_GET['url'])) {
                            $url = explode('/', $_GET['url']);
                            if (isset($url[4])) {
                            ?>
                                <div class="alert-msg" role="alert"> <?= $url[4]; ?></div>
                            <?php
                            }
                        }
                        
                        if (!empty($articles)) {
                            ?>
                            <div class="all-articles my-articles">
                            <?php
                            foreach($articles as $article){
                                
                                ?>

                                    <div class="delete-confirm delete-confirm-article" id="delete-confirm-<?php echo $article->getId(); ?>">
                                        <p>Êtes vous sûr de vouloir supprimer cet article ? </p>

                                            <a href="/Devign_2/Article/deleteArticle/<?php echo $article->getId(); ?>" class="submit  btn-del">Oui</a>
                                            <button  class="submit btn-del" id="dont-delete-<?php echo $article->getId(); ?>">Non</button>
                                    
                                        </form>
                                    </div>

                                    <div class="card-article">
                                        <div>
                                            <div class="date-post"><?php echo date('d.m.Y', strtotime($article->getDate())); ?></div>
                                            <div class="blue"></div>
                                            <a href="/Devign_2/ArticlesCategory/showArticle/<?php echo $article->getId(); ?>" class="sub-cat">
                                                <p><?php echo $article->getTitle(); ?></p>
                                            </a>
                                            
                                            <div class="delimit-forum"></div>
                                            <figure class="img-all-articles">
                                                <img src="assets/img/articles/<?php echo $article->getCategory()->getName(); ?>/<?php echo $article->getLastimg(); ?>" alt="">
                                            </figure>
                                            <p><?php echo substr($article->getText(), 0, 100); ?>...</p>
                                            <p class="nb-comments"><i class="fas fa-comments"></i> <?php echo $article->getNbcomments(); ?> Commentaires</p>
                                            <div class="delimit-forum"></div>

                                            <div class="actions">
                                                <a href="/Devign_2/Article/updateArticle/<?php echo $article->getId(); ?>" class="submit  btn-update-article">Modifier</a>
                                                <button  class="submit btn-update-article delete-article" id="<?php echo $article->getId(); ?>">Supprimer</button>
                                            </div>
                                        </div>

                                    </div>
                                <?php
                            }

                            ?>
                            
                                </div>
                            <div class="pagination">
                            <?php
                            for ($i=1; $i <= $totalPages ; $i++) { 
                                ?>
                                     <a href="/Devign_2/Article/myArticles/<?php echo $_SESSION['devign']['userId'].'/'.$i; ?>"><?php echo $i.'.'; ?></a>
                                <?php
                            }
                            ?>
                            </div>
                            <?php
                        } else {
                            ?>
                            <div class="no-articles">
                                <p>Aucun article</p>
                            </div>
                            <?php
                        }
                    ?>
        </div>

        </section>

    </main>

    <script>
            $(".delete-article").on("click", function(){
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