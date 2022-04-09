<?php
session_start();

include('includes/config.php');

if(strlen($_SESSION['alogin'])==0) {
	header('location:index.php'); 

   
}
if (isset($_POST['issued'])) {


    $identity=$_POST['sid'];
    $isbn=$_POST['isbn'];
    $status=0;

$insert = "INSERT INTO tblissuedbookdetails (BookId, ReaderID, ReturnStatus) VALUES (:isbn, :sid, :martine)";
    $query3 = $dbh->prepare ($insert);
    $query3->bindParam(':isbn',$isbn, PDO::PARAM_INT);
    $query3->bindParam(':sid',$identity, PDO::PARAM_STR);
    $query3->bindParam(':martine',$status, PDO::PARAM_INT);
    $query3->execute();
   

    var_dump($_POST);
}

?>
<!DOCTYPE html>
<html lang="FR">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <title>Gestion de bibliotheque en ligne | Ajout de sortie</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
<script>
// function JS pour recuperer le nom du lecteur a partir de son identifiant
//Ce code est piqué de singup
function checkSid (str) {
        let xhr = new XMLHttpRequest();
        xhr.open("GET", 'get_reader.php?sid='+str);
        xhr.responseType="text";
        xhr.send ();

        xhr.onload= function (){
                document.getElementById('message').innerHTML= xhr.response;

        }
        xhr.onerror = function(){
            alert("Une erreur s'est produite");
        }

}

function checkIsbn (str) {
        let xhr = new XMLHttpRequest();
        xhr.open("GET", 'get_book.php?isbn='+str);
        xhr.responseType="text";
        xhr.send ();

        xhr.onload= function (){
                document.getElementById('message2').innerHTML= xhr.response;

        }
        xhr.onerror = function(){
            alert("Une erreur s'est produite");
        }

}
// fonction JS pour recuperer le titre du livre a partir de son identifiant ISBN

</script> 
</head>
<body>
      <!------MENU SECTION START-->
<?php include('includes/header.php');?>
<!-- MENU SECTION END-->

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
                
                <form method="post" action="add-issue-book.php">
                <fieldset class="form-group border p-3">
                <legend class="text-center">Sortie d'un livre</legend>
                    <div class="form-group">
                        <label >Identifiant lecteur <span style="color:red">*</span></label>
                        <input id="sid" in class="form-control"  type="text" name="sid" onBlur="checkSid(this.value)" ><br><br>
                        <span id="message"></span>
                    </div>

                    <div>
                        <label>ISBN <span style="color:red">*</span></label>
                        <input id="isbn"class="form-control"  type="text" name="isbn" onBlur="checkIsbn(this.value)"><br><br>
                        <span id="message2"></span>
                    </div>
                   


                    <button type="submit" name="issued" class="btn btn-info">Créer la sortie</button>
                    </fieldset>

<!-- Dans le formulaire du sortie, on appelle les fonctions JS de recuperation du nom du lecteur et du titre du livre 
 sur evenement onBlur-->
    
     <!-- CONTENT-WRAPPER SECTION END-->
<?php include('includes/footer.php');?>
      <!-- FOOTER SECTION END-->
     <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
