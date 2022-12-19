<?php
session_start();
if(!isset($_SESSION['login']) or $_SESSION['role'] != "adminClient"){
    session_destroy();
    header("Location:../index.html");
    exit;
}

$heures = htmlspecialchars($_POST['heures']);
$minutes = htmlspecialchars($_POST['minutes']);
$secondes = htmlspecialchars($_POST['secondes']);
$successives_attempts = htmlspecialchars($_POST['successives_attempts']);

$param = array(
    'heures' => $heures,
    'minutes' => $minutes,
    'secondes' => $secondes,
    'in_time' => strtotime($heures . ":" . $minutes . ":" . $secondes),
    'successives_attempts' => $successives_attempts
);

file_put_contents("db/param_attempts.php", json_encode($param), "w");