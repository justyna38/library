<?php
// On d�marre ou on r�cup�re la session courante
session_start();

// On inclue le fichier de configuration et de connexion � la base de donn�es
include('includes/config.php');

// Si l'utilisateur n'est logu� ($_SESSION['alogin'] est vide)
if(strlen($_SESSION['alogin'])==0) {
	// Si l'utilisateur est d�connect�
	// L'utilisateur est renvoy� vers la page de login : index.php
	header('location:index.php');
// On le redirige vers la page d'accueil
// Sinon on affiche la liste des lecteurs de la table tblreaders
} else { 



    $sql="SELECT * FROM tblreaders ORDER BY id ASC ";
    $query=$dbh->prepare($sql);
    $query->execute();
    $resultats= $query->fetchAll(PDO::FETCH_OBJ);


   
   
  
    

if(isset($_GET['inid'])){

$inactif= $_GET['inid'];
$status=1;

$sqlInactif="UPDATE tblreaders SET Status=:inactif WHERE id=:sid";
$query2= $dbh->prepare($sqlInactif);
$query2->bindParam(':inactif',$status, PDO::PARAM_INT);
$query2->bindParam(':sid',$inactif, PDO::PARAM_INT);
$query2->execute();
}

if(isset($_GET['id'])){
$actif=$_GET['id'];
$status=0;

$sqlActif="UPDATE tblreaders SET Status=:actif WHERE id=:sid";
$query3= $dbh->prepare($sqlActif);
$query3->bindParam(':actif',$status, PDO::PARAM_INT);
 $query3->bindParam(':sid',$actif, PDO::PARAM_INT);
$query3->execute();
}
    
if(isset($_GET['del'])){
 $delete=$_GET['del'];
 $status=2;


$sqlSupprimer="UPDATE tblreaders SET Status=:supprimer WHERE id=:sid";
$query3= $dbh->prepare($sqlSupprimer);
$query3->bindParam(':supprimer',$status, PDO::PARAM_INT);
$query3->bindParam(':sid',$delete, PDO::PARAM_INT);
$query3->execute();


}

    

    


// Lors d'un click sur un bouton "inactif", on r�cup�re la valeur de l'identifiant
// du lecteur dans le tableau $_GET['inid']
// et on met � jour le statut (0) dans la table tblreaders pour cet identifiant de lecteur

// Lors d'un click sur un bouton "actif", on r�cup�re la valeur de l'identifiant
// du lecteur dans le tableau $_GET['id']
// et on met � jour le statut (1) dans  table tblreaders pour cet identifiant de lecteur

// Lors d'un click sur un bouton "supprimer", on r�cup�re la valeur de l'identifiant
// du lecteur dans le tableau $_GET['del']
// et on met � jour le statut (2) dans la table tblreaders pour cet identifiant de lecteur

// On r�cup�re tous les lecteurs dans la base de donn�es

            }
?>

<!DOCTYPE html>
<html lang="FR">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>Gestion de bibliothèque en ligne | Reg lecteurs</title>
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
<!-- Titre de la page (Gestion du Registre des lecteurs) -->
<div class="container">
<div class="row">
                <div class="col">
                    
                        <h3>Gestion des lecteurs</h3>
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
                                <th scope="col">ID lecteurs</th>
                                <th scope="col">Nom</th>
                                <th scope="col">Email</th>
                                <th scope="col">Portable</th>
                                <th scope="col">Date de reg</th>
                                <th scope="col">Status</th>
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
                                <td> <?php echo $result->ReaderId; ?></td>
                                  
                                <td><?php echo $result-> FullName; ?></td>
                                <td><?php echo $result-> EmailId; ?></td>
                                <td><?php echo $result-> MobileNumber; ?></td>
                                <td><?php echo $result-> RegDate; ?></td>
                                <td> <?php if ($result-> Status==1){
                                echo 'Inactif';
                                     }elseif ($result->Status==0){
                                echo 'Actif';
                                     }elseif ($result->Status==2) {
                                echo 'Supprimé';      
                                } ?></td>
                    
                            
                                <td>
                                    <?php if($result->Status==2){

                                    }elseif ($result->Status==1){?>
                                        <a href="reg-readers.php?id=<?php echo $result->id ?>">
                                        <button class="btn btn-primary">Actif</button>

                                        <a href="reg-readers.php?del=<?php echo $result->id ?>" onClick="return confirm('Etes-vous sûr ?')">
                                    <button class="btn btn-warning">Supprimer</button>
                                </a>
                                    </a>
                                    <?php }elseif ($result->Status==0) {?>
                          
                                <a href="reg-readers.php?inid=<?php echo $result->id ?>">
                                    <button class="btn btn-danger">Inactif</button>
                                </a>
                                <a href="reg-readers?del=<?php echo $result->id ?>">
                            <button class="btn btn-warning">Supprimer</button>
                                </a>

                                    <?php } ?>
                                
                                
                               
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
 
   <!--On ins�re ici le tableau des lecteurs.
       On g�re l'affichage des boutons Actif/Inactif/Supprimer en fonction de la valeur du statut du lecteur -->

     <!-- CONTENT-WRAPPER SECTION END-->
  <?php include('includes/footer.php');?>
      <!-- FOOTER SECTION END-->
     <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>-->
</body>
</html>
