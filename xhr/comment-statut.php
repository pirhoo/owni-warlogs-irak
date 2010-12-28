<?php
  session_start();
  @header('Content-Type: text/html; charset=UTF-8');

  chdir("../");
  require_once("./includes/class/Mydb.class.php");
  require_once("./includes/lang.php");
  require_once("./includes/defines.php");

  require_once("./includes/authentification.php");

  if(is_logged() && isset($_GET["statut"]) && isset($_GET["ID"]) ) {

        $query = "UPDATE war_contrib SET Visible = ".$_GET['statut']." WHERE ID = ".$_GET["ID"];

        if(!$db_wikileaks->query($query));
            echo $db_wikileaks->getErr_query();
  }
?>
