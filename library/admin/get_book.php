<?php 

session_start();
include('includes/config.php');


/* Cette fonction est declenchee au moyen d'un appel AJAX depuis le formulaire de sortie de livre */

if (!empty($_GET['isbn'])){		
	$isbn=$_GET['isbn'];

	var_dump($isbn);

	$sql1="SELECT * FROM tblbooks WHERE ISBNNumber=:isbn";
	$query1=$dbh->prepare($sql1);
	$query1->bindParam(':isbn', $isbn, PDO::PARAM_INT);
	// On execute la requete
	$query1->execute();
	
	$result1= $query1 -> fetch ( PDO :: FETCH_OBJ);


}

if (!empty($result1)){
echo $result1->BookName;
}else{

	echo "<span style='color:red'>Livre n'exsite pas </span>";
}


/* On recupere le numero ISBN du livre*/
// On prepare la requete de recherche du livre correspondnat
// On execute la requete
// Si un resultat est trouve
	// On affiche le nom du livre
	// On active le bouton de soumission du formulaire
// Sinon
	// On affiche que "ISBN est non valide"
	// On desactive le bouton de soumission du formulaire 
?>
