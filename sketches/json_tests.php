<?php

// Définir les données à écrire dans le fichier JSON
$data = array(
  "nom" => "John Doe",
  "email" => "johndoe@example.com",
  "age" => 35
);

// Encoder les données en format JSON
$jsonData = json_encode($data);

// Définir le nom du fichier où les données seront enregistrées
$fileName = "data.json";

// Écrire les données dans le fichier
file_put_contents($fileName, $jsonData);

?>


<?php

// Définir le nom du fichier à lire
$fileName = "data.json";

// Lire le contenu du fichier en tant que chaîne de caractères
$jsonData = file_get_contents($fileName);

// Décoder les données JSON en un objet ou un tableau PHP
$data = json_decode($jsonData);

// Afficher les données
echo $data["nom"] . "<br />";
echo $data["email"] . "<br />";
echo $data["age"] . "<br />";

?>

<?php

// Définir le nom du fichier à lire
$fileName = "data.json";

// Lire le contenu du fichier en tant que chaîne de caractères
// en utilisant
