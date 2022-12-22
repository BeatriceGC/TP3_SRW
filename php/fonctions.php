<?php
function random(int $car) : string {
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

function get_algo()
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
    for ($i = 0; $i <= sizeof($acc_attempts); $i++) {
        // Recherche par nom et par ip pour éviter les attaques par force brute
        if ($acc_attempts[$i]->acc == $acc) {
            // Regarde si la dernière tentative est récente
            if ($acc_attempts[$i]->timestamp + 2 * 60 >= time()) return true;
            else return false;
        }
    }
    return false;
}

function get_attempts(string $acc) : int{
    $acc_attempts = json_decode(file_get_contents("db/attempts.json"));
    for ($i = 0; $i <= sizeof($acc_attempts); $i++){
        // Retrouver l'utilisateur
        if($acc_attempts[$i]->acc == $acc) {
            return $acc_attempts[$i]->cur_attempts;
        }
    }
    return 0;
}

function get_total(string $acc) : int {
    $acc_attempts = json_decode(file_get_contents("db/attempts.json"));
    for ($i = 0; $i <= sizeof($acc_attempts); $i++){
        // Retrouver l'utilisateur
        if($acc_attempts[$i]->acc == $acc) {
            return $acc_attempts[$i]->total_attempts;
        }
    }
    return 0;
}

function increment_attempt(string $acc) : void {
    $acc_attempts = json_decode(file_get_contents("db/attempts.json"));
    $cur = get_attempts($acc);
    $total = get_total($acc);
    for ($i = 0; $i <= sizeof($acc_attempts); $i++) {
        // Retrouver l'utilisateur
        if ($acc_attempts[$i]->acc == $acc) {
            // On a bien trouvé le compte
            $cur += 1;
        }
    }
    $acc_attempts[$i] = array(
        'acc' => $acc,
        'timestamp' => time(),
        'cur_attempts' => $cur,
        'total_attempts' => $total
    );
    file_put_contents("db/attempts.json", json_encode($acc_attempts));
}

function reset_acc_attempts(string $acc, bool $rst) : void {
    $acc_attempts = json_decode(file_get_contents("db/attempts.json"));
    for ($i = 0; $i < sizeof($acc_attempts); $i++) {
        if($acc_attempts[$i]->acc == $acc and !$rst){
            $total_att = $acc_attempts[$i]->total_attempts + 1;
            // On reset le cur et on ajoute une tentative au total
            $acc_attempts[$i] = array(
                'acc' => $acc,
                'timestamp' => time(),
                'cur_attempts' => 0,
                'total_attempts' => $total_att
            );
        } else {
            // On reset tout la dernière connexion du compte a fonctionné
            $acc_attempts[$i] = array(
                'acc' => $acc,
                'timestamp' => time(),
                'cur_attempts' => 0,
                'total_attempts' => 0
            );
        }
    }
    file_put_contents("db/attempts.json", json_encode($acc_attempts));
}

function check_delay (string $acc) : bool {
    $acc_attempts = json_decode(file_get_contents("db/attempts.json"));
    $param_attempts = json_decode(file_get_contents("db/param_attempts.json"));
    for ($i = 0; $i < sizeof($acc_attempts); $i++) {
        if($acc_attempts[$i]->acc == $acc){
            if ($acc_attempts[$i]->timestamp + $param_attempts->in_time >= time())
                return true;
            else
                return false;
        }
    }
    return false;
}

function check_validity (string $acc) : bool {
    $acc_attempts = json_decode(file_get_contents("db/attempts.json"));
    $param = json_decode(file_get_contents("db/validity.json"));
    for ($i = 0; $i < sizeof($acc_attempts); $i++) {
        if($acc_attempts[$i]->acc == $acc){
            if ($acc_attempts[$i]->total_attempts < $param->max_attempts )
                return true;
            else
                return false;
        }
    }
    return true;
}