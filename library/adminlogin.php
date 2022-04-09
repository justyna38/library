<?php
// On demarre ou on recupere la session courante
session_start();

// On inclue le fichier de configuration et de connexion � la base de donn�es
include('includes/config.php');

// On invalide le cache de session $_SESSION['alogin'] = ''
if(isset($_SESSION['alogin']) && $_SESSION['alogin']!=''){
    $_SESSION = array();

}

	// Apres la soumission du formulaire de login (plus bas dans ce fichier)
	if (isset($_POST['login']))
	{
	// On verifie si le code captcha est correct en comparant ce que l'utilisateur a saisi dans le formulaire
	// $_POST["vercode"] et la valeur initialis�e $_SESSION["vercode"] lors de l'appel a captcha.php (voir plus bas
	if($_POST['vercode']!=$_SESSION['vercode']) {
        echo"<script> alert('Le code est incorrect')</script>";
	}else{
    	// Le code est correct, on peut continuer
    	// On recupere le nom de l'utilisateur saisi dans le formulaire
		$username=$_POST['username'];
        // On recupere le mot de passe saisi par l'utilisateur et on le crypte (fonction md5)
		$password=md5($_POST['password']);
        // On construit la requete qui permet de retrouver l'utilisateur a partir de son nom et de son mot de passe
        // depuis la table admin
		$sql="SELECT UserName, Password FROM admin WHERE UserName LIKE :username AND Password LIKE :password";
		$query = $dbh->prepare($sql);
		$query ->bindParam (':username', $username, PDO::PARAM_STR);
		$query ->bindParam (':password', $password, PDO::PARAM_STR);
		$query ->execute();

		$result= $query->fetch(PDO::FETCH_OBJ);
        	// Si le resultat de recherche n'est pas vide 
			if(!empty($result)){

			$_SESSION['alogin']= $_POST['username'];
        	// On stocke le nom de l'utilisateur  $_POST['username'] en session $_SESSION
        	// On redirige l'utilisateur vers le tableau de bord administration (n'existe pas encore)
			header('location:admin/dashboard.php');			
		} else{
			echo"<script> alert('Le code est incorrect')</script>";
		} 
	}
}

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <title>Gestion de bibliotheque en ligne</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
</head>
<body>
    <!-- On inclue le fichier header.php qui contient le menu de navigation-->
<?php include('includes/header.php');?>

<div class="content-wrapper">
	<!--On affiche le titre de la page-->
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				
			</div>
        </div>
        <!--On affiche le formulaire de login-->
		<div class="container-fluid">
<div class="row">
                <div class="col-md-9 offset-md-1">
                    <div>
					<h4>LOGIN ADMINISTRATION</h4>
        		<form method="POST">
        			<div>
        				<label>Entrez le nom de l'utilisateur</label>
        				<input class="form-control" type="text" name="username" required>
        			</div>
        			<div>
        				<label>Mot de passe</label>
        				<input class="form-control"  type="password" name="password" required>
        			</div>
        			<div class="input-group  col-md-8">
  <div class="input-group-prepend">
    <span class="input-group-text" id="">Code de vérification</span>
  </div>
  <input name="vercode" type="texte" >
			<img src="captcha.php">  
</div>
        			
        			
        			<button type="submit" name="login" class="btn btn-info">LOGIN</button>
        		</form>
				</div>
        	</div>
        </div>
        <!--A la suite de la zone de saisie du captcha, on ins�re l'image cr��e par captcha.php : <img src="captcha.php">  -->
    </div>
</div>
     <!-- CONTENT-WRAPPER SECTION END-->
<?php include('includes/footer.php');?>
      <!-- FOOTER SECTION END-->
      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
