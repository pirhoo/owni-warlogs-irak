<?php

  // langue de l'appli
  if(!isset($_GET['lang']))
      defineLang();
  else
      defineLang($_GET['lang']);



    if(LANG == "FR") {
        define("DOC_TITLE", "War Logs : cette guerre est aussi votre guerre, contribuez !");
        define("DOC_URL", "http://app.owni.fr/warlogs/");
    } else {
        define("DOC_TITLE", "War Logs: this war is also yours, contribute!");
        define("DOC_URL", "http://app.owni.fr/warlogs/?lang=EN");
    }
    
    define("ARTICLE_URL", "http://owni.fr/2010/07/27/warlogs-wikileaks-application-enquete-contributive-europeenne/");


  function defineLang($lang = null) {
        if($lang == null) {
            
            if(isset($_SESSION['lang']))
                define("LANG", $_SESSION['lang']);
            else
                define("LANG", "FR");

        } else {
            define("LANG", $lang);
            $_SESSION['lang'] = $lang;
        }

  }


  function getPays($clef) {
      // clef => Array("pays_en", "pays_fr")
      $pays = Array("FR" => Array("France", "France"),
                    'BA' => array('Bosnia','Bosnie'),
                    'TR' => array('Turkey','Turquie'),
                    'NO' => array('Norway','Norvège'),
                    'FI' => array('Finland','Finlande'),
                    'SE' => array('Sweden','Suède'),
                    'BG' => array('Bulgaria','Bulgarie'),
                    'RO' => array('Romania','Roumanie'),
                    'EE' => array('Estonia','Estonie'),
                    'LV' => array('Latvia','Lettonie'),
                    'LT' => array('Lithuania','Lituanie'),
                    'HU' => array('Hungary','Hongrie'),
                    'HR' => array('Croatia','Croatie'),
                    'SI' => array('Slovenia','Slovénie'),
                    'NL' => array('The Netherlands','Pays-Bas'),
                    'FR' => array('France','France'),
                    'ES' => array('Spain','Espagne'),
                    'IT' => array('Italy','Italie'),
                    'AT' => array('Austria','Autriche'),
                    'BE' => array('Belgium','Belgique'),
                    'CH' => array('Switzerland','Suisse'),
                    'CY' => array('Cyprus','Chypre'),
                    'CZ' => array('Czech Republic','République Tchèque'),
                    'DE' => array('Germany','Allemagne'),
                    'DK' => array('Denmark','Danemark'),
                    'GR' => array('Greece','Grèce'),
                    'IE' => array('Ireland','Irlande'),
                    'IS' => array('Iceland','Islande'),
                    'PL' => array('Poland','Pologne'),
                    'PT' => array('Portugal','Portugal'),
                    'RU' => array('Russia','Russie'),
                    'SK' => array('Slovakia','Slovaquie'),
                    'UA' => array('Ukraine','Ukraine'),
                    'YU' => array('Yugoslavia','Yougoslavie'));

      return $pays[$clef][getLangID(LANG)];
  }

  function getLangID($pays) {
      switch ($pays) {
          case "EN":
              return 0;
              break;

          case "FR":
              return 1;
              break;
      }
  }

  function getTrad($ligne) {
      
      $data = Array( "EN" => Array("Choose a country", // 0
                                   "Choose a category", // 1
                                   "Display only", // 2
                                   "Wounded allied", // 3
                                   "Killed allied", // 4
                                   "Wounded afghans", // 5
                                   "Killed afghans", // 6
                                   "Wounded civilans", // 7
                                   "Killed civilians", // 8
                                   "Wounded Enemies", // 9
                                   "Killed enemies", // 10
                                   "Imprisoned enemies", // 11
                                   "Affiliation", // 12
                                   "Summary", // 13
                                   "Details", // 14
                                   "Discussion", // 15
                                   "All", // 16
                                   "Your name", // 17
                                   "Your email", // 18
                                   "Yes, I wish to receive updates on this investigation", // 19
                                   "Your comment", // 20
                                   "WARLOGS gives you access to 6 years of a war sumed up in 75,000 documents.<br />%nb have already been analyzed. Take action and rate a document!<br /><strong>Source: <a href='http://wardiary.wikileaks.org/'>WikiLeaks</a></strong>", // 21
                                   "Refine your search", // 22
                                   "Map", // 23
                                   "Date", // 24
                                   "Name of the unit", // 25
                                   "Type", // 26
                                   "Type of the unit", // 27
                                   "Category", // 28
                                   "Tracking number", // 29
                                   "Region", // 30
                                   "Latitude", // 31
                                   "Target of the attack", // 32
                                   "Longitude", // 33
                                   "Reporting unit", // 34
                                   "Originator", // 35
                                   "said", // 36
                                   "USA, UK & Non Europe", // 37
                                    "Your message is queueing and will soon be reviewed... Thank you!", // 38
                                    "or killed", // 39
                                    "or wounded", // 40
                                    "search", // 41
                                    "All", // 42
                                    "No match for your request.", //43
                                    "<img src='./theme/images/FR.png' alt='' />Version française", // 44
                                    "Your name, email address and message are required (not publicly displayed)", // 45
                                    "Nickname", // 46
                                    "Password", // 47
                                    "Log in", // 48
                                    "Authentification failled.", // 49
                                    "Comments", // 50
                                    "Approuved", // 51
                                    "Disapprouved", // 52
                                    "Pending", // 53
                                    "Mark as", // 54
                                    "Logout", // 55
                                    "See the report", // 56
                                    "Title", // 57
                                    "Context", // 58
                                    "Add a context article", // 59
                                    "Cancel" // 60
                                    ,"violent" //61
                                    ,"shocking" //62
                                    ,"sordid" //63
                                    ,"next log" //64
                                    ,"contribute" //65
                                    ,"You have rated this document as" // 66
                                    ,"interesting" //67
                                    ,"uninteresting" //68
                                    ,"How would you rate this document?" //69
                                    ,"Thank you for your contribution." // 70
                                    , "the most interesting" // 71
                                    , "the most commented" // 72
                                    , "all" // 73
                                    , "positive reaction" // 74
                                    , "positive reactions" // 75
                                    , "appealing" // 76
                                    , "other" // 77
                                    , "people found this document interesting" // 78
                                    , "people found this document interesting" // 79
                                    , "comment" // 80
                                    , "comments" // 81
				    ),
          
                     "FR" => Array("Choisissez un pays", // 0
                                   "Choisissez une catégorie", // 1
                                   "Afficher uniquement", // 2
                                   "Alliés blessés", // 3
                                   "Alliés tués", // 4
                                   "Afghans blessés", // 5
                                   "Afghans tués", // 6
                                   "Civils blessés", // 7
                                   "Civils tués", // 8
                                   "Ennemis blessés", // 9
                                   "Ennemis tués", // 10
                                   "Ennemis capturés", // 11
                                   "Affiliation", // 12
                                   "Résumé", // 13
                                   "Détails", // 14
                                   "Discussion", // 15
                                   "Toutes", // 16
                                   "Votre nom", // 17
                                   "Votre email", // 18
                                   "Oui, je souhaite être alerté des informations majeures relatives à cette enquête", // 19
                                   "Votre message", // 20
                                   "WARLOGS vous donne accès à 6 ans de guerre résumés dans 75 000 documents.<br />%nb documents ont déjà été analysés par les internautes, contribuez vous aussi !<br /><strong>Source: <a href='http://wardiary.wikileaks.org/'>WikiLeaks</a></strong>", // 21
                                   "Affinez votre recherche", // 22
                                   "Carte", // 23
                                   "Date", // 24
                                   "Nom de l'unité", // 25
                                   "Type", // 26
                                   "Type de l'unité", // 27
                                   "Catégorie", // 28
                                   "Numéro de suivi", // 29
                                   "Region", // 30
                                   "Latitude", // 31
                                   "Cible de l'attaque", // 32
                                   "Longitude", // 33
                                   "Unité au rapport", // 34
                                   "Initiateur", // 35
                                   "a dit", // 36
                                   "USA, GB & Hors Europe", // 37
                                   "Votre message est dans la file d'attente... Merci !", // 38
                                   "ou tués", // 39
                                   "ou blessés", // 40
                                   "rechercher", // 41
                                    "Tous",// 42
                                    "Aucun rapport ne correspond à votre recherche.", //43
                                    "<img src='./theme/images/EN.png' alt='' />English version", // 44
                                    "Le nom, l'adresse email et le message sont obligatoires (mais ne seront pas diffusés).", // 45
                                    "Pseudo", // 46
                                    "Mot de passe", // 47
                                    "Se connecter", // 48
                                    "L'authentification a échoué.", // 49
                                    "Commentaires", // 50
                                    "Approuvé", // 51
                                    "Désapprouvé", // 52
                                    "En attente", // 53
                                    "Marquer comme", // 54
                                    "Déconnexion", // 55
                                    "Voir le rapport", // 56
                                    "Titre", // 57
                                    "Context", // 58
                                    "Ajouter un article de contexte", // 59
                                    "Annuler" // 60
                                    ,"violent" //61
                                    ,"choquant" //62
                                    ,"sordide" //63
                                    ,"log suivant" //64
                                    ,"contribuez" //65
                                    ,"Vous avez jugé ce document" // 66
                                    ,"intéressant" //67
                                    ,"pas intéressant" //68
                                    ,"Comment qualifieriez-vous ce document ?" //69
                                    ,"Merci pour votre participation." // 70
                                    , "les + intéressants" // 71
                                    , "les + commentés" // 72
                                    , "tous" // 73
                                    , "réaction positive" // 74
                                    , "réactions positives" // 75
                                    , "édifiant" // 76
                                    , "autre" // 77
                                    , "personne a trouvé ce document intéressant" // 78
                                    , "personnes ont trouvé ce document intéressant" // 79
                                    , "commentaire" // 80
                                    , "commentaires" // 81
                                    ) );

      return $data[LANG][$ligne];
  }

?>
