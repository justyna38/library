<?php
session_start();

include('includes/config.php');

// Si l'utilisateur n'est plus logu�
if(strlen($_SESSION['alogin'])==0) {
// On le redirige vers la page de login
header('location:index.php');
// Sinon on peut continuer. Apr�s soumission du formulaire de modification du mot de passe
} else { 
	if(isset($_POST['mdp'])) {

	// Si le formulaire a bien ete soumis
		// On recupere le mot de passe courant
		$password = md5($_POST['password']);
		// On recupere le nouveau mot de passe
		$newpassword=md5($_POST['newpassword']);
		// On recupere le nom de l'utilisateur stock� dans $_SESSION
		$nom=$_SESSION['alogin'];
		var_dump($_POST);
		// On prepare la requete de recherche pour recuperer l'id de l'administrateur (table admin)
		$sql="SELECT * FROM admin WHERE UserName=:alogin AND Password=:pass";
			$query=$dbh->prepare($sql);
			$query->bindParam(':alogin', $nom, PDO::PARAM_STR);
			$query->bindParam(':pass', $password, PDO::PARAM_STR);
			$query->execute();
			$result= $query->fetch(PDO::FETCH_OBJ);
		// dont on connait le nom et le mot de passe actuel
		// On execute la requete
		
		// Si on trouve un resultat
		if(!empty($result)){
			// On prepare la requete de mise a jour du nouveau mot de passe de cet id
			$sql2="UPDATE admin SET Password=:newpassword WHERE UserName=:alogin";
			$query2 = $dbh->prepare($sql2);
			$query2->bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
			$query2->bindParam(':alogin', $nom, PDO::PARAM_STR);
			$query2->execute();


		
			// On execute la requete
			// On stocke un message de sussces de l'operation
			// On purge le message d'erreur
		// Sinon on a trouve personne	
			// On stocke un message d'erreur
			echo "<script> alert ( 'operation réussie') </script>";
			
			} else {
				
				echo "<script> alert ('operation non réussie') </script>";
			  }
	// Sinon le formulaire n'a pas encore ete soumis
		// On initialise le message de succes et le message d'erreur (chaines vides)
	}
		}
?>

<!DOCTYPE html>
<html lang = "FR">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>Gestion bibliotheque en ligne</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- Penser a mettre dans la feuille de style les classes pour afficher le message de succes ou d'erreur  -->
</head>
<script type="text/javascript">
// On cree une fonction JS valid() qui renvoie
// true si les mots de passe sont identiques
// false sinon
function valid() {
	let password= document.getElementById ("password");
        let newpassword= document.getElementById ("newpassword");
        let message= document.getElementById("message");
      

        if(password.value === newpassword.value){
            message.style.color="green";
            message.innerHTML= "Les mots de passe sont identiques";
            return true;
        }else{
            message.style.color="red";
            message.innerHTML= "Les mots de passe sont differents";
            newpassword.focus ();
            return false;
        }
}
</script>

<body>
    <!------MENU SECTION START-->
<?php include('includes/header.php');?>
<!-- MENU SECTION END-->

<div class="container-fluid">
<div class="row">
                <div class="col-md-9 offset-md-1">
                    <div>
					<h3>Changer le mot de passe</h3>
                            <form name="new" method="post" action="change-password.php" >
                              
			<!--On affiche le nom complet - editable-->   
                                <div>
                                    <label> Mot de passe actuel</label>
                                    <input class="form-control" type="password" name="password"/>
                                </div>
                           
			<!--On affiche le numero de portable- editable-->     
                                <div>
                                    <label>Nouveau mot de passe :</label>
                                    <input class="form-control" type="password" name="newpassword" id="password"   />
                                </div>
                                     
			<!--On affiche l'email- editable-->
                                <div>
                                    <label>Confirmer le mot de passe</label>
                                    <input class="form-control" type="password" name="newpassword"  
									id="newpassword" onKeyup="return valid()"/>
                                    </div>
									<span id="message"></span>
                

                                    <button type="submit"  name="mdp" class="btn btn-outline-success" >Changer</button> 
                                </div>
                </div>
            </div>
        </div> 
<!-- On affiche le titre de la page "Changer de mot de passe"  -->
<!-- On affiche le message de succes ou d'erreur  -->
          
<!-- On affiche le formulaire de changement de mot de passe-->
<!-- La fonction JS valid() est appelee lors de la soumission du formulaire onSubmit="return valid();" -->           

     <!-- CONTENT-WRAPPER SECTION END-->
 <?php include('includes/footer.php');?>
      <!-- FOOTER SECTION END-->
     <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>-->
</body>
</html>
