<?php
session_start();
if(!isset($_SESSION['login']) or $_SESSION['role'] != "adminClient"){
    session_destroy();
    header("Location:../index.html");
    exit;
}

$years = htmlspecialchars($_POST['years']);
$months = htmlspecialchars($_POST['months']);
$days = htmlspecialchars($_POST['days']);
$max_attempts = htmlspecialchars($_POST['max_attempt']);

$timestamp = array(
    'years' => $years,
    'months' => $months,
    'days' => $days,
    'validity' => strtotime($years . '-' . $months . '-' . $days),
    'max_attempts' => $max_attempts
);

file_put_contents("db/validity.json", json_encode($timestamp));
header('Location:admin.php');