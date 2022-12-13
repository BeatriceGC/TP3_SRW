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
            $salt_bdd = json_decode(file_get_contents("salt.json"), true);
            foreach($salt_bdd as $slt){
                // Récupération du sel lié au compte
                if ($slt->name == $id) {
                    $salt = $slt;
                }
            }
            if (!isset($salt)) $salt = "ceciestleselpourlemotdepasse";
//            $pre_cipher = $salt->salt . $mdp;
            $cipher = hash_hmac('sha256', $mdp, $salt->salt);
            if ($usr->password === $cipher and $usr->actif) {
                // la connexion est réussie
                $_SESSION['login'] = $usr->name;
                $_SESSION['role'] = $usr->role;
                if ($usr->role == "admin") {
                    header("Location:php/admin.php");
                } else if ($usr->role = "affaire") {
                    header("Location:php/affaireClient.php");
                } else if ($usr->role = "resident") {
                    header("Location:php/residentielClient.php");
                }
            }
        }
    }
    // Meaning no account is corresponding.
    header("Location:index.html");
    exit;
} else {
    // Utilisateur veut s'inscrire
    // création du sel
    $salt_bdd = json_decode(file_get_contents("salt.json"), true);
    $salt = "ceciestleselpourlemotdepasse";
//    $saltedPassword = $salt . $mdp;
    $passwordHash = hash_hmac('sha256', $mdp, $salt);
    $users[] = array(
        'name' => $id,
        'email' => $email,
        'password' => $passwordHash,
        'role' => $role,
        'actif' => false
    );
    $salt_bdd[] = array (
        'salt' => $salt,
        'name' => $id
    );
    $file = json_encode($users);
    file_put_contents('data.json', $file);
    file_put_contents("salt.json", json_encode($salt_bdd));
    header("Location:index.html");
}

?>
<body></body>
</html>
