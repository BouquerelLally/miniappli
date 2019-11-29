<?php

$titre = $_POST["titre"];
$contenu = $_POST["contenu"];
$ami = $_POST["ami"];
  
$sql = "INSERT INTO ecrit (titre, contenu, idAuteur, idAmi, dateEcrit) VALUES (?, ?, ?, ?, NOW())";
$query = $pdo->prepare($sql);
$query->execute(array($titre, $contenu, $_SESSION['id'], $ami));

header("Location:index.php?id=" . $_POST['ami']);

?>