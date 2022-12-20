<?php
require "fonctions.php";
session_start();

// On fait une demande de changement de mot de passe depuis la session de compte
if(!isset($_SESSION['login'])) {
    $from_acc = true;

    $name = $_SESSION['login'];
    $old_mdp = htmlspecialchars($_POST['old']);
    $new_mdp = htmlspecialchars($_POST['password']);
    $conf_pass = htmlspecialchars($_POST['password2']);

    // Vérification de la validité des deux nouveaux mdp
    if ($new_mdp != $conf_pass) {
        echo("Les mots de passe ne correspondent pas. Veuillez réessayer.\n");
        switch ($_SESSION['role']){
            case "adminClient":
                echo("Cliquez " . " <a href='admin.php'>ICI</a>" . " pour revenir en arrière");
                break;
            case "affaireClient":
                echo("Cliquez " . " <a href='affaireClient.php'>ICI</a>" . " pour revenir en arrière");
                break;
            case "residentielClient":
                echo("Cliquez " . " <a href='residentielClient.php'>ICI</a>" . " pour revenir en arrière");
                break;
        }
        exit;
    }
} else { // On fait la demande de changement de mot de passe depuis l'index
    $from_acc = false;

    $name = htmlspecialchars($_POST['name_signe']);
    $acc = htmlspecialchars($_POST['email_sign']);
    $new_mdp = htmlspecialchars($_POST['password_change']);
}

// Récupération de la base de donnée
$users = json_decode(file_get_contents("db/data.json"));
$salt_bdd = json_decode(file_get_contents("db/salt.json"));
$log = json_decode(file_get_contents("db/log.json"));

// Récupération de l'IP et de la date pour les logs
$ip = getIp();
$date = date('d-m-y h:i:s');

// Accès à l'utilisateur dans la base de données:
for ($i = 0; $i < sizeof($users); $i++){
    // Recherche du nom de l'utilisateur pour accéder à ses informations
    if ($name == $users[$i]->name){
        // Evaluation du mot de passe
        if($from_acc) {
            if(compare_password($users[$i]->name, $old_mdp)){
                // L'ancien mot de passe entré est le bon, modification du mot de passe :
                // Récupération des informations de cryptage du compte :
                for ($j = 0; $j < sizeof($salt_bdd); $j++) {
                    if ($salt_bdd[$j]->name == $name) {
                        $slt = $salt_bdd[$j]->salt;
                        $iter = $salt_bdd[$j]->iteration;
                        $hash = $salt_bdd[$j]->hash;
                    }
                }
                // Si tout se passe bien
                if(isset($slt) and isset($hash) and isset($iter)) {
                    // Cipher du nouveau mot de passe
                    $passwordHash = cipher_password($new_mdp, $hash, $slt, $iter);
                    // Sauvegarde du nouveau mot de passe
                    $users[$i] = array(
                        'name' => $_SESSION['login'],
                        'email' => $_SESSION['email'],
                        'password' => $passwordHash,
                        'role' => $_SESSION['role'],
                        'actif' => true
                    );
                    file_put_contents('db/data.json', json_encode($users));
                    // Enregistrement du changement de mot de passe dans les logs
                    $log[] = array(
                        'address' => $ip,
                        'time' => $date,
                        'account' => $_SESSION['email'],
                        'action' => 'password change',
                        'state' => true
                    );
                    file_put_contents('db/log.json', json_encode($log));

                    // Redirection vers la session attribuée
                    if ($_SESSION['role'] == "adminClient") {
                        header("Location:admin.php");
                    } else if ($_SESSION['role'] == "affairesClient") {
                        header("Location:affaireClient.php");
                    } else if ($_SESSION['role'] == "residentielClient") {
                        header("Location:residentielClient.php");
                    } else header("Location:php/deconnexion.php");
                } else {
                    // Enregistrement de l'échec de changement de mot de passe dans les logs
                    $log[] = array(
                        'address' => $ip,
                        'time' => $date,
                        'account' => $_SESSION['email'],
                        'action' => 'password change',
                        'state' => false
                    );
                    file_put_contents('db/log.json', json_encode($log));
                    session_destroy();
                    header("Location:../index.html");
                }
            }
        }
    }
}