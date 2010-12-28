<?
$terms = array();
global $terms;
$handle = fopen("./files/NATOspeak.csv", "r");
 while(($data = fgetcsv($handle, 0, ",")) !== FALSE) {
 	//initialisation
	$term = '';
	$explain_en = '';
	$explain_fr = '';
	
	//scrape le csv
	$term = strtoupper($data[0]);
	if (isset($data[1]))
		$explain_en = $data[1];
	if (isset($data[2]))
		$explain_fr = ($data[2]);
	
	//populates master array
	$terms[$term]['FR']=$explain_fr;
	$terms[$term]['EN']=$explain_en;
 }
 
function addAcronymsAndFormat($txt_raw, $lg){
	
	$txt_raw = strtoupper($txt_raw);
	$txt_raw = nl2br($txt_raw);
	//txt will be enriched version of raw
	$txt = $txt_raw;
	
	//cleans shit
	$txt = preg_replace("/\*./", " ", $txt);
	
	//format according to SALTUR
		$txt = preg_replace("/\W(S-|S:|A-|A:|L-|L:|T-|T:|U-|U:|R-|R:)/", "<br> $1 ", $txt, -1);	
	//adds paragraph when updates
		//$txt = str_replace("UPDATE", "<br>UPDATE",$txt);
	//adds line break when time
		$regex = "/(\.|\. AT )(\d\d)(\d\d)([Z|D|z|d])/";
		$replacement = ".<br>AT <abbr title='$2:$3'>$2$3$4</abbr>";
		$txt = preg_replace($regex, $replacement, $txt);
	//adds line break when time #2
		$regex = "/(AT )(\d\d)(\d\d)(\d\d)(\w\w\w)(\d\d)\(Z\)/";
		$replacement = "<br>AT <abbr title='$3:$4'>$2$3$4$5(Z)</abbr>";
		$txt = preg_replace($regex, $replacement, $txt);
	//adds abbr to other time
		$regex = "/\W(\d\d)(\d\d)([Z|D|z|d]) /";
		$replacement = " <abbr title='$1:$2'>$1$2$3</abbr> ";
		$txt = preg_replace($regex, $replacement, $txt);
	//adds Acronyms
	global $terms;
	
	$txt_array = explodeX(array(".","!"," ","?",";","/"), $txt);
	foreach ($txt_array as $word){
		if (array_key_exists($word, $terms)) {
			//word is recognized
			if ($terms[$word][$lg]!="")
				$replace = "<abbr title='". $terms[$word][$lg] ."'>".$word."</abbr>";
			else if ($terms[$word]['EN']!="")
				$replace = "<abbr title='". $terms[$word]['EN'] ."'>".$word."</abbr>";
			else
				$replace = "<strong>".$word."</strong>";
				
			$pattern = "/(\W)".$word."(\W)/";
			$replacement = "$1".$replace."$2";
			$txt = preg_replace($pattern, $replacement, $txt);
		}
	}
	return $txt;
}

function explodeX($delimiters,$string)
{
    $return_array = Array($string); // The array to return
    $d_count = 0;
    while (isset($delimiters[$d_count])) // Loop to loop through all delimiters
    {
        $new_return_array = Array(); 
        foreach($return_array as $el_to_split) // Explode all returned elements by the next delimiter
        {
            $put_in_new_return_array = explode($delimiters[$d_count],$el_to_split);
            foreach($put_in_new_return_array as $substr) // Put all the exploded elements in array to return
            {
                $new_return_array[] = $substr;
            }
        }
        $return_array = $new_return_array; // Replace the previous return array by the next version
        $d_count++;
    }
    return $return_array; // Return the exploded elements
}