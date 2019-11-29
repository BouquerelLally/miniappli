<form method="post" action="index.php?action=amis">
    <input type="text" placeholder="Recherche" name="txtRecherche"/>
    <input type="submit" value="Rechercher" name="submitRecherche"/>
</form>

<?php

if(isset($_POST['txtRecherche'])) {
    $recherche = $_POST['txtRecherche'];
    $recherche = "%" . $recherche . "%";
    
    $sql = "SELECT * FROM user WHERE login LIKE ?";
    $query = $pdo->prepare($sql);
    $query->execute(array($recherche));

    while($line = $query->fetch()){
        echo "<a href='index.php?id=" . $line['id'] . "'>" . $line['login'] . "</a>";
    }
}

?>

<h3>Mes amis</h3>

<!-- Liste d'amis -->

<h3> Invitations </h3>

<!-- Liste des invitations -->

<h3> En attente </h3>

<!-- Liste des demandes en attente -->