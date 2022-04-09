<?php
session_start();
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0) { 
    // On le redirige vers la page de login  



    header('location:index.php');
} else { 
    $sqlBook="SELECT tblbooks.id, BookName, ISBNNumber,BookPrice, tblcategory.CategoryName, tblauthors.AuthorName
    FROM tblbooks, tblauthors, tblcategory
    WHERE tblbooks.CatId=tblcategory.id
    AND tblbooks.AuthorId=tblauthors.id";
  $query1=$dbh->prepare($sqlBook);
  $query1->execute();
  $resultats1= $query1->fetchAll(PDO::FETCH_OBJ);

  

    if(isset($_GET['del'])) {
		// On recupere l'identifiant de la cat�gorie a supprimer
  $bookid=$_GET['del'];
  $sql2="DELETE FROM tblbooks WHERE id=:delete";
$query2=$dbh->prepare($sql2);
$query2->bindParam(':delete',$bookid,PDO::PARAM_INT);

$query2 -> execute();
$_SESSION['delmsg']="la catégorie est bien supprimée";
  header('location:manage-books.php');

}
}

?>

<!DOCTYPE html>
<html lang="FR">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <title>Gestion de bibliothèque en ligne | Gestion livres</title>
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

<div class="container">
<div class="row">
                <div class="col">
                    
                        <h3>Gestion des livres</h3>
                </div>
            </div>
            <div class="row">
                <div class="col">
                  
                    <div class="alert alert-success">
                     
                  </div>
                 
                  </div>

                  
       
                        <table class="table table-striped table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">Titre du livre</th>
                                <th scope="col">Catégorie</th>
                                <th scope="col">Nom de l'auteur</th>
                                <th scope="col">Le numéro ISBN</th>
                                <th scope="col">Le prix</th>
                                <th scope="col">Action</th>
                                </tr>
                                </thead>
                            
                            <tbody>
                            <?php 
                                if (is_array($resultats1)){
                                    $cnt= 1;
                                    foreach ($resultats1 AS $result){
                                        error_log(print_r($resultats1,1));
                                ?>
                                


                                <tr>
                                <td><?php echo $cnt ?> </td>
                                <td> <?php echo $result->BookName; ?></td>
                                 
                                <td><?php echo $result->CategoryName; ?></td>
                                <td><?php echo $result->AuthorName; ?></td>
                                <td><?php echo $result->ISBNNumber; ?></td>
                                <td><?php echo $result->BookPrice; ?></td>
                            
                                <td>
                                <a href="edit-book.php?bookid=<?php echo $result->id ?>">
                                    <button class="btn btn-primary">Editer</button>
                                </a>
                                <a href="manage-books?del=<?php echo $result->id ?>" onClick="return confirm('Etes-vous sûr ?')">
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

<?php include('includes/footer.php');?>
      <!-- FOOTER SECTION END-->
     <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
