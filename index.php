<?php
    @session_start();
    require_once("./includes/lang.php");
    
    require_once("./includes/class/Mydb.class.php");
    require_once("./includes/class/WLratings.class.php");
    require_once("./includes/defines.php");

    global $db_wikileaks; // DANS ./includes/defines.php

    require_once("./includes/authentification.php");
    require_once("./includes/addAcronyms.php");
    require_once("./includes/date.php");

            
    switch($_GET['action']) {
        // contribution
        // on ajoute puis on redirige pour éviter les doublons
        case "contrib" :
            $reportKey = htmlentities($_POST['ReportKey'], ENT_QUOTES, "UTF-8");
            $name = htmlentities($_POST['Name'], ENT_QUOTES, "UTF-8");
            $email = htmlentities($_POST['Email'], ENT_QUOTES, "UTF-8");
            $content = htmlentities($_POST['Content'], ENT_QUOTES, "UTF-8");
            $alert = ($_POST['Alert']) ? 1 : 0;

            if( preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $email)
            &&  $name != ""
            &&  $content != "") {

                $query = "INSERT INTO war_contrib VALUES (null, '$reportKey', '".LANG."', '$name', '$email', $alert, ".time().", 0, '$content')";
                if(!$db_wikileaks->query($query));
                    echo $db_wikileaks->getErr_query();

            }

            header('Location: index.php?ecran=2n&msg=38&lang='.LANG.'&key='.$_POST['ReportKey']);
            break;
	    
	    case "rand" : // self explenatory, huh?
	    $query = "SELECT `ReportKey` FROM `war_diary` WHERE 1";
                if(!$db_wikileaks->query($query));
                    echo $db_wikileaks->getErr_query();
		$db_wikileaks->ds(rand(0,$db_wikileaks->nr()));
		list ($key) = $db_wikileaks->fr();
	    header('Location: index.php?ecran=2&lang='.LANG.'&key='.$key);
	    break;

    }

    @header('Content-Type: text/html; charset=UTF-8');

