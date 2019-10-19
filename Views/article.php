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
    <title>Article</title>

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

                <div class="show-article">

                    <div>
                        <div class="article">
                            <div class="blue"></div>
                            <div class="date-post"><?php echo date('d.m.Y', strtotime($article->getDate())); ?></div>
                            
                            <div class="article-pres">
                                <div>
                                    <a href="/Devign_2/User/Profile/<?php echo $article->getUser()->getId(); ?>">
                                        <div class="img-message-creator-avatar">
                                            <figure><img src="./assets/img//avatars/<?php echo $article->getUser()->getAvatar(); ?>" alt=""></figure>
                                        </div>
                                    </a>
                                    <div class="pres">
                                        <p class="article-title"><?php echo $article->getTitle(); ?></p>
                                        <a href="/Devign_2/User/Profile/<?php echo $article->getUser()->getId(); ?>" class="user-creator-name">Par <span><?php echo $article->getUser()->getFirstName(); ?></span></a>
                                    </div>
                                </div>
                            </div>

                            <div class="delimit-forum"></div>

                            <div class="imgs-article">
                                <?php
                                    if (!empty($photos)) {
                                        foreach ($photos as $photo) {
                                            ?>
                                            <div>
                                                <figure class="img-article">
                                                    <img src="assets/img/articles/<?php echo $category->getName(); ?>/<?php echo $photo->getPhotoName(); ?>" alt="">
                                                </figure>
                                            </div>
                                            <?php
                                        }
                                    }
                                ?>
                            </div>
                            <div class="text-article">
                                <p><?php echo $article->getText(); ?></p>
                            </div>
                        </div>
                        <div class="comments-title">
                            <div class="com-pres">
                                <p><i class="fas fa-comments"></i> Commentaires</p>
                            </div>

                            <div>
                            <?php
                                if (!empty($comments)) {
                                    foreach ($comments as $comment) {
                                        if ($comment->getSeen() == 1) {
                                        ?>
                                            <div class="comments">
                                                <div class="blue-topics"></div>
                                                    <div class="message-creator-avatar">
                                                        <a href="/Devign_2/User/Profile/<?php echo $comment->getUser()->getId(); ?>">
                                                            <div class="img-message-creator-avatar">
                                                                <figure><img src="./assets/img//avatars/<?php echo $comment->getUser()->getAvatar(); ?>" alt=""></figure>
                                                        </div>
                                                        </a>
                                                </div>

                                                <div class="message-creator">
                                                    <p>Par <span><?php echo $comment->getUser()->getFirstName();?></span></p>
                                                    <p>Le <?php echo date('d.m.Y', strtotime($comment->getDate()));?></p>
                                                    <p><?php echo $comment->getContent(); ?></p>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                    }
                                }

                                /*.................POSTER UN COMMENTAIRE........................*/ 
                                if (isset($_SESSION['devign']['userId'])) {
                                    
                                    ?>
                                    <p class="new-topic">< Poster un commentaire ></p>
                    
                                    <form class="form-add-topic" action="/Devign_2/ArticlesCategory/newComment/" method="POST" novalidate>

                                        
                                        <textarea name="comment">Entrez votre texte</textarea>
                    
                                        <input type="hidden" name="user" value="<?php echo $_SESSION['devign']['userId']; ?>"/>
                
                                        <input type="hidden" name="article" value="<?php echo $article->getId(); ?>"/>
                    
                                        <input class="submit" type="submit" value="Poster ce commentaire">
                    
                                    </form>
                                    <?php
                    
                                    } else {
                                        ?>
                                            <div class="msg-no-connect">
                                                <p><a href="/Devign_2/User/connexion">Veuillez vous connecter pour poster un commentaire</a></p>
                                            </div>
                                        <?php
                                    }
                            ?>
                            </div>
                        </div>

                    </div>

                    <div class="sidebar">
                        <div class="research">

                        <form action="/Devign_2/ArticlesCategory/articlesByResearchAndByCategory/<?php echo $article->getCategory(); ?>/1" method="POST">
                            <input type="hidden" name="category" value="<?php echo $article->getCategory(); ?>">
                            <input class="input-research" type="text" name="research" placeholder="Rechercher parmi les articles"/>
                            <input class="submit" type="submit" value="Valider ma recherche"/>
                        </form>

                            <!-- <input class="input-research" type="text" placeholder="Rechercher dans les articles">
                            <i class="fas fa-search picto-research"></i> -->
                        </div>
                        <div>
                            <p>Rejoignez la communauté</p>
                            <i class="fas fa-users picto-users"></i>
                        </div>
                        <div class="delimit-sidebar"></div>
                    </div>


                </div>

            </div>
    
       </main>
       
  </body>
</html>