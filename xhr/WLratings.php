<?php
    @session_start();
    @header('Content-Type: text/html; charset=UTF-8');

    /*
        crée un contenu pour insertion par XHR dans une page incluant jQuery
    */

    chdir("../");
    require_once("./includes/class/Mydb.class.php");
    require_once("./includes/class/WLratings.class.php");
    require_once("./includes/lang.php");
    require_once("./includes/defines.php");

    $reportKey = trim(!empty($_POST["key"])? $_POST["key"]:$_GET["key"]);
    $evaluation = trim($_POST["evaluation"]);
    $ratings = $_POST["ratings"]; // array

    $wlratings = new WLratings ($reportKey);

    if (!empty($evaluation)) {
            $wlratings->set_evaluation($evaluation);
    }
    if (!empty($wlratings->my_evaluation)) {
	if (!empty($ratings) AND is_array($ratings))
		$wlratings->set_ratings($ratings);
        
	
	if ($wlratings->my_evaluation!="positive" OR !empty($wlratings->my_ratings)) {
            
		$output .= '<p>'.getTrad(70).'</p>
		<p><img src="./theme/images/Contribute-btn-small_'.LANG.'.png" alt="'.getTrad(65).'" onclick="return contrib()" /></p>
		<div id="randnext"><a href="index.php?action=rand" onclick="">'.getTrad(64).'</a></div>';
	}
	else {
		// output form for ratings
		$criteria = "";
		foreach ($wlratings->WL_ratings_criteria as $id => $label) {
                    if ($label)
                        $criteria .= '<input type="checkbox" name="wl_ratings_'.$id.'" value="'.$id.'" id="wl_ratings_'.$id.'" class="wl_ratings" /> <label for="wl_ratings_'.$id.'">'.htmlspecialchars($label).'</label>';
		}
                
		$output = '<p>'.getTrad(66).($wlratings->my_evaluation=="positive" ? getTrad(67) : getTrad(68) ).'<br />';
		$output .= getTrad(69).'</p>
			<div id="wlform">
				<form name="WLrate" action="#" id="WLrate" onSubmit="wlRatingsRate(); return false;" style="margin-right:20px;margin-top:-6px;">
				'.$criteria.'
				<input type="image" name="submit" id="submit" src="./theme/images/Valider-btn_'.LANG.'.png" alt="submit" onClick="" style="margin-bottom:-11px;" />
			</form></div>';
	}
    }
    else {
            // default screen
            $output = '<p>'.getTrad(69).'</p>
                    <div id="wlform"><form name="WLevaluate" action="#" id="WLevaluate" onSubmit="wlRatingsEvaluate(); return false;">
                            <input type="hidden" name="wl_evaluation" id="wl_evaluation" value="" />
                            <input type="image" name="wl_evaluation_positive" src="./theme/images/Interessant-btn_'.LANG.'.png" id="wl_evaluation_positive" src="" alt="intéressant" onClick="this.form.wl_evaluation.value=\'positive\';" style="margin-right:20px;" />
                            <input type="image" name="wl_evaluation_negative" src="./theme/images/Pas-interessant-btn_'.LANG.'.png"  id="wl_evaluation_negative" src="" alt="pas intéressant" onClick="this.form.wl_evaluation.value=\'negative\';" />
                    </form></div>';
    }
    echo ($output);
?>