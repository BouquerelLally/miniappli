<?php

setcookie('remember', '', time()-3600*24);
$sql = "UPDATE user set remember=NULL WHERE id=?";
$query = $pdo->prepare($sql);
$query->execute(array($_SESSION['id']));
    
session_destroy();
header("location:index.php");

?>