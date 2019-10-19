<div class="nav-profile">
            <ul>
                <li><a href="/Devign_2/User/updateProfile/<?php echo $user->getId(); ?>">MODIFIER PROFIL</a></li>
                <li><a href="/Devign_2/Conversation/allConversations/<?php echo $user->getId(); ?>">CONVERSATIONS</a></li>
                <?php
                    if ($user->getRoleId() == 1 || $user->getRoleId() == 2){
                        ?>
                            <li><a href="/Devign_2/Article/newArticle/<?php echo $user->getId(); ?>">NOUVEL ARTICLE</a></li>
                            <li><a href="/Devign_2/Article/ValidComments/<?php echo $user->getId(); ?>">COMMENTAIRES À VALIDER</a></li>
                            <li><a href="/Devign_2/Article/myArticles/<?php echo $user->getId(); ?>/1">MES ARTICLES</a></li>
                            <li><a href="/Devign_2/User/allUsers/<?php echo $user->getId(); ?>">UTILISATEURS</a></li>
                        <?php
                    }
                ?>
            </ul>
</div>

<script type="text/javascript">
      
</script>