<?php
require("php/fonctions.php");
session_start();

// Récupération des variables
$id = htmlspecialchars($_POST['name_sign']);
$email = htmlspecialchars($_POST['email_sign']);
$mdp = htmlspecialchars($_POST['password_sign']);
$mdp2 = htmlspecialchars($_POST['password_confirm']);
$role = htmlspecialchars($_POST['typeClient']);

// Récupération de la base de données
$users = json_decode(file_get_contents("db/data.json"));
$salt_bdd = json_decode(file_get_contents("db/salt.json"));
$log = json_decode(file_get_contents("db/log.json"));

// Récupération de l'IP et de la date pour les logs
$ip = getIp();
$date = date('d-m-y h:i:s');

if($mdp == $mdp2){
    $salt = random(32);
    $iter = mt_rand(12, 10000);
    $hash = get_algo();

    $passwordHash = cipher_password($mdp, $hash, $salt, $iter);

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

    file_put_contents('db/log.json', json_encode($log));
    file_put_contents('db/data.json', json_encode($users));
    file_put_contents('db/salt.json', json_encode($salt_bdd));
    header("Location:../index.html");
}

