<?php
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $offset = ($page - 1) * NB_PER_PAGE;

    $query  = "SELECT D.* ";
    if(MODE == 0) // mode 0, on récupère le nombre d'avis positifs
        $query .= ", E.positive ";
    elseif(MODE == 1) // mode 1, on récupère le nombre de commentaire
        $query .= ", COUNT(C.id) AS comm ";
    
    $query .= "FROM war_diary D ";
    if(MODE == 0) // mode 0, on récupère le nombre d'avis positifs
        $query .= ", war_evaluations E ";
    elseif(MODE == 1) // mode 1, on récupère le nombre de commentaire
        $query .= ", war_contrib C ";

    // ici on prend en compte tous les filtres
    // ------------------------------------------------------
    
    if(NATION == "OTHERS")
        $query .= "WHERE nation = '' ";
    elseif(NATION == "ALL")
        $query .= "WHERE D.ReportKey LIKE '%' ";
    else
        $query .= "WHERE nation LIKE '%".NATION."%' ";

    $query .= (CATEGORY != "ALL") ? "AND Category LIKE '".CATEGORY."' " : "" ;

    $query .= (CWIA) ? "AND CivilianWIA > 0 " : "" ;
    $query .= (CKIA) ? "AND CivilianKIA > 0 " : "" ;

    $query .= (AWIA) ? "AND FriendlyWIA > 0 " : "" ;
    $query .= (AKIA) ? "AND FriendlyKIA > 0 " : "" ;

    $query .= (EWIA) ? "AND EnemyWIA > 0 " : "" ;
    $query .= (EKIA) ? "AND EnemyKIA > 0 " : "" ;

    if( ($_GET['s'] != "") ) :
		$query .= "AND ( ";
		//finds several terms in query
		$s = $_GET['s'];
		$s = explode(" ",$s);
		foreach ($s as $s_term){
			//adds OR if not 1st term
			if ($s[0] != $s_term)
				$query .= " AND ";
			$query .= "(Title     LIKE '%".htmlentities($s_term, ENT_QUOTES, "UTF-8")."%' ";
			$query .= "OR    Summary   LIKE '%".htmlentities($s_term, ENT_QUOTES, "UTF-8")."%' ";
			$query .= "OR    D.ReportKey LIKE '%".htmlentities($s_term, ENT_QUOTES, "UTF-8")."%')";
		}
		$query .= ") ";
    endif;

    // fin de prise en compte des filtres
    // ------------------------------------------------------

    // Maintenant on fait les jointures selon les modes
    if(MODE == 0) {
        $query .= "AND positive > 0 ";
        $query .= "AND E.ReportKey = D.ReportKey ";
    } elseif(MODE == 1) {
        $query .= "AND C.Visible = 1 ";
        $query .= "AND C.ReportKey = D.ReportKey ";
        $query .= "GROUP BY D.ReportKey "; // pour le compte
    }

    // on adapte l'ordre au mode
    
    if(MODE == 0)
        $query .= "ORDER BY E.positive DESC, E.score DESC, D.Date DESC ";
    elseif(MODE == 1)
        $query .= "ORDER BY comm DESC,  D.Date  DESC ";
    else // MODE == 2 (défualt)
        $query .= "ORDER BY D.Date  DESC ";

    $query .= "LIMIT ".NB_PER_PAGE." OFFSET ".$offset." ";

    if(!$db_wikileaks->query($query));
        echo $db_wikileaks->getErr_query(); ?>

    <ul>
        <?php
            while( $row = $db_wikileaks->fo() ) :
                echo '<li>
                            <a href="index.php?back&ecran=2&amp;key='.$row->ReportKey.'" title="'.$row->Title.'"><span>'.$row->Title.' '.($row->positive>0?'('.$row->positive.')':'').'</span></a>';
                            if(MODE == 0 && $row->positive > 0) {
                                echo '<span class="nbAvis">'.$row->positive." ";
                                        if($row->positive == 1) echo "<span class='label'>".getTrad(74)."</span>";
                                        else                    echo "<span class='label'>".getTrad(75)."</span>";
                                echo '</span>';
                            } elseif(MODE == 1 && ($row->comm > 0) ) {
                                echo '<span class="nbAvis comm">'.$row->comm." ";
                                        if($row->comm == 1) echo "<span class='label'>".getTrad(80)."</span>";
                                        else                echo "<span class='label'>".getTrad(81)."</span>";
                                echo '</span>';
                            }

                 echo '</li>';
            endwhile;

            if($page == 1 && $db_wikileaks->affected() == 0)
                    echo "<strong style='display:block;margin:20px'>".getTrad(43)."</strong>";
        ?>
    </ul>


















