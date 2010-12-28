<?php

  // pays à consulter
  if(!isset($_GET['nation']))
      define("NATION", "ALL");
  else
      define("NATION", $_GET['nation']);

  if(!isset($_GET['s']))
      define("SEARCH", "");
  else
      define("SEARCH", $_GET['s']);

  define("NB_PER_PAGE", 40);


   if(isset($_GET['ecran']) )
       define("ECRAN",  $_GET['ecran']);
   else
       define("ECRAN",  1);

   if(isset($_GET['mode']) )
       define("MODE",  $_GET['mode']);
   else
       define("MODE",  0);

  // AFFICHER UNIQUEMENT
  //civils
  if(!isset($_GET['CWIA']))
      define("CWIA", 0);
  else
      define("CWIA", $_GET['CWIA']);

  if(!isset($_GET['CKIA']))
      define("CKIA", 0);
  else
      define("CKIA", $_GET['CKIA']);

  // alliés
  if(!isset($_GET['AWIA']))
      define("AWIA", 0);
  else
      define("AWIA", $_GET['AWIA']);

  if(!isset($_GET['AKIA']))
      define("AKIA", 0);
  else
      define("AKIA", $_GET['AKIA']);

  // ennemies
  if(!isset($_GET['EWIA']))
      define("EWIA", 0);
  else
      define("EWIA", $_GET['EWIA']);

  if(!isset($_GET['EKIA']))
      define("EKIA", 0);
  else
      define("EKIA", $_GET['EKIA']);



  // catégorie à filtrer
  if(!isset($_GET['category']) || $_GET['category'] == "ALL")
      define("CATEGORY", "ALL");
  else
      define("CATEGORY", $_GET['category']);

  $mysql["host"] = "localhost";
  $mysql["database"] = "appowni";
  $mysql["user"] = "appowni";
  $mysql["password"] = "pheePh3Ienga";

  /**
  $mysql["host"] = "localhost";
  $mysql["database"] = "AFG-WAR-DIARY";
  $mysql["user"] = "root";
  $mysql["password"] = "rootmdp";
  /**/

  $WL_ratings_criteria = array (0=>null, 1=>getTrad(61), 2=>getTrad(62), 3=>getTrad(63), 4=>getTrad(76), 5=>getTrad(77));
  $db_wikileaks = new Mydb ($mysql["host"], $mysql["database"], $mysql["user"], $mysql["password"]);
  
?>
