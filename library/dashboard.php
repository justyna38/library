<?php
// On recupere la session courante
session_start();

// On inclue le fichier de configuration et de connexion a la base de donn�es
include('includes/config.php');
error_log(print_r($_SESSION,1));

if(strlen($_SESSION['login'])==0) {
	// Si l'utilisateur est d�connect�
	// L'utilisateur est renvoy� vers la page de login : index.php
  header('location:index.php');
} else {
	// On r�cup�re l'identifiant du lecteur dans le tableau $_SESSION
     $sid=$_SESSION['rdid'];
     $rsts=0;
     // $sql= "SELECT ReaderID FROM tblreaders WHERE ReaderID LIKE rdrid"
	// On veut savoir combien de livres ce lecteur a emprunte
	// On construit la requete permettant de le savoir a partir de la table tblissuedbookdetails
          $sql1="SELECT id FROM tblissuedbookdetails WHERE REaderID LIKE :sid";
          $query1= $dbh->prepare($sql1);
          $query1 ->bindParam(':sid',$sid,PDO::PARAM_STR);
          $query1->execute();
          $result1= $query1->fetchAll(PDO::FETCH_OBJ);
	// On stocke le r�sultat dans une variable
	$issuedbooks=count($result1);

	// On veut savoir combien de livres ce lecteur n'a pas rendu
	// On construit la requete qui permet de compter combien de livres sont associ�s � ce lecteur avec le ReturnStatus � 0 
	$sql2="SELECT id FROM tblissuedbookdetails WHERE ReaderID LIKE :sid AND ReturnSatus=:rsts";
     $query2=$dbh->prepare($sql2);
     $query2->bindParam(':sid',$sid,PDO::PARAM_STR);
     $query2->bindParam(':rsts',$rsts,PDO::PARAM_STR);
     $query2->execute();
     $result2= $query2->fetchAll(PDO::FETCH_OBJ);
	// On stocke le r�sultat dans une variable

     $returnsbooks=count($result2);
?>

<!DOCTYPE html>
<html lang="FR">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>Gestion de librairie en ligne | Tableau de bord utilisateur</title>
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
<!-- On affiche le titre de la page : Tableau de bord utilisateur-->
<div class="container">
     <div class="row">
          <div class="col">

 <h3>TABLEAU DE BORD LECTEUR</h3>
             
          </div>
     </div>
     <div class="row">
          <div class="col-md-3">
               <div class="alert alert-info text-center border-info">
                    <span class="fa fa-bars fa-5x"></span>
                    <span><?php echo $issuedbooks?> </span>
                    Livres empruntes

               </div>

          </div>

          <div class="col-md-3">
               <div class="alert alert-warning text-center border-warning">
                    <span class="fa fa-recycle fa-5x"></span>
                    <span><?php echo $returnsbooks?> </span>
                    Livres non encore rendus

               </div>

          </div>
     </div>
  </div>


   <!-- On affiche la carte des livres emprunt�s par le lecteur-->
   <!-- On affiche la carte des livres non rendus le lecteur-->
<?php include('includes/footer.php');?>
     <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
<?php }?>
