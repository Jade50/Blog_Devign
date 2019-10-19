<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <base href="/Devign_2/">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" type="text/css" href="./assets/css/style.css">
    <script src="./assets/js/jquery.min.js"></script>
    <title>Forum Catégories</title>

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
                    if (!empty($Categories)) {

                        foreach ($Categories as $categorie) {
                            ?>
                                <p class="titles"><?php echo $categorie->GetName(); ?></p>
                                <div class="delimit"></div>
                            <?php 

                                if (!empty($subCategories)) {
                                ?>
                                    <div class="subcategories">
                                <?php

                                    foreach ($subCategories as $subCategorie) {
                                        if ($categorie->GetId() == $subCategorie->GetCategory()) {
                                        ?>
                                        <div class="forum-subcategories"> 
                                            <div>
                                                <div class="blue"></div>
                                                <figure class="picto-forum">
                                                    <img src="assets/img/ressources/<?php echo $subCategorie->getPicto(); ?>" alt="">
                                                </figure>
                                                <a href="/Devign_2/ForumCategory/AllTopics/<?php echo $subCategorie->getId(); ?>" class="sub-cat">
                                                    <p><?php echo $subCategorie->GetName(); ?></p>
                                                    <p><?php echo $subCategorie->GetDesc(); ?></p>
                                                </a>
                                            </div>
                                            <div class="delimit-forum"></div>
                                        <?php 

                                            if (!empty($lastTopics)) {

                                                foreach ($lastTopics as $lastTopic) {
                                                    if ($lastTopic->GetSubcategory()->getId() == $subCategorie->getId()) {
                                                    ?> 
                                                        <div class="last-subject">
                                                            <p>Dernier sujet :</p>
                                                            <a href="#"><?php echo $lastTopic->GetSubject(); ?></a>
                                                        </div>
                                                    <?php
                                                    } 
                                                }
                                            } 
                                            
                                            if($subCategorie->getNbTopics() == 0){
                                                ?>
                                                    <div class="last-subject">
                                                        <p>Dernier sujet :</p>
                                                        <p>Cette catégorie ne contient encore aucun sujet</p>
                                                    </div>
                                                <?php
                                            }
                                        ?>
                                            </div>
                                        <?php
                                    }
                                }
                            }
                            ?>
                                </div>
                            <?php
                        }
                    }
                ?>


                <?php
                    // if (!empty($Categories)) {
                    //     foreach ($Categories as $categorie) {
                    //     echo '<p class="titles">'.$categorie->GetName().'</p>';
                    //     echo '<div class="delimit"></div>';
                    //     if (!empty($subCategories)) {
                    //         echo '<div class="subcategories">';
                    //         foreach ($subCategories as $subCategorie) {
                    //             if ($categorie->GetId() == $subCategorie->GetCategory()) {
                    //                 echo '<div class="forum-subcategories"> <div><div class="blue"></div><figure class="picto-forum"><img src="assets/img/ressources/'.$subCategorie->getPicto().'" alt=""></figure><p class="p-sub-cat">'.$subCategorie->GetName().'</p><p>'.$subCategorie->GetDesc().'</p></div>';
                    //                 echo '<div class="delimit-forum"></div>';
                    //                 if (!empty($lastTopics)) {
                    //                     foreach ($lastTopics as $lastTopic) {
                    //                         if ($lastTopic->GetSubcat()->getId() == $subCategorie->getId()) {
                    //                             echo '<div class="last-subject"><p>Dernier sujet :</p><p>'.$lastTopic->GetSubject().'</p></div>';
                    //                         } 
                    //                     }
                    //                     if($subCategorie->getNbTopics() == 0){
                    //                         echo '<div class="last-subject"><p>Dernier sujet :</p><p>Cette catégorie ne contient encore aucun sujet</p></div>';
                    //                     }
                    //                 } 
                    //                 echo '</div>';
                    //             }
                    //         }
                    //     }
                    //     echo '</div>';
                    //     }
                    // }
                ?>
            </div>
    
       </main>
       
  </body>
</html>