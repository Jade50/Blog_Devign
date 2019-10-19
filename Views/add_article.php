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
    <title>Ajouter un article</title>

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

            <h5>Ajouter un nouvel article</h5>
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
                <div class="add-article">
                
                    <form method="POST" action="/Devign_2/Article/addNewArticle/<?php echo $_SESSION['devign']['userId']; ?>" enctype="multipart/form-data">

                    <input type="hidden" name="user" value="<?php echo $_SESSION['devign']['userId']; ?>">
                        <div class="add-article-form">
                            <div>
                                <input type="text" placeholder="Titre" name="title">
                                <select name="category" id="">
                                    <?php
                                        foreach ($articlesCategories as $articlesCategory) {
                                            ?>
                                                <option value="<?php echo $articlesCategory->getId() ?>"><?php echo $articlesCategory->getName() ?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                                <div class="input-file-container">
                                    <input type="file" class="input-file" name="imgs[]" multiple="multiple" id="my-file">
                                    <label for="my-file" class="input-file-trigger submit" tabindex="0">Sélectionnez vos photos</label>
                                </div>
                                <input class="submit" type="submit">
                            </div>
                            <div>
                                <textarea name="text" id="" cols="30" rows="9">Entrez votre texte</textarea>

    
                            </div>
                        </div>
                    </form>
                </div>
            </div>
           
                  
        </div>

        </section>

    </main>
       
  </body>
</html>