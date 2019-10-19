<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Balise obligatoire avec le nom du dossier à récupérer, sinon ça ne chargera pas les fichiers CSS, pcr le router va chercher dans les mauvais dossiers -->
  <base href="/Devign_2/">
	<meta charset="UTF-8">
	<title>DEVIGN</title>

<!-- LIEN CSS-->
	<link rel="stylesheet" type="text/css" href="./assets/css/style.css">
	<link rel="stylesheet" href="./assets/css/owl.carousel.min.css">
	<link rel="stylesheet" href="./assets/css/owl.theme.default.min.css">
	<link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500" rel="stylesheet">
	<script src="./assets/js/jquery.min.js"></script>

</head>

<body>

<?php
	include_once('nav.php');
?>



<!-- HEADER -->
	<header>
		<scroll-page id="accueil">

			<div class="imgheader conteneurlogo">
				<img class="logo" src="./assets/img/logo.png">
				<h1>Blog indépendant</h1>
			</div>
		</scroll-page>
	</header>
	
<!-- MAIN -->
	<main class="gradient">

		<scroll-page id=portfolio class="sectionblog">
			
			<div class="section wrapper">
				
				<h2>Notre communauté</h2>
				<h3>Derniers Portfolio en date</h3>
				<h4>Nos adhérants ont du talent, visiter leurs univers graphiques!</h4>

				<div class="owl-carousel owl-theme">
		  			<a class="item" href="https://google.fr"><img src="./assets/img/carousel/image1.jpg" alt="Nom auteur"></a> 
		  			<a class="item" href="https://google.fr"><img src="./assets/img/carousel/image2.jpg" alt="Nom auteur"></a> 
		  			<a class="item" href="https://google.fr"><img src="./assets/img/carousel/image3.jpg" alt="Nom auteur"></a> 
		 			<a class="item" href="https://google.fr"><img src="./assets/img/carousel/image4.jpg" alt="Nom auteur"></a> 
		 			<a class="item" href="https://google.fr"><img src="./assets/img/carousel/image1.jpg" alt="Nom auteur"></a> 
		 			<a class="item" href="https://google.fr"><img src="./assets/img/carousel/image2.jpg" alt="Nom auteur"></a> 
		 			<a class="item" href="https://google.fr"><img src="./assets/img/carousel/image3.jpg" alt="Nom auteur"></a> 
				</div>

			</div>
		</scroll-page>

		<scroll-page id="ressources" class="sectionressources">
				
			<div class="section wrapper">
				<h2>Ressources graphiques</h2>
				<h3>Soyez créatif</h3>
				<h4>Les meilleurs sites qui proposent des ressources HTML,CSS, JS et graphique. Templates, sites et fichiers à télécharger au formation Illustrator, illustrator, PNG, JPG...</h4>

				<div class="sectionressources-img">
					<div class="floatl"><a href=""></a></div>
					<div class="floatl"><a href=""></a></div>
					<div class="floatl"><a href=""></a></div>
					<div class="floatl"><a href=""></a></div>
					<div class="floatl"><a href=""></a></div>
				</div>

			<!-- ICONE POUR RESPONSIVE -->
				<div class="sectionressources-img-min invisible">
					<div class="icon"><a href=""><img src="./assets/img/ressources/html.png"></a></div>
					<div class="icon"><a href=""><img src="./assets/img/ressources/css.png"></a></div>
					<div class="icon"><a href=""><img src="./assets/img/ressources/ai.png"></a></div>
					<div class="icon"><a href=""><img src="./assets/img/ressources/ps.png"></a></div>
					<div class="icon"><a href=""><img src="./assets/img/ressources/js.png"></a></div>
				</div>
			</div>
		</scroll-page>
	</main>

	    <!--...................NAV PROFILE.....................-->

<!--JS CAROUSEL-->
	<script type="text/javascript" src="./assets/js/owl.carousel.min.js"></script>

	<script type="text/javascript">
   		$(document).ready(function() {
     		var owl = $('.owl-carousel');
     		owl.owlCarousel({
      			margin: 10,
       			nav: true,
       			loop: true,
       			center:true,
       		responsive: { 0: {items: 1},
         				800: {items: 3},
         				1200: {items: 5}
       					}
     				})
   				})</script>

<!--JS COMPTABILITE NAV SCROLL-->
	<script>
	$(document).ready(function(){
	  // Add smooth scrolling to all links
	  $("a").on('click', function(event) {

	    // Make sure this.hash has a value before overriding default behavior
	    if (this.hash !== "") {
	      // Prevent default anchor click behavior
	      event.preventDefault();

	      // Store hash
	      var hash = this.hash;

	      // Using jQuery's animate() method to add smooth page scroll
	      // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
	      $('html, body').animate({
	        scrollTop: $(hash).offset().top
	      }, 800, function(){

	        // Add hash (#) to URL when done scrolling (default click behavior)
	        window.location.hash = hash;
	      });
	    } // End if
	  });
	});


</script>


</body>
</html>