<?php
//$_POST[name]="lukedetón";
//$_POST[region]='na';

$name	=urlencode(strtolower (str_replace(" ","",$_POST[name])));
$server	=$_POST[region];
$url	="http://".$server.".op.gg/summoner/userName=".$name;
$opgg	=@file_get_contents($url);
$ranks	=array("Bronze", "Silver", "Gold", "Platinum", "Diamond", "Master", "Challenger");

foreach ($ranks as $value) {
    if (strpos ( $opgg ,"4 ".$value )){
		$return='<div class="rank4" title="Season 4" style="background:url(icons/'.strtoupper($value).'_I.png);background-size: 100% auto;"></div>';
		echo $return;
	}
}
?>
