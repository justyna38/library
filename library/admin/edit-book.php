<?php
session_start();

include('includes/config.php');

if(strlen($_SESSION['alogin'])==0) { 
      // On le redirige vers la page de login  
        header('location:../index.php');
  } else { 


    $bookid = intval($_GET['bookid']);

      $sql1 = "SELECT * FROM tblcategory WHERE Status = 1";
      $query1 = $dbh->prepare ($sql1);
      $query1->execute();
      $results1 = $query1->fetchAll(PDO::FETCH_OBJ);

      $sql2 = "SELECT * FROM tblauthors";
    $query2 = $dbh->prepare($sql2);
    $query2->execute();
    $results2 = $query2->fetchAll(PDO::FETCH_OBJ);

    $sql3 = "SELECT * FROM tblbooks WHERE id=:bookid";
    $query3 = $dbh->prepare($sql3);
    
  
    $query3->execute();
    $results3 = $query3->fetch(PDO::FETCH_OBJ);
    


     


	// Apres soumission du formulaire de categorie
    if (isset($_POST['update'])) {

        $bookid = intval($_GET['bookid']);
      $titre = $_POST['titre'];
      $category = $_POST['category'];
      $auteur= $_POST['auteur'];
      $isbn=$_POST['isbn'];
      $prix=$_POST['prix'];
  var_dump($_POST);
$sqlup="UPDATE tblbooks SET BookName=:titre, CatId=:category, AuthorId=:author, ISBNNumber=:isbn, BookPrice=:prix WHERE id=:bookid ";
$queryup = $dbh->prepare($sqlup);
        $queryup->bindParam(':titre', $titre, PDO::PARAM_STR);
        $queryup->bindParam(':category', $category, PDO::PARAM_INT);
        $queryup->bindParam(':author', $auteur, PDO::PARAM_INT);
        $queryup->bindParam(':isbn', $isbn, PDO::PARAM_INT);
        $queryup->bindParam(':prix', $prix, PDO::PARAM_INT);
        $queryup->bindParam(':bookid', $bookid, PDO::PARAM_INT);
        $queryup->execute();

        $_SESSION['updatemsg'] = "Le livre mise à jour";
		
        // On redirige l'utilisateur vers edit-categories.php
    header('location:manage-books.php');

  

  }
}

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <title>Gestion de bibliothèque en ligne | Livres</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <!-- link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' / -->
</head>
<body>
      <!------MENU SECTION START-->
<?php include('includes/header.php');?>
<!-- MENU SECTION END-->
<div class="row justify-content-center">
  <fieldset class="col-8 col-md-6 px-3">
    <legend>Ajouter un livre</legend>
   

		</div>
		<div class="row">
			<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
			    <form method="post">
                    <div>
                    <label>Titre<span style="color:red">*</span></label>
                    
                    <input type="text" name="titre" required value="<?php echo $results3->BookName; ?>">
                    </div>

                    <div>
                    <label>Catégorie<span style="color:red">*</span></label>
                    <select name="category" required>
                        <option value="">Choisir une catégorie</option>

                        <?php 
                        if (count($results1) > 0) {
                            foreach($results1 AS $result1) {
                        ?>
                        <option value="<?php echo $result1->id?>"><?php echo $result1->CategoryName ?></option>
                        <?php
                            }
                        }
                        ?>
                    </select>
                    </div>

                    <div>
                    <label>Auteur<span style="color:red">*</span></label>
                    <select name="auteur" required>
                        <option value="">Choisir un(e) auteur(e)</option>
                        <?php 
                        if (count($results2) > 0) {
                            foreach($results2 AS $result2) {
                        ?>
                        <option value="<?php echo $result2->id?>"> <?php echo $result2->AuthorName ?></option>

                        <?php
                            }
                        }
                        ?>
                    </select>

                    <div>
                    <label>ISBN<span style="color:red">*</span></label>
                    <input type="text" name="isbn" required value="<?php echo $results3->ISBNNumber; ?>">
                    <p>Le numéro ISBN doit être unique</p>
                    </div>

                    <div>
                    <label>Prix<span style="color:red">*</span></label>
                    <input type="text" name="prix" required value="<?php echo $results3->BookPrice; ?>">
                    </div>

                    <button type="submit" name="update" class="btn btn-info">Ajouter</button>

                    </div>
                </form>
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
