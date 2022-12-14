<?php
function random($car): string
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