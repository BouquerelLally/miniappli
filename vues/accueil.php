<?php

if(!isset($_SESSION["id"])) {
        header("Location:index.php?action=login");
    }

$ok = false;
if(!isset($_GET["id"]) || $_GET["id"]==$_SESSION["id"]) {
    $id = $_SESSION["id"];
    $ok = true;
} else {
    $id = $_GET["id"];
    $sql = "SELECT * FROM lien WHERE etat='amis'
            AND ((idUtilisateur1=? AND idUtilisateur2=?) OR ((idUtilisateur1=? AND idUtilisateur2=?)))";
    $query = $pdo->prepare($sql);
    $query->execute(array($id, $_SESSION['id'], $_SESSION['id'], $id));
        
    $line = $query->fetch();
    
    if($line != false) {
        $ok = true;
    } 
}

$sql = "SELECT login FROM user WHERE id = ?";
$query = $pdo->prepare($sql);
$query->execute(array($id));
$line = $query->fetch();
echo "<h2>Profil de " . $line['login'] . "</h2>";

if($ok==false) {
    $sql = "SELECT * FROM lien WHERE etat='attente'
            AND ((idUtilisateur1=? AND idUtilisateur2=?) OR ((idUtilisateur1=? AND idUtilisateur2=?)))";
    $query = $pdo->prepare($sql);
    $query->execute(array($id, $_SESSION['id'], $_SESSION['id'], $id));
        
    $line = $query->fetch();
    
        if($line == false) {
            echo "Vous n'êtes pas encore ami. <br/>";
            echo "<form action='index.php?action=demande_amis' method='post';>
            <input type='hidden' name='idDemande' value='" . $id . "'>
            <input type='submit' value='Demande en ami'>";
        } else {
            echo "Invitation envoyée.";
        }
    
} else {
    $sql= "SELECT * FROM ecrit JOIN user ON idAuteur=user.id WHERE idAmi=? order by ecrit.id DESC";
    $query = $pdo->prepare($sql);
    $query->execute(array($id));
?>

<h3>Écrire un nouveau post</h3>

<form action="index.php?action=nouveau_post" method="post">
    <input type="hidden" value="<?php echo $id; ?>" name="ami">
    <input type="text" placeholder="Titre" name="titre">
    <input type="text" placeholder="Contenu" name="contenu">
    <input type="submit" value ="Poster">
</form>

<?php
    while($line = $query->fetch()) {
        $idAmi = $line['idAuteur'];
        echo "<a href='index.php?action=accueil&id=$idAmi'>" . $line['login'] . "</a><br/>";
        echo $line['dateEcrit'] . "<br/>";
        echo $line['titre'] . "<br/>";
        echo $line['contenu'] . "<br/>";
    }
}

?>