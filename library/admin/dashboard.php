<?php
// On d�marre ou on r�cup�re la session courante
session_start();

// On inclue le fichier de configuration et de connexion � la base de donn�es
include('includes/config.php');

if(strlen($_SESSION['alogin'])==0){
	// Si l'utilisateur est d�connect�
	// L'utilisateur est renvoy� vers la page de login : index.php
  header('location:../index.php');
} else {
// sinon on r�cup�re les informations � afficher
	// On r�cup�re le nombre de livres depuis la table tblbooks
  

  $sql= "SELECT id FROM tblbooks ";
  // sql=""SELECT (COUNT) FROM tblbooks;dans le PDO:: on utilise FETCH_COLUMN
  $query=$dbh->prepare($sql);
  $query->execute();
  $result= $query->fetchAll(PDO::FETCH_OBJ);

  $numBook=count($result);

	
	// On r�cup�re le nombre de livres en pr�t depuis la table tblissuedbookdetails
  
  $sql2="SELECT id FROM tblissuedbookdetails WHERE ReturnStatus=0";
  $query2=$dbh->prepare($sql2);
  $query2->execute();
  $result2= $query2->fetchAll(PDO::FETCH_OBJ);

  $numPret=count($result2);
	
	// On r�cup�re le nombre de livres retourn�s  depuis la table tblissuedbookdetails
  $sql3="SELECT id FROM tblissuedbookdetails WHERE ReturnStatus>0";
  $query3=$dbh->prepare($sql3);
  $query3->execute();
  $result3= $query3->fetchAll(PDO::FETCH_OBJ);

  $numRendu=count($result3);

	// Ce sont les livres dont le statut est 1
	
	// On r�cup�re le nombre de lecteurs dans la table tblreaders
  $sql4="SELECT ReaderId FROM tblreaders";
  $query4=$dbh->prepare($sql4);
  $query4->execute();
  $result4= $query4->fetchAll(PDO::FETCH_OBJ);

  $numLecteurs=count($result4);
	
	// On r�cup�re le nombre d'auteurs dans la table tblauthors
	
  $sql5="SELECT id FROM tblauthors";
  $query5=$dbh->prepare($sql5);
  $query5->execute();
  $result5= $query5->fetchAll(PDO::FETCH_OBJ);

  $numAuteurs=count($result5);

	// On r�cup�re le nombre de cat�gories dans la table tblcategory	
  $sql6="SELECT id FROM tblcategory";
  $query6=$dbh->prepare($sql6);
  $query6->execute();
  $result6= $query6->fetchAll(PDO::FETCH_OBJ);

  $numCategory=count($result6);

?>
<!DOCTYPE html>
<html lang="FR">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>Gestion de bibliothèque en ligne | Tab bord administration</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
</head>
<body>
 <!--On inclue ici le menu de navigation includes/header.php-->
<?php include('includes/header.php');?>
<div class="container">
     <div class="row">
          <div class="col">
        

<!-- On affiche le titre de la page : TABLEAU DE BORD ADMINISTRATION-->
<h3>Tableau de bord Adminitrateur</h3>

</div>
     </div>
        <!-- On affiche la carte Nombre de livres -->
        <div class="row">
        <div class="col-md-3">
               <div class="alert alert-light text-center border-info role="alert">
               <span class="fa fa-book" style="font-size:100px;color:green"></span><br>
               <span><?php echo $numBook ?></span><br>
               Nombre de livres
               </div>
          </div>

         
        <!-- On affiche la carte Livres en pr�t -->

        
        <div class="col-md-3">
               <div class="alert alert-light text-center border-info role="alert>
               <span class="fa fa-bars" style="font-size:100px;color:red"></span><br>
               <span><?php echo $numPret ?></span><br>
               Livres en pret
               </div>
               </div>

               <div class="col-md-3">
               <div class="alert alert-light text-center border-info role="alert>
               <span class="fa fa-recycle" style="font-size:100px;color:blue"></span><br>
               <span><?php echo   $numRendu ?></span><br>
               Livres rendus
               </div>
               </div>

               <div class="col-md-3">
               <div class="alert alert-light text-center border-info role="alert>
               <span class="fa fa-user" style="font-size:100px;color:yellow"></span><br>
               <span><?php echo $numLecteurs ?></span><br>
               Lecteurs
               </div>
               </div>

               <div class="col-md-3">
               <div class="alert alert-light text-center border-info role="alert>
               <span class="fa fa-pencil" style="font-size:100px;color:purple"></span><br>
               <span><?php echo $numAuteurs ?></span><br>
               Auteurs
               </div>
               </div>

               <div class="col-md-3">
               <div class="alert alert-light text-center border-info role="alert>
               <span class="fa fa-table" style="font-size:100px;color:black"></span><br>
               <span><?php echo $numCategory ?></span><br>
               Livres en pret
               </div>
               </div>
          
          </div>
</div>
        <!-- On affiche la carte Livres retourn�s -->
        <!-- On affiche la carte Lecteurs -->
 		<!-- On affiche la carte Auteurs -->
 		<!-- On affiche la carte Cat�gories -->

     <!-- CONTENT-WRAPPER SECTION END-->
	<?php include('includes/footer.php');?>
      <!-- FOOTER SECTION END-->
      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
<?php } ?>
