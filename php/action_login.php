<?php
require("php/fonctions.php");
session_start();

// Récupération des variables pour login
$email = htmlspecialchars($_POST['email_log']);
$mdp = htmlspecialchars($_POST['password_log']);

// Récupération de la base de données
$users = json_decode(file_get_contents("db/data.json"));
$salt_bdd = json_decode(file_get_contents("db/salt.json"));
$log = json_decode(file_get_contents("db/log.json"));

// Récupération de l'IP et de la date pour les logs
$ip = getIp();
$date = date('d-m-y h:i:s');

// Ouverture du fichier des tentatives de connexions
$acc_attempts = json_decode(file_get_contents("db/attempts.json"));
$attempts_param = json_decode(file_get_contents("db/param_attempts.json"));

// Utilisateur veut se connecter
for ($i = 0; $i < sizeof($users); $i++) {
    // Regarder si l'utilisateur a le droit de se connecter
    if(!empty($acc_attempts)) {
        // On récupère son nombre de tentatives
        $cur = get_attempts($email);
        // On regarde s'il y en a pas trop par rapport au max dans les paramètres
        if ($cur >= $attempts_param->successives_attempts)
            // Si la limite de temps n'est pas encore dépassée
            if ($acc_attempts[$i]->timestamp >= time()+2*60) {
                echo("Si vous avez oublié votre mot de passe vous pouvez cliquer <a href='changepass.php'>ici</a> pour le modifier.");
                exit;
            }
        $cur = 0; // Reset du compteur
        $acc_attempts[$i] = array(
            'acc' => $email,
            'timestamp' => $date,
            'cur_attempts' => $cur,
        );
        // On remet les tentatives de l'utilisateur à 0
        file_put_contents("db/attempts.json", json_encode($acc_attempts));
    }
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
                header("Location:admin.php");
            } else if ($_SESSION['role'] == "affairesClient") {
                header("Location:affaireClient.php");
            } else if ($_SESSION['role'] == "residentielClient") {
                header("Location:residentielClient.php");
            } else header("Location:deconnexion.php");
        }
    }
}
// Si la connexion échoue
if (!isset($_SESSION['login'])) {
    // On regarde si c'est la première tentative de connexion du compte ou non
    if (empty($acc_attempts)) {
        increment_attempt($email);
    } else {
        if (search_account_attempts($email)) {
            // On récupère le nombre courant de tentative
            $cur = get_attempts($email);
            // On vérifie que ce n'est pas plus que le max
            if ($cur >= $attempts_param[$i]->successives_attempts) {
                // on fait patientier
                exit;
            } else {
                increment_attempt($email);
            }
        }
    }
    // Enregistrement de la tentative de connexion
    $log[] = array(
        'address' => $ip,
        'time' => $date,
        'account' => $email,
        'action' => 'login',
        'state' => false
    );
    file_put_contents('log.json', json_encode($log));
    echo ("La tentative de connexion ayant échoué, cliquez <a href='../index.html'>ici</a> pour retourner à l'accueil\n");
}