<?php
session_start();

include('includes/config.php');

if(strlen($_SESSION['alogin'])==0) { 
     // On le redirige vers la page de login  
      header('location:../index.php');
 } else { 

     $authorId = intval($_GET['authorid']);
     if (isset($_POST['update'])) {

          $author = $_POST['category'];

          $up = "UPDATE tblauthors SET AuthorName = :author WHERE id = :authorid";
          $query2 = $dbh->prepare($up);
        $query2->bindParam(':author', $author, PDO::PARAM_STR);
        $query2->bindParam(':authorid', $authorId, PDO::PARAM_INT);
        $query2->execute();
        $_SESSION['updatemsg'] = "Auteur mise à jour";
        header('location:manage-authors.php');


     }
 }
 $sql = "SELECT * FROM tblauthors WHERE id = :authorid";
$query = $dbh->prepare($sql);
$query->bindParam(':authorid', $authorId, PDO::PARAM_INT);
$query->execute();
$result = $query->fetch(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="FR">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <title>Gestion de bibliothèque en ligne | Auteurs</title>
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
            <div class="col-md-12">
                <h4 class="header-line">Editer l'auteur</h4>
            </div>
		</div>
<!-- On affiche le formulaire dedition-->
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <?php
                    if (!empty($result)) {
                ?>
                <form method="post">
                    <div>
                        <label>Nom</label>
                        <input type="text" name="category" value="<?php echo $result->AuthorName ;?>">
                    </div>

                        <?php } ?>
                    </div>
                    <button type="submit" name="update" class="btn btn-info">Mise à jour</button>
                </form>
              </div>
        </div>
<!-- MENU SECTION END-->

     <!-- CONTENT-WRAPPER SECTION END-->
<?php include('includes/footer.php');?>
      <!-- FOOTER SECTION END-->
     <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
