<?php

require("fonctions.php");
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
    // Test des identifiants dans la bdd
    if ($users[$i]->email == $email) {
        // Regarder si l'utilisateur a le droit de se connecter
        // On récupère son nombre de tentatives
        $cur = get_attempts($email);
        $total = get_total($email);
        // On regarde s'il y en a pas trop par rapport au max dans les paramètres
        if ($cur >= $attempts_param->successives_attempts) {
            // Si la limite de temps n'est pas encore dépassée
            if ($acc_attempts[$i]->timestamp >= time() + 2 * 60) {
                echo("Si vous avez oublié votre mot de passe vous pouvez cliquer <a href='changepass.php'>ici</a> pour le modifier.");
                exit;
            }
        }
        if(!check_validity($email)){
            echo("Vous avez dépassé le nombre de tentative maximale.\n");
            echo("Vous pouvez changer votre mot de passe <a href='changepass.php'>ici</a>.");
            exit;
        }
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

            // Reset les tentatives du compte
            reset_acc_attempts($email, true);

            // Redirection vers la session attribuée
            switch ($_SESSION['role']){
                case "adminClient":
                    header("Location:admin.php");
                    break;
                case "affaireClient":
                    header("Location:affaireClient.php");
                    break;
                case "residentielClient":
                    header("Location:residentielClient.php");
                    break;
            }
        }
    }
}
// Si la connexion échoue
if (!isset($_SESSION['login'])) {
    // On regarde si c'est la première tentative de connexion du compte ou non
    if (search_account_attempts($email)) {
        // On récupère le nombre courant de tentative
        $cur = get_attempts($email);
        // On vérifie que ce n'est pas plus que le max
        if ($cur >= $attempts_param->successives_attempts) {
            if(check_delay($email)) {
                echo("Trop de tentatives en peu de temps. Vous allez devoir attendre avant de réessayer");
                echo("Si vous avez oublié votre mot de passe vous pouvez cliquer <a href='changepass.php'>ici</a> pour le modifier.");
                exit;
            } else {
                if (check_validity($email)) {
                    reset_acc_attempts($email, false);
                } else {
                    echo("Vous avez dépassé le nombre de tentative maximale.\n");
                    echo("Vous pouvez changer votre mot de passe <a href='changepass.php'>ici</a>.");
                    exit;
                }
            }
        } else {
            increment_attempt($email);
        }
    } else {
        // On crée sa première entrée
        increment_attempt($email);
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
    echo("La tentative de connexion ayant échoué, cliquez <a href='../index.html'>ici</a> pour retourner à l'accueil\n");
}