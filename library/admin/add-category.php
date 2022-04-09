<?php
session_start();

include('includes/config.php');

// Si l'utilisateur n'est plus logu�
// On le redirige vers la page de login
if(strlen($_SESSION['alogin'])==0) {
    header('location:../index.php');
}else{
    if (isset($_POST['create'])){
    
// Sinon on peut continuer. Apr�s soumission du formulaire de creation
	// On recupere le nom et le statut de la categorie
    $nameCateg=$_POST['nameCateg'];
    date_default_timezone_set('Europe/Paris');
    $date=date('Y-m-d H:i:s', time());
    // $date= date("Y/m/d");

    $statuscategory = $_POST['statuscategory'];
    if ($statuscategory == 0){
        $status = 0;
    } else if ($statuscategory == 1){
        $status = 1;
    }
    $resultatstatus = $status;
   
    

	// On prepare la requete d'insertion dans la table tblcategory
         $sql="INSERT INTO tblcategory (CategoryName, Status, UpdationDate) VALUES (:CategoryName,:Status,:CreationDate)";
	// On execute la requete
            $query= $dbh->prepare($sql);
            $query->bindParam(':CategoryName',$nameCateg,PDO::PARAM_STR);
            $query->bindParam(':Status',$resultatstatus,PDO::PARAM_STR);
            $query->bindParam(':CreationDate',$date,PDO::PARAM_STR);
            $query -> execute();

    
	// On stocke dans $_SESSION le message correspondant au resultat de loperation
        $lastInsertId = $dbh->lastInsertId();
		
		if($lastInsertId) {
			$_SESSION['msg']="categorie cree avec succes";
			header('location:manage-categories.php');
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

                                
                                 <div class="form-1-container section-container">
    <div class="container">
        <div class="row">
            <div class="col form-1 section-description wow fadeIn">
                
                <div class="divider-1 wow fadeInUp"><span></span></div>
                
            </div>
        </div>
        <div class="row">
            <div class="col-md-10 offset-md-1 form-1-box wow fadeInUp">
 
                <form action="add-category.php" method="post">
                    <!-- User's Credentials  -->
                    <fieldset class="form-group border p-3">
                        <legend class="w-auto px-2">Information Categorie</legend>
                        <div class="form-group">
                            <label for="username">Nom:</label>
                            <input type="text" class="form-control username" id="username" placeholder="Catégorie" name="nameCateg">
                        </div>
                       
                        
                    </fieldset>
                    <!-- User's Preferences  -->
                    <fieldset class="form-group border p-3">
                        <legend class="w-auto px-2">Status</legend>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="statuscategory" id="daily" value="1">
                            <label class="form-check-label" ><strong>Actif</strong></label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="statuscategory" id="weekly" value="0">
                            <label class="form-check-label"><strong>Inactif</strong></label>
                        </div>
                        
                    </fieldset>
                    <!-- Submit Button  -->
                    <div class="form-group row text-right">
                        <div class="col">
                            <button type="submit" name="create" class="btn btn-primary btn-customized">Créer</button>
                        </div>
                    </div>
                </form>
 
            </div>
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
