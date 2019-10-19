
<nav>

	<div class="nav-responsive">
		<figure><img class="small-logo" src="./assets/img/logo.png"></figure>
		<div class="responsive">
			<div class="barre"></div>
			<div class="barre"></div>
			<div class="barre"></div>
		</div>
	</div>
	<div class="navigation wrapper">

		<div class="nav">
			<a href="/Devign_2/Home/index">ACCUEIL</a>
			<?php
				if (!isset($_SESSION['devign']['userId'])) {
					?>
						<a href="/Devign_2/User/subscribe">INSCRIPTION</a>
						<a href="/Devign_2/User/connexion">CONNEXION</a>
					<?php
				}
			?>
			<a href="/Devign_2/ForumCategory/index">FORUM</a>
			<a href="/Devign_2/ArticlesCategory/index">ARTICLES</a>
			<?php
				if (isset($_SESSION['devign']['userId'])) {
					?>
						<a href="/Devign_2/User/Disconnection">DECONNEXION</a>
						<div class="down-profile">
							<a class="responsive-nav-profile" href="/Devign_2/User/myProfile/<?php echo $_SESSION['devign']['userId']; ?>">MON PROFIL</a>
							<div class="down"></div>
						</div>
					<?php
				}
			?>
		</div>
	</div>
</nav>

<script type="text/javascript">

	// if ($(window).width() < 400) {
	// 	$(".navigation").hide();
	// 	$(".responsive").on("click", function(){
	// 		$(".navigation").toggle('slow');
	// 	});
	// }

	// if ($(window).width() < 400) {
	// 	$(".nav-profile").hide();
	// 	$(".responsive-nav-profile").on("click", function(){
	// 	    $(".nav-profile").show('slow');
	// 	});
	// }


			$(".responsive").on("click", function(){
                if ($(".navigation").is(":visible")) {
                    $(".navigation").slideUp();
					$("nav").css({"background":"rgba(56, 110, 116, 0.3)"});
                }
                else {
                    $(".navigation").slideDown();
					$("nav").css({"background":"rgba(56, 110, 116, 0.9)"});
					$('.down-profile').append($('.nav-profile'));
                }
            });


			$(".down").on("click", function(){
				if ($(".nav-profile").is(":visible")) {
					$(".nav-profile").css({"background":"rgba(56, 110, 116, 0.3)"});
					$(".nav-profile").slideUp();
				} else {
					$(".nav-profile").css({"background":"rgba(56, 110, 116, 0.9)"});
					$(".nav-profile").slideDown();
				}
			});
			

</script>