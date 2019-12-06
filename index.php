<?php

include("config/config.php");
include("config/bd.php");
include("divers/balises.php");
include("config/actions.php");
session_start();

if(isset($_SESSION['id']) == false && isset($_COOKIE['remember'])) {
    $sql = "SELECT * FROM user WHERE remember=?";
    $query = $pdo->prepare($sql);
    $query->execute(array($_COOKIE['remember']));
    
    $line = $query->fetch();
    if($line != false) {
        $_SESSION['id'] = $line['id'];
        $_SESSION['login'] = $line['login'];
    }
}

ob_start(); // Je démarre le buffer de sortie : les données à afficher sont stockées


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>CATCHAT!</title>

    <!-- Bootstrap core CSS -->
    <link href="./css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="./css/ie10.css" rel="stylesheet">


    <!-- Ma feuille de style à moi -->
    <link href="./css/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Fredoka+One&display=swap" rel="stylesheet"> 

    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>

<body>

<?php
if (isset($_SESSION['info'])) {
    echo "<div class='alert alert-info alert-dismissible' role='alert'>
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
     <span aria-hidden='true'>&times;</span></button>
        <strong>Information : </strong> " . $_SESSION['info'] . "</div>";
    unset($_SESSION['info']);
}
?>


<header>
    <a href="index.php?action=accueil"><h1>CATCHAT!</h1></a>
</header>
<nav>
    <ul>
        <?php
        if (isset($_SESSION['id'])) {
            $sql = "SELECT * FROM user WHERE id = ?";
            $query = $pdo->prepare($sql);
            $query->execute(array($_SESSION['id']));
            
            $line = $query->fetch();
            
            echo "<li> <img src ='" . $line['avatar'] . "'> Bonjour " . $_SESSION['login'] . " <a href='index.php?action=deconnexion'>Deconnexion</a></li>
                <form method='post' action='index.php?action=amis'>
                    <input type='text' placeholder='Recherche' name='txtRecherche'/>
                    <input type='submit' value='Rechercher' name='submitRecherche'/>
                </form>";

if(isset($_POST['txtRecherche'])) {
    $recherche = $_POST['txtRecherche'];
    $recherche = "%" . $recherche . "%";
    
    $sql = "SELECT * FROM user WHERE login LIKE ?";
    $query = $pdo->prepare($sql);
    $query->execute(array($recherche));

    while($line = $query->fetch()){
        echo "<a href='index.php?id=" . $line['id'] . "'>" . $line['login'] . "</a><br/>";
    }
}
            
            echo "<a href='index.php?action=amis'><img src='../icones/icons8-personne-homme-30.png'></a>";
            
        } else {
            echo "<li><a href='index.php?action=login'>Login</a></li>";
            echo "<li><a href='index.php?action=creation'>Register</a></li>";
        }
        ?>
    </ul>
</nav>

<div class="container-fluid">
    <div class="row">
        <!--<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">-->
        <div class="col-md-12 main">
            <?php
            // Quelle est l'action à faire ?
            if (isset($_GET["action"])) {
                $action = $_GET["action"];
            } else {
                $action = "accueil";
            }

            // Est ce que cette action existe dans la liste des actions
            if (array_key_exists($action, $listeDesActions) == false) {
                include("vues/404.php"); // NON : page 404
            } else {
                include($listeDesActions[$action]); // Oui, on la charge
            }

            ob_end_flush(); // Je ferme le buffer, je vide la mémoire et affiche tout ce qui doit l'être
            ?>


        </div>
    </div>
</div>
<footer>© 2019 CatChat, Inc.</footer>
</body>
</html>
