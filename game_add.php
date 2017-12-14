<?php

//---------------- BDD
$pdo = new PDO('mysql:host=localhost;dbname=moijv', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

//---------------- SESSION
session_start();

//---------------- CHEMIN
define("RACINE_SITE", $_SERVER['DOCUMENT_ROOT'] . "/PHP/moijv-git/");
// echo RACINE_SITE;
// echo '<pre>'; print_r($_SERVER); echo '</pre>';
define("URL", 'https://localhost/PHP/moijv-git/');

//---------------- VARIABLE
$content = "";

if($_POST)
{
	// Exo : si il n'y a pas d'erreur, réaliser le script permettant d'insérer un membre (requête préparé)
	// $_POST['mdp'] = password_hash($_POST['mdp'], PASSWORD_DEFAULT);

	$resultat = $pdo->prepare("INSERT INTO game(title,description,image,category,available) VALUES (:title, :description, :image, :category, :available)");

	$resultat->bindValue(':title', $_POST['title'], PDO::PARAM_STR);
	$resultat->bindValue(':description', $_POST['description'], PDO::PARAM_STR);
	$resultat->bindValue(':image', $_POST['image'], PDO::PARAM_STR);
	$resultat->bindValue(':category', $_POST['category'], PDO::PARAM_STR);
	$resultat->bindValue(':available', $_POST['available'], PDO::PARAM_INT);

	$resultat->execute();


	$content .= '<div class="alert alert-success col-md-8 cold-md-offset-2 text-center">Jeu ajouté.</div>';

}

echo $content;
?>

<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Moi JV</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/shop-homepage.css" rel="stylesheet">

  </head>

  <body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="#">Moi JV</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a class="nav-link" href="index.php">Acceuil
                <span class="sr-only">(current)</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">A propos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="game_add.php">Ajout d'un jeu</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="register_add.php">Inscription</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Contact</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Page Content -->
    <div class="container">

      <div class="row">

        <div class="col-lg-3">

          <h1 class="my-4">Moi JV</h1>
          <div class="list-group">
            <a href="#" class="list-group-item">RPG</a>
            <a href="#" class="list-group-item">FPS</a>
            <a href="#" class="list-group-item">Puzzle Game</a>
          </div>

        </div>
        <!-- /.col-lg-3 -->

        <div class="col-lg-9">

          <form method="post" action="game_add.php" class="col-md-8 col-md-offset-2">
			<h2 class="alert alert-info text-center">New game</h2>

			<div class="form-group">
				<label for="title">Title</label>
				<input type="text" class="form-control" id="title" name="title" placeholder="votre titre">
			</div><br>

			<div class="form-group">
				<label for="description">Description</label>
				<textarea class="form-control" id="description" name="description" placeholder="votre description"></textarea>
			</div><br>

			<div class="form-group">
				<label for="image">Image</label>
				<input type="file" class="form-control" id="image" name="image">
			</div><br>

			<div class="form-group">
				<label for="category">Category</label>
				<select class="form-control" name="category">
					<option value="RPG">RPG</option>
					<option value="FPS">FPS</option>
					<option value="Puzzle Game">Puzzle Game</option>
				</select>
			</div><br>

			<div class="form-group">
				<button type="submit" class="col-md-12 btn btn-primary">Envoi</button>
			</div><br>
		  </form>

        </div>
        <!-- /.col-lg-9 -->

      </div>
      <!-- /.row -->

    </div>
    <!-- /.container -->

    <!-- Footer -->
    <footer class="py-5 bg-dark">
      <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; Moi JV 2017</p>
      </div>
      <!-- /.container -->
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>

</html>