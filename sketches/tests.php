<?php
function random($car): string
{
    $string = "";
    $chaine = "abcdefghijklmnpqrstuvwxy";
    srand((double)microtime()*1000000);
    for($i=0; $i<$car; $i++) {
        $string .= $chaine[rand()%strlen($chaine)];
    }
    return md5($string);
}

// APPEL
// Génère une chaine de longueur 20
//$chaine = random(32);