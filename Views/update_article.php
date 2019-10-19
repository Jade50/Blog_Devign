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
    <title>Modifier un article</title>

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

    <!--...................NAV PROFILE.....................-->
    <?php
        include('nav_profile.php');
    ?>
    <!--...................PROFILE........................-->
        <div class="my-profile">

            <h5>MODIFIER UN ARTICLE</h5>
            <div class="delimit"></div>
          
            <div class="new-article">
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

                <div class="update-article">
                    <form action="/Devign_2/Article/updateArticleTreat/<?php echo $article->getId(); ?>" method="POST" enctype="multipart/form-data">
                        <div class="update">
                            <div>
                                <input type="hidden" name="id" value="<?php echo $article->getId(); ?>">
                                <label for="title" for="title">Titre</label>
                                <input name="title" type="text" value="<?php echo $article->getTitle(); ?>">
                                <label for="category" for="category">Catégorie</label>
                                <select name="category" name="category" id="">
                                    <?php
                                        foreach ($articlesCategories as $articlesCategory) {
                                            ?>
                                                <option <?php if ($article->getCategory()->getId() == $articlesCategory->getId()) {
                                                    echo "selected";
                                                } ?> value="<?php echo $articlesCategory->getId(); ?>"><?php echo $articlesCategory->getName(); ?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                                    
                                <div class="input-file-container">
                                    <input type="file" class="input-file" name="imgs[]" multiple="multiple" id="my-file">
                                    <label for="my-file" class="input-file-trigger submit" tabindex="0">Chargez de nouvelles photos</label>
                                </div>
                                <input class="submit" type="submit" value="Modifier">
                            </div>

                            <div>
                                <label for="text">Contenu</label>
                                <textarea name="text" id="" cols="30" rows="10"><?php echo $article->getText(); ?></textarea>
                            </div>
                        </div>

                        <div class="img-update-articles">
                            <?php
                                if (!empty($photos)) {
                                    foreach ($photos as $photo) {
                                        ?>
                                        <div>
                                            <figure class="img-article">
                                                <img src="assets/img/articles/<?php echo $article->getCategory()->getName(); ?>/<?php echo $photo->getPhotoName(); ?>" alt="">
                                            </figure>
                                        </div>
                                        <?php
                                    }
                                }
                            ?>
                        </div>
                    </form>
                </div>
            </div>
           
                  
        </div>

        </section>

    </main>
       
  </body>
</html>