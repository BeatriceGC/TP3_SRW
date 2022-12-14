<!DOCTYPE html>
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
            $salt_bdd = json_decode(file_get_contents("salt.json"));
            foreach ($salt_bdd as $salt) {
                if ($salt->name == $usr->name){
                    $slt = $salt->salt;
                    $iter = $salt->iteration;
                }
            }
            $saltedPassword = $slt . $mdp;
            $passwordHash = hash_pbkdf2('sha256', $saltedPassword, $slt, $iter);
            if ($usr->password === $passwordHash and $usr->actif) {
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
    echo ("La tentative de connexion ayant échoué, cliquez <a href='index.html'>ici</a> pour retourner à l'accueil");
} else {
    $salt_bdd = json_decode(file_get_contents("salt.json"), true);
    $salt = "ceciestleselpourlemotdepasse";
    $saltedPassword = $salt . $mdp;
    $passwordHash = hash_pbkdf2('sha256', $saltedPassword, $salt, 1000);
    $users[] = array(
        'name' => $id,
        'email' => $email,
        'password' => $passwordHash,
        'role' => $role,
        'actif' => false
    );
    $salt_bdd[] = array(
        'salt' => $salt,
        'iteration' => 1000,
        'name' => $id
    );
    $file = json_encode($users);
    file_put_contents('data.json', $file);
    file_put_contents('salt.json', json_encode($salt_bdd));
    header("Location:index.html");
}