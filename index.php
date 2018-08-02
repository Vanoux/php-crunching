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
//stristr() —> Version insensible à la casse de strstr() =>  Trouve la première occurrence dans une chaîne
$nbWord = 0; // nb de mots = à 0
foreach($dico as $w){ 
    if (stristr($w, 'w')){ // Si pour chaque mots parcouru dans $dico, on trouve la première occurrence de $w = 'w'
        $nbWord++;         // alors l'incrementer à $word (pour comptabiliser les mots)
    };  
} echo "=> " . $nbWord . "<br>";// afficher le nombre de mots avec le lettre 'w' => résultat 347 ?

// ou bien en reprenant le process de la question d'avant 
// avec stripos() -> Cherche la position de la première occurrence (exemple ici "w") dans une chaîne sans tenir compte de la casse (contrairement à strpo())
// PB avec stripos() = ne compte pas les w en début de mots car cherche la position et cette facon de faire ne tient pas compte de la position 0 car false!
echo " et avec la 2ème méthode => " . count(array_filter($dico, function($w){
    return stripos($w, 'w'); // résultat => 347 ! ok!
}))
?>


<h4>Combien de mots finissent par la lettre « q » ?</h4>
<?php 
$nbWord = 0;
foreach($dico as $q){ 
    //strrchr() —> Trouve la dernière occurrence d'un caractère dans une chaîne
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
    return substr($q, -1)=='q'; // resutat = 0 , pourquoi?? 
}))

?>

<hr>
<!--########################################################################################################################-->

<h1>Liste de films</h1>

<?php
$string = file_get_contents("films.json", FILE_USE_INCLUDE_PATH);
$brut = json_decode($string, true);
$top = $brut["feed"]["entry"]; # liste de films
?>

<h4>Afficher le top 10 des films sous forme de liste : </h4>
<?php
//Avec un for :
// for($i=0; $i<=9; $i++){
//     echo $i+1 . " : " . $top [$i]['im:name']['label'] . "<br>";
// }
// Avec un foreach :
foreach ($top as $key => $value){
    if ($key < 10){
    echo $key+1 . " : " . $value['im:name']['label'] . "<br>";
    }
} 
?>

<h4>Quel est le classement du film « Gravity » ?</h4>
<?php
// Avec un for :
// for($i=0; $i<=100; $i++){
//     if($top [$i]['im:name']['label']=='Gravity'){
//         echo $top [$i]['im:name']['label'] . " est à la " . $i . " ème position . ";
//     } 
// }

// Avec un foreach :
foreach($top as $key => $value){
    if($value['im:name']['label']=="Gravity"){
        echo $value['im:name']['label'] . " est à la " . $key . "ème position";
    }
}
?>

<h4>Quel est le réalisateur du film « The LEGO Movie » ?</h4>
<?php
// Avec un for :
// for($i=0; $i<=100; $i++){
//     if($top [$i]['im:name']['label']=='The LEGO Movie'){
//         echo "Les réalisateurs de ce film sont : " . $top [$i]['im:artist']['label'] ;
//     } 
// }
// Avec un foreach :
foreach($top as $key => $value){
    if($value['im:name']['label']=='The LEGO Movie'){
        echo "Les réalisateurs de ce film sont : " . $value['im:artist']['label'];
    }
}
?>

<h4>Combien de films sont sortis avant 2000 ?</h4>
<?php
// Avec un for :
for($i=0; $i<=100; $i++){
    if($top [$i]['im:releaseDate']['label'][0]<2){
        echo $top [$i]['im:name']['label']. "<br>";
        $film++;
    } 
}echo "Le nombre de films sortis avant 2000 : " . $film .  "<br>";

// Avec un foreach (resultat 12 films ???)
// foreach($top as $key => $value){
//     if($value['im:releaseDate']['label'][0]<2){
//         echo $value['im:name']['label'] . "<br>";
//         $film++;
//     }
// }echo "Le nombre de films sortis avant 2000 : " . $film .  "<br>";
?>

<h4>Quel est le film le plus récent ? Le plus vieux ?</h4>
<?php
//$array = [];
// for($i=0; $i<100; $i++){
//     $date = substr($top[$i]['im:releaseDate']['label'], 0, 10);
//        $array[$i]=$date;
       //echo $array[$i] . "<br>"; 
           
    //} 
    // echo max($array) . "<br>";
    // echo min($array) . "<br>";

foreach ($top as $key => $value){
    $youngOld[$value ['im:name'] ['label']] = substr($value ['im:releaseDate']['label'], 0, 10) . "<br>";
} //var_dump($youngOld); 
foreach ($youngOld as $key => $value){
    if ($value == max($youngOld)){
        echo  "Nom du film le plus récent : " . $key . " => Date de Sortie : " . max($youngOld) . "<br>";
    }
    if ($value == min($youngOld)){
        echo "Nom du film le plus vieux : " . $key . " => Date de Sortie : " . min($youngOld) ;
    }
}

?>

<h4>Quelle est la catégorie de films la plus représentée ?</h4>
<?php
foreach ($top as $key => $value) {
    //$array[svalue ['category']['attributes']['label']] = array_count_values($array); //array_count_value() = Compte le nombre de valeurs d'un tableau
    $array[] = $value['category']['attributes']['label'];
    //var_dump($array);
    $arrayCount = array_count_values($array);//array_count_value() = Compte le nombre de valeurs d'un tableau
}
//print_r($arrayCount);

foreach ($arrayCount as $key => $value) {
    if ($value == max($arrayCount)) {
    echo $key;		
    }
}
?>

<h4>Quel est le réalisateur le plus présent dans le top100 ?</h4>
<?php
foreach ($top as $key => $value){
    $director[] = $value['im:artist']['label'];
    $arrayCount = array_count_values($director);
} //print_r($arrayCount);

foreach ($arrayCount as $key => $value){
    if ($value == max($arrayCount)){
        echo $key;
    }
}
?>

<h4>Combien cela coûterait-il d'acheter le top10 sur iTunes ? de le louer ?</h4>
<?php
foreach ($top as $key => $value){
    if($key < 10){
        $sum += $value['im:price']['attributes']['amount']; // pareil que $sum = $sum + $value.....
        //echo  $value['im:price']['attributes']['amount']  . "<br>";    
    }  
} echo $sum . "<br>";
?>

<h4>Quel est le mois ayant vu le plus de sorties au cinéma ?</h4>
<?php
foreach ($top as $key => $value){
    $array = explode (" ", $value['im:releaseDate']['attributes']['label']);//explode = "explose" une string de plusieurs mots à chaques espaces " " pour en faire un array.
    $month[] = $array[0];
    $arrayCount = array_count_values($month);
} 
//print_r($arrayCount);
foreach ($arrayCount as $key => $value){
    if ($value == max($arrayCount)){
        echo "=> " . $key . " : " . $value . " sorties" . "<br>";
    }
}
?>

<h4>Quels sont les 10 meilleurs films à voir en ayant un budget limité ?</h4>
<?php
foreach ($top as $key => $value){
    $price[] = $value['im:price']['attributes']['amount'];
    $arrayCount = array_count_values($price);
   // $movies[] = $value['im:name']['label'];
}
// print_r($arrayCount);
//print_r($movies);

foreach ($arrayCount as $key => $value){
    //echo $key . " => " . $value . "<br>";
    if($key < 8){
        echo "Il y a " . $value . " films à " . $key . " $ " . "<br>";
    }  
}

    
?>

</body>
</html>