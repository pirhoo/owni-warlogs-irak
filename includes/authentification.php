<?php

// on veut se connecter
if(isset($_POST["pseudo"]) && isset($_POST["mdp"]) )
    try_to_login();

// on veut se deconnecter
if(isset($_GET['deconnexion']))
    disconnect();


function is_logged() {
    
    if(!isset($_SESSION["Nickname"]) || !isset($_SESSION["Password"]) ) {
        return false;
    } else {

        /* @var $db_wikileaks Mydb */
        global $db_wikileaks;
        
        $query = "SELECT COUNT(*) AS nb FROM war_user WHERE Nickname LIKE '".$_SESSION["Nickname"]."' AND Password LIKE '".$_SESSION["Password"]."' ";

        if(!$db_wikileaks->query($query));
            echo $db_wikileaks->getErr_query();

         return ( $db_wikileaks->fo()->nb == 1);
    }
        
}

function disconnect() {
     unset($_SESSION["Nickname"]);
     unset($_SESSION["Password"]);
     header("Location: admin.php?lang=".LANG);
}

function try_to_login() {
    
    if( !is_logged() ) {

        /* @var $db_wikileaks Mydb */
        global $db_wikileaks;

        $pseudo = $_POST["pseudo"];
        $mdp = md5($_POST["mdp"]);

        $query = "SELECT COUNT(*) AS nb FROM war_user WHERE Nickname LIKE '$pseudo' AND Password LIKE '$mdp' ";

        if(!$db_wikileaks->query($query));
            echo $db_wikileaks->getErr_query();

         if( $db_wikileaks->fo()->nb == 1) {
             $_SESSION["Nickname"] = $pseudo;
             $_SESSION["Password"] = $mdp;
            header("Location: admin.php?lang=".LANG);
         } else {
            header("Location: admin.php?fail&lang=".LANG);
         }
        
    }
}

?>
