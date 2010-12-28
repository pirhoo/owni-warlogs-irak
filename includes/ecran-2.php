<?php

    $query  = "SELECT D.*, DATE_FORMAT(D.Date, '%Y') as Year, I.positive ";
    $query .= "FROM war_diary AS D ";
    $query .= "LEFT JOIN war_evaluations AS I ON I.ReportKey = D.ReportKey ";
    $query .= "WHERE D.ReportKey ='".$_GET['key']."'";

    /* @var $db_wikileaks Mydb */
    if(!$db_wikileaks->query($query));
        echo $db_wikileaks->getErr_query();

    if( $row = $db_wikileaks->fo() ) :


        // TITRE
        echo '<h3 class="rapportTitle">
            <a href="index.php?action=rand" class="nextLog">'.getTrad(64).'</a>'.$row->Title.'
       </h3>';
       echo ($row->positive > 0) ? '<span class="nbAvis ecran-2">'.$row->positive.( $row->positive <= 1 ?  "&nbsp;".getTrad(78) : "&nbsp;".getTrad(79) )."</span>" : "";

        ?>
        <ul class="top-tabs">
            <li class="first actif"><?php echo getTrad(13); ?></li>
            <li><?php echo getTrad(23); ?></li>
            <li><?php echo getTrad(14); ?></li>
            <li class="bg-light"><?php echo getTrad(15); ?></li>
            <li class="bg-light last"><?php echo getTrad(58); ?></li>
        </ul>
        <?php
        
        // RESUMÉ
        echo '<div class="tab summary open">';
                    echo '<div class="content">';
                echo '<p>'.addAcronymsAndFormat($row->Summary, LANG).'</p>';
            echo '</div>';
        echo '</div>';

        // CARTE
        echo '<div class="tab close map empty">';
                echo '<div id="gMap" style="height:368px; width:580px;"></div>';
        echo '</div>';


        // DÉTAILS
        echo '<div class="tab close">';

            ?>
            <div class="content">
                
                <table class="details">
                    <tr>
                        <td colspan="2">
                            <strong><?php echo getTrad(57); ?></strong><br /><?php echo $row->Title; ?>
                        </td>
                        <td><strong><?php echo getTrad(29); ?></strong><br /><?php echo $row->TrackingNumber; ?></td>
                    </tr>
                    <tr>
                        <td><strong><?php echo getTrad(24); ?></strong><br /><?php echo $row->Date; ?></td>
                        <td><strong><?php echo getTrad(3); ?></strong><br /><?php echo $row->FriendlyWIA; ?></td>
                        <td><strong><?php echo getTrad(4); ?></strong><br /><?php echo $row->FriendlyKIA; ?></td>
                    </tr>

                    <tr>
                        <td><strong><?php echo getTrad(25); ?></strong><br /><?php echo $row->UnitName; ?></td>
                        <td><strong><?php echo getTrad(26); ?></strong><br /><?php echo $row->Type; ?></td>
                        <td><strong><?php echo getTrad(35); ?></strong><br /><?php echo $row->OriginatorGroup; ?></td>
                        
                    </tr>

                    <tr>
                        <td><strong><?php echo getTrad(27); ?></strong><br /><?php echo $row->TypeOfUnit; ?></td>
                        <td><strong><?php echo getTrad(5); ?></strong><br /><?php echo $row->HostNationWIA; ?></td>
                        <td><strong><?php echo getTrad(6); ?></strong><br /><?php echo $row->HostNationKIA; ?></td>
                    </tr>
                    
                    <tr>
                        <td><strong><?php echo getTrad(11); ?></strong><br /><?php echo $row->EnemyDetained; ?></td>
                        <td><strong><?php echo getTrad(9); ?></strong><br /><?php echo $row->EnemyWIA; ?></td>
                        <td><strong><?php echo getTrad(10); ?></strong><br /><?php echo $row->EnemyKIA; ?></td>
                        
                    </tr>

                    <tr>
                        <td><strong><?php echo getTrad(30); ?></strong><br /><?php echo $row->Region; ?></td>
                        <td><strong><?php echo getTrad(32); ?></strong><br /><?php echo $row->AttackOn; ?></td>
                        <td><strong><?php echo getTrad(34); ?></strong><br /><?php echo $row->ReportingUnit; ?></td>
                    </tr>

                    <tr>
                        <td><strong><?php echo getTrad(28); ?></strong><br /><?php echo $row->Category; ?></td>
                        <td><strong><?php echo getTrad(7); ?></strong><br /><?php echo $row->CivilianWIA; ?></td>
                        <td><strong><?php echo getTrad(8); ?></strong><br /><?php echo $row->CivilianKIA; ?></td>
                    </tr>
                    
                    <tr>
                        <td><strong><?php echo getTrad(31); ?></strong><br /><?php echo $row->Latitude; ?></td>
                        <td><strong><?php echo getTrad(33); ?></strong><br /><?php echo $row->Longitude; ?></td>
                        <td></td>
                    </tr>
                </table>
            </div>
            <?php
        echo '</div>';

        // CONTRIBUER
        echo '<div class="tab close contrib">';            
            ?>
            <form method="POST" action="index.php?action=contrib" onsubmit="return checkForm();">
                <input type="hidden" name="Lang" value ="<?php echo LANG; ?>" />
                <input type="hidden" name="ReportKey" value ="<?php echo $row->ReportKey; ?>" />

                <div style="float:left">
                    <label><?php echo getTrad(17); ?> :<br /><input type="text" name="Name" class="text" /></label><br />
                    <label><?php echo getTrad(18); ?> :<br /><input type="text" name="Email" class="text" /></label><br />
                </div>

                <label ><?php echo getTrad(20); ?> :<br /><textarea name="Content"></textarea></label>

                <br style="clear:left;" />
                
                <?php if(LANG == 'FR') : ?>
                    <input type="image" src="./theme/images/Contribute-btn-small_FR.png"style="float:right;border:0px" name="submit" alt="Go">
                <?php else: ?>
                    <input type="image" src="./theme/images/Contribute-btn-small_EN.png"style="float:right;border:0px" name="submit" alt="Go">
                <?php endif; ?>

                <label style="clear:left; display:block;"><input type="checkbox" name="Alert" style="position:relative;bottom:-3px;margin-right:2px;margin-left:2px;" /><?php echo getTrad(19); ?></label><br />

            </form>

            <div class="contrib-list">
              <?php
                    $query  = "SELECT * ";
                    $query .= "FROM war_contrib ";
                    $query .= "WHERE ReportKey ='".$row->ReportKey."' ";
                    $query .= "AND Visible = 1 ";
                    $query .= "ORDER BY Date DESC";

                    if(!$db_wikileaks->query($query));
                        echo $db_wikileaks->getErr_query();

                    while($contrib = $db_wikileaks->fo() ) :
                        echo '<div class="contrib-line">';
                            echo "<span class='name'><abbr title='".easyTime($contrib->Date)."'>".$contrib->Name . "</abbr> ".getTrad(36)." :</span>" ;
                            echo "<p class='content'>".nl2br($contrib->Content). "</p>" ;
                        echo '</div>';
                    endwhile;
                ?>
            </div>

        <?php
        echo '</div>';
        ?>

        <div class="tab close tab-context">
            <?php

            $query  = 'SELECT * FROM `war_article` WHERE Annee = '.$row->Year.' ';
            $query .= ($row->nation != "" ) ? 'OR nation = "'.$row->nation.'" ' : '';
            $query .= 'OR Region = "'.$row->Region.'" ';

            if($row->FriendlyWIA > 0 || $row->FriendlyKIA > 0 || $row->HostNationWIA > 0 || $row->HostNationKIA > 0)
                    $query .= "OR Type LIKE '%mili%' ";

            if($row->CivilianWIA > 0 || $row->CivilianKIA > 0 )
                    $query .= "OR Type LIKE '%civil%' ";

            if($row->EnemyWIA > 0 || $row->EnemyKIA > 0 )
                    $query .= "OR Type LIKE '%enemy%' ";



            if(!$db_wikileaks->query($query));
                echo $db_wikileaks->getErr_query();

            // on calcul le score de chaque articles
            $i = 0;
            while($art = $db_wikileaks->fa() ) {


                // on calcul son score
                $score = 0;
                $score += ($row->Annee == $art["Year"]) ? 1 : 0;
                $score += ($row->nation == $art["Nation"] && !empty($art["Nation"]) ) ? 2 : 0;
                $score += ($row->Region == $art["Region"]) ? 3 : 0;

                $score += ($row->FriendlyWIA > 0 || $row->FriendlyKIA > 0 || $row->HostNationWIA > 0 || $row->HostNationKIA > 0) && substr("mili", $art["Type"]) ? 2 : 0;
                $score += ($row->CivilianWIA > 0 || $row->CivilianKIA > 0 ) && substr("civil", $art["Type"]) ? 2 : 0;
                $score += ($row->EnemyWIA > 0 || $row->EnemyKIA > 0 ) && substr("enemy", $art["Type"]) ? 2 : 0;

                if( $score >= 1 ) {
                    // on stock cet uplet si sont score est suppérieur à 1
                    $articles[] = $art;
                    // stock son score
                    $articles[$i++]["Score"] = $score;
                }

            }


            // fonction de comparaison de 2 entités selon leur score
            function cmpScore($a, $b) {
                return ($a["Score"] > $b["Score"])  ? -1 : 1;
            }


            // utilise la fonction cmpScore pour trier le tableau $articles
            if(count($articles) > 0) :
                usort($articles, "cmpScore");
                ?>
                <div>
                    <div class="list">
                        <ol>
                            <?php
                                for($i =0; $i < 8 && $i < count($articles); $i++ ) {
                                    $titre = ( strlen($articles[$i]['Titre']) > 80 ) ? substr($articles[$i]['Titre'], 0, 70).'...' : $articles[$i]['Titre'] ;
                                    echo '<li><a href="'.$articles[$i]['URL'].'" target="_blank" title="'.$articles[$i]['Titre'].'">'.$titre.'</a></li>';
                                }
                            ?>
                        </ol>
                    </div>
                </div>
            <?php endif; ?>
        </div>
                
        <script type="text/javascript"
            src="http://maps.google.com/maps/api/js?sensor=false">
        </script>
                
        <script type="text/javascript">

            function addOpenEvent() {

                $(".top-tabs li").click(function () {
                    var i = $(this).index();
                    $(".top-tabs li").removeClass("actif");
                    $(this).addClass("actif");
                    
                    $(".tab").stop().hide(0).addClass("close");
                    $(".tab:eq("+i+")").stop().show(0).removeClass("close").addClass("open");

                    if( i == 1 && $(".tab.map").hasClass("empty") ) {
                         $(".tab.map").removeClass("empty");
                        initMap();
                    }
                });


                /* SUR WARLOGS 1.36 ON FAISAIT COMME ÇA

                // on ajuste la hauteur des blocks
                const openH  = 350;
                const closeH = 50;
                $(".tab.open").height(openH);
                $(".tab.close").height(closeH);

                $(".trigger", ".tab.close").click(function () {
                    $(".tab").stop().animate({height:closeH}, 400);

                    $(".tab").addClass("close");
                    $(".tab.open").removeClass("open");

                    $(this).parent().removeClass("close");
                    $(this).parent().addClass("open");

                    $(this).parent().stop().animate({height:openH}, 400, function () {

                        addOpenEvent();

                    });
                });

                $(".trigger", ".tab.open").click(function () {
                    
                    var next_i = $(this).parent().index();
                    if(next_i >= 4) next_i = 0;
                    
                    $(".tab").addClass("close");
                    $(".tab.open").removeClass("open");

                    $(".tab:eq("+next_i+")").removeClass("close");
                    $(".tab:eq("+next_i+")").addClass("open");

                    $(this).parent().stop().animate({ height: closeH });

                    $(".tab:eq("+next_i+")").stop().animate({height:openH}, 400, function () {

                        addOpenEvent();

                    });
                });

                */

            }

            function contrib() {
                $(".top-tabs li:eq(3)").trigger("click");
            }

            function initMap() {

                <?php if($row->Latitude != "" && $row->Longitude != "") { ?>

                    // cet objet correspond à une lattitude et une longitude (utilisé pour centrer la map)
                    var latlng = new google.maps.LatLng(<?php echo $row->Latitude; ?>, <?php echo $row->Longitude; ?>);

                    // cet objets listes les options de la map
                    var myOptions = {
                      zoom: 14,
                      center: latlng,
                      mapTypeId: google.maps.MapTypeId.HYBRID
                    };

                    // création de la map
                    var map = new google.maps.Map(document.getElementById("gMap"), myOptions);

                    var markers = new Array();
                    markers.push(new google.maps.Marker({
                      position: latlng,
                      map: map,
                      title:"<?php echo $row->ReportKey; ?>",
                      icon: "./theme/images/marker_jaune.png"
                    }) );


                    var infow = new Array();

                    // création de l'infowinfow'
                    infow.push(
                        new google.maps.InfoWindow(
                          { content: "<?php echo "<a style='display:block; color: #ead200; width:180px; font-weight:bold;padding-right:20px' href='index.php?ecran=2&lang=".LANG."&key=$row->ReportKey'>$row->Title</a><br />$row->Date"; ?>",
                            size: new google.maps.Size(50,50)
                          })
                     );

                     // ajout de l'évènement lors du clique sur le marqueur'
                    google.maps.event.addListener(markers[0], 'click', function() {
                        // cache toutes les autres infowindows
                        for(var i in infow)
                            infow[i].close();

                        // affiche la bonne
                        infow[0].open(map, markers[0]);
                    });

                    // on recherche les évènements rencontré dans la région
                    <?php

                        $query  = "SELECT *, DATE_FORMAT(Date, '%Y') as Year ";
                        $query .= "FROM war_diary ";
                        $query .= "WHERE Latitude  > ".($row->Latitude - 0.0100)." ";
                        $query .= "AND   Latitude  < ".($row->Latitude + 0.0100)." ";
                        $query .= "AND   Longitude > ".($row->Longitude - 0.0100)." ";
                        $query .= "AND   Longitude < ".($row->Longitude + 0.0100)." ";
                        $query .= "AND   ReportKey != '".$row->ReportKey."' ";
                        $query .= "ORDER BY Date DESC ";
                        $query .= "LIMIT 100 OFFSET 0";

                        if(!$db_wikileaks->query($query));
                            echo $db_wikileaks->getErr_query();

                        $i = 1;
                        while ( $event = $db_wikileaks->fo() )
                            if($event->ReportKet !=  $row->ReportKey && $event->Latitude != "" && $event->Longitude != "") {
                                ?>

                                // création du marqueur
                                markers.push(new google.maps.Marker({
                                  position: new google.maps.LatLng(<?php echo $event->Latitude; ?>, <?php echo $event->Longitude; ?>),
                                  map: map,
                                  title:"<?php echo $event->ReportKey; ?>"
                                }) );

                                // création de l'infoWindow'
                                infow.push(
                                    new google.maps.InfoWindow(
                                      { content: "<?php echo "<a style='display:block; color:#9b1313; width:180px; font-weight:bold;padding-right:20px' href='index.php?ecran=2&lang=".LANG."&key=$event->ReportKey'>$event->Title</a><br />$event->Date"; ?>",
                                        size: new google.maps.Size(50,50)
                                      })
                                 );

                                 // ajout de l'évènement lors du clique sur le marqueur'
                                google.maps.event.addListener(markers[<?php echo $i; ?>], 'click', function() {

                                    // cache toutes les autres infowindows
                                    for(var i in infow)
                                        infow[i].close();

                                    // affiche la bonne
                                    infow[<?php echo $i; ?>].open(map, markers[<?php echo $i; ?>]);
                                });

                                <?php $i ++;
                            }
                    ?>

                    infow[0].open(map, markers[0]);

                <?php } ?>
            }

            addOpenEvent();
        </script>

    <?php endif; ?>

    <div class="notation">
        <div id="wlratings">
        </div>
    </div>

<script type="text/javascript">

	function wlRatingsEvaluate () {
		wlRatingsPost ("&evaluation="+$("#wlratings #wlform #wl_evaluation").val());
		return false;
	}
	function wlRatingsRate () {
		var args = '';
		$('#wlratings #wlform :checkbox').each(function (index) {
			args += '&ratings[]='+$(this).is(':checked');
		});
		wlRatingsPost (args);
		return false;
	}
	function wlRatingsPost (args) {
		var args;
		$.ajax({
		   type: "POST",
		   url:  "xhr/WLratings.php?key=<?php echo ($row->ReportKey); ?>",
		   data: "key=<?php echo ($row->ReportKey); ?>&"+args,
		   success: function(msg){
		     $('#wlratings').html (msg);
		   }
		 });
	}
</script>