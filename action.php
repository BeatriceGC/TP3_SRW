<!DOCTYPE html>
<?php
require("php/fonctions.php");
session_start();

// Récupération des variables
$id = htmlspecialchars($_POST['name']);
$email = htmlspecialchars($_POST['email']);
$mdp = htmlspecialchars($_POST['password']);
$mdp2 = htmlspecialchars($_POST['password2']);
$role = htmlspecialchars($_POST['typeClient']);

// Récupération de la base de données
$users = json_decode(file_get_contents("db/data.json"));
$salt_bdd = json_decode(file_get_contents("db/salt.json"));
$log = json_decode(file_get_contents("db/log.json"));

// Récupération de l'IP et de la date pour les logs
$ip = getIp();
$date = date('d-m-y h:i:s');

if (empty($mdp2)) {
    // Ouverture du fichier des tentatives de connexions seulement si c'est une connexion.
    $acc_attempts = json_decode(file_get_contents("db/attempts.json"));
    $attempts_param = json_decode(file_get_contents("db/param_attempts.json"));
    // Utilisateur veut se connecter
    for ($i = 0; $i < sizeof($users); $i++) {
        // On regarde si c'est la première tentative de connexion du compte ou non
//        if (search_account_attempts($users[$i]->name)) {
//            // On récupère le nombre courant de tentative
//            $cur = get_attempts($users[$i]->name);
//            // On vérifie que ce n'est pas plus que le max
//            if($cur >= $attempts_param->successives_attempts) {
//                // on fait patientier
//                exit;
//            } else {
//                // Incrémente le cur
//                exit;
//            }
//        }
        // Test des identifiants dans la bdd
        if ($users[$i]->email == $email) {
            // Comparaison des mots de passe
            if (compare_password($users[$i]->name, $mdp) and $users[$i]->actif) {
                // la connexion est réussie
                $_SESSION['login'] = $users[$i]->name;
                $_SESSION['role'] = $users[$i]->role;
                $_SESSION['email'] = $users[$i]->email;

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
                } else if ($_SESSION['role'] == "affairesClient") {
                    header("Location:php/affaireClient.php");
                } else if ($_SESSION['role'] == "residentielClient") {
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
        echo ("La tentative de connexion ayant échoué, cliquez <a href='index.html'>ici</a> pour retourner à l'accueil\n");
    }
} else {
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
    $file = json_encode($users);
    file_put_contents('db/data.json', $file);
    file_put_contents('db/salt.json', json_encode($salt_bdd));
    header("Location:index.html");
}
//else {
//    echo('Votre connexion à échoué plus de 5 fois. Vous allez devoir attendre avant de pouvoir continuer.\n');
//    echo ("La tentative de connexion ayant échoué, cliquez <a href='index.html'>ici</a> pour retourner à l'accueil\n");
//}