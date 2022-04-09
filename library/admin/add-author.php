<?php
session_start();

include('includes/config.php');

if(strlen($_SESSION['alogin'])==0) {
     header('location:../index.php');
 }else{
     if (isset($_POST['create'])){ 
     $author=$_POST['authorname'];
     date_default_timezone_set('Europe/Paris');
     $date=date('Y-m-d H:i:s', time());
    



// On prepare la requete d'insertion dans la table tblauthors
$sql="INSERT INTO tblauthors (AuthorName, UpdationDate) VALUES (:author,:up)";

$query= $dbh->prepare($sql);
$query->bindParam(':author',$author,PDO::PARAM_STR);
$query->bindParam(':up',$date,PDO::PARAM_STR);
$query -> execute();
$lastInsertId = $dbh->lastInsertId();
		
if($lastInsertId) {
     $_SESSION['msg']="categorie cree avec succes";
     header('location:manage-authors.php');
} else {
     $_SESSION['error']="Une erreur s'est produite";
}


     }
}
var_dump($_POST);
?>

<!DOCTYPE html>
<html lang="FR">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <title>Gestion de bibliothèque en ligne | Ajout de categories</title>
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
     <!-- CONTENT-WRAPPER SECTION END-->

     <div class="form-1-container section-container">
     <div class="container">
        <div class="row">
            <div class="col-form-1 section-description wow fadeIn">
            <div class="divider-1 wow fadeInUp"><span></span></div>
               
            </div>
		</div>
<!-- On affiche le formulaire dedition-->
        <div class="row">
            <div  class="col-md-10 offset-md-1 form-1-box wow fadeInUp">
                
                <form method="post" action="add-author.php">
                <fieldset class="form-group border p-3">
                <legend class="text-center">Ajouter un nouvel auteur</legend>
                    <div class="form-group">
                        <label >Nom</label>
                        <input class="form-control"  type="text" name="authorname"><br><br>
                    </div>
                    <button type="submit" name="create" class="btn btn-info">Ajouter</button>
                    </fieldset>

                     
                   
                </form>
                </div>
        </div>
              
            </div>
        </div>
             
              

     
<?php include('includes/footer.php');?>
      <!-- FOOTER SECTION END-->
     <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
