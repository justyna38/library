<?php
session_start();

include('includes/config.php');

if(strlen($_SESSION['alogin'])==0) {
	// Si l'utilisateur est d�connect�
	// L'utilisateur est renvoy� vers la page de login : index.php
	header('location:index.php');
} else { 
  $sql="SELECT * FROM tblauthors ORDER BY id ASC ";
  $query=$dbh->prepare($sql);
  $query->execute();
  $resultats= $query->fetchAll(PDO::FETCH_OBJ);

  if(isset($_GET['del'])) {
      // On recupere l'identifiant de la cat�gorie a supprimer
$authorId=$_GET['del'];
$sql2="DELETE FROM tblauthors WHERE id=:delete";
$query2=$dbh->prepare($sql2);
$query2->bindParam(':delete',$authorId,PDO::PARAM_INT);
$query2 -> execute();

$_SESSION['delmsg']="la catégorie est bien supprimée";
  header('location:manage-authors.php');

}
}
?>

<!DOCTYPE html>
<html lang="FR">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <title>Gestion de bibliothèque en ligne | Gestion des auteurs</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
</head>
<body>
      <!------MENU SECTION START-->
<?php include('includes/header.php');?>
<!-- MENU SECTION END-->
<div class="container">
<div class="row">
                <div class="col">
                    
                        <h3>Gestion des auteurs</h3>
                </div>
            </div>
            <div class="row">
                <div class="col">
                  

                  </div>
                 
                  </div>

                  
       
                        <table class="table table-striped table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
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
                                <td> <?php echo $result->AuthorName; ?></td>
                                 
                                <td><?php echo $result-> creationDate; ?></td>
                                <td><?php echo $result-> UpdationDate; ?></td>
                            
                                <td>
                                <a href="edit-author.php?authorid=<?php echo $result->id ?>">
                                    <button class="btn btn-primary">Editer</button>
                                </a>
                                <a href="manage-authors?del=<?php echo $result->id ?>" onClick="return confirm('Etes-vous sûr ?')">
                                    <button class="btn btn-danger">Supprimer</button>
                                </a>
                                    </td>
                                </td>
                                </tr>
                                <?php
                                $cnt++; 
                                    
                                    }}
                            
                                    ?>
                                    
                                
                            </tbody>
                     </table>
 </div>
</div>
</div>  

     <!-- CONTENT-WRAPPER SECTION END-->
<?php include('includes/footer.php');?>
      <!-- FOOTER SECTION END-->
     <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
