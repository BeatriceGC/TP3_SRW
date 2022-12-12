<!DOCTYPE HTML>
<html lang="fr">
<header></header>
<?php
    session_start();
    $id = "pouet";
    $email = htmlspecialchars($_POST['email']);
    $mdp = htmlspecialchars($_POST['password']);
    $mdp2 = htmlspecialchars($_POST['password2']);

    $file = file_get_contents("data2.json");
    $users = json_decode($file, true);

if (empty($mdp2)){
        // Utilisateur veut se connecter
        foreach($users as $usr){
            // Test des identifiants dans la bdd
            if($usr->email == $email) {
                if($usr->password == $mdp){
                    // la connexion est réussie
                    $_SESSION['login'] = $usr->name;
                    $_SESSION['role'] = $usr->role;
                    header("Location:html/admin.php");
                    echo("<h1>");
                    echo("Welcomenn, " . $usr->name . ".");
                    echo("</h1>");
                } else echo "unknown password\n";
            } else echo "unknown name\n;";
        }
    } else {
        // Utilisateur veut s'inscrire
        $users[] = '{\"name\" : '.$id.',\"email\" : '.$email.',\"password\" : '.$mdp.',\"role\" : \"none\",}';
        $file = json_encode($users);
        file_put_contents('data2.json', $file);
    }

?>
<body></body>
</html>
