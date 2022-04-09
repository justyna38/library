<?php
session_start();

include('includes/config.php');

if(strlen($_SESSION['alogin'])==0) {
	header('location:index.php');
} else {
	$sql1 = "SELECT * FROM tblcategory WHERE Status = 1";
    $query1 = $dbh->prepare ($sql1);
    $query1->execute();
    $results1 = $query1->fetchAll(PDO::FETCH_OBJ);

    $sql2 = "SELECT * FROM tblauthors";
    $query2 = $dbh->prepare($sql2);
    $query2->execute();
    $results2 = $query2->fetchAll(PDO::FETCH_OBJ);
	
    if (isset($_POST['add'])) {
        $bookname = $_POST['bookname'];
        $category = $_POST['category'];
        $author = $_POST['authors'];
        $isbn = $_POST['isbn'];
        $price = $_POST['price'];
        var_dump($_POST);

        $sql = "INSERT INTO tblbooks (BookName, CatId, AuthorId, ISBNNumber, BookPrice)
                VALUES (:BookName, :CatId, :AuthorId, :ISBNNumber, :BookPrice)";

        $query = $dbh->prepare($sql);
        $query->bindParam(':BookName', $bookname, PDO::PARAM_STR);
        $query->bindParam(':CatId', $category, PDO::PARAM_INT);
        $query->bindParam(':AuthorId', $author, PDO::PARAM_INT);
        $query->bindParam(':ISBNNumber', $isbn, PDO::PARAM_STR);
        $query->bindParam(':BookPrice', $price, PDO::PARAM_STR);
        $query->execute();
        $lastInsertId = $dbh->lastInsertId();

        if ($lastInsertId > 0) {
            $_SESSION['msg'] = "Le livre a été ajouté avec succès";
        } else {
            $_SESSION['error'] = "Une erreur s'est produite";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="FR">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <title>Gestion de bibliothèque en ligne | Ajout de livres</title>
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
<div class="row justify-content-center">
  <fieldset class="col-8 col-md-6 px-3">
    <legend>Ajouter un livre</legend>
   

		</div>
		<div class="row">
			<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
			    <form method="post" action="add-book.php">
                    <div>
                    <label>Titre<span style="color:red">*</span></label>
                    <input type="text" name="bookname" required>
                    </div>

                    <div>
                    <label>Catégorie<span style="color:red">*</span></label>
                    <select name="category" required>
                        <option value="">Choisir une catégorie</option>

                        <?php 
                        if (count($results1) > 0) {
                            foreach($results1 AS $result1) {
                        ?>
                        <option value="<?php echo $result1->id?>"> <?php echo $result1->CategoryName ?></option>
                        <?php
                            }
                        }
                        ?>
                    </select>
                    </div>

                    <div>
                    <label>Auteur<span style="color:red">*</span></label>
                    <select name="authors" required>
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
                    <input type="text" name="isbn" required>
                    <p>Le numéro ISBN doit être unique</p>
                    </div>

                    <div>
                    <label>Prix<span style="color:red">*</span></label>
                    <input type="text" name="price" required>
                    </div>

                    <button type="submit" name="add" class="btn btn-info">Ajouter</button>

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
