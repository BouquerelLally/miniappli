<?php

if(isset($_POST['login']) && isset($_POST['mdp']) && isset($_POST['mdp2']) && isset($_POST['email'])) {
    
    if($_POST['mdp'] != $_POST['mdp2']) {
        message("Les deux mots de passe sont différents.");
        header("location:index.php?action=creation");
    } else {
        $sql = "SELECT * FROM user WHERE login=?";
        $query = $pdo->prepare($sql);
        $query->execute(array($_POST['login']));
        $line = $query->fetch();
        if($line != false) {
            message("Login déjà utilisé.");
            header("location:index.php?action=creation");
        } else {
            $sql = "SELECT * FROM user WHERE email=?";
            $query = $pdo->prepare($sql);
            $query->execute(array($_POST['email']));
            $line = $query->fetch();
            if($line != false) {
                message("Email déjà utilisé.");
                header("location:index.php?action=creation");
            } else {
                $sql = "INSERT INTO user VALUES(NULL, ?, PASSWORD(?), ?, '', '')";

                $query = $pdo->prepare($sql);
                $query->execute(array($_POST['login'], $_POST['mdp'], $_POST['email']));
                message("Bienvenue parmi nous " . $_POST['login']);
                header("Location:index.php");
            }
        }
    }
} else {
    header("location:index.php");
}

?>