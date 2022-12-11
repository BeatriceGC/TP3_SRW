<!DOCTYPE HTML>
<html lang="fr">
<header></header>
<?php
    session_start();
    $id = htmlspecialchars($_POST['email']);
    $mdp = htmlspecialchars($_POST['password']);
    $file = file_get_contents("data2.json");

    $users = json_decode($file);

    foreach($users as $usr){
        // Test des identifiants dans la bdd
        if($usr->email == $id) {
            if($usr->password == $mdp){
                // la connexion est réussie
                $_SESSION['login'] = $usr->name;
                $_SESSION['role'] = $usr->role;
                header("Location:html/admin.html");
                echo("<h1>");
                    echo("Welcomenn, " . $usr->name . ".");
                echo("</h1>");
            } else echo "unknown password\n";
        } else echo "unknown name\n;";
    }
?>
<body></body>
</html>
