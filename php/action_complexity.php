<?php
// Démarrage de la session
session_start();
// Verification de si la session est correcte
if(!isset($_SESSION['login']) or $_SESSION['role'] != "adminClient"){
    session_destroy();
    header("Location:../index.html");
    exit;
}

// Récupération des informations de complexités dans le json
$complexity = json_decode(file_get_contents("db/complexity.json"));

// Récupération des variables pour la complexité du mot de passe

$min_car = htmlspecialchars($_POST['min_car']);
$med_car = htmlspecialchars($_POST['med_car']);
$opti_car = htmlspecialchars($_POST['opti_car']);

$min_digit = htmlspecialchars($_POST['min_digit']);
$med_digit = htmlspecialchars($_POST['med_digit']);
$opti_digit = htmlspecialchars($_POST['opti_digit']);

$min_specials = htmlspecialchars($_POST['min_spec']);
$med_specials = htmlspecialchars($_POST['med_spec']);
$opti_specials = htmlspecialchars($_POST['opti_spec']);

$min_maj = htmlspecialchars($_POST['min_maj']);
$med_maj = htmlspecialchars($_POST['med_maj']);
$opti_maj = htmlspecialchars($_POST['opti_maj']);

$param = array(
    "min_car" => $min_car,
    "med_car" => $med_car,
    "opti_car" => $opti_car,

    "min_digit" => $min_digit,
    "med_digit" => $med_digit,
    "opti_digit" => $opti_digit,

    "min_specials" => $min_specials,
    "med_specials" => $med_specials,
    "opti_specials" => $opti_specials,

    "min_maj" => $min_maj,
    "med_maj" => $med_maj,
    "opti_maj" => $opti_maj,
);

file_put_contents('db/complexity.json', json_encode($param), 'w');