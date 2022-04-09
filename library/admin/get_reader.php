<?php 
session_start();

include('includes/config.php');
/* Cette fonction est declenchee au moyen d'un appel AJAX depuis le formulaire de sortie de livre */
/* On recupere le numero l'identifiant du lecteur SID---*/
if (!empty($_GET['sid'])){		
	$identity=$_GET['sid'];
// On prepare la requete de recherche du lecteur correspondnat
$sql="SELECT * FROM tblreaders WHERE ReaderId=:sid";
$query=$dbh->prepare($sql);
$query->bindParam(':sid', $identity, PDO::PARAM_STR);
// On execute la requete
$query->execute();

$result= $query -> fetch ( PDO :: FETCH_OBJ);



// Si un resultat est trouve

if (!empty($result) AND $result->Status !=2){
	// On affiche le nom du lecteur
	echo $result->FullName ;
	// On active le bouton de soumission du formulaire
	// echo '<input type="button" id="button" />';
	} elseif (!empty($result) AND $result->Status ==2){ 
			// Sinon
			// Si le lecteur est bloque
			// On affiche lecteur bloque
			echo "<span style='color:red'>Lecteur bloqué </span>";
			// On desactive le bouton de soumission du formulaire
			// echo '<input type="button" id="button" disabled="disabled" />';
	} elseif ($result != $identity){
		// Sinon
		// Si le lecteur n existe pas
		// On affiche que "Le lecteur est non valide"
		echo "<span style='color:red'>Ce lecteur n'existe pas</span>";
		// echo '<input type="button" id="button" disabled="disabled" />';


	}
}

	// On affiche le nom du lecteur








	// On active le bouton de soumission du formulaire
// Sinon
	// Si le lecteur n existe pas
		// On affiche que "Le lecteur est non valide"
		// On desactive le bouton de soumission du formulaire
	// Si le lecteur est bloque
		// On affiche lecteur bloque
		// On desactive le bouton de soumission du formulaire


?>
