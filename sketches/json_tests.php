<!--Pour écrire dans un fichier JSON en PHP, vous pouvez utiliser la fonction
json_encode pour encoder les données dans un format JSON,
puis la fonction file_put_contents pour enregistrer les données dans un fichier sur le serveur.
Voici un exemple de code qui montre comment effectuer ces étapes : -->
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

<!--Pour lire les données d'un fichier JSON en PHP,
vous pouvez utiliser la fonction file_get_contents pour lire
le contenu du fichier en tant que chaîne de caractères,
puis la fonction json_decode pour décoder les données
de la chaîne JSON en un objet ou un tableau PHP.
Voici un exemple de code qui montre comment effectuer ces étapes :-->
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

<!--Vous pouvez également utiliser la fonction file_get_contents
avec l'option FILE_USE_INCLUDE_PATH pour lire un fichier JSON à
partir de l'emplacement actuel du script PHP. Cela peut être utile
si vous souhaitez lire un fichier JSON à partir d'un emplacement
relatif à votre script PHP, plutôt que de spécifier un chemin d'accès absolu. -->