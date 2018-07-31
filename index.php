<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Dictionnaire</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link rel="stylesheet" type="text/css" media="screen" href="main.css" /> -->
</head>
<body>
 
<h1>Dictionnaire</h1>
<br>

<?php
//file_get_contents() — Lit tout un fichier dans une chaîne
$string = file_get_contents("dictionnaire.txt", FILE_USE_INCLUDE_PATH); // FILE_USE_INCLUDE_PATH = l'utilisation du fichier inclut le chemin
$dico = explode("\n", $string); //Coupe une chaîne en segments (= transforme en array! équivalent de split en js)
?>

<h4>Combien de mots contient ce dictionnaire ?</h4>
<?php  // count() —> Compte tous les éléments d'un tableau ou quelque chose d'un objet
echo "=> " . count($dico); ?>


<h4>Combien de mots font exactement 15 caractères ?</h4>
<?php  
//echo "=> " . count($dico == 15); -> resultat 1 ? = fonctionne pas!

// (il faut que je trouve des chaines de 15 caractères dans l'array dico)
// Pour cela :
// - Je dois compter tous les élements du tableau (integer) => count()
// - Je dois filtrer les mots du tableau avec => array_filter()—> Filtre les éléments d'un tableau grâce à une fonction utilisateur{} (voir doc php!)
// - Je dois trouver la longueur des mots => strlen() —> Calcule la taille d'une chaîne

echo "=> " . count(array_filter($dico, function($x){ 
    return strlen($x) == 15; // résultat 12298 ? = fonctionne !!
}))
?>


<h4>Combien de mots contiennent la lettre « w » ?</h4>
<?php // Même process que la question d'avant (à essayer avec une autre methode --> foreach?)
// stripos() -> Cherche la position de la première occurrence (exemple ici "w") dans une chaîne sans tenir compte de la casse (contrairement à strpo())
$nbWord = 0; // nb de mots = à 0
foreach($dico as $w){ 
    if (stripos($w, 'w')){ // Si pour chaque mots parcouru dans $dico, on trouve la première occurrence de $w = 'w'
        $nbWord++;         // alors l'incrementer à $word (pour comptabiliser les mots)
    };  
} echo "=> " . $nbWord . "<br>";// afficher le nombre de mots avec le lettre 'w' => résultat 347 ?

// ou bien en reprenant le process de la question d'avant :
echo " et avec la 2ème méthode => " . count(array_filter($dico, function($w){
    return stripos($w, 'w'); // résultat => 347 ! ok!
}))
?>


<h4>Combien de mots finissent par la lettre « q » ?</h4>
<?php 
$nbWord = 0;
foreach($dico as $q){ //strrchr() —> Trouve la dernière occurrence d'un caractère dans une chaîne
    // if(strrchr($q, 'q')){
    //      $nbWord++; // resultat => 16849 ???? ca fait beaucoup!!
    // }

    //Exemple doc php de substr() : $rest = substr("abcdef", -1);    // retourne "f"
    if(substr($q, -1)=='q'){ // si le 2ème paramètre est négatif = commence à la fin de la string
        $nbWord++; // resultat = 8 ?? 
    }  
} echo "=> " . $nbWord . "<br>";

// ou bien avec la 2ème méthode :
echo " et avec la 2ème méthode => " . count(array_filter($disco, function($q){
    return substr($q, -1)=='q'; // resutat = 0 ?? 
}))

?>

</body>
</html>