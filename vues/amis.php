<h3>Mes amis</h3>

<?php 

$sql = "SELECT * FROM user WHERE id IN ( SELECT user.id FROM user INNER JOIN lien ON idUtilisateur1=user.id AND etat='amis' AND idUtilisateur2=? UNION SELECT user.id FROM user INNER JOIN lien ON idUtilisateur2=user.id AND etat='amis' AND idUtilisateur1=?)";
$query = $pdo->prepare($sql);     
$query->execute(array($_SESSION['id'], $_SESSION['id']));

echo "<ul>";

while($line = $query->fetch()) {
    echo "<li><a href='index.php?id=" . $line['id'] . "'>" . $line['login'] . "</a></li>";
}

echo "</ul>";

?>
    
<h3> Invitations </h3>

<?php

$sql = "SELECT user.* FROM user WHERE id IN(SELECT idUtilisateur1 FROM lien WHERE idUtilisateur2=? AND etat='attente')";
$query = $pdo->prepare($sql);     
$query->execute(array($_SESSION['id']));

echo "<ul>";

while($line = $query->fetch()) {
    echo "<li><a href='index.php?id=" . $line['id'] . "'>" . $line['login'] . "</a></li>";
    echo "<a href='index.php?action=repondre&etat=amis&id=" . $line['id'] . "'> Accepter </a>";
    echo "<a href='index.php?action=repondre&etat=refusé&id=" . $line['id'] . "'> Refuser </a>";
}

echo "</ul>";

?>

<h3> Demandes envoyées </h3>

<?php

$sql = "SELECT user.* FROM user INNER JOIN lien ON user.id=idUtilisateur2 AND etat='attente' AND idUtilisateur1=?";
$query = $pdo->prepare($sql);     
$query->execute(array($_SESSION['id']));

echo "<ul>";

while($line = $query->fetch()) {
    echo "<li><a href='index.php?id=" . $line['id'] . "'>" . $line['login'] . "</a></li>";
}

echo "</ul>";
    
?>