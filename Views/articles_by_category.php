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
    <title>Articles par catégories</title>

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

            <p class="titles">Articles <?php echo $category->getName(); ?></p>
            <div class="delimit"></div>

            <?php
                if (!empty($articles)) {

                    ?>
                        <div class="all-articles">
                    <?php
                    foreach($articles as $article){
                        ?>
                            <div class="card-article">
                                <div>
                                    <div class="date-post"><?php echo date('d.m.Y', strtotime($article->getDate())); ?></div>
                                    <div class="blue"></div>
                                    <a href="/Devign_2/ArticlesCategory/showArticle/<?php echo $article->getId(); ?>" class="sub-cat">
                                        <p><?php echo $article->getTitle(); ?></p>
                                    </a>
                                    
                                    <div class="delimit-forum"></div>
                                    <p class="article-creator">Par <span><?php echo $article->getUser()->getFirstName(); ?></span></p>
                                    <figure class="img-all-articles">
                                        <img src="assets/img/articles/<?php echo $category->getName(); ?>/<?php echo $article->getLastimg(); ?>" alt="">
                                    </figure>
                                    <p><?php echo substr($article->getText(), 0, 150); ?>...</p>
                                    <p class="nb-comments"><i class="fas fa-comments"></i> <?php echo $article->getNbcomments(); ?> Commentaires</p>
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
                                 <a href="/Devign_2/ArticlesCategory/articlesByCategory/<?php echo $category->getId().'/'.$i; ?>"><?php echo $i.'.'; ?></a>
                            <?php
                        }
                        ?>
                        </div>
                        <?php
                } else {
                    ?>
                    <div class="no-articles">
                        <p>Aucun article pour cette catégorie</p>
                    </div>
                    <?php
                }
            ?>

            </div>
    
       </main>
       
  </body>
</html>