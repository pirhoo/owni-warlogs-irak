<?php

	function easyTime($timestamp)
	{
		$date_obtenu = hardTime($timestamp);
		$nbrSeconde = time() - $timestamp;
		$demainTS =  mktime(0, 0, 0, date('m', time()), date('d', time()),  date('Y', time()) ) + 60*60*24;	
		$aujourdhuiTS = mktime(0, 0, 0, date('m', time()), date('d', time()),  date('Y', time()) );
	
		if(date('d/m/Y',$timestamp) == date('d/m/Y',time()))
		{
			if($nbrSeconde/60/60 < 1)
			{	
				if($nbrSeconde < 60)
				{	
					$date_obtenu =  "il y a $nbrSeconde&nbsp;";
					
					if($nbrMinute == 1) $date_obtenu .= 'seconde';
					else  $date_obtenu .= 'secondes';
				}
				else
				{
					
					$nbrMinute = round( (time() - $timestamp) / 60 );
					$date_obtenu =   "il y a $nbrMinute&nbsp;";
					
					if($nbrMinute == 1) $date_obtenu .= "minute";
					else  $date_obtenu .= "minutes";
				}
			}
			else
			{
				$nbrHeure = round( (time() -$timestamp) / 60 /60 );
				$date_obtenu =   "il y a $nbrHeure&nbsp;";
				
				if($nbrHeure == 1) $date_obtenu .= "heure";
				else  $date_obtenu .= "heures";
			}

			return $date_obtenu;
		}
		elseif( ($timestamp > $aujourdhuiTS) and ($timestamp <= $demainTS) )
		{
			return "demain";
		}
		elseif(time() < $timestamp)
		{
			return date('d/m/Y',$timestamp) ;
		}
		elseif($timestamp > 0)
		{
			
			if(date('d/m/Y',$timestamp) == date('d/m/Y',time()))
			{
				
				if($nbrSeconde/60/60 < 1)
				{	
					
					if($nbrSeconde < 60)
					{	
						$date_obtenu =  "il y a $nbrSeconde&nbsp;";
						
						if($nbrMinute == 1) $date_obtenu .= 'seconde';
						else  $date_obtenu .= 'secondes';
					}
					else
					{
						
						$nbrMinute = round( (time() - $timestamp) / 60 );
						$date_obtenu =   "il y a $nbrMinute&nbsp;";
						
						if($nbrMinute == 1) $date_obtenu .= "minute";
						else  $date_obtenu .= "minutes";
					}
				}
				else
				{
					$nbrHeure = round( (time() -$timestamp) / 60 /60 );
					$date_obtenu =   "il y a $nbrHeure&nbsp;";
					
					if($nbrHeure == 1) $date_obtenu .= "heure";
					else  $date_obtenu .= "heures";
				}
			}
			else
			{
				$jourEnCour =  mktime(0, 0, 0, date('m', time()), date('d', time()),  date('Y', time()) );
				$jourTimestamp = mktime(0,0,0, date('m', $timestamp), date('d', $timestamp),  date('Y', $timestamp) );
				
				$nbrSeconde =  $jourEnCour - $jourTimestamp;
				$nbrJour = round($nbrSeconde/60/60/24);
				
				if($nbrJour == 1)
				{
					$date_obtenu =  "hier";
				}
				elseif($nbrJour < 7)
				{
					$date_obtenu =  "il y a $nbrJour&nbsp;jours";
				}
			}
		
			return $date_obtenu;
		}
		else
		{
			return 0;
		}
	}

	
	function hardTime($timestamp)
	{
		
		$monthsNumber =  date('m', $timestamp);
		$date =  date('d', $timestamp)."/";
		$date .= $monthsNumber."/";
		$date .= date('Y', $timestamp)." ";
		$date .= date('H\hi', $timestamp);
		
		return $date;
	}
?>