<!DOCTYPE HTML>
<html lang="fr">
<header></header>
<?php
session_start();
$id = htmlspecialchars($_POST['name']);
$email = htmlspecialchars($_POST['email']);
$mdp = htmlspecialchars($_POST['password']);
$mdp2 = htmlspecialchars($_POST['password2']);
$role = htmlspecialchars($_POST['typeClient']);

$file = file_get_contents("data.json");
$users = json_decode($file);

if (empty($mdp2)) {
    // Utilisateur veut se connecter
    foreach ($users as $usr) {
        // Test des identifiants dans la bdd
        if ($usr->email == $email) {
            $salt="ceciestleselpourlemotdepasse";
            $saltedPassword = $salt . $mdp;
            $passwordHash = hash_hmac('sha256', $saltedPassword, $salt);
            if ($usr->password === $passwordHash) {
                // la connexion est réussie
                $_SESSION['login'] = $usr->name;
                $_SESSION['role'] = $usr->role;
                echo $usr->name;
                if ($_SESSION['role'] == "adminClient") {
                    header("Location:php/admin.php");
                } else if ($_SESSION['role'] = "affairesClient") {
                    header("Location:php/affaireClient.php");
                } else if ($_SESSION['role'] = "residentielClient") {
                    header("Location:php/residentielClient.php");
                } else header("Location:php/deconnexion.php");
            }
        }
    }
} else {
    $salt = "ceciestleselpourlemotdepasse";
    $saltedPassword = $salt . $mdp;
    $passwordHash = hash_hmac('sha256', $saltedPassword, $salt);
    $users[] = array(
        'name' => $id,
        'email' => $email,
        'password' => $passwordHash,
        'role' => $role,
        'actif' => false
    );
    $file = json_encode($users);
    file_put_contents('data.json', $file);
    header("Location:index.html");
}

?>
<body></body>
</html>
