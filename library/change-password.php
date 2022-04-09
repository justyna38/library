<?php
// On recupere la session courante
session_start();

// On inclue le fichier de configuration et de connexion � la base de donn�es
include('includes/config.php');

// Si l'utilisateur n'est pas logue, on le redirige vers la page de login (index.php)
if(strlen($_SESSION['rdid'])==0) {
	// sinon, on peut continuer,
	header('location:index.php');
  }else{
	$sid =$_SESSION['rdid'];
	
	// si le formulaire a ete envoye : $_POST['change'] existe
	if(isset($_POST['change'])){
		//On recupere le mot de passe et on le crypte (fonction md5)
		
        $password = md5($_POST['password']);
		
		//On recupere le nouveau mot de passe et on le crypte
		$newpassword=md5($_POST['newpassword']);
		//On recupere l'email de l'utilisateur dans le tabeau $_SESSION
		$mail=$_SESSION['login'];
		//On cherche en base l'utilisateur avec ce mot de passe et cet email
			$sql="SELECT * FROM tblreaders WHERE ReaderId=:sid AND EmailId=:mail";
			$query=$dbh->prepare($sql);
			$query->bindParam(':sid', $sid, PDO::PARAM_STR);
			$query->bindParam(':mail', $mail, PDO::PARAM_STR);
			$query->execute();
			$result= $query->fetch(PDO::FETCH_OBJ);
			

			
		
		// Si le resultat de recherche n'est pas vide

		if(!empty($result)){
			// On met a jour en base le nouveau mot de passe (tblreader) pour ce lecteur

			$sql2="UPDATE tblreaders SET Password1=:newpassword WHERE EmailId=:mail";
			$query2 = $dbh->prepare($sql2);
			$query2->bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
			$query2->bindParam(':mail', $mail, PDO::PARAM_STR);
			$query2->execute();

			// $_SESSION['alogin']= $_POST['username']

		
			// On stocke le message d'operation reussie
			echo "<script> alert ( 'operation réussie') </script>";
		//sinon (resultat de recherche vide)
		} else {
			//On stocke le message "mot de passe invalide"
			echo "<script> alert ('operation non réussie') </script>";
  		}
	}
	
}

?>
<!DOCTYPE html>
<html lang="FR">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <title>Gestion de bibliotheque en ligne | changement de mot de passe</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    
    <!-- Penser au code CSS de mise en forme des message de succes ou d'erreur -->

</head>
<script type="text/javascript">

// <!-- On cree une fonction JS valid() qui verifie si les deux mots de passe saisis sont identiques -->
// <!-- Cette fonction retourne un booleen -->
function valid(){
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
<!-- Mettre ici le code CSS de mise en forme des message de succes ou d'erreur -->
<?php include('includes/header.php');?>
	<!--On affiche le titre de la page : CHANGER MON MOT DE PASSE--> 
	
	
	<div class="container-fluid">
<div class="row">
                <div class="col-md-9 offset-md-1">
                    <div>
					<h3>Changer le mot de passe</h3>
                            <form name="change" method="post" action="change-password.php" >
                              
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
                

                                    <button type="submit"  name="change" class="btn btn-outline-success" >Changer</button> 
                                </div>
                </div>
            </div>
        </div> 
	<!--  Si on a une erreur, on l'affiche ici -->
	<!--  Si on a un message, on l'affiche ici -->
        
<!--On affiche le formulaire--> 
<!-- la fonction de validation de mot de passe est appelee dans la balise form : onSubmit="return valid();"--> 
         

 <?php include('includes/footer.php');?>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
