<?php 

// On inclue le fichier de configuration et de connexion a la base de donnees
require_once("includes/config.php");
// On recupere dans $_GET l email soumis par l'utilisateur
		if (!empty($_GET['emailid'])){		
		$email=$_GET['emailid'];
	// On verifie que l'email est un email valide (fonction filter_var)
	if(FALSE===(filter_var($email, FILTER_VALIDATE_EMAIL)==false)){
		echo "Cet email n'est pas valide";
	
		// Si ce n'est pas le cas, on fait un echo qui signale l'erreur
	}else {

		
		// Si c'est bon
		// On prepare la requete qui recherche la presence de l'email dans la table tblreaders
		$sql= "SELECT EmailId FROM tblreaders WHERE EmailId= :email";
		$query= $dbh->prepare($sql);
		// On execute la requete et on stocke le resultat de recherche
		$query->bindParam(':email',$email,PDO :: PARAM_STR);
		$query->execute();
		$result= $query -> fetch ( PDO :: FETCH_OBJ);
		// Si le resultat n'est pas vide. On signale a l'utilisateur que cet email existe deja et on desactive le bouton 
		// de soumission du formulaire

		if(!empty($result)){
			echo "<span style ='color:red'> Cet login existe déja ! </span>";

		} else {
			echo "<span style ='color:green'> Cet login est disponible !' </span>";

		} 
	} 
}
		


 
		
		// Sinon on signale a l'utlisateur que l'email est disponible et on active le bouton du formulaire


?>
