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
