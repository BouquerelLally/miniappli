<?php

if(isset($_POST['idRepondre']) && isset($_POST['etat'])) {
    if($_POST['etat'] == 'Accepter') {
        
        $id = $_POST['idRepondre'];
        $sql = "UPDATE lien SET etat = 'amis' WHERE idUtilisateur1=? AND idUtilisateur2=?";
        $query = $pdo->prepare($sql);
        $query->execute(array($id, $_SESSION['id']));
        
        message("Demande acceptée.");
        header("Location:" .$_SERVER['HTTP_REFERER']);
        
    } elseif($_POST['etat'] == 'Refuser') {
        
        $id = $_POST['idRepondre'];
        $sql = "DELETE FROM lien WHERE idUtilisateur1=? AND idUtilisateur2=?";
        $query = $pdo->prepare($sql);
        $query->execute(array($id, $_SESSION['id']));
        
        message("Demande refusée.");
        header("Location:" .$_SERVER['HTTP_REFERER']);
        
    }
}

?>