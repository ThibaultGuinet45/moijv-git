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

// Réaliser un formulaire HTML correspondant à la table membre, tous les champs sauf status et id_membre
// Contrôler en PHP que l'on récupère totues les données saisies via le formulaire

// Exo : Contrôler la disponibilité du pseudo et afficher un msg d'erreur si le pseudo existe en BDD
if($_POST)
{
	// debug($_POST);
	$erreur = '';
	// on sélectionne tout dans la BDD à condition que le champs pseudo de la BDD soit égal à la donnée saisie dans le champs pseudo par l'internaute
	$resultat = $pdo->query("SELECT * FROM user WHERE username = '$_POST[username]'");
	// rowCount() est une méthode issue de la classe PDOStatement qui retourne le nombre de résultat de la requête de sélection
	// si le resultat est supérieur, cela veut dire que le pseudo existe déjà en BDD, on affiche un msg d'erreur
	if($resultat->rowCount() >= 1)
	{
		$erreur .= '<div class="alert alert-danger col-md-8 cold-md-offset-2 text-center">Pseudo indisponible</div>';
	}
	// Exo : contrôler que la taille du champs nom et prenom soit comprise entre 2 et 15 caractères
	// contrôler le format du champs email
	// faites en sorte que l'internaute ne puisse pas insérer du code HTML ou JS
	if(iconv_strlen($_POST['lastname']) < 2 || iconv_strlen($_POST['lastname']) > 15)
	{
		$erreur .= '<div class="alert alert-danger col-md-8 cold-md-offset-2 text-center">Erreur de taille nom</div>';
	}
	if(iconv_strlen($_POST['firstname']) < 2 || iconv_strlen($_POST['firstname']) > 15)
	{
		$erreur .= '<div class="alert alert-danger col-md-8 cold-md-offset-2 text-center">Erreur de taille prénom</div>';
	}
	if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
	{
		$erreur .= '<div class="alert alert-danger col-md-8 cold-md-offset-2 text-center">Erreur de format email</div>';
	}
	foreach($_POST as $key => $value)
	{
		$_POST[$key] = strip_tags($value);
	}
	if(!preg_match('#^[a-zA-Z0-9._-]+$#',$_POST['username']))
	{
		$erreur .= '<div class="alert alert-danger col-md-8 cold-md-offset-2 text-center">Erreur de format du pseudo</div>';
	}
	// preg_match() : une expression régulière est oujours entouré de # pour préciser les options
	// ^ indique le début de la chaîne
	// $ indique la fin de la chaîne
	// + est la pour que les lettres autorisées peuvent apparaître plusieurs fois

$content .= $erreur;

	// Exo : si il n'y a pas d'erreur, réaliser le script permettant d'insérer un membre (requête préparé)
	if(empty($erreur)) // si la variable $erreur est vide alors on valide
	{
		// $_POST['mdp'] = password_hash($_POST['mdp'], PASSWORD_DEFAULT);

		$resultat = $pdo->prepare("INSERT INTO user(username,lastname,firstname,password,email) VALUES (:username, :lastname, :firstname, :password, :email)");

		$resultat->bindValue(':username', $_POST['username'], PDO::PARAM_STR);
		$resultat->bindValue(':lastname', $_POST['lastname'], PDO::PARAM_STR);
		$resultat->bindValue(':firstname', $_POST['firstname'], PDO::PARAM_STR);
		$resultat->bindValue(':password', $_POST['password'], PDO::PARAM_STR);
		$resultat->bindValue(':email', $_POST['email'], PDO::PARAM_STR);

		$resultat->execute();


		$content .= '<div class="alert alert-success col-md-8 cold-md-offset-2 text-center">Inscription réussie. <a href="connexion.php">Cliquez ici pour vous connecter</a></div>';
	}
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

          <form method="post" action="register_add.php" class="col-md-8 col-md-offset-2">
			<h2 class="alert alert-info text-center">New user</h2>

			<div class="form-group">
				<label for="username">Username</label>
				<input type="text" class="form-control" id="username" name="username" placeholder="votre pseudo">
			</div><br>

			<div class="form-group">
				<label for="password">Password</label>
				<input type="password" class="form-control" id="password" name="password" placeholder="votre mot de passe">
			</div><br>

			<div class="form-group">
				<label for="lastname">Lastname</label>
				<input type="text" class="form-control" id="lastname" name="lastname" placeholder="votre nom">
			</div><br>

			<div class="form-group">
				<label for="firstname">Firstname</label>
				<input type="text" class="form-control" id="firstname" name="firstname" placeholder="votre prenom">
			</div><br>
			
			<div class="form-group">
				<label for="email">Email</label>
				<input type="text" class="form-control" id="email" name="email" placeholder="votre email">
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