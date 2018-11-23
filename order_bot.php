<?php
require_once 'chemin.php';
require_once 'analyse.php';


//   subway ligne diagram

//             ---Z---
//            |       |
//            X       W                          // $subway_1 = array("A","B","C","D","E");
//    A---B---C---D---E---F                      // $subway_2 = array("C","G","H","I","J");
//            |           |                      // $subway_3 = array("I","L","M","N","O");
//            G           S                      // $subway_4 = array("P","Q","R","S");
//            |           |                      // $subway_5 = array("I","Y","Q");
//            H           R                      // $subway_6 = array("X","Z","W");   
//            |           | 
//            I-----Y-----Q
//            |           |
//            J           P
//            |           |
//      L-----M-----N-----O


//      CLASS METRO
$newChemin = new chemin($_POST['gare_depart'], $_POST['gare_fin']);
$start = "";
$newChemin->getChemin($voisin_tab,$start);
$sortChemin = $newChemin->sortChemin();



//      CLASS ANALYSE
$newAnalyse = new analyse();
$cheminFinal = $newAnalyse->analyse_time($timeStation,$sortChemin,$newChemin->gare_depart,$newChemin->gare_fin);

?>
