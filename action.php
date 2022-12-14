<!DOCTYPE html>
<?php
require("php/fonctions.php");
session_start();
$id = htmlspecialchars($_POST['name']);
$email = htmlspecialchars($_POST['email']);
$mdp = htmlspecialchars($_POST['password']);
$mdp2 = htmlspecialchars($_POST['password2']);
$role = htmlspecialchars($_POST['typeClient']);

$users = json_decode(file_get_contents("data.json"));
$salt_bdd = json_decode(file_get_contents("salt.json"));
$log = json_decode(file_get_contents("log.json"));

$ip = getIp();
$date = date('d-m-y h:i:s');

if (empty($mdp2)) {
    // Utilisateur veut se connecter
    foreach ($users as $usr) {
        // Test des identifiants dans la bdd
        if ($usr->email == $email) {
            foreach ($salt_bdd as $salt) {
                if ($salt->name == $usr->name){
                    $slt = $salt->salt;
                    $iter = $salt->iteration;
                    $hash = $salt->hash;
                }
            }
            $saltedPassword = $slt . $mdp;
            $passwordHash = hash_pbkdf2($hash, $saltedPassword, $slt, $iter);
            if ($usr->password === $passwordHash and $usr->actif) {
                // la connexion est réussie
                $_SESSION['login'] = $usr->name;
                $_SESSION['role'] = $usr->role;

                // Enregistrement de la connexion dans les logs
                $log[] = array(
                    'address' => $ip,
                    'time' => $date,
                    'account' => $email,
                    'action' => 'login',
                    'state' => true
                );
                file_put_contents('log.json', json_encode($log));

                // Redirection vers la session attribuée
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
    // Si la connexion échoue
    if (!isset($_SESSION['login'])) {
        // Enregistrement de la tentative de connexion
        $log[] = array(
            'address' => $ip,
            'time' => $date,
            'account' => $email,
            'action' => 'login',
            'state' => false
        );
        file_put_contents('log.json', json_encode($log));
        echo ("La tentative de connexion ayant échoué, cliquez <a href='index.html'>ici</a> pour retourner à l'accueil");
        header("Location:index.html");
    }
} else {
    $salt = random(32);
    $iter = mt_rand(12, 10000);
    $hash = get_algo();

    $saltedPassword = $salt . $mdp;
    $passwordHash = hash_pbkdf2($hash, $saltedPassword, $salt, $iter);

    // Enregistrement de l'utilisateur
    $users[] = array(
        'name' => $id,
        'email' => $email,
        'password' => $passwordHash,
        'role' => $role,
        'actif' => false
    );

    // Enregistrement du sel hash et iter de l'utilisateur
    $salt_bdd[] = array(
        'hash' => $hash,
        'salt' => $salt,
        'iteration' => $iter,
        'name' => $id
    );

    // Enregistrement de la création de compte dans les logs
    $log[] = array(
        'address' => $ip,
        'time' => $date,
        'account' => $email,
        'action' => 'signup',
        'state' => true
    );

    file_put_contents('log.json', json_encode($log));
    $file = json_encode($users);
    file_put_contents('data.json', $file);
    file_put_contents('salt.json', json_encode($salt_bdd));
    header("Location:index.html");
}