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
    <title>Articles catégories</title>

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

            <p class="titles">Articles par catégorie</p>
            <div class="delimit"></div>
                <?php
                    if (!empty($articlesCategories)) {
                        ?>
                            <div class="subcategories">
                        <?php
                        foreach ($articlesCategories as $category) {
                            ?>
                                <div class="forum-subcategories">
                                    <div class="cards-categories">
                                        <div class="blue"></div>

                                        <?php
                                            switch ($category->getId()) {
                                                case 1:
                                                    ?><i class="fas fa-desktop picto"></i><?php
                                                    break;
                                                case 2:
                                                    ?><i class="fas fa-palette picto"></i><?php
                                                    break;
                                                case 3:
                                                    ?><i class="fas fa-file-code picto"></i><?php
                                                    break;
                                            }
                                        ?>
                                        
                                        <a href="/Devign_2/ArticlesCategory/articlesByCategory/<?php echo $category->getId(); ?>/1" class="sub-cat">
                                            <p><?php echo $category->GetName(); ?></p>
                                            <p class="desc-cat"><?php echo $category->GetDesc(); ?></p>
                                        </a>
                                    </div>
                                   <div class="delimit-forum"></div>
                                   <?php 

                                    if (!empty($lastArticles)) {

                                        foreach ($lastArticles as $lastArticle) {
                                            if ($lastArticle->GetCategory() == $category->getId()) {
                                            ?> 
                                                <div class="last-subject">
                                                    <p>Dernier article :</p>
                                                    <a href="#"><?php echo $lastArticle->GetTitle(); ?></a>
                                            <?php
                                                if (!empty($lastArticle->getLastimg())) {
                                                    ?>
                                                    <div class="last-article">
                                                        <figure class="img-last-article">
                                                            <img src="assets/img/articles/<?php echo $category->getName(); ?>/<?php echo $lastArticle->getLastimg(); ?>" alt="">
                                                        </figure>
                                                        <p><?php echo substr($lastArticle->getText(),0,100); ?>...</p>
                                                    </div>
                                                </div>
                                                    <?php
                                                }
                                            } 
                                        }
                                    } 

                                    if($category->getNbArticles() == 0){
                                        ?>
                                            <div class="last-subject">
                                                <p>Dernier article :</p>
                                                <p>Cette catégorie ne contient encore aucun article</p>
                                            </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            <?php
                        }
                        ?>
                            </div>
                        <?php
                    }
                ?>


            </div>
    
       </main>
       
  </body>
</html>