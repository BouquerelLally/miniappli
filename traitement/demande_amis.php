<?php
if(isset($_POST['idDemande'])) {
    $id = $_POST['idDemande'];

    $sql="INSERT INTO lien VALUES(NULL,?,?,'attente')";
    $query = $pdo->prepare($sql);
    $query->execute(array($_SESSION['id'], $id));
    
    message("Votre demande a été envoyé");
    
    header("Location:" .$_SERVER['HTTP_REFERER']);
}

?>