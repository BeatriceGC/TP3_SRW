<?php
$password = "hello";
// On utilise l'algorithme PASSWORD_BCRYPT pour crypter le mot de passe
$passwordHash = password_hash($password, PASSWORD_BCRYPT);

if (password_verify($password, $passwordHash)) {
    // Le mot de passe est correct
} else {
    // Le mot de passe est incorrect
}

// Génération d'un sel aléatoire
$salt = bin2hex(random_bytes(16));

// Concaténation du sel et du mot de passe
$saltedPassword = $salt . $password;

// Hashage du mot de passe avec l'algorithme SHA-256
$passwordHash = hash_hmac('sha256', $saltedPassword, $salt);

// Génération d'une clef secrète aléatoire
$secretKey = random_bytes(32);

// Calcul du hash du mot de passe en utilisant la clef secrète comme "grain de sel"
$passwordHash = hash_hmac('sha256', $password, $secretKey);

// Génère un sel aléatoire de 16 octets (128 bits)
$salt = random_bytes(16);


$password = 'mypassword';
$salt = 'mysalt';

// Hash the password using sha-256 and the salt
$hashed_password = hash_pbkdf2('sha256', $password, $salt, 10000, 32);

// Compare the hashed password to the stored password
if ($hashed_password === $stored_password) {
    // The passwords match
    echo "The password is correct!";
} else {
    // The passwords do not match
    echo "The password is incorrect!";
}
