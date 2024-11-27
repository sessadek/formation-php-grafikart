<?php
// $creneaux = [];
// while (true) {
//     $open_hour = (int) readline('open hour : ');
//     $close_hour = (int) readline('close hour : ');
//     if($open_hour >= $close_hour) {
//         echo "\ncréneaux erronée\n";
//     } else {
//         $creneaux[] = [$open_hour, $close_hour];
//         $action = readline('Ajouter un nouveau creneaux (n) : ');
//         if($action === 'n')  {
//             break;
//         }
//     }
// }

// $str = 'Le magasin est ouvert ';

// foreach($creneaux as $key => $creneau) {
//     if($key > 0) {
//         $str .= " et de ";
//     }
//     $str .= $creneau[0] . "h à " . $creneau[1]. "h";
// }



// echo $str;
// $client_hour = (int) readline('Client hour : ');

// $is_open = false;

// foreach($creneaux as $creneau) {
//     if($creneau[0] <= $client_hour && $client_hour <= $creneau[1]) {
//         $is_open = true;
//         break;
//     }
// }

// print_r($creneaux);
// print_r($is_open);
// if($is_open) {
//     echo 'Le magasin est ouvert';
// } else {
//     echo 'Le magasin est fermé';
// }

// $mot = readline("Entre une mot : ");
// $mot = strtolower($mot);
// $reverse = strrev($mot);
// if($mot === $reverse) {
//     echo "palyndrome";
// } else {
//     echo "not palyndrome";
// }


// $notes = [10, 15, 9];
// $notes2 = &$notes;
// $notes2[] = 16;
// $sum = array_sum($notes);
// $average = round($sum / count($notes), 2);
// var_dump($notes, $notes2);

// $insultes = ['con', 'merde'];
// $asterisc = [];
// $phrase = readline('Entre une phrase : ');
// $has_insulte = false;

// foreach($insultes as $insulte) {
//     if(str_contains($phrase, $insulte)) {
//         $has_insulte = true;
//         break;
//     }
// }
// if(!$has_insulte) {
//     echo "je trouve pas des insultes dans ce mot";
// }
// foreach($insultes as $insulte) {
    
//     $lettre = substr($insulte, 0, 1);
//     $taille = strlen($insulte) - 1;
//     $asterisc[] = $lettre . str_repeat('*', $taille);  
// }


// $phrase = str_replace($insultes, $asterisc, $phrase);

// echo $phrase;

function response_yes_no(?string $phrase = null): bool {
    while(true) {
        $question = readline($phrase . " - o/n : ");
        if($question === "o") {
            return true;
        } elseif($question === "n") {
            return false;
        }
    }
}

// $result = response_yes_no("Voulez-vous continuer ? ");
// var_dump($result);

function valide_hour(int $hour): bool {
    return !empty($hour) && is_numeric($hour) && $hour >=0 && $hour < 24;
}

function demande_creneau(?string $phrase = null): array {
    if(!is_null($phrase)) {
        echo "$phrase \n";
    }
    while(true) {
        $open_hour = (int) readline("Open hour (enter valide schedule between 0 and 23): ");
        if(valide_hour($open_hour)) {
            break;
        }
    }

    while(true) {
        $close_hour = (int) readline("close hour (enter valide schedule between 0 and 23 and close hour should be greather than open hour): ");
        if(valide_hour($close_hour) && $open_hour < $close_hour) {
            break;
        }
    }
    return [$open_hour, $close_hour];
    
    
}

function demande_creneaux(?string $phrase = null): array {
    if(is_null($phrase)) {
        $phrase = "Entre vos créneaux : \n";
    }
    $creneaux = [];
    while (response_yes_no($phrase)) {
        $creneaux[] = demande_creneau();
    }
    return $creneaux;
}


$creneaux = demande_creneaux();
if(!empty($creneaux)) {
    var_dump($creneaux);
}