?>
<!DOCTYPE html>
<html xmlns:fb="http://www.facebook.com/2008/fbml" xml:lang="fr" lang="fr">
<head>
            <title><?php echo DOC_TITLE; ?></title>

            <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
            <meta http-equiv="content-language" content="fr" />

            <meta property="og:title" content="<?php echo DOC_TITLE; ?>"/>
            <meta property="og:site_name" content="War Logs"/>
            <meta property="og:image" content="http://app.owni.fr/warlogs/theme/images/warLogs.png"/>

            <link rel="stylesheet" href="./theme/global.css" type="text/css" media="screen" />


            <script type="text/javascript" src="http://www.google.com/jsapi"></script>
            <script type="text/javascript">
                  google.load("jquery", "1.4.2");
            </script>
            <script type="text/javascript" src="./includes/jquery.scrollTo-min.js"></script>

            <script type="text/javascript">

                var search = "<?php echo SEARCH; ?>";
                var mode = 0;
                var page = 1;
                
                function isEmail(str) {
                    Expression = new RegExp("^[a-z0-9._-]+@{1}[a-z0-9_-]{2,50}\.{1}[a-z]{2,4}$","i")
                    return Expression.test(str);
                }

                function checkForm() {

                    if( isEmail( $(":input[name=Email]").val() )
                             && ($(":input[name=Name]").val() != "")
                             && ($(":input[name=Content]").val() != "") ) {
                             return true;
                     } else {
                        showPopup("<?php echo getTrad(45); ?>");
                        return false;
                     }
                }

                function getEmbed() {
                    $(".share").hide();
                    $(".inputEmbed").show();
                    $(':input:eq(0)', '.inputEmbed').select();
                }

                function dropEmbed() {
                    $(".share").show();
                    $(".inputEmbed").hide();
                }

                
                function getContraintes() {

                    var cWIA = $("input:eq(0)" ,".WIA_KIA").attr('checked') ? 1 : 0;
                    var cKIA = $("input:eq(1)" ,".WIA_KIA").attr('checked') ? 1 : 0;
                    var aWIA = $("input:eq(2)" ,".WIA_KIA").attr('checked') ? 1 : 0;
                    var aKIA = $("input:eq(3)" ,".WIA_KIA").attr('checked') ? 1 : 0;
                    var eWIA = $("input:eq(4)" ,".WIA_KIA").attr('checked') ? 1 : 0;
                    var eKIA = $("input:eq(5)" ,".WIA_KIA").attr('checked') ? 1 : 0;

                    var contraintes  = "&CWIA="+cWIA;
                        contraintes += "&CKIA="+cKIA;
                        contraintes += "&AWIA="+aWIA;
                        contraintes += "&AKIA="+aKIA;
                        contraintes += "&EWIA="+eWIA;
                        contraintes += "&EKIA="+eKIA;
                        contraintes += "&mode="+mode;

                    if(search != "") contraintes += "&s="+search;

                    return contraintes;
                }

                function majListe(page) {
                    var parametres = "lang=<?php echo LANG; ?>&nation="+$("select.location").val()+getContraintes();

                    // on bloque l'appli'
                    // les inputs
                    $(":input").attr("disabled", "disabled");
                    // le loader
                    $(".mask").addClass("modal").stop().fadeIn(400);
                    $(".mask .loader").stop().fadeIn(400);

                    $.ajax({ url: "./xhr/logs-list.php",
                            type: "GET",
                            data : parametres,
                            context: document.body,
                            success: function(html){
                                $(".col-right").html(html);

                                $(":input").attr("disabled", "");
                                $(".mask").removeClass("modal").stop().fadeOut(400);
                                $(".mask .loader").stop().fadeOut(400);
                            }
                         });
                }

                function showPopup(html) {
                    $(".mask .loader").hide();
                    $(".mask").fadeIn(800);
                    $(".popup").animate({top:"50%"}, 800);
                    $(".popup .content").html(html);
                }


                $(document).ready(function () {

                    <?php if(ECRAN == 1) : ?>

                        var xhrLoad = false;


                        $(".col-right").scroll( function () {
                            var nb_item = $("ul > li", this).length ;
                            var pos = ( $(this).scrollTop()  ) / ( nb_item * 50 ) * 100;

                            
                            if(pos > 70 && !xhrLoad) { // si on a scrollé la liste à plus de 70%
                                // on dit qu'on est déjà en train de charger'
                                xhrLoad = true;
                                var new_page = Math.ceil( nb_item / <?php echo NB_PER_PAGE; ?> + 1 );
                                if(new_page > page) {
                                    page = new_page;
                                    var parametres = "nation="+$("select.location").val()+"&page="+page+getContraintes();

                                    $.ajax({ url: "./xhr/logs-list.php",
                                            type: "GET",
                                            data : parametres,
                                            context: document.body,
                                            success: function(html){
                                                $(".col-right").append(html);
                                                // on autorise une nouvelle fois le chargement
                                                xhrLoad = false;
                                            },
                                            error: function() {
                                                page--;
                                            }
                                         });
                                 }
                            }

                        });

                        $("select.location").change( function () {
                            majListe(1);
                        });

                        $("select.category").change( function () {
                            majListe(1);
                        });

                        $("input", ".WIA_KIA").change( function () {
                            majListe(1);
                        });


                        $(".top-tabs.home li").click(function ()  {
                            $(".top-tabs.home li").removeClass("actif");
                            $(this).addClass("actif");
                            mode = $(this).index();
                            page = 1;
                            majListe(1);
                            $(".col-right").scrollTop(0);
                        });
                        
                  <?php elseif(ECRAN == 2) : ?>
			
			    wlRatingsPost();

                  <?php elseif(ECRAN == 3) : ?>

                                $(".searchComment").keyup(function () {

                                    var occ = $(this).val();
                                    $(".admin-comm").each(function (index) {

                                        var text  = $(".content", this).text() + "\n";
                                            text += $(".name abbr", this).text();

                                        if(text.indexOf(occ) > -1) {
                                            $(this).show();
                                          } else
                                            $(this).hide();

                                    });

                                }).focus(function () {
                                    if( $(this).val() ==  "<?php echo getTrad(41); ?>..." )
                                        $(this).val("");

                                });

                                $(".cancel").click( function () {
                                    $(".searchComment").val("");
                                    $(".searchComment").trigger("keyup");
                                    $(".searchComment").val("<?php echo getTrad(41); ?>...");
                                });

                    <?php endif; ?>

                    <?php if(isset($_GET["msg"])) { ?>
                            showPopup("<?php echo getTrad($_GET["msg"]); ?>");
                    <?php } ?>
                            
                    $(".mask").click(function () {
                        if(! $(this).hasClass("modal")) {

                            $(".mask").fadeOut(800);
                            $(".popup").animate({top:-50}, 800);
                            
                        }
                    });
                    
                    $(".popup .close img").click(function () {
                        $(".mask").fadeOut(800);
                        $(".popup").animate({top:-50}, 800);
                    });

                });
            </script>
    </head>
    <body>
        <div id="app">
            <div class="mask"><img class="loader" src="./theme/images/loader.gif" alt="loading..." /></div>
            
            <div class="popup"><span class="close"><img src="./theme/images/close.png" alt="close" /></span><div class="content"></div></div>

            <div class="columns">

                <div class="column col-left">
                    <div class="tc">
                        <?php if(LANG == "FR") : ?>
                            <a href="index.php?ecran=1"><img src="./theme/images/logo.png" width="206" height="148" alt="" /></a>
                        <?php else:  ?>
                            <a href="index.php?ecran=1"><img src="./theme/images/logo_EN.png" width="206" height="148" alt="" /></a>
                        <?php endif; ?>
                    </div>

                    <?php if(ECRAN == 1) : ?>

                        <p class="tj white" style="padding: 10px 20px">
                            <?php
                                $db_wikileaks->query("SELECT COUNT(DISTINCT id) AS nb FROM war_evaluations");
                                $nb = $db_wikileaks->fo();
                                echo str_replace("%nb", $nb->nb, getTrad(21));
                            ?>
                        </p>


                        <p class="tj white" style="padding: 5px !important">
                            <a href="index.php?action=rand"><img src="./theme/images/Rand-large_<?php echo LANG; ?>.png" alt="" /></a>
                        </p>
                        
                        <form class="search-form" method="GET" action="index.php">
                            <input type="hidden" value="<?php echo LANG; ?>" name="lang" />
                            <p>
                                <label class="white">
                                    <?php echo getTrad(41); ?> :
                                    <input type="text" name="s" value="<?php echo SEARCH; ?>" class="search"/>
                                </label>
                                <input type="submit" value="ok" />
                            </p>
                        </form>
                        
                        <span class="line">&nbsp;</span>

                        <p>
                            <label for="location" class="white">
                                <?php echo getTrad(0); ?> :
                            </label>
                            <select name="location" id="location" class="location">
                                <?php if(LANG == "FR") : ?>
                                    <option value="ALL" selected='selected' >Tous</option>
                                    <option value="OTHERS"  >USA, GB & Hors Europe</option>
                                    <option value="BA" >Bosnie</option><option value="BE" >Belgique</option><option value="BG" >Bulgarie</option><option value="DE" >Allemagne</option><option value="EE" >Estonie</option><option value="ES" >Espagne</option><option value="FI" >Finlande</option><option value="FR" >France</option><option value="GR" >Grèce</option><option value="HR" >Croatie</option><option value="HU" >Hongrie</option><option value="IT" >Italie</option><option value="LT" >Lituanie</option><option value="LV" >Lettonie</option><option value="NL" >Pays-Bas</option><option value="NO" >Norvège</option><option value="PL" >Pologne</option><option value="PT" >Portugal</option><option value="RO" >Roumanie</option><option value="SE" >Suède</option><option value="TR" >Turquie</option>
                                <?php elseif(LANG == "EN"): ?>
                                    <option value="ALL" selected='selected' >All</option>
                                    <option value="OTHERS"  >USA, UK & Non Europe</option>
                                    <option value="BA" >Bosnia</option><option value="BE" >Belgium</option><option value="BG" >Bulgaria</option><option value="DE" >Germany</option><option value="EE" >Estonia</option><option value="ES" >Spain</option><option value="FI" >Finland</option><option value="FR" >France</option><option value="GR" >Greece</option><option value="HR" >Croatia</option><option value="HU" >Hungary</option><option value="IT" >Italy</option><option value="LT" >Lithuania</option><option value="LV" >Latvia</option><option value="NL" >The Netherlands</option><option value="NO" >Norway</option><option value="PL" >Poland</option><option value="PT" >Portugal</option><option value="RO" >Romania</option><option value="SE" >Sweden</option><option value="TR" >Turkey</option>
                                <?php endif; ?>
                            </select>
                        </p>

                        <?php /* ?>
                        <span class="line">&nbsp;</span>
                        <p>
                                <label for="category" class="white">
                                    <?php echo getTrad(1); ?> : <br />
                                    <select name="category" id="category" class="category">
                                        <option value="ALL" <?php echo ("ALL" == CATEGORY) ?  "selected='selected'" : ""; ?>><?php echo getTrad(16); ?></option>
                                        <?php
                                            $query  = "SELECT DISTINCT Category ";
                                            $query .= "FROM war_diary ";
                                            $query .= "ORDER BY Category";

                                            if(!$db_wikileaks->query($query));
                                                echo $db_wikileaks->getErr_query();

                                            while( $row = $db_wikileaks->fo() ) {
                                                if($row->Category != "") {
                                                    echo '<option value="'.$row->Category.'" ';
                                                    echo ($row->Category == CATEGORY) ?  "selected='selected'" : "";
                                                    echo '>'.$row->Category.'</option>';
                                                }
                                            }
                                         ?>
                                    </select>
                                </label>
                        </p> <?php /**/ ?>
                        
                        <span class="line">&nbsp;</span>
                        <p>
                            <label for="" class="white"><?php echo getTrad(2); ?> :</label>
                            <ul class="WIA_KIA">

                                    <li class="first"><label title="<?php echo getTrad(7); ?>"><input type="checkbox" value="civilWIA" <?php echo (CWIA) ? "checked='checked'" : ""; ?> /> <?php echo getTrad(7); ?></label></li>
                                    <li><label title="<?php echo getTrad(8); ?>"><input type="checkbox" value="civilKIA" <?php echo (CKIA) ? "checked='checked'" : ""; ?> /> <?php echo getTrad(39); ?></label></li>

                                    <li class="first"><label title="<?php echo getTrad(3); ?>"><input type="checkbox" value="friendlyWIA" <?php echo (AWIA) ? "checked='checked'" : ""; ?> /> <?php echo getTrad(3); ?></label></li>
                                    <li><label title="<?php echo getTrad(4); ?>"><input type="checkbox" value="friendlyKIA" <?php echo (AKIA) ? "checked='checked'" : ""; ?> /> <?php echo getTrad(39); ?></label></li>

                                    <li class="first"><label title="<?php echo getTrad(9); ?>"><input type="checkbox" value="ennemyWIA" <?php echo (EWIA) ? "checked='checked'" : ""; ?> /> <?php echo getTrad(9); ?></label></li>
                                    <li><label title="<?php echo getTrad(10); ?>"><input type="checkbox" value="ennemyKIA" <?php echo (EKIA) ? "checked='checked'" : ""; ?> /> <?php echo getTrad(39); ?></label></li>

                            </ul>
                        </p>
                    <?php elseif(ECRAN == 2) : ?>
                        <p class="tj white" style="padding: 10px 20px">
                                <?php
                                    $db_wikileaks->query("SELECT COUNT(DISTINCT id) AS nb FROM war_evaluations");
                                    $nb = $db_wikileaks->fo();
                                    echo str_replace("%nb", $nb->nb, getTrad(21));
                                ?>
                        </p>
                        <p class="tj white" style="padding: 10px 7px">
                                <a href="javascript:contrib();"><img src="./theme/images/Contribute-btn-large_<?php echo LANG; ?>.png" alt="" /></a>
                                
                                <a href="<?php echo isset($_GET["back"]) ? "javascript:history.back()" : "index.php"; ?>">
                                    <img src="./theme/images/Retour-btn_<?php echo LANG; ?>.png" alt="" />
                                </a>
                        </p>

                    <?php elseif(ECRAN == 3 && is_logged()) : ?>
                        <p class="tj white" style="padding: 10px 20px">
                                <a href="admin.php?deconnexion"><?php echo getTrad(55); ?></a>
                        </p>
                        <span class="line">&nbsp;</span>
                        <p clas="tj white">
                            <input type="text" value="<?php echo getTrad(41)?>..." class="searchComment" /><img src="./theme/images/cross.png" alt="<?php echo getTrad(60)?>" class="cancel" />
                        </p>
                        <ol class="tj white" style="padding: 10px 20px">
                            <!--li onclick="$('.main-content').scrollTo( '#comments', 500, {axis: 'y'});">
                                <?php echo getTrad(50); ?>
                            </li>
                            <i onclick="$('.main-content').scrollTo( '#add-article', 500, {axis: 'y'});">
                                <?php echo getTrad(59); ?>
                            </li-->
                        </ol>

                        
                    <?php endif; ?>
		</div>


               <?php if(ECRAN == 1) : ?>
                    <ul class="top-tabs home h0">
                        <li class="first actif"><?php echo getTrad(71); ?></li>
                        <li><?php echo getTrad(72); ?></li>
                        <li class="last"><?php echo getTrad(73); ?>&nbsp;<span style="color:#cf1a1a;">&nbsp;(75 000)</span></li>
                    </ul>
                <?php endif; ?>

		<div class="column col-right <?php if( ECRAN == 1) echo ' home'; elseif( ECRAN == 3) echo ' admin'; ?>">
                    <?php
                        switch ( ECRAN ):

                            case 1:
                                include("includes/ecran-1.php");
                                break;

                            case 2:
                                include("includes/ecran-2.php");
                                break;

                            case 3:
                                include("includes/ecran-3.php");
                                break;

                            default:
                                include("includes/ecran-1.php");
                                break;

                        endswitch;
                    ?>
                </div>
            </div>
            <div class="breaker">&nbsp;</div>
            <div id="footer">
                <div class="partage">
                        <?php

                        if(ECRAN == 3) {
                            if(LANG == FR) : ?>
                                <a href="admin.php?lang=EN" class="tradTrigger">
                                    <?php echo getTrad(44); ?>
                                </a>
                            <?php else: ?>
                                <a href="admin.php?lang=FR" class="tradTrigger">
                                    <?php echo getTrad(44); ?>
                                </a>
                            <?php endif;

                        } else {

                            $param = "&ecran=".ECRAN;
                            if(ECRAN == 2)  $param .= "&key=".$_GET['key'];

                            if(LANG == FR) : ?>
                                <a href="index.php?lang=EN<?php echo $param; ?>" class="tradTrigger">
                                    <?php echo getTrad(44); ?>
                                </a>
                            <?php else: ?>
                                <a href="index.php?lang=FR<?php echo $param; ?>" class="tradTrigger">
                                    <?php echo getTrad(44); ?>
                                </a>
                            <?php endif;
                        } ?>

                        <span class="share inputEmbed" style="display:none">
                            <?php if(LANG == "FR") : ?>
                                <input value='<a href="http://app.owni.fr/warlogs/" target="_blank"><img src="http://app.owni.fr/warlogs/theme/images/apercu_FR.png" alt="War Logs" /></a>' />
                                <span onclick="dropEmbed();">Fermer</span>
                            <?php elseif(LANG == "EN"): ?>
                                <input value='<a href="http://app.owni.fr/warlogs/?lang=EN" target="_blank"><img src="http://app.owni.fr/warlogs/theme/images/apercu_EN.png" alt="War Logs" /></a>' />
                                <span onclick="dropEmbed();">Close</span>
                            <?php endif; ?>
                        </span>

                        <?php if(LANG == "FR") : ?>
                            <a class="share mini-embed bg-white " href="#" onclick="getEmbed()">
                                &lt;intégrer&gt;
                            </a>
                        <?php elseif(LANG == "EN"): ?>
                            <a class="share mini-embed bg-white " href="#" onclick="getEmbed()">
                                &lt;embed&gt;
                            </a>
                        <?php endif; ?>

                        <a class="share mini-share-mail bg-white" target="_blank" href='http://www.addtoany.com/email?linkurl=<?php echo  rawurlencode(DOC_URL);  ?>&linkname=<?php echo   rawurlencode(ARTICLE_URL);  ?>&t=<?php echo rawurldecode(DOC_TITLE); ?>'>
                            <img alt="share mail" src="./theme/images/mini-email.png" /> email
                        </a>
                        <a class="share mini-share-facebook" target="_blank" href="http://www.facebook.com/share.php?u=<?php echo  rawurlencode(DOC_URL);  ?>&t=<?php echo rawurldecode(DOC_TITLE); ?>">
                            <img alt="facebook" src="./theme/images/mini-share-facebook.png" />
                        </a>

                        <span class="share twitter bg-white">
                            <iframe width="90" scrolling="no" height="20" frameborder="0" src="http://api.tweetmeme.com/button.js?url=<?php echo rawurlencode(DOC_URL); ?>&amp;style=compact&amp;hashtags=warlogs"></iframe>
                        </span>
                    </div>


                    <div id="owni">
                        <a href="http://owni.fr/2010/07/27/warlogs-wikileaks-application-enquete-contributive-europeenne/"><img src="./theme/images/owni.png"  alt="Owni"  /></a>
                        <a href="http://www.slate.fr/story/25467/wikileaks-afghanistan-application-enquete-participative/"><img src="./theme/images/slate.png" alt="Slate"  /></a>
                        <a href="http://www.monde-diplomatique.fr/carnet/2010-07-26-Rapports-explosifs-sur-la-guerre/"><img src="./theme/images/mondediplo.png" alt="Monde Diplo" /></a>
                        <a href="http://www.typhon.com/"><img src="./theme/images/typhon.png"  alt="Typhon"  /></a>
                    </div>
            </div>
        </div>
    </body>
</html>
