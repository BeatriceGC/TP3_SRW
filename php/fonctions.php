<?php
function random(int $car): string
{
    $string = "";
    $chaine = "abcdefghijklmnpqrstuvwxy";
    srand((double)microtime() * 1000000);
    for ($i = 0; $i < $car; $i++) {
        $string .= $chaine[rand() % strlen($chaine)];
    }
    return md5($string);
}

function getIp()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function get_algo(): string
{
    // Suppression des algorithmes de hashes non compatibles
    do $rand = mt_rand(0, 59);
    while(($rand <= 44 and $rand >= 29));

    return hash_algos()[$rand];
}

function cipher_password(string $password, string $hash, string $salt, int $iter) : string {
    return hash_pbkdf2($hash, ($salt . $password), $salt, $iter);
}

function compare_password(string $name, string $clear_mdp) : bool {
    $users = json_decode(file_get_contents("db/data.json"));
    $salt_bdd = json_decode(file_get_contents("db/salt.json"));
    // Recherche de l'utilisateur $name dans la bdd
    for ($i = 0; $i < sizeof($users); $i++) {
        // Utilisateur trouvé
        if ($users[$i]->name == $name) {
            // On récupère son sel, hash et itérations.
            for ($j = 0; $j < sizeof($salt_bdd); $j++) {
                if ($salt_bdd[$j]->name == $name) {
                    $slt = $salt_bdd[$j]->salt;
                    $iter = $salt_bdd[$j]->iteration;
                    $hash = $salt_bdd[$j]->hash;
                }
            }
            // Cipher du mot de passe de la même façon que l'utilisateur
            $passwordHash = cipher_password($clear_mdp, $hash, $slt, $iter);

            // Comparaison des résultats :
            if($passwordHash == $users[$i]->password) return true;
            else return false;
        }
    }
    return false;
}

// Fonction pour trouver si un compte à déjà fait une tentative de connexion récente ou non
function search_account_attempts(string $acc) : bool {
    $acc_attempts = json_decode(file_get_contents("db/attempts.json"));
    for ($i = 0; $i < sizeof($acc_attempts); $i++) {
        // Recherche par nom et par ip pour éviter les attaques par force brute
        if ($acc_attempts[$i]->name == $acc) {
            // Regarde si la dernière tentative est récente
            $interval = new DateInterval("PT2M");
            $time = date_create_from_format("U", $acc_attempts->timestamp)->add($interval)->format("H:i:s");
            // La dernière tentative remonte à moins de 2 minutes
            if($time >= time()) return true;
            else return false;
        }
    }
    return false;
}

function get_attempts(string $acc) : int {
    $acc_attempts = json_decode(file_get_contents("db/attempts.json"));
    for ($i = 0; $i < sizeof($acc_attempts); $i++){
        // Retrouver l'utilisateur
        if($acc_attempts[$i]->name == $acc) {
            return $acc_attempts[$i]->cut_attempts;
        }
    }
    return 0;
}

function increment_attempt(string $acc) : void {
    $acc_attempts = json_decode(file_get_contents("db/attempts.json"));
    $cur = 0;
    for ($i = 0; $i < sizeof($acc_attempts); $i++){
        // Retrouver l'utilisateur
        if($acc_attempts[$i]->name == $acc) {
            // On a bien trouvé le compte
            $cur = $acc_attempts[$i]->cur_attempts + 1;
            $acc_attempts[$i] = array(
                'name' => $acc,
                'timestamp' => new DateTime(),
                'cur_attempts' => $cur
            );
            file_put_contents("db/attempts.json", json_encode($acc_attempts));
        }
    }
}

echo (date('h:i:s'));