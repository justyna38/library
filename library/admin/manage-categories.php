<?php
// On recupere la session courante
session_start();

// On inclue le fichier de configuration et de connexion a la base de donn�es
include('includes/config.php');

if(strlen($_SESSION['alogin'])==0) {
	// Si l'utilisateur est d�connect�
	// L'utilisateur est renvoy� vers la page de login : index.php
	header('location:index.php');
} else { 
  $sql="SELECT * FROM tblcategory ORDER BY id ASC ";
  $query=$dbh->prepare($sql);
  $query->execute();
  $resultats= $query->fetchAll(PDO::FETCH_OBJ);
  
 



if(isset($_GET['del'])) {
		// On recupere l'identifiant de la cat�gorie a supprimer
  $catId=$_GET['del'];

       

		// On prepare la requete de suppression
		// On execute la requete
		// On informe l'utilisateur du resultat de loperation
		// On redirige l'utilisateur vers la page manage-categories.php
  $sql2="DELETE FROM tblcategory WHERE id=:delete";
  $query2=$dbh->prepare($sql2);
  $query2->bindParam(':delete',$catId,PDO::PARAM_INT);
  $query2 -> execute();

  $_SESSION['delmsg']="la catégorie est bien supprimée";
  header('location:manage-categories.php');

  error_log(print_r($query2,1));


		// On execute la requete
       

//         $lastInsertId = $dbh->lastInsertId();
		
// }if($lastInsertId) {
// 			$_SESSION['msg']="categorie supprimée avec succes";
// 			header('location:manage-categories.php');
// 		} else {
// 			$_SESSION['error']="Une erreur s'est produite";
}
	
 }

// ?>

<!-- MENU SECTION END-->
    <!-- On affiche le titre de la page-->
    <!-- On prevoit ici une div pour l'affichage des erreurs ou du succes de l'operation de mise a jour ou de suppression d'une categorie-->
 	<!-- On affiche le formulaire de gestion des categories-->

   <!DOCTYPE html>
<html lang="FR">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <title>Gestion de bibliotheque en ligne | Gestion des livres</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
</head>
<body>
      <!--On insere ici le menu de navigation T-->
<?php include('includes/header.php');?>
	<!-- On affiche le titre de la page : LIVRES SORTIS --> 
    <div class="container">
<div class="row">
                <div class="col">
                    
                        <h3>Gestion des catégories</h3>
                </div>
            </div>
            <div class="row">
                <div class="col">
                  <?php if(!empty($_SESSION['delmsg'])){?>
                    <div class="alert alert-success">
                      <strong>Succès:</strong>
                      <?php echo ($_SESSION['delmsg']); ?>
                  </div>
                  <?php }?>
                  </div>

                  
       
                        <table class="table table-striped table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Status</th>
                                <th scope="col">Crée le</th>
                                <th scope="col">Mise à jour</th>
                                <th scope="col">Action</th>
                                </tr>
                            </thead>
                            
                            <tbody>
                                <?php 
                                if (is_array($resultats)){
                                    $cnt= 1;
                                    foreach ($resultats AS $result){
                                        error_log(print_r($resultats,1));
                                ?>
                                <tr>
                                <td><?php echo $cnt ?> </td>
                                <td> <?php echo $result->CategoryName; ?></td>
                                  <td> <?php if ($result-> Status==0){
                                echo "<button class='btn btn-danger'>INACTIF</button>";
                                     }else{
                                      echo "<button class='btn btn-success'>ACTIF</button>"; } ?></td>
                                <td><?php echo $result-> CreationDate; ?></td>
                                <td><?php echo $result-> UpdationDate; ?></td>
                            
                                <td>
                                <a href="edit-category.php?catid=<?php echo $result->id ?>">
                                    <button class="btn btn-primary">Editer</button>
                                </a>
                                <a href="manage-categories?del=<?php echo $result->id ?>" onClick="return confirm('Etes-vous sûr ?')">
                                    <button class="btn btn-danger">Supprimer</button>
                                </a>
                                    </td>
                                </td>
                                </tr>
                                <?php
                                $cnt++; 
                                       }
                                    }
                               
                            
                                    ?>
                                    
                                
                            </tbody>
                     </table>
 </div>
</div>
</div>  
           <!-- On affiche le titre de la page : LIVRES SORTIS -->      
           <!-- On affiche la liste des sorties contenus dans $results sous la forme d'un tableau -->
           <!-- Si il n'y a pas de date de retour, on affiche non retourne --> 

  
  <?php include('includes/footer.php');?>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
