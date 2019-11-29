<?php

if(isset($_POST['login']) && isset($_POST['mdp'])) {
    $sql = "SELECT * FROM user WHERE login=? AND mdp=PASSWORD(?)";

    // Etape 1 : On prépare la requête
	$query = $pdo->prepare($sql);
	
    // Etape 2 :On l'exécute. 
    // 2 paramètre dans la requête
	$query->execute(array($_POST['login'], $_POST['mdp'])); 

	// Etape 3 : On parcours le résultat
    // Ici le login est unique, donc on sait que l'on peut avoir zero ou une  seule ligne
    // un seul fetch
    $line = $query->fetch();

// Si $line est faux le couple login mdp est mauvais, on retourne au formulaire
    if($line==false) {
        message("Mot de passe incorrect.");
        header("location:index.php?action=login");
    }
                    
// sinon on crée les variables de session $_SESSION['id'] et $_SESSION['login'] et on va à la page d'accueil
    else {
        $_SESSION['id'] = $line['id'];
        $_SESSION['login'] = $line['login'];
        header("location:index.php");
        
        if(isset($_POST['remember'])) {
            $key = uniqid("", true);
            setcookie("remember", $key, time()+3600*24*31);
        
            $sql = "UPDATE user set remember=? WHERE id=?";
            $query = $pdo->prepare($sql);
            $query->execute(array($key, $line['id']));
        }
    }
    
} else {
    header("location:index.php?action=login");
}

?>