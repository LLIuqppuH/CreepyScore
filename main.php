<?php
//$_POST[name]="NL Paarthurnax";
//$_POST[region]="tr";
$name			=strtolower (str_replace(" ","",$_POST[name]));
if ($name==""){
	new Output("Please fill in the player's name");
	exit;
}
$serverupper	=$_POST[region];
$server			=strtolower($_POST[region]);

$RitoResponse	=new RitoRequest($name,$server);
$idsChampsJSON	=new IDsChampsJSON();
$fill			=new ThisGameInfo($name,$server,$RitoResponse,$idsChampsJSON);
new Output($error,$fill);
//print_r($fill);
class ThisGameInfo{
	public function __construct($name,$server,$RitoResponse,$idsChampsJSON) {
		$runes=new AllRunes();
		$read=json_decode($IDsChampsJSONString);
		$this->{0}=new stdClass();
		$this->{0}->result		='OK';
		$this->{0}->name			=$_POST[name];
		$this->{0}->server		=strtolower($_POST[region]);
		$this->{0}->localstorage	=json_encode($_POST);
		$i=0;
		foreach ($RitoResponse as $key => $value){
			$this->{0}->allIDs[]=$RitoResponse->{$key}->summonerId;
			$this->{$key}			=new stdClass();
			$this->{$key}->runes	=new stdClass();
			$this->{$key}->masteries=new stdClass();
			$this->{$key}->summonerName		=$RitoResponse->{$key}->summonerName;			
			$this->{$key}->champ			=$RitoResponse->{$key}->championId;
			$this->{$key}->num				=$i;
			$i++;
			foreach ($value->runes as $key2 => $value2){
				foreach ($runes->{$value2->runeId}->stats as $key3 => $value3){
					$this->{$key}->runes->{$key3}+=$value3*$value2->count;
				}	
			}
			
			$this->{$key}->mast->{1}=0;
			$this->{$key}->mast->{2}=0;
			$this->{$key}->mast->{3}=0;
			foreach ($value->masteries as $key2 => $value2){
				$this->{$key}->masteries->{$value2->masteryId}=$value2->rank;
				$rest = substr($value2->masteryId, 1, 1);
				$this->{$key}->mast->{substr($value2->masteryId, 1, 1)}+=$value2->rank;
			}

			$this->{$key}->champInfo=$idsChampsJSON->json->{$this->{$key}->champ};
			
		}
	}	
}

class Output{
	public function __construct($error=NULL,$fill=NULL){
		if ($error)
		{		
			$this->{0}->result=$error;
			echo json_encode($this);			
		}else{
			echo json_encode($fill);
		}
	}
}
 
class IDsChampsJSON{
	public function __construct() {
		$data='{"266":{"nameA":"Aatrox","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Aatrox_0.jpg","nameB":"aatrox","number":"0","backX":"30"},"103":{"nameA":"Ahri","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Ahri_0.jpg","nameB":"ahri","number":"1","backX":"40"},"84":{"nameA":"Akali","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Akali_0.jpg","nameB":"akali","number":"2","backX":"40"},"12":{"nameA":"Alistar","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Alistar_0.jpg","nameB":"alistar","number":"3","backX":"45"},"32":{"nameA":"Amumu","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Amumu_0.jpg","nameB":"amumu","number":"4","backX":"40"},"34":{"nameA":"Anivia","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Anivia_0.jpg","nameB":"anivia","number":"5","backX":"85"},"1":{"nameA":"Annie","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Annie_0.jpg","nameB":"annie","number":"6","backX":"55"},"22":{"nameA":"Ashe","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Ashe_0.jpg","nameB":"ashe","number":"7","backX":"40"},"268":{"nameA":"Azir","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Azir_0.jpg","nameB":"azir","number":"8","backX":"65"},"432":{"nameA":"Bard","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Bard_0.jpg","nameB":"bard","number":"9","backX":"50"},"53":{"nameA":"Blitzcrank","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Blitzcrank_0.jpg","nameB":"blitzcrank","number":"10","backX":"85"},"63":{"nameA":"Brand","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Brand_0.jpg","nameB":"brand","number":"11","backX":"65"},"201":{"nameA":"Braum","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Braum_0.jpg","nameB":"braum","number":"12","backX":""},"51":{"nameA":"Caitlyn","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Caitlyn_0.jpg","nameB":"caitlyn","number":"13","backX":"60"},"69":{"nameA":"Cassiopeia","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Cassiopeia_0.jpg","nameB":"cassiopeia","number":"14","backX":"35"},"31":{"nameA":"Chogath","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Chogath_0.jpg","nameB":"chogath","number":"15","backX":"45"},"42":{"nameA":"Corki","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Corki_0.jpg","nameB":"corki","number":"16","backX":"40"},"122":{"nameA":"Darius","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Darius_0.jpg","nameB":"darius","number":"17","backX":"40"},"131":{"nameA":"Diana","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Diana_0.jpg","nameB":"diana","number":"18","backX":"60"},"36":{"nameA":"DrMundo","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/DrMundo_0.jpg","nameB":"drmundo","number":"19","backX":"80"},"119":{"nameA":"Draven","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Draven_0.jpg","nameB":"draven","number":"20","backX":""},"60":{"nameA":"Elise","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Elise_0.jpg","nameB":"elise","number":"21","backX":""},"28":{"nameA":"Evelynn","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Evelynn_0.jpg","nameB":"evelynn","number":"22","backX":"75"},"81":{"nameA":"Ezreal","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Ezreal_0.jpg","nameB":"ezreal","number":"23","backX":"30"},"9":{"nameA":"FiddleSticks","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/FiddleSticks_0.jpg","nameB":"fiddlesticks","number":"24","backX":"15"},"114":{"nameA":"Fiora","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Fiora_0.jpg","nameB":"fiora","number":"25","backX":""},"105":{"nameA":"Fizz","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Fizz_0.jpg","nameB":"fizz","number":"26","backX":""},"3":{"nameA":"Galio","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Galio_0.jpg","nameB":"galio","number":"27","backX":""},"41":{"nameA":"Gangplank","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Gangplank_0.jpg","nameB":"gangplank","number":"28","backX":""},"86":{"nameA":"Garen","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Garen_0.jpg","nameB":"garen","number":"29","backX":"80"},"150":{"nameA":"Gnar","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Gnar_0.jpg","nameB":"gnar","number":"30","backX":"60"},"79":{"nameA":"Gragas","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Gragas_0.jpg","nameB":"gragas","number":"31","backX":""},"104":{"nameA":"Graves","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Graves_0.jpg","nameB":"graves","number":"32","backX":"70"},"120":{"nameA":"Hecarim","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Hecarim_0.jpg","nameB":"hecarim","number":"33","backX":"80"},"74":{"nameA":"Heimerdinger","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Heimerdinger_0.jpg","nameB":"heimerdinger","number":"34","backX":""},"39":{"nameA":"Irelia","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Irelia_0.jpg","nameB":"irelia","number":"35","backX":""},"40":{"nameA":"Janna","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Janna_0.jpg","nameB":"janna","number":"36","backX":"75"},"59":{"nameA":"JarvanIV","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/JarvanIV_0.jpg","nameB":"jarvaniv","number":"37","backX":""},"24":{"nameA":"Jax","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Jax_0.jpg","nameB":"jax","number":"38","backX":"85"},"126":{"nameA":"Jayce","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Jayce_0.jpg","nameB":"jayce","number":"39","backX":"80"},"222":{"nameA":"Jinx","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Jinx_0.jpg","nameB":"jinx","number":"40","backX":"25"},"429":{"nameA":"Kalista","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Kalista_0.jpg","nameB":"kalista","number":"41","backX":"65"},"43":{"nameA":"Karma","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Karma_0.jpg","nameB":"karma","number":"42","backX":"65"},"30":{"nameA":"Karthus","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Karthus_0.jpg","nameB":"karthus","number":"43","backX":""},"38":{"nameA":"Kassadin","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Kassadin_0.jpg","nameB":"kassadin","number":"44","backX":"30"},"55":{"nameA":"Katarina","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Katarina_0.jpg","nameB":"katarina","number":"45","backX":"85"},"10":{"nameA":"Kayle","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Kayle_0.jpg","nameB":"kayle","number":"46","backX":""},"85":{"nameA":"Kennen","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Kennen_0.jpg","nameB":"kennen","number":"47","backX":"80"},"121":{"nameA":"Khazix","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Khazix_0.jpg","nameB":"khazix","number":"48","backX":"80"},"96":{"nameA":"KogMaw","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/KogMaw_0.jpg","nameB":"kogmaw","number":"49","backX":"75"},"7":{"nameA":"Leblanc","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Leblanc_0.jpg","nameB":"leblanc","number":"50","backX":""},"64":{"nameA":"LeeSin","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/LeeSin_0.jpg","nameB":"lee sin","number":"51","backX":""},"89":{"nameA":"Leona","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Leona_0.jpg","nameB":"leona","number":"52","backX":"40"},"127":{"nameA":"Lissandra","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Lissandra_0.jpg","nameB":"lissandra","number":"53","backX":"40"},"236":{"nameA":"Lucian","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Lucian_0.jpg","nameB":"lucian","number":"54","backX":"60"},"117":{"nameA":"Lulu","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Lulu_0.jpg","nameB":"lulu","number":"55","backX":""},"99":{"nameA":"Lux","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Lux_0.jpg","nameB":"lux","number":"56","backX":"40"},"54":{"nameA":"Malphite","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Malphite_0.jpg","nameB":"malphite","number":"57","backX":""},"90":{"nameA":"Malzahar","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Malzahar_0.jpg","nameB":"malzahar","number":"58","backX":""},"57":{"nameA":"Maokai","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Maokai_0.jpg","nameB":"maokai","number":"59","backX":"65"},"11":{"nameA":"MasterYi","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/MasterYi_0.jpg","nameB":"masteryi","number":"60","backX":"60"},"21":{"nameA":"MissFortune","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/MissFortune_0.jpg","nameB":"missfortune","number":"61","backX":"75"},"82":{"nameA":"Mordekaiser","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Mordekaiser_0.jpg","nameB":"mordekaiser","number":"62","backX":"65"},"25":{"nameA":"Morgana","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Morgana_0.jpg","nameB":"morgana","number":"63","backX":"55"},"267":{"nameA":"Nami","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Nami_0.jpg","nameB":"nami","number":"64","backX":"70"},"75":{"nameA":"Nasus","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Nasus_0.jpg","nameB":"nasus","number":"65","backX":"30"},"111":{"nameA":"Nautilus","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Nautilus_0.jpg","nameB":"nautilus","number":"66","backX":""},"76":{"nameA":"Nidalee","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Nidalee_0.jpg","nameB":"nidalee","number":"67","backX":"70"},"56":{"nameA":"Nocturne","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Nocturne_0.jpg","nameB":"nocturne","number":"68","backX":"30"},"20":{"nameA":"Nunu","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Nunu_0.jpg","nameB":"nunu","number":"69","backX":"85"},"2":{"nameA":"Olaf","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Olaf_0.jpg","nameB":"olaf","number":"70","backX":""},"61":{"nameA":"Orianna","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Orianna_0.jpg","nameB":"orianna","number":"71","backX":""},"80":{"nameA":"Pantheon","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Pantheon_0.jpg","nameB":"pantheon","number":"72","backX":"30"},"78":{"nameA":"Poppy","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Poppy_0.jpg","nameB":"poppy","number":"73","backX":""},"133":{"nameA":"Quinn","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Quinn_0.jpg","nameB":"quinn","number":"74","backX":"80"},"33":{"nameA":"Rammus","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Rammus_0.jpg","nameB":"rammus","number":"75","backX":"65"},"421":{"nameA":"RekSai","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/RekSai_0.jpg","nameB":"RekSai","number":"76","backX":"35"},"58":{"nameA":"Renekton","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Renekton_0.jpg","nameB":"renekton","number":"77","backX":"55"},"107":{"nameA":"Rengar","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Rengar_0.jpg","nameB":"rengar","number":"78","backX":"65"},"92":{"nameA":"Riven","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Riven_0.jpg","nameB":"riven","number":"79","backX":""},"68":{"nameA":"Rumble","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Rumble_0.jpg","nameB":"rumble","number":"80","backX":"35"},"13":{"nameA":"Ryze","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Ryze_0.jpg","nameB":"ryze","number":"81","backX":"75"},"113":{"nameA":"Sejuani","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Sejuani_0.jpg","nameB":"sejuani","number":"82","backX":"65"},"35":{"nameA":"Shaco","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Shaco_0.jpg","nameB":"shaco","number":"83","backX":""},"98":{"nameA":"Shen","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Shen_0.jpg","nameB":"shen","number":"84","backX":"80"},"102":{"nameA":"Shyvana","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Shyvana_0.jpg","nameB":"shyvana","number":"85","backX":""},"27":{"nameA":"Singed","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Singed_0.jpg","nameB":"singed","number":"86","backX":""},"14":{"nameA":"Sion","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Sion_0.jpg","nameB":"sion","number":"87","backX":""},"15":{"nameA":"Sivir","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Sivir_0.jpg","nameB":"sivir","number":"88","backX":"10"},"72":{"nameA":"Skarner","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Skarner_0.jpg","nameB":"skarner","number":"89","backX":"70"},"37":{"nameA":"Sona","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Sona_0.jpg","nameB":"sona","number":"90","backX":"40"},"16":{"nameA":"Soraka","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Soraka_0.jpg","nameB":"soraka","number":"91","backX":"30"},"50":{"nameA":"Swain","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Swain_0.jpg","nameB":"swain","number":"92","backX":""},"134":{"nameA":"Syndra","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Syndra_0.jpg","nameB":"syndra","number":"93","backX":""},"91":{"nameA":"Talon","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Talon_0.jpg","nameB":"talon","number":"94","backX":""},"44":{"nameA":"Taric","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Taric_0.jpg","nameB":"taric","number":"95","backX":"75"},"17":{"nameA":"Teemo","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Teemo_0.jpg","nameB":"teemo","number":"96","backX":"20"},"412":{"nameA":"Thresh","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Thresh_0.jpg","nameB":"thresh","number":"97","backX":""},"18":{"nameA":"Tristana","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Tristana_0.jpg","nameB":"tristana","number":"98","backX":"40"},"48":{"nameA":"Trundle","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Trundle_0.jpg","nameB":"trundle","number":"99","backX":"35"},"23":{"nameA":"Tryndamere","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Tryndamere_0.jpg","nameB":"tryndamere","number":"100","backX":"35"},"4":{"nameA":"TwistedFate","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/TwistedFate_0.jpg","nameB":"twistedfate","number":"101","backX":"60"},"29":{"nameA":"Twitch","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Twitch_0.jpg","nameB":"twitch","number":"102","backX":"60"},"77":{"nameA":"Udyr","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Udyr_0.jpg","nameB":"udyr","number":"103","backX":"15"},"6":{"nameA":"Urgot","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Urgot_0.jpg","nameB":"urgot","number":"104","backX":"40"},"110":{"nameA":"Varus","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Varus_0.jpg","nameB":"varus","number":"105","backX":"85"},"67":{"nameA":"Vayne","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Vayne_0.jpg","nameB":"vayne","number":"106","backX":"85"},"45":{"nameA":"Veigar","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Veigar_0.jpg","nameB":"veigar","number":"107","backX":"30"},"161":{"nameA":"Velkoz","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Velkoz_0.jpg","nameB":"velkoz","number":"108","backX":""},"254":{"nameA":"Vi","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Vi_0.jpg","nameB":"vi","number":"109","backX":"30"},"112":{"nameA":"Viktor","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Viktor_0.jpg","nameB":"viktor","number":"110","backX":"65"},"8":{"nameA":"Vladimir","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Vladimir_0.jpg","nameB":"vladimir","number":"111","backX":"80"},"106":{"nameA":"Volibear","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Volibear_0.jpg","nameB":"volibear","number":"112","backX":"35"},"19":{"nameA":"Warwick","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Warwick_0.jpg","nameB":"warwick","number":"113","backX":"80"},"62":{"nameA":"MonkeyKing","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/MonkeyKing_0.jpg","nameB":"wukong","number":"114","backX":""},"101":{"nameA":"Xerath","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Xerath_0.jpg","nameB":"xerath","number":"115","backX":""},"5":{"nameA":"XinZhao","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/XinZhao_0.jpg","nameB":"xinzhao","number":"116","backX":"85"},"157":{"nameA":"Yasuo","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Yasuo_0.jpg","nameB":"yasuo","number":"117","backX":""},"83":{"nameA":"Yorick","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Yorick_0.jpg","nameB":"yorick","number":"118","backX":"75"},"154":{"nameA":"Zac","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Zac_0.jpg","nameB":"zac","number":"119","backX":"70"},"238":{"nameA":"Zed","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Zed_0.jpg","nameB":"zed","number":"120","backX":"45"},"115":{"nameA":"Ziggs","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Ziggs_0.jpg","nameB":"ziggs","number":"121","backX":"20"},"26":{"nameA":"Zilean","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Zilean_0.jpg","nameB":"zilean","number":"122","backX":"55"},"143":{"nameA":"Zyra","pic":"http:\/\/ddragon.leagueoflegends.com\/cdn\/img\/champion\/loading\/Zyra_0.jpg","nameB":"zyra","number":"123","backX":""}}';	
		$this->json=json_decode($data);
	}
}

class RitoRequest{
	public function __construct($name,$server) {  
		$key			="377050fe-b182-4796-bf4c-efdaf944278d";
		$req1			=@file_get_contents('https://'.$server.'.api.pvp.net:443/api/lol/'.$server.'/v1.4/summoner/by-name/'.$name.'?api_key='.$key);
		$summonerByName	=json_decode ($req1);
		$serverfixname	=array("na" => "NA1","br" => "BR1","lan" => "LA1","las" => "LA2","oce" => "OC1","eune" => "EUN1","euw" => "EUW1","ru" => "RU","tr" => "TR1");	
		$req2			=@file_get_contents('https://'.$server.'.api.pvp.net/observer-mode/rest/consumer/getSpectatorGameInfo/'.$serverfixname[$server].'/'.$summonerByName->{$name}->id.'?api_key='.$key);
		$getSpectatorGameInfo	=json_decode ($req2);
		for ($i = 0; $i < count($getSpectatorGameInfo->participants); $i++) {
			$this->{$getSpectatorGameInfo->participants[$i]->summonerId}=$getSpectatorGameInfo->participants[$i];
		} 
		if (count($getSpectatorGameInfo->participants)<5) {
				$error=$_POST[name]." is not in game now.";
				new Output($error,$fill);
				exit;
		}		
		//print_r($this);
    }
}

class AllRunes{
	public function __construct() {  
		$data='{
	"type": "rune",
	"version": "5.2.2",
	"basic": {
		"name": "",
		"rune": {
			"isrune": true,
			"tier": 1,
			"type": "red"
		},
		"gold": {
			"base": 0,
			"total": 0,
			"sell": 0,
			"purchasable": false
		},
		"group": "",
		"description": "",
		"colloq": ";",
		"plaintext": "",
		"consumed": false,
		"stacks": 1,
		"depth": 1,
		"consumeOnFull": false,
		"from": [],
		"into": [],
		"specialRecipe": 0,
		"inStore": true,
		"hideFromAll": false,
		"requiredChampion": "",
		"stats": {
			"FlatHPPoolMod": 0,
			"rFlatHPModPerLevel": 0,
			"FlatMPPoolMod": 0,
			"rFlatMPModPerLevel": 0,
			"PercentHPPoolMod": 0,
			"PercentMPPoolMod": 0,
			"FlatHPRegenMod": 0,
			"rFlatHPRegenModPerLevel": 0,
			"PercentHPRegenMod": 0,
			"FlatMPRegenMod": 0,
			"rFlatMPRegenModPerLevel": 0,
			"PercentMPRegenMod": 0,
			"FlatArmorMod": 0,
			"rFlatArmorModPerLevel": 0,
			"PercentArmorMod": 0,
			"rFlatArmorPenetrationMod": 0,
			"rFlatArmorPenetrationModPerLevel": 0,
			"rPercentArmorPenetrationMod": 0,
			"rPercentArmorPenetrationModPerLevel": 0,
			"FlatPhysicalDamageMod": 0,
			"rFlatPhysicalDamageModPerLevel": 0,
			"PercentPhysicalDamageMod": 0,
			"FlatMagicDamageMod": 0,
			"rFlatMagicDamageModPerLevel": 0,
			"PercentMagicDamageMod": 0,
			"FlatMovementSpeedMod": 0,
			"rFlatMovementSpeedModPerLevel": 0,
			"PercentMovementSpeedMod": 0,
			"rPercentMovementSpeedModPerLevel": 0,
			"FlatAttackSpeedMod": 0,
			"PercentAttackSpeedMod": 0,
			"rPercentAttackSpeedModPerLevel": 0,
			"rFlatDodgeMod": 0,
			"rFlatDodgeModPerLevel": 0,
			"PercentDodgeMod": 0,
			"FlatCritChanceMod": 0,
			"rFlatCritChanceModPerLevel": 0,
			"PercentCritChanceMod": 0,
			"FlatCritDamageMod": 0,
			"rFlatCritDamageModPerLevel": 0,
			"PercentCritDamageMod": 0,
			"FlatBlockMod": 0,
			"PercentBlockMod": 0,
			"FlatSpellBlockMod": 0,
			"rFlatSpellBlockModPerLevel": 0,
			"PercentSpellBlockMod": 0,
			"FlatEXPBonus": 0,
			"PercentEXPBonus": 0,
			"rPercentCooldownMod": 0,
			"rPercentCooldownModPerLevel": 0,
			"rFlatTimeDeadMod": 0,
			"rFlatTimeDeadModPerLevel": 0,
			"rPercentTimeDeadMod": 0,
			"rPercentTimeDeadModPerLevel": 0,
			"rFlatGoldPer10Mod": 0,
			"rFlatMagicPenetrationMod": 0,
			"rFlatMagicPenetrationModPerLevel": 0,
			"rPercentMagicPenetrationMod": 0,
			"rPercentMagicPenetrationModPerLevel": 0,
			"FlatEnergyRegenMod": 0,
			"rFlatEnergyRegenModPerLevel": 0,
			"FlatEnergyPoolMod": 0,
			"rFlatEnergyModPerLevel": 0,
			"PercentLifeStealMod": 0,
			"PercentSpellVampMod": 0
		},
		"tags": [],
		"maps": {
			"1": true,
			"8": true,
			"10": true,
			"12": true
		}
	},
	"data": {
		"10001": {
			"name": "Razer Mark of Precision",
			"description": "+2.23% critical damage",
			"image": {
				"full": "10001.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 0,
				"y": 0,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "red"
			},
			"stats": {
				"FlatCritDamageMod": 0.022314
			},
			"tags": ["physicalAttack",
			"percent",
			"mark"],
			"colloq": null,
			"plaintext": null
		},
		"10002": {
			"name": "Razer Quintessence of Speed",
			"description": "+1.5% movement speed",
			"image": {
				"full": "10002.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 48,
				"y": 0,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "black"
			},
			"stats": {
				"PercentMovementSpeedMod": 0.015
			},
			"tags": ["utility",
			"percent",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5001": {
			"name": "Lesser Mark of Attack Damage",
			"description": "+0.53 attack damage",
			"image": {
				"full": "r_1_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 96,
				"y": 0,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "red"
			},
			"stats": {
				"FlatPhysicalDamageMod": 0.525
			},
			"tags": ["physicalAttack",
			"flat",
			"mark"],
			"colloq": null,
			"plaintext": null
		},
		"5002": {
			"name": "Lesser Mark of Scaling Attack Damage",
			"description": "+0.08 attack damage per level (+1.35 at champion level 18)",
			"image": {
				"full": "r_2_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 144,
				"y": 0,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "red"
			},
			"stats": {
				"rFlatPhysicalDamageModPerLevel": 0.075
			},
			"tags": ["physicalAttack",
			"perLevel",
			"mark"],
			"colloq": null,
			"plaintext": null
		},
		"5003": {
			"name": "Lesser Mark of Attack Speed",
			"description": "+0.94% attack speed",
			"image": {
				"full": "r_3_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 192,
				"y": 0,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "red"
			},
			"stats": {
				"PercentAttackSpeedMod": 0.009434
			},
			"tags": ["physicalAttack",
			"percent",
			"mark"],
			"colloq": null,
			"plaintext": null
		},
		"5005": {
			"name": "Lesser Mark of Critical Damage",
			"description": "+1.24% critical damage",
			"image": {
				"full": "r_1_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 96,
				"y": 0,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "red"
			},
			"stats": {
				"FlatCritDamageMod": 0.012397
			},
			"tags": ["physicalAttack",
			"percent",
			"mark"],
			"colloq": null,
			"plaintext": null
		},
		"5007": {
			"name": "Lesser Mark of Critical Chance",
			"description": "+0.52% critical chance",
			"image": {
				"full": "r_3_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 192,
				"y": 0,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "red"
			},
			"stats": {
				"FlatCritChanceMod": 0.005155
			},
			"tags": ["physicalAttack",
			"percent",
			"mark"],
			"colloq": null,
			"plaintext": null
		},
		"5009": {
			"name": "Lesser Mark of Armor Penetration",
			"description": "+0.72 armor penetration",
			"image": {
				"full": "r_1_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 96,
				"y": 0,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "red"
			},
			"stats": {
				"rFlatArmorPenetrationMod": 0.72
			},
			"tags": ["physicalAttack",
			"flat",
			"mark"],
			"colloq": null,
			"plaintext": null
		},
		"5011": {
			"name": "Lesser Mark of Health",
			"description": "+1.93 health",
			"image": {
				"full": "r_3_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 192,
				"y": 0,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "red"
			},
			"stats": {
				"FlatHPPoolMod": 1.9305
			},
			"tags": ["defense",
			"flat",
			"mark"],
			"colloq": null,
			"plaintext": null
		},
		"5012": {
			"name": "Lesser Mark of Scaling Health",
			"description": "+0.3 health per level (+5.4 at champion level 18)",
			"image": {
				"full": "r_4_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 240,
				"y": 0,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "red"
			},
			"stats": {
				"rFlatHPModPerLevel": 0.3005
			},
			"tags": ["defense",
			"perLevel",
			"mark"],
			"colloq": null,
			"plaintext": null
		},
		"5013": {
			"name": "Lesser Mark of Armor",
			"description": "+0.51 armor",
			"image": {
				"full": "r_1_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 96,
				"y": 0,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "red"
			},
			"stats": {
				"FlatArmorMod": 0.508
			},
			"tags": ["defense",
			"flat",
			"mark"],
			"colloq": null,
			"plaintext": null
		},
		"5015": {
			"name": "Lesser Mark of Magic Resist",
			"description": "+0.43 magic resist",
			"image": {
				"full": "r_3_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 192,
				"y": 0,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "red"
			},
			"stats": {
				"FlatSpellBlockMod": 0.43
			},
			"tags": ["defense",
			"flat",
			"mark"],
			"colloq": null,
			"plaintext": null
		},
		"5016": {
			"name": "Lesser Mark of Scaling Magic Resist",
			"description": "+0.04 magic resist per level (+0.72 at champion level 18)",
			"image": {
				"full": "r_4_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 240,
				"y": 0,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "red"
			},
			"stats": {
				"rFlatSpellBlockModPerLevel": 0.0412
			},
			"tags": ["defense",
			"perLevel",
			"mark"],
			"colloq": null,
			"plaintext": null
		},
		"5021": {
			"name": "Lesser Mark of Cooldown Reduction",
			"description": "-0.11% cooldowns",
			"image": {
				"full": "r_1_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 96,
				"y": 0,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "red"
			},
			"stats": {
				"rPercentCooldownMod": -0.001112
			},
			"tags": ["utility",
			"percent",
			"mark"],
			"colloq": null,
			"plaintext": null
		},
		"5023": {
			"name": "Lesser Mark of Ability Power",
			"description": "+0.33 ability power",
			"image": {
				"full": "r_3_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 192,
				"y": 0,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "red"
			},
			"stats": {
				"FlatMagicDamageMod": 0.33
			},
			"tags": ["magic",
			"flat",
			"mark"],
			"colloq": null,
			"plaintext": null
		},
		"5024": {
			"name": "Lesser Mark of Scaling Ability Power",
			"description": "+0.06 ability power per level (+1.08 at champion level 18)",
			"image": {
				"full": "r_4_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 240,
				"y": 0,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "red"
			},
			"stats": {
				"rFlatMagicDamageModPerLevel": 0.0577
			},
			"tags": ["magic",
			"perLevel",
			"mark"],
			"colloq": null,
			"plaintext": null
		},
		"5025": {
			"name": "Lesser Mark of Mana",
			"description": "+3.28 mana",
			"image": {
				"full": "r_1_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 96,
				"y": 0,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "red"
			},
			"stats": {
				"FlatMPPoolMod": 3.2813
			},
			"tags": ["magic",
			"flat",
			"mark"],
			"colloq": null,
			"plaintext": null
		},
		"5026": {
			"name": "Lesser Mark of Scaling Mana",
			"description": "+0.65 mana per level (+11.7 at champion level 18)",
			"image": {
				"full": "r_2_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 144,
				"y": 0,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "red"
			},
			"stats": {
				"rFlatMPModPerLevel": 0.6481
			},
			"tags": ["magic",
			"perLevel",
			"mark"],
			"colloq": null,
			"plaintext": null
		},
		"5027": {
			"name": "Lesser Mark of Mana Regeneration",
			"description": "+0.15 mana regen / 5 sec.",
			"image": {
				"full": "r_3_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 192,
				"y": 0,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "red"
			},
			"stats": {
				"FlatMPRegenMod": 0.02916
			},
			"tags": ["magic",
			"flat",
			"mark"],
			"colloq": null,
			"plaintext": null
		},
		"5029": {
			"name": "Lesser Mark of Magic Penetration",
			"description": "+0.49 magic penetration",
			"image": {
				"full": "r_1_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 96,
				"y": 0,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "red"
			},
			"stats": {
				"rFlatMagicPenetrationMod": 0.49
			},
			"tags": ["magic",
			"flat",
			"mark"],
			"colloq": null,
			"plaintext": null
		},
		"5031": {
			"name": "Lesser Glyph of Attack Damage",
			"description": "+0.16 attack damage",
			"image": {
				"full": "b_1_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 288,
				"y": 0,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "blue"
			},
			"stats": {
				"FlatPhysicalDamageMod": 0.1575
			},
			"tags": ["physicalAttack",
			"flat",
			"glyph"],
			"colloq": null,
			"plaintext": null
		},
		"5032": {
			"name": "Lesser Glyph of Scaling Attack Damage",
			"description": "+0.02 attack damage per level (+0.36 at champion level 18)",
			"image": {
				"full": "b_2_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 336,
				"y": 0,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "blue"
			},
			"stats": {
				"rFlatPhysicalDamageModPerLevel": 0.0225
			},
			"tags": ["physicalAttack",
			"perLevel",
			"glyph"],
			"colloq": null,
			"plaintext": null
		},
		"5033": {
			"name": "Lesser Glyph of Attack Speed",
			"description": "+0.35% attack speed",
			"image": {
				"full": "b_3_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 384,
				"y": 0,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "blue"
			},
			"stats": {
				"PercentAttackSpeedMod": 0.003538
			},
			"tags": ["physicalAttack",
			"percent",
			"glyph"],
			"colloq": null,
			"plaintext": null
		},
		"5035": {
			"name": "Lesser Glyph of Critical Damage",
			"description": "+0.31% critical damage",
			"image": {
				"full": "b_1_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 288,
				"y": 0,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "blue"
			},
			"stats": {
				"FlatCritDamageMod": 0.003099
			},
			"tags": ["physicalAttack",
			"percent",
			"glyph"],
			"colloq": null,
			"plaintext": null
		},
		"5037": {
			"name": "Lesser Glyph of Critical Chance",
			"description": "+0.15% critical chance",
			"image": {
				"full": "b_3_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 384,
				"y": 0,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "blue"
			},
			"stats": {
				"FlatCritChanceMod": 0.001546
			},
			"tags": ["physicalAttack",
			"percent",
			"glyph"],
			"colloq": null,
			"plaintext": null
		},
		"5041": {
			"name": "Lesser Glyph of Health",
			"description": "+1.49 health",
			"image": {
				"full": "b_3_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 384,
				"y": 0,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "blue"
			},
			"stats": {
				"FlatHPPoolMod": 1.485
			},
			"tags": ["defense",
			"flat",
			"glyph"],
			"colloq": null,
			"plaintext": null
		},
		"5042": {
			"name": "Lesser Glyph of Scaling Health",
			"description": "+0.3 health per level (+5.4 at champion level 18)",
			"image": {
				"full": "b_4_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 432,
				"y": 0,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "blue"
			},
			"stats": {
				"rFlatHPModPerLevel": 0.3005
			},
			"tags": ["defense",
			"perLevel",
			"glyph"],
			"colloq": null,
			"plaintext": null
		},
		"5043": {
			"name": "Lesser Glyph of Armor",
			"description": "+0.39 armor",
			"image": {
				"full": "b_1_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 288,
				"y": 0,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "blue"
			},
			"stats": {
				"FlatArmorMod": 0.3908
			},
			"tags": ["defense",
			"flat",
			"glyph"],
			"colloq": null,
			"plaintext": null
		},
		"5045": {
			"name": "Lesser Glyph of Magic Resist",
			"description": "+0.74 magic resist",
			"image": {
				"full": "b_3_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 384,
				"y": 0,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "blue"
			},
			"stats": {
				"FlatSpellBlockMod": 0.74
			},
			"tags": ["defense",
			"flat",
			"glyph"],
			"colloq": null,
			"plaintext": null
		},
		"5046": {
			"name": "Lesser Glyph of Scaling Magic Resist",
			"description": "+0.09 magic resist per level (+1.68 at champion level 18)",
			"image": {
				"full": "b_4_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 432,
				"y": 0,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "blue"
			},
			"stats": {
				"rFlatSpellBlockModPerLevel": 0.09333
			},
			"tags": ["defense",
			"perLevel",
			"glyph"],
			"colloq": null,
			"plaintext": null
		},
		"5047": {
			"name": "Lesser Glyph of Health Regeneration",
			"description": "+0.15 health regen / 5 sec.",
			"image": {
				"full": "b_1_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 288,
				"y": 0,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "blue"
			},
			"stats": {
				"FlatHPRegenMod": 0.03
			},
			"tags": ["defense",
			"flat",
			"glyph"],
			"colloq": null,
			"plaintext": null
		},
		"5051": {
			"name": "Lesser Glyph of Cooldown Reduction",
			"description": "-0.47% cooldowns",
			"image": {
				"full": "b_1_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 288,
				"y": 0,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "blue"
			},
			"stats": {
				"rPercentCooldownMod": -0.0047
			},
			"tags": ["utility",
			"percent",
			"glyph"],
			"colloq": null,
			"plaintext": null
		},
		"5052": {
			"name": "Lesser Glyph of Scaling Cooldown Reduction",
			"description": "-0.05% cooldowns per level (-0.93% at champion level 18)",
			"image": {
				"full": "b_2_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 336,
				"y": 0,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "blue"
			},
			"stats": {
				"rPercentCooldownModPerLevel": -0.00051667
			},
			"tags": ["utility",
			"percent",
			"perLevel",
			"glyph"],
			"colloq": null,
			"plaintext": null
		},
		"5053": {
			"name": "Lesser Glyph of Ability Power",
			"description": "+0.66 ability power",
			"image": {
				"full": "b_3_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 384,
				"y": 0,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "blue"
			},
			"stats": {
				"FlatMagicDamageMod": 0.66
			},
			"tags": ["magic",
			"flat",
			"glyph"],
			"colloq": null,
			"plaintext": null
		},
		"5054": {
			"name": "Lesser Glyph of Scaling Ability Power",
			"description": "+0.1 ability power per level (+1.8 at champion level 18)",
			"image": {
				"full": "b_4_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 432,
				"y": 0,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "blue"
			},
			"stats": {
				"rFlatMagicDamageModPerLevel": 0.0962
			},
			"tags": ["magic",
			"perLevel",
			"glyph"],
			"colloq": null,
			"plaintext": null
		},
		"5055": {
			"name": "Lesser Glyph of Mana",
			"description": "+6.25 mana",
			"image": {
				"full": "b_1_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 288,
				"y": 0,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "blue"
			},
			"stats": {
				"FlatMPPoolMod": 6.25
			},
			"tags": ["magic",
			"flat",
			"glyph"],
			"colloq": null,
			"plaintext": null
		},
		"5056": {
			"name": "Lesser Glyph of Scaling Mana",
			"description": "+0.79 mana per level (+14.22 at champion level 18)",
			"image": {
				"full": "b_2_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 336,
				"y": 0,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "blue"
			},
			"stats": {
				"rFlatMPModPerLevel": 0.787
			},
			"tags": ["magic",
			"perLevel",
			"glyph"],
			"colloq": null,
			"plaintext": null
		},
		"5057": {
			"name": "Lesser Glyph of Mana Regeneration",
			"description": "+0.19 mana regen / 5 sec.",
			"image": {
				"full": "b_3_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 384,
				"y": 0,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "blue"
			},
			"stats": {
				"FlatMPRegenMod": 0.038
			},
			"tags": ["magic",
			"flat",
			"glyph"],
			"colloq": null,
			"plaintext": null
		},
		"5058": {
			"name": "Lesser Glyph of Scaling Mana Regeneration",
			"description": "+0.04 mana regen / 5 sec. per level (+0.67 at champion level 18)",
			"image": {
				"full": "b_4_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 432,
				"y": 0,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "blue"
			},
			"stats": {
				"rFlatMPRegenModPerLevel": 0.007444
			},
			"tags": ["magic",
			"perLevel",
			"glyph"],
			"colloq": null,
			"plaintext": null
		},
		"5059": {
			"name": "Lesser Glyph of Magic Penetration",
			"description": "+0.35 magic penetration",
			"image": {
				"full": "b_1_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 288,
				"y": 0,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "blue"
			},
			"stats": {
				"rFlatMagicPenetrationMod": 0.35
			},
			"tags": ["magic",
			"flat",
			"glyph"],
			"colloq": null,
			"plaintext": null
		},
		"5061": {
			"name": "Lesser Seal of Attack Damage",
			"description": "+0.24 attack damage",
			"image": {
				"full": "y_1_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 0,
				"y": 48,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "yellow"
			},
			"stats": {
				"FlatPhysicalDamageMod": 0.2364
			},
			"tags": ["physicalAttack",
			"flat",
			"seal"],
			"colloq": null,
			"plaintext": null
		},
		"5062": {
			"name": "Lesser Seal of Scaling Attack Damage",
			"description": "+0.03 attack damage per level (+0.61 at champion level 18)",
			"image": {
				"full": "y_2_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 48,
				"y": 48,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "yellow"
			},
			"stats": {
				"rFlatPhysicalDamageModPerLevel": 0.0338
			},
			"tags": ["physicalAttack",
			"perLevel",
			"seal"],
			"colloq": null,
			"plaintext": null
		},
		"5063": {
			"name": "Lesser Seal of Attack Speed",
			"description": "+0.42% attack speed",
			"image": {
				"full": "y_3_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 96,
				"y": 48,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "yellow"
			},
			"stats": {
				"PercentAttackSpeedMod": 0.004245
			},
			"tags": ["physicalAttack",
			"percent",
			"seal"],
			"colloq": null,
			"plaintext": null
		},
		"5065": {
			"name": "Lesser Seal of Critical Damage",
			"description": "+0.43% critical damage",
			"image": {
				"full": "y_1_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 0,
				"y": 48,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "yellow"
			},
			"stats": {
				"FlatCritDamageMod": 0.004339
			},
			"tags": ["physicalAttack",
			"percent",
			"seal"],
			"colloq": null,
			"plaintext": null
		},
		"5067": {
			"name": "Lesser Seal of Critical Chance",
			"description": "+0.23% critical chance",
			"image": {
				"full": "y_3_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 96,
				"y": 48,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "yellow"
			},
			"stats": {
				"FlatCritChanceMod": 0.00232
			},
			"tags": ["physicalAttack",
			"percent",
			"seal"],
			"colloq": null,
			"plaintext": null
		},
		"5071": {
			"name": "Lesser Seal of Health",
			"description": "+4.48 health",
			"image": {
				"full": "y_3_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 96,
				"y": 48,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "yellow"
			},
			"stats": {
				"FlatHPPoolMod": 4.48
			},
			"tags": ["defense",
			"flat",
			"seal"],
			"colloq": null,
			"plaintext": null
		},
		"5072": {
			"name": "Lesser Seal of Scaling Health",
			"description": "+0.75 health per level (+13.44 at champion level 18)",
			"image": {
				"full": "y_4_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 144,
				"y": 48,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "yellow"
			},
			"stats": {
				"rFlatHPModPerLevel": 0.74667
			},
			"tags": ["defense",
			"perLevel",
			"seal"],
			"colloq": null,
			"plaintext": null
		},
		"5073": {
			"name": "Lesser Seal of Armor",
			"description": "+0.56 armor",
			"image": {
				"full": "y_1_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 0,
				"y": 48,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "yellow"
			},
			"stats": {
				"FlatArmorMod": 0.56
			},
			"tags": ["defense",
			"flat",
			"seal"],
			"colloq": null,
			"plaintext": null
		},
		"5074": {
			"name": "Lesser Seal of Scaling Armor",
			"description": "+0.09 armor per level (+1.68 at champion level 18)",
			"image": {
				"full": "y_2_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 48,
				"y": 48,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "yellow"
			},
			"stats": {
				"rFlatArmorModPerLevel": 0.09333
			},
			"tags": ["defense",
			"perLevel",
			"seal"],
			"colloq": null,
			"plaintext": null
		},
		"5075": {
			"name": "Lesser Seal of Magic Resist",
			"description": "+0.41 magic resist",
			"image": {
				"full": "y_3_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 96,
				"y": 48,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "yellow"
			},
			"stats": {
				"FlatSpellBlockMod": 0.4125
			},
			"tags": ["defense",
			"flat",
			"seal"],
			"colloq": null,
			"plaintext": null
		},
		"5076": {
			"name": "Lesser Seal of Scaling Magic Resist",
			"description": "+0.05 magic resist per level (+0.9 at champion level 18)",
			"image": {
				"full": "y_4_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 144,
				"y": 48,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "yellow"
			},
			"stats": {
				"rFlatSpellBlockModPerLevel": 0.0536
			},
			"tags": ["defense",
			"perLevel",
			"seal"],
			"colloq": null,
			"plaintext": null
		},
		"5077": {
			"name": "Lesser Seal of Health Regeneration",
			"description": "+0.31 health regen / 5 sec.",
			"image": {
				"full": "y_1_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 0,
				"y": 48,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "yellow"
			},
			"stats": {
				"FlatHPRegenMod": 0.062
			},
			"tags": ["defense",
			"flat",
			"seal"],
			"colloq": null,
			"plaintext": null
		},
		"5078": {
			"name": "Lesser Seal of Scaling Health Regeneration",
			"description": "+0.06 health regen / 5 sec. per level (+1.08 at champion level 18)",
			"image": {
				"full": "y_2_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 48,
				"y": 48,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "yellow"
			},
			"stats": {
				"rFlatHPRegenModPerLevel": 0.0125
			},
			"tags": ["defense",
			"perLevel",
			"seal"],
			"colloq": null,
			"plaintext": null
		},
		"5081": {
			"name": "Lesser Seal of Cooldown Reduction",
			"description": "-0.2% cooldowns",
			"image": {
				"full": "y_1_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 0,
				"y": 48,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "yellow"
			},
			"stats": {
				"rPercentCooldownMod": -0.002
			},
			"tags": ["utility",
			"percent",
			"seal"],
			"colloq": null,
			"plaintext": null
		},
		"5083": {
			"name": "Lesser Seal of Ability Power",
			"description": "+0.33 ability power",
			"image": {
				"full": "y_3_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 96,
				"y": 48,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "yellow"
			},
			"stats": {
				"FlatMagicDamageMod": 0.33
			},
			"tags": ["magic",
			"flat",
			"seal"],
			"colloq": null,
			"plaintext": null
		},
		"5084": {
			"name": "Lesser Seal of Scaling Ability Power",
			"description": "+0.06 ability power per level (+1.08 at champion level 18)",
			"image": {
				"full": "y_4_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 144,
				"y": 48,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "yellow"
			},
			"stats": {
				"rFlatMagicDamageModPerLevel": 0.0577
			},
			"tags": ["magic",
			"perLevel",
			"seal"],
			"colloq": null,
			"plaintext": null
		},
		"5085": {
			"name": "Lesser Seal of Mana",
			"description": "+3.83 mana",
			"image": {
				"full": "y_1_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 0,
				"y": 48,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "yellow"
			},
			"stats": {
				"FlatMPPoolMod": 3.8281
			},
			"tags": ["magic",
			"flat",
			"seal"],
			"colloq": null,
			"plaintext": null
		},
		"5086": {
			"name": "Lesser Seal of Scaling Mana",
			"description": "+0.65 mana per level (+11.7 at champion level 18)",
			"image": {
				"full": "y_2_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 48,
				"y": 48,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "yellow"
			},
			"stats": {
				"rFlatMPModPerLevel": 0.6481
			},
			"tags": ["magic",
			"perLevel",
			"seal"],
			"colloq": null,
			"plaintext": null
		},
		"5087": {
			"name": "Lesser Seal of Mana Regeneration",
			"description": "+0.23 mana regen / 5 sec.",
			"image": {
				"full": "y_3_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 96,
				"y": 48,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "yellow"
			},
			"stats": {
				"FlatMPRegenMod": 0.04514
			},
			"tags": ["magic",
			"flat",
			"seal"],
			"colloq": null,
			"plaintext": null
		},
		"5088": {
			"name": "Lesser Seal of Scaling Mana Regeneration",
			"description": "+0.036 mana regen / 5 sec. per level (+0.65 at champion level 18)",
			"image": {
				"full": "y_4_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 144,
				"y": 48,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "yellow"
			},
			"stats": {
				"rFlatMPRegenModPerLevel": 0.0072
			},
			"tags": ["magic",
			"perLevel",
			"seal"],
			"colloq": null,
			"plaintext": null
		},
		"5091": {
			"name": "Lesser Quintessence of Attack Damage",
			"description": "+1.25 attack damage",
			"image": {
				"full": "bl_1_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 192,
				"y": 48,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "black"
			},
			"stats": {
				"FlatPhysicalDamageMod": 1.25
			},
			"tags": ["physicalAttack",
			"flat",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5092": {
			"name": "Lesser Quintessence of Scaling Attack Damage",
			"description": "+0.14 attack damage per level (+2.52 at champion level 18)",
			"image": {
				"full": "bl_2_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 240,
				"y": 48,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "black"
			},
			"stats": {
				"rFlatPhysicalDamageModPerLevel": 0.1389
			},
			"tags": ["physicalAttack",
			"perLevel",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5093": {
			"name": "Lesser Quintessence of Attack Speed",
			"description": "+2.52% attack speed",
			"image": {
				"full": "bl_3_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 288,
				"y": 48,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "black"
			},
			"stats": {
				"PercentAttackSpeedMod": 0.0252
			},
			"tags": ["physicalAttack",
			"percent",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5095": {
			"name": "Lesser Quintessence of Critical Damage",
			"description": "+2.48% critical damage",
			"image": {
				"full": "bl_1_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 192,
				"y": 48,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "black"
			},
			"stats": {
				"FlatCritDamageMod": 0.024793
			},
			"tags": ["physicalAttack",
			"percent",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5097": {
			"name": "Lesser Quintessence of Critical Chance",
			"description": "+1.03% critical chance",
			"image": {
				"full": "bl_3_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 288,
				"y": 48,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "black"
			},
			"stats": {
				"FlatCritChanceMod": 0.010309
			},
			"tags": ["physicalAttack",
			"percent",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5099": {
			"name": "Lesser Quintessence of Armor Penetration",
			"description": "+1.42 armor penetration",
			"image": {
				"full": "bl_1_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 192,
				"y": 48,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "black"
			},
			"stats": {
				"rFlatArmorPenetrationMod": 1.42
			},
			"tags": ["physicalAttack",
			"flat",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5101": {
			"name": "Lesser Quintessence of Health",
			"description": "+14.5 health",
			"image": {
				"full": "bl_3_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 288,
				"y": 48,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "black"
			},
			"stats": {
				"FlatHPPoolMod": 14.5
			},
			"tags": ["defense",
			"flat",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5102": {
			"name": "Lesser Quintessence of Scaling Health",
			"description": "+1.5 health per level (+27 at champion level 18)",
			"image": {
				"full": "bl_4_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 336,
				"y": 48,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "black"
			},
			"stats": {
				"rFlatHPModPerLevel": 1.5024
			},
			"tags": ["defense",
			"perLevel",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5103": {
			"name": "Lesser Quintessence of Armor",
			"description": "+2.37 armor",
			"image": {
				"full": "bl_1_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 192,
				"y": 48,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "black"
			},
			"stats": {
				"FlatArmorMod": 2.3684
			},
			"tags": ["defense",
			"flat",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5104": {
			"name": "Lesser Quintessence of Scaling Armor",
			"description": "+0.21 armor per level (+3.78 at champion level 18)",
			"image": {
				"full": "bl_2_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 240,
				"y": 48,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "black"
			},
			"stats": {
				"rFlatArmorModPerLevel": 0.2083
			},
			"tags": ["defense",
			"perLevel",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5105": {
			"name": "Lesser Quintessence of Magic Resist",
			"description": "+2.22 magic resist",
			"image": {
				"full": "bl_3_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 288,
				"y": 48,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "black"
			},
			"stats": {
				"FlatSpellBlockMod": 2.22
			},
			"tags": ["defense",
			"flat",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5106": {
			"name": "Lesser Quintessence of Scaling Magic Resist",
			"description": "+0.21 magic resist per level (+3.78 at champion level 18)",
			"image": {
				"full": "bl_4_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 336,
				"y": 48,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "black"
			},
			"stats": {
				"rFlatSpellBlockModPerLevel": 0.2062
			},
			"tags": ["defense",
			"perLevel",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5107": {
			"name": "Lesser Quintessence of Health Regeneration",
			"description": "+1.5 health regen / 5 sec.",
			"image": {
				"full": "bl_1_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 192,
				"y": 48,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "black"
			},
			"stats": {
				"FlatHPRegenMod": 0.3
			},
			"tags": ["defense",
			"flat",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5108": {
			"name": "Lesser Quintessence of Scaling Health Regeneration",
			"description": "+0.16 health regen / 5 sec. per level (+2.88 at champion level 18)",
			"image": {
				"full": "bl_2_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 240,
				"y": 48,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "black"
			},
			"stats": {
				"rFlatHPRegenModPerLevel": 0.03126
			},
			"tags": ["defense",
			"perLevel",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5111": {
			"name": "Lesser Quintessence of Cooldown Reduction",
			"description": "-1.4% cooldowns",
			"image": {
				"full": "bl_1_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 192,
				"y": 48,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "black"
			},
			"stats": {
				"rPercentCooldownMod": -0.014
			},
			"tags": ["utility",
			"percent",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5112": {
			"name": "Lesser Quintessence of Scaling Cooldown Reduction",
			"description": "-0.15% cooldowns per level (-2.8% at champion level 18)",
			"image": {
				"full": "bl_2_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 240,
				"y": 48,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "black"
			},
			"stats": {
				"rPercentCooldownModPerLevel": -0.0015556
			},
			"tags": ["utility",
			"percent",
			"perLevel",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5113": {
			"name": "Lesser Quintessence of Ability Power",
			"description": "+2.75 ability power",
			"image": {
				"full": "bl_3_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 288,
				"y": 48,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "black"
			},
			"stats": {
				"FlatMagicDamageMod": 2.75
			},
			"tags": ["magic",
			"flat",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5114": {
			"name": "Lesser Quintessence of Scaling Ability Power",
			"description": "+0.24 ability power per level (+4.32 at champion level 18)",
			"image": {
				"full": "bl_4_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 336,
				"y": 48,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "black"
			},
			"stats": {
				"rFlatMagicDamageModPerLevel": 0.2404
			},
			"tags": ["magic",
			"perLevel",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5115": {
			"name": "Lesser Quintessence of Mana",
			"description": "+20.83 mana",
			"image": {
				"full": "bl_1_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 192,
				"y": 48,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "black"
			},
			"stats": {
				"FlatMPPoolMod": 20.8333
			},
			"tags": ["magic",
			"flat",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5116": {
			"name": "Lesser Quintessence of Scaling Mana",
			"description": "+2.31 mana per level (+41.58 at champion level 18)",
			"image": {
				"full": "bl_2_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 240,
				"y": 48,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "black"
			},
			"stats": {
				"rFlatMPModPerLevel": 2.3148
			},
			"tags": ["magic",
			"perLevel",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5117": {
			"name": "Lesser Quintessence of Mana Regeneration",
			"description": "+0.69 mana regen / 5 sec.",
			"image": {
				"full": "bl_3_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 288,
				"y": 48,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "black"
			},
			"stats": {
				"FlatMPRegenMod": 0.13888
			},
			"tags": ["magic",
			"flat",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5118": {
			"name": "Lesser Quintessence of Scaling Mana Regeneration",
			"description": "+0.14 mana regen / 5 sec. per level (+2.52 at champion level 18)",
			"image": {
				"full": "bl_4_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 336,
				"y": 48,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "black"
			},
			"stats": {
				"rFlatMPRegenModPerLevel": 0.02712
			},
			"tags": ["magic",
			"perLevel",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5119": {
			"name": "Lesser Quintessence of Magic Penetration",
			"description": "+1.11 magic penetration",
			"image": {
				"full": "bl_1_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 192,
				"y": 48,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "black"
			},
			"stats": {
				"rFlatMagicPenetrationMod": 1.11
			},
			"tags": ["magic",
			"flat",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5121": {
			"name": "Lesser Quintessence of Movement Speed",
			"description": "+0.83% movement speed",
			"image": {
				"full": "bl_3_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 288,
				"y": 48,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "black"
			},
			"stats": {
				"PercentMovementSpeedMod": 0.008333
			},
			"tags": ["utility",
			"percent",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5123": {
			"name": "Mark of Attack Damage",
			"description": "+0.74 attack damage",
			"image": {
				"full": "r_1_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 384,
				"y": 48,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "red"
			},
			"stats": {
				"FlatPhysicalDamageMod": 0.735
			},
			"tags": ["physicalAttack",
			"flat",
			"mark"],
			"colloq": null,
			"plaintext": null
		},
		"5124": {
			"name": "Mark of Scaling Attack Damage",
			"description": "+0.1 attack damage per level (+1.89 at champion level 18)",
			"image": {
				"full": "r_2_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 432,
				"y": 48,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "red"
			},
			"stats": {
				"rFlatPhysicalDamageModPerLevel": 0.105
			},
			"tags": ["physicalAttack",
			"perLevel",
			"mark"],
			"colloq": null,
			"plaintext": null
		},
		"5125": {
			"name": "Mark of Attack Speed",
			"description": "+1.32% attack speed",
			"image": {
				"full": "r_3_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 0,
				"y": 96,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "red"
			},
			"stats": {
				"PercentAttackSpeedMod": 0.013208
			},
			"tags": ["physicalAttack",
			"percent",
			"mark"],
			"colloq": null,
			"plaintext": null
		},
		"5127": {
			"name": "Mark of Critical Damage",
			"description": "+1.74% critical damage",
			"image": {
				"full": "r_1_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 384,
				"y": 48,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "red"
			},
			"stats": {
				"FlatCritDamageMod": 0.017355
			},
			"tags": ["physicalAttack",
			"percent",
			"mark"],
			"colloq": null,
			"plaintext": null
		},
		"5129": {
			"name": "Mark of Critical Chance",
			"description": "+0.72% critical chance",
			"image": {
				"full": "r_3_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 0,
				"y": 96,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "red"
			},
			"stats": {
				"FlatCritChanceMod": 0.007216
			},
			"tags": ["physicalAttack",
			"percent",
			"mark"],
			"colloq": null,
			"plaintext": null
		},
		"5131": {
			"name": "Mark of Armor Penetration",
			"description": "+1 armor penetration",
			"image": {
				"full": "r_1_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 384,
				"y": 48,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "red"
			},
			"stats": {
				"rFlatArmorPenetrationMod": 1.0
			},
			"tags": ["physicalAttack",
			"flat",
			"mark"],
			"colloq": null,
			"plaintext": null
		},
		"5133": {
			"name": "Mark of Health",
			"description": "+2.7 health",
			"image": {
				"full": "r_3_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 0,
				"y": 96,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "red"
			},
			"stats": {
				"FlatHPPoolMod": 2.7027
			},
			"tags": ["defense",
			"flat",
			"mark"],
			"colloq": null,
			"plaintext": null
		},
		"5134": {
			"name": "Mark of Scaling Health",
			"description": "+0.42 health per level (+7.56 at champion level 18)",
			"image": {
				"full": "r_4_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 48,
				"y": 96,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "red"
			},
			"stats": {
				"rFlatHPModPerLevel": 0.4207
			},
			"tags": ["defense",
			"perLevel",
			"mark"],
			"colloq": null,
			"plaintext": null
		},
		"5135": {
			"name": "Mark of Armor",
			"description": "+0.71 armor",
			"image": {
				"full": "r_1_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 384,
				"y": 48,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "red"
			},
			"stats": {
				"FlatArmorMod": 0.7112
			},
			"tags": ["defense",
			"flat",
			"mark"],
			"colloq": null,
			"plaintext": null
		},
		"5137": {
			"name": "Mark of Magic Resist",
			"description": "+0.6 magic resist",
			"image": {
				"full": "r_3_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 0,
				"y": 96,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "red"
			},
			"stats": {
				"FlatSpellBlockMod": 0.6
			},
			"tags": ["defense",
			"flat",
			"mark"],
			"colloq": null,
			"plaintext": null
		},
		"5138": {
			"name": "Mark of Scaling Magic Resist",
			"description": "+0.06 magic resist per level (+1.08 at champion level 18)",
			"image": {
				"full": "r_4_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 48,
				"y": 96,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "red"
			},
			"stats": {
				"rFlatSpellBlockModPerLevel": 0.0577
			},
			"tags": ["defense",
			"perLevel",
			"mark"],
			"colloq": null,
			"plaintext": null
		},
		"5143": {
			"name": "Mark of Cooldown Reduction",
			"description": "-0.16% cooldowns",
			"image": {
				"full": "r_1_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 384,
				"y": 48,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "red"
			},
			"stats": {
				"rPercentCooldownMod": -0.001556
			},
			"tags": ["utility",
			"percent",
			"mark"],
			"colloq": null,
			"plaintext": null
		},
		"5145": {
			"name": "Mark of Ability Power",
			"description": "+0.46 ability power",
			"image": {
				"full": "r_3_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 0,
				"y": 96,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "red"
			},
			"stats": {
				"FlatMagicDamageMod": 0.462
			},
			"tags": ["magic",
			"flat",
			"mark"],
			"colloq": null,
			"plaintext": null
		},
		"5146": {
			"name": "Mark of Scaling Ability Power",
			"description": "+0.08 ability power per level (+1.44 at champion level 18)",
			"image": {
				"full": "r_4_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 48,
				"y": 96,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "red"
			},
			"stats": {
				"rFlatMagicDamageModPerLevel": 0.0808
			},
			"tags": ["magic",
			"perLevel",
			"mark"],
			"colloq": null,
			"plaintext": null
		},
		"5147": {
			"name": "Mark of Mana",
			"description": "+4.59 mana",
			"image": {
				"full": "r_1_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 384,
				"y": 48,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "red"
			},
			"stats": {
				"FlatMPPoolMod": 4.5938
			},
			"tags": ["magic",
			"flat",
			"mark"],
			"colloq": null,
			"plaintext": null
		},
		"5148": {
			"name": "Mark of Scaling Mana",
			"description": "+0.91 mana per level (+16.38 at champion level 18)",
			"image": {
				"full": "r_2_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 432,
				"y": 48,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "red"
			},
			"stats": {
				"rFlatMPModPerLevel": 0.9074
			},
			"tags": ["magic",
			"perLevel",
			"mark"],
			"colloq": null,
			"plaintext": null
		},
		"5149": {
			"name": "Mark of Mana Regeneration",
			"description": "+0.2 mana regen / 5 sec.",
			"image": {
				"full": "r_3_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 0,
				"y": 96,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "red"
			},
			"stats": {
				"FlatMPRegenMod": 0.04084
			},
			"tags": ["magic",
			"flat",
			"mark"],
			"colloq": null,
			"plaintext": null
		},
		"5151": {
			"name": "Mark of Magic Penetration",
			"description": "+0.68 magic penetration",
			"image": {
				"full": "r_1_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 384,
				"y": 48,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "red"
			},
			"stats": {
				"rFlatMagicPenetrationMod": 0.68
			},
			"tags": ["magic",
			"flat",
			"mark"],
			"colloq": null,
			"plaintext": null
		},
		"5153": {
			"name": "Glyph of Attack Damage",
			"description": "+0.22 attack damage",
			"image": {
				"full": "b_1_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 96,
				"y": 96,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "blue"
			},
			"stats": {
				"FlatPhysicalDamageMod": 0.2205
			},
			"tags": ["physicalAttack",
			"flat",
			"glyph"],
			"colloq": null,
			"plaintext": null
		},
		"5154": {
			"name": "Glyph of Scaling Attack Damage",
			"description": "+0.03 attack damage per level (+0.57 at champion level 18)",
			"image": {
				"full": "b_2_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 144,
				"y": 96,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "blue"
			},
			"stats": {
				"rFlatPhysicalDamageModPerLevel": 0.0315
			},
			"tags": ["physicalAttack",
			"perLevel",
			"glyph"],
			"colloq": null,
			"plaintext": null
		},
		"5155": {
			"name": "Glyph of Attack Speed",
			"description": "+0.5% attack speed",
			"image": {
				"full": "b_3_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 192,
				"y": 96,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "blue"
			},
			"stats": {
				"PercentAttackSpeedMod": 0.004953
			},
			"tags": ["physicalAttack",
			"percent",
			"glyph"],
			"colloq": null,
			"plaintext": null
		},
		"5157": {
			"name": "Glyph of Critical Damage",
			"description": "+0.43% critical damage",
			"image": {
				"full": "b_1_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 96,
				"y": 96,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "blue"
			},
			"stats": {
				"FlatCritDamageMod": 0.004339
			},
			"tags": ["physicalAttack",
			"percent",
			"glyph"],
			"colloq": null,
			"plaintext": null
		},
		"5159": {
			"name": "Glyph of Critical Chance",
			"description": "+0.22% critical chance",
			"image": {
				"full": "b_3_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 192,
				"y": 96,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "blue"
			},
			"stats": {
				"FlatCritChanceMod": 0.002165
			},
			"tags": ["physicalAttack",
			"percent",
			"glyph"],
			"colloq": null,
			"plaintext": null
		},
		"5163": {
			"name": "Glyph of Health",
			"description": "+2.08 health",
			"image": {
				"full": "b_3_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 192,
				"y": 96,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "blue"
			},
			"stats": {
				"FlatHPPoolMod": 2.079
			},
			"tags": ["defense",
			"flat",
			"glyph"],
			"colloq": null,
			"plaintext": null
		},
		"5164": {
			"name": "Glyph of Scaling Health",
			"description": "+0.42 health per level (+7.56 at champion level 18)",
			"image": {
				"full": "b_4_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 240,
				"y": 96,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "blue"
			},
			"stats": {
				"rFlatHPModPerLevel": 0.4207
			},
			"tags": ["defense",
			"perLevel",
			"glyph"],
			"colloq": null,
			"plaintext": null
		},
		"5165": {
			"name": "Glyph of Armor",
			"description": "+0.55 armor",
			"image": {
				"full": "b_1_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 96,
				"y": 96,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "blue"
			},
			"stats": {
				"FlatArmorMod": 0.5471
			},
			"tags": ["defense",
			"flat",
			"glyph"],
			"colloq": null,
			"plaintext": null
		},
		"5167": {
			"name": "Glyph of Magic Resist",
			"description": "+1.04 magic resist",
			"image": {
				"full": "b_3_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 192,
				"y": 96,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "blue"
			},
			"stats": {
				"FlatSpellBlockMod": 1.04
			},
			"tags": ["defense",
			"flat",
			"glyph"],
			"colloq": null,
			"plaintext": null
		},
		"5168": {
			"name": "Glyph of Scaling Magic Resist",
			"description": "+0.13 magic resist per level (+2.34 at champion level 18)",
			"image": {
				"full": "b_4_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 240,
				"y": 96,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "blue"
			},
			"stats": {
				"rFlatSpellBlockModPerLevel": 0.13
			},
			"tags": ["defense",
			"perLevel",
			"glyph"],
			"colloq": null,
			"plaintext": null
		},
		"5169": {
			"name": "Glyph of Health Regeneration",
			"description": "+0.21 health regen / 5 sec.",
			"image": {
				"full": "b_1_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 96,
				"y": 96,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "blue"
			},
			"stats": {
				"FlatHPRegenMod": 0.042
			},
			"tags": ["defense",
			"flat",
			"glyph"],
			"colloq": null,
			"plaintext": null
		},
		"5173": {
			"name": "Glyph of Cooldown Reduction",
			"description": "-0.67% cooldowns",
			"image": {
				"full": "b_1_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 96,
				"y": 96,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "blue"
			},
			"stats": {
				"rPercentCooldownMod": -0.00667
			},
			"tags": ["utility",
			"percent",
			"glyph"],
			"colloq": null,
			"plaintext": null
		},
		"5174": {
			"name": "Glyph of Scaling Cooldown Reduction",
			"description": "-0.07% cooldowns per level (-1.3% at champion level 18)",
			"image": {
				"full": "b_2_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 144,
				"y": 96,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "blue"
			},
			"stats": {
				"rPercentCooldownModPerLevel": -0.0007223
			},
			"tags": ["utility",
			"percent",
			"perLevel",
			"glyph"],
			"colloq": null,
			"plaintext": null
		},
		"5175": {
			"name": "Glyph of Ability Power",
			"description": "+0.92 ability power",
			"image": {
				"full": "b_3_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 192,
				"y": 96,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "blue"
			},
			"stats": {
				"FlatMagicDamageMod": 0.92
			},
			"tags": ["magic",
			"flat",
			"glyph"],
			"colloq": null,
			"plaintext": null
		},
		"5176": {
			"name": "Glyph of Scaling Ability Power",
			"description": "+0.13 ability power per level (+2.34 at champion level 18)",
			"image": {
				"full": "b_4_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 240,
				"y": 96,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "blue"
			},
			"stats": {
				"rFlatMagicDamageModPerLevel": 0.1346
			},
			"tags": ["magic",
			"perLevel",
			"glyph"],
			"colloq": null,
			"plaintext": null
		},
		"5177": {
			"name": "Glyph of Mana",
			"description": "+8.75 mana",
			"image": {
				"full": "b_1_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 96,
				"y": 96,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "blue"
			},
			"stats": {
				"FlatMPPoolMod": 8.75
			},
			"tags": ["magic",
			"flat",
			"glyph"],
			"colloq": null,
			"plaintext": null
		},
		"5178": {
			"name": "Glyph of Scaling Mana",
			"description": "+1.1 mana per level (+19.8 at champion level 18)",
			"image": {
				"full": "b_2_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 144,
				"y": 96,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "blue"
			},
			"stats": {
				"rFlatMPModPerLevel": 1.1019
			},
			"tags": ["magic",
			"perLevel",
			"glyph"],
			"colloq": null,
			"plaintext": null
		},
		"5179": {
			"name": "Glyph of Mana Regeneration",
			"description": "+0.26 mana regen / 5 sec.",
			"image": {
				"full": "b_3_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 192,
				"y": 96,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "blue"
			},
			"stats": {
				"FlatMPRegenMod": 0.052
			},
			"tags": ["magic",
			"flat",
			"glyph"],
			"colloq": null,
			"plaintext": null
		},
		"5180": {
			"name": "Glyph of Scaling Mana Regeneration",
			"description": "+0.05 mana regen / 5 sec. per level (+0.94 at champion level 18)",
			"image": {
				"full": "b_4_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 240,
				"y": 96,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "blue"
			},
			"stats": {
				"rFlatMPRegenModPerLevel": 0.01044
			},
			"tags": ["magic",
			"perLevel",
			"glyph"],
			"colloq": null,
			"plaintext": null
		},
		"5181": {
			"name": "Glyph of Magic Penetration",
			"description": "+0.49 magic penetration",
			"image": {
				"full": "b_1_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 96,
				"y": 96,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "blue"
			},
			"stats": {
				"rFlatMagicPenetrationMod": 0.49
			},
			"tags": ["magic",
			"flat",
			"glyph"],
			"colloq": null,
			"plaintext": null
		},
		"5183": {
			"name": "Seal of Attack Damage",
			"description": "+0.33 attack damage",
			"image": {
				"full": "y_1_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 288,
				"y": 96,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "yellow"
			},
			"stats": {
				"FlatPhysicalDamageMod": 0.3309
			},
			"tags": ["physicalAttack",
			"flat",
			"seal"],
			"colloq": null,
			"plaintext": null
		},
		"5184": {
			"name": "Seal of Scaling Attack Damage",
			"description": "+0.05 attack damage per level (+0.85 at champion level 18)",
			"image": {
				"full": "y_2_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 336,
				"y": 96,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "yellow"
			},
			"stats": {
				"rFlatPhysicalDamageModPerLevel": 0.0473
			},
			"tags": ["physicalAttack",
			"perLevel",
			"seal"],
			"colloq": null,
			"plaintext": null
		},
		"5185": {
			"name": "Seal of Attack Speed",
			"description": "+0.59% attack speed",
			"image": {
				"full": "y_3_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 384,
				"y": 96,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "yellow"
			},
			"stats": {
				"PercentAttackSpeedMod": 0.005943
			},
			"tags": ["physicalAttack",
			"percent",
			"seal"],
			"colloq": null,
			"plaintext": null
		},
		"5187": {
			"name": "Seal of Critical Damage",
			"description": "+0.61% critical damage",
			"image": {
				"full": "y_1_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 288,
				"y": 96,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "yellow"
			},
			"stats": {
				"FlatCritDamageMod": 0.006074
			},
			"tags": ["physicalAttack",
			"percent",
			"seal"],
			"colloq": null,
			"plaintext": null
		},
		"5189": {
			"name": "Seal of Critical Chance",
			"description": "+0.32% critical chance",
			"image": {
				"full": "y_3_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 384,
				"y": 96,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "yellow"
			},
			"stats": {
				"FlatCritChanceMod": 0.003247
			},
			"tags": ["physicalAttack",
			"percent",
			"seal"],
			"colloq": null,
			"plaintext": null
		},
		"5193": {
			"name": "Seal of Health",
			"description": "+6.24 health",
			"image": {
				"full": "y_3_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 384,
				"y": 96,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "yellow"
			},
			"stats": {
				"FlatHPPoolMod": 6.24
			},
			"tags": ["defense",
			"flat",
			"seal"],
			"colloq": null,
			"plaintext": null
		},
		"5194": {
			"name": "Seal of Scaling Health",
			"description": "+1.04 health per level (+18.72 at champion level 18)",
			"image": {
				"full": "y_4_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 432,
				"y": 96,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "yellow"
			},
			"stats": {
				"rFlatHPModPerLevel": 1.04
			},
			"tags": ["defense",
			"perLevel",
			"seal"],
			"colloq": null,
			"plaintext": null
		},
		"5195": {
			"name": "Seal of Armor",
			"description": "+0.78 armor",
			"image": {
				"full": "y_1_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 288,
				"y": 96,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "yellow"
			},
			"stats": {
				"FlatArmorMod": 0.78
			},
			"tags": ["defense",
			"flat",
			"seal"],
			"colloq": null,
			"plaintext": null
		},
		"5196": {
			"name": "Seal of Scaling Armor",
			"description": "+0.13 armor per level (+2.34 at champion level 18)",
			"image": {
				"full": "y_2_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 336,
				"y": 96,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "yellow"
			},
			"stats": {
				"rFlatArmorModPerLevel": 0.13
			},
			"tags": ["defense",
			"perLevel",
			"seal"],
			"colloq": null,
			"plaintext": null
		},
		"5197": {
			"name": "Seal of Magic Resist",
			"description": "+0.58 magic resist",
			"image": {
				"full": "y_3_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 384,
				"y": 96,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "yellow"
			},
			"stats": {
				"FlatSpellBlockMod": 0.5775
			},
			"tags": ["defense",
			"flat",
			"seal"],
			"colloq": null,
			"plaintext": null
		},
		"5198": {
			"name": "Seal of Scaling Magic Resist",
			"description": "+0.08 magic resist per level (+1.44 at champion level 18)",
			"image": {
				"full": "y_4_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 432,
				"y": 96,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "yellow"
			},
			"stats": {
				"rFlatSpellBlockModPerLevel": 0.075
			},
			"tags": ["defense",
			"perLevel",
			"seal"],
			"colloq": null,
			"plaintext": null
		},
		"5199": {
			"name": "Seal of Health Regeneration",
			"description": "+0.43 health regen / 5 sec.",
			"image": {
				"full": "y_1_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 288,
				"y": 96,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "yellow"
			},
			"stats": {
				"FlatHPRegenMod": 0.086
			},
			"tags": ["defense",
			"flat",
			"seal"],
			"colloq": null,
			"plaintext": null
		},
		"5200": {
			"name": "Seal of Scaling Health Regeneration",
			"description": "+0.09 health regen / 5 sec. per level (+1.62 at champion level 18)",
			"image": {
				"full": "y_2_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 336,
				"y": 96,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "yellow"
			},
			"stats": {
				"rFlatHPRegenModPerLevel": 0.0175
			},
			"tags": ["defense",
			"perLevel",
			"seal"],
			"colloq": null,
			"plaintext": null
		},
		"5203": {
			"name": "Seal of Cooldown Reduction",
			"description": "-0.29% cooldowns",
			"image": {
				"full": "y_1_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 288,
				"y": 96,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "yellow"
			},
			"stats": {
				"rPercentCooldownMod": -0.002889
			},
			"tags": ["utility",
			"percent",
			"seal"],
			"colloq": null,
			"plaintext": null
		},
		"5205": {
			"name": "Seal of Ability Power",
			"description": "+0.46 ability power",
			"image": {
				"full": "y_3_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 384,
				"y": 96,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "yellow"
			},
			"stats": {
				"FlatMagicDamageMod": 0.462
			},
			"tags": ["magic",
			"flat",
			"seal"],
			"colloq": null,
			"plaintext": null
		},
		"5206": {
			"name": "Seal of Scaling Ability Power",
			"description": "+0.08 ability power per level (+1.44 at champion level 18)",
			"image": {
				"full": "y_4_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 432,
				"y": 96,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "yellow"
			},
			"stats": {
				"rFlatMagicDamageModPerLevel": 0.0808
			},
			"tags": ["magic",
			"perLevel",
			"seal"],
			"colloq": null,
			"plaintext": null
		},
		"5207": {
			"name": "Seal of Mana",
			"description": "+5.36 mana",
			"image": {
				"full": "y_1_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 288,
				"y": 96,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "yellow"
			},
			"stats": {
				"FlatMPPoolMod": 5.3594
			},
			"tags": ["magic",
			"flat",
			"seal"],
			"colloq": null,
			"plaintext": null
		},
		"5208": {
			"name": "Seal of Scaling Mana",
			"description": "+0.91 mana per level (+16.38 at champion level 18)",
			"image": {
				"full": "y_2_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 336,
				"y": 96,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "yellow"
			},
			"stats": {
				"rFlatMPModPerLevel": 0.9074
			},
			"tags": ["magic",
			"perLevel",
			"seal"],
			"colloq": null,
			"plaintext": null
		},
		"5209": {
			"name": "Seal of Mana Regeneration",
			"description": "+0.32 mana regen / 5 sec.",
			"image": {
				"full": "y_3_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 384,
				"y": 96,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "yellow"
			},
			"stats": {
				"FlatMPRegenMod": 0.0632
			},
			"tags": ["magic",
			"flat",
			"seal"],
			"colloq": null,
			"plaintext": null
		},
		"5210": {
			"name": "Seal of Scaling Mana Regeneration",
			"description": "+0.05 mana regen / 5 sec. per level (+0.9 at champion level 18)",
			"image": {
				"full": "y_4_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 432,
				"y": 96,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "yellow"
			},
			"stats": {
				"rFlatMPRegenModPerLevel": 0.01
			},
			"tags": ["magic",
			"perLevel",
			"seal"],
			"colloq": null,
			"plaintext": null
		},
		"5213": {
			"name": "Quintessence of Attack Damage",
			"description": "+1.75 attack damage",
			"image": {
				"full": "bl_1_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 0,
				"y": 144,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "black"
			},
			"stats": {
				"FlatPhysicalDamageMod": 1.75
			},
			"tags": ["physicalAttack",
			"flat",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5214": {
			"name": "Quintessence of Scaling Attack Damage",
			"description": "+0.19 attack damage per level (+3.42 at champion level 18)",
			"image": {
				"full": "bl_2_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 48,
				"y": 144,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "black"
			},
			"stats": {
				"rFlatPhysicalDamageModPerLevel": 0.1944
			},
			"tags": ["physicalAttack",
			"perLevel",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5215": {
			"name": "Quintessence of Attack Speed",
			"description": "+3.51% attack speed",
			"image": {
				"full": "bl_3_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 96,
				"y": 144,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "black"
			},
			"stats": {
				"PercentAttackSpeedMod": 0.0351
			},
			"tags": ["physicalAttack",
			"percent",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5217": {
			"name": "Quintessence of Critical Damage",
			"description": "+3.47% critical damage",
			"image": {
				"full": "bl_1_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 0,
				"y": 144,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "black"
			},
			"stats": {
				"FlatCritDamageMod": 0.034711
			},
			"tags": ["physicalAttack",
			"percent",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5219": {
			"name": "Quintessence of Critical Chance",
			"description": "+1.44% critical chance",
			"image": {
				"full": "bl_3_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 96,
				"y": 144,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "black"
			},
			"stats": {
				"FlatCritChanceMod": 0.014433
			},
			"tags": ["physicalAttack",
			"percent",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5221": {
			"name": "Quintessence of Armor Penetration",
			"description": "+1.99 armor penetration",
			"image": {
				"full": "bl_1_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 0,
				"y": 144,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "black"
			},
			"stats": {
				"rFlatArmorPenetrationMod": 1.99
			},
			"tags": ["physicalAttack",
			"flat",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5223": {
			"name": "Quintessence of Health",
			"description": "+20 health",
			"image": {
				"full": "bl_3_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 96,
				"y": 144,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "black"
			},
			"stats": {
				"FlatHPPoolMod": 20.0
			},
			"tags": ["defense",
			"flat",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5224": {
			"name": "Quintessence of Scaling Health",
			"description": "+2.1 health per level (+37.8 at champion level 18)",
			"image": {
				"full": "bl_4_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 144,
				"y": 144,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "black"
			},
			"stats": {
				"rFlatHPModPerLevel": 2.1034
			},
			"tags": ["defense",
			"perLevel",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5225": {
			"name": "Quintessence of Armor",
			"description": "+3.32 armor",
			"image": {
				"full": "bl_1_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 0,
				"y": 144,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "black"
			},
			"stats": {
				"FlatArmorMod": 3.3158
			},
			"tags": ["defense",
			"flat",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5226": {
			"name": "Quintessence of Scaling Armor",
			"description": "+0.29 armor per level (+5.22 at champion level 18)",
			"image": {
				"full": "bl_2_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 48,
				"y": 144,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "black"
			},
			"stats": {
				"rFlatArmorModPerLevel": 0.2917
			},
			"tags": ["defense",
			"perLevel",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5227": {
			"name": "Quintessence of Magic Resist",
			"description": "+3.11 magic resist",
			"image": {
				"full": "bl_3_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 96,
				"y": 144,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "black"
			},
			"stats": {
				"FlatSpellBlockMod": 3.11
			},
			"tags": ["defense",
			"flat",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5228": {
			"name": "Quintessence of Scaling Magic Resist",
			"description": "+0.29 magic resist per level (+5.22 at champion level 18)",
			"image": {
				"full": "bl_4_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 144,
				"y": 144,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "black"
			},
			"stats": {
				"rFlatSpellBlockModPerLevel": 0.2886
			},
			"tags": ["defense",
			"perLevel",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5229": {
			"name": "Quintessence of Health Regeneration",
			"description": "+2.1 health regen / 5 sec.",
			"image": {
				"full": "bl_1_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 0,
				"y": 144,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "black"
			},
			"stats": {
				"FlatHPRegenMod": 0.42
			},
			"tags": ["defense",
			"flat",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5230": {
			"name": "Quintessence of Scaling Health Regeneration",
			"description": "+0.22 health regen / 5 sec. per level (+3.96 at champion level 18)",
			"image": {
				"full": "bl_2_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 48,
				"y": 144,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "black"
			},
			"stats": {
				"rFlatHPRegenModPerLevel": 0.04376
			},
			"tags": ["defense",
			"perLevel",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5233": {
			"name": "Quintessence of Cooldown Reduction",
			"description": "-1.95% cooldowns",
			"image": {
				"full": "bl_1_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 0,
				"y": 144,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "black"
			},
			"stats": {
				"rPercentCooldownMod": -0.0195
			},
			"tags": ["utility",
			"percent",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5234": {
			"name": "Quintessence of Scaling Cooldown Reduction",
			"description": "-0.21% cooldowns per level (-3.9% at champion level 18)",
			"image": {
				"full": "bl_2_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 48,
				"y": 144,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "black"
			},
			"stats": {
				"rPercentCooldownModPerLevel": -0.002167
			},
			"tags": ["utility",
			"percent",
			"perLevel",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5235": {
			"name": "Quintessence of Ability Power",
			"description": "+3.85 ability power",
			"image": {
				"full": "bl_3_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 96,
				"y": 144,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "black"
			},
			"stats": {
				"FlatMagicDamageMod": 3.85
			},
			"tags": ["magic",
			"flat",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5236": {
			"name": "Quintessence of Scaling Ability Power",
			"description": "+0.34 ability power per level (+6.12 at champion level 18)",
			"image": {
				"full": "bl_4_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 144,
				"y": 144,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "black"
			},
			"stats": {
				"rFlatMagicDamageModPerLevel": 0.3365
			},
			"tags": ["magic",
			"perLevel",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5237": {
			"name": "Quintessence of Mana",
			"description": "+29.17 mana",
			"image": {
				"full": "bl_1_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 0,
				"y": 144,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "black"
			},
			"stats": {
				"FlatMPPoolMod": 29.1667
			},
			"tags": ["magic",
			"flat",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5238": {
			"name": "Quintessence of Scaling Mana",
			"description": "+3.24 mana per level (+58.32 at champion level 18)",
			"image": {
				"full": "bl_2_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 48,
				"y": 144,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "black"
			},
			"stats": {
				"rFlatMPModPerLevel": 3.2407
			},
			"tags": ["magic",
			"perLevel",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5239": {
			"name": "Quintessence of Mana Regeneration",
			"description": "+0.97 mana regen / 5 sec.",
			"image": {
				"full": "bl_3_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 96,
				"y": 144,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "black"
			},
			"stats": {
				"FlatMPRegenMod": 0.19444
			},
			"tags": ["magic",
			"flat",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5240": {
			"name": "Quintessence of Scaling Mana Regeneration",
			"description": "+0.19 mana regen / 5 sec. per level (+3.42 at champion level 18)",
			"image": {
				"full": "bl_4_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 144,
				"y": 144,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "black"
			},
			"stats": {
				"rFlatMPRegenModPerLevel": 0.03798
			},
			"tags": ["magic",
			"perLevel",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5241": {
			"name": "Quintessence of Magic Penetration",
			"description": "+1.56 magic penetration",
			"image": {
				"full": "bl_1_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 0,
				"y": 144,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "black"
			},
			"stats": {
				"rFlatMagicPenetrationMod": 1.56
			},
			"tags": ["magic",
			"flat",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5243": {
			"name": "Quintessence of Movement Speed",
			"description": "+1.17% movement speed",
			"image": {
				"full": "bl_3_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 96,
				"y": 144,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "black"
			},
			"stats": {
				"PercentMovementSpeedMod": 0.011667
			},
			"tags": ["utility",
			"percent",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5245": {
			"name": "Greater Mark of Attack Damage",
			"description": "+0.95 attack damage",
			"image": {
				"full": "r_1_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 192,
				"y": 144,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "red"
			},
			"stats": {
				"FlatPhysicalDamageMod": 0.945
			},
			"tags": ["physicalAttack",
			"flat",
			"mark"],
			"colloq": null,
			"plaintext": null
		},
		"5246": {
			"name": "Greater Mark of Scaling Attack Damage",
			"description": "+0.13 attack damage per level (+2.43 at champion level 18)",
			"image": {
				"full": "r_2_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 240,
				"y": 144,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "red"
			},
			"stats": {
				"rFlatPhysicalDamageModPerLevel": 0.135
			},
			"tags": ["physicalAttack",
			"perLevel",
			"mark"],
			"colloq": null,
			"plaintext": null
		},
		"5247": {
			"name": "Greater Mark of Attack Speed",
			"description": "+1.7% attack speed",
			"image": {
				"full": "r_3_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 288,
				"y": 144,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "red"
			},
			"stats": {
				"PercentAttackSpeedMod": 0.016981
			},
			"tags": ["physicalAttack",
			"percent",
			"mark"],
			"colloq": null,
			"plaintext": null
		},
		"5249": {
			"name": "Greater Mark of Critical Damage",
			"description": "+2.23% critical damage",
			"image": {
				"full": "r_1_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 192,
				"y": 144,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "red"
			},
			"stats": {
				"FlatCritDamageMod": 0.022314
			},
			"tags": ["physicalAttack",
			"percent",
			"mark"],
			"colloq": null,
			"plaintext": null
		},
		"5251": {
			"name": "Greater Mark of Critical Chance",
			"description": "+0.93% critical chance",
			"image": {
				"full": "r_3_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 288,
				"y": 144,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "red"
			},
			"stats": {
				"FlatCritChanceMod": 0.009278
			},
			"tags": ["physicalAttack",
			"percent",
			"mark"],
			"colloq": null,
			"plaintext": null
		},
		"5253": {
			"name": "Greater Mark of Armor Penetration",
			"description": "+1.28 armor penetration",
			"image": {
				"full": "r_1_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 192,
				"y": 144,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "red"
			},
			"stats": {
				"rFlatArmorPenetrationMod": 1.28
			},
			"tags": ["physicalAttack",
			"flat",
			"mark"],
			"colloq": null,
			"plaintext": null
		},
		"5255": {
			"name": "Greater Mark of Health",
			"description": "+3.47 health",
			"image": {
				"full": "r_3_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 288,
				"y": 144,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "red"
			},
			"stats": {
				"FlatHPPoolMod": 3.4749
			},
			"tags": ["defense",
			"flat",
			"mark"],
			"colloq": null,
			"plaintext": null
		},
		"5256": {
			"name": "Greater Mark of Scaling Health",
			"description": "+0.54 health per level (+9.72 at champion level 18)",
			"image": {
				"full": "r_4_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 336,
				"y": 144,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "red"
			},
			"stats": {
				"rFlatHPModPerLevel": 0.5409
			},
			"tags": ["defense",
			"perLevel",
			"mark"],
			"colloq": null,
			"plaintext": null
		},
		"5257": {
			"name": "Greater Mark of Armor",
			"description": "+0.91 armor",
			"image": {
				"full": "r_1_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 192,
				"y": 144,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "red"
			},
			"stats": {
				"FlatArmorMod": 0.9144
			},
			"tags": ["defense",
			"flat",
			"mark"],
			"colloq": null,
			"plaintext": null
		},
		"5259": {
			"name": "Greater Mark of Magic Resist",
			"description": "+0.77 magic resist",
			"image": {
				"full": "r_3_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 288,
				"y": 144,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "red"
			},
			"stats": {
				"FlatSpellBlockMod": 0.77
			},
			"tags": ["defense",
			"flat",
			"mark"],
			"colloq": null,
			"plaintext": null
		},
		"5260": {
			"name": "Greater Mark of Scaling Magic Resist",
			"description": "+0.07 magic resist per level (+1.26 at champion level 18)",
			"image": {
				"full": "r_4_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 336,
				"y": 144,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "red"
			},
			"stats": {
				"rFlatSpellBlockModPerLevel": 0.0742
			},
			"tags": ["defense",
			"perLevel",
			"mark"],
			"colloq": null,
			"plaintext": null
		},
		"5265": {
			"name": "Greater Mark of Cooldown Reduction",
			"description": "-0.2% cooldowns",
			"image": {
				"full": "r_1_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 192,
				"y": 144,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "red"
			},
			"stats": {
				"rPercentCooldownMod": -0.002
			},
			"tags": ["utility",
			"percent",
			"mark"],
			"colloq": null,
			"plaintext": null
		},
		"5267": {
			"name": "Greater Mark of Ability Power",
			"description": "+0.59 ability power",
			"image": {
				"full": "r_3_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 288,
				"y": 144,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "red"
			},
			"stats": {
				"FlatMagicDamageMod": 0.594
			},
			"tags": ["magic",
			"flat",
			"mark"],
			"colloq": null,
			"plaintext": null
		},
		"5268": {
			"name": "Greater Mark of Scaling Ability Power",
			"description": "+0.1 ability power per level (+1.8 at champion level 18)",
			"image": {
				"full": "r_4_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 336,
				"y": 144,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "red"
			},
			"stats": {
				"rFlatMagicDamageModPerLevel": 0.1038
			},
			"tags": ["magic",
			"perLevel",
			"mark"],
			"colloq": null,
			"plaintext": null
		},
		"5269": {
			"name": "Greater Mark of Mana",
			"description": "+5.91 mana",
			"image": {
				"full": "r_1_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 192,
				"y": 144,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "red"
			},
			"stats": {
				"FlatMPPoolMod": 5.9063
			},
			"tags": ["magic",
			"flat",
			"mark"],
			"colloq": null,
			"plaintext": null
		},
		"5270": {
			"name": "Greater Mark of Scaling Mana",
			"description": "+1.17 mana per level (+21.06 at champion level 18)",
			"image": {
				"full": "r_2_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 240,
				"y": 144,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "red"
			},
			"stats": {
				"rFlatMPModPerLevel": 1.1667
			},
			"tags": ["magic",
			"perLevel",
			"mark"],
			"colloq": null,
			"plaintext": null
		},
		"5271": {
			"name": "Greater Mark of Mana Regeneration",
			"description": "+0.26 mana regen / 5 sec.",
			"image": {
				"full": "r_3_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 288,
				"y": 144,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "red"
			},
			"stats": {
				"FlatMPRegenMod": 0.0525
			},
			"tags": ["magic",
			"flat",
			"mark"],
			"colloq": null,
			"plaintext": null
		},
		"5273": {
			"name": "Greater Mark of Magic Penetration",
			"description": "+0.87 magic penetration",
			"image": {
				"full": "r_1_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 192,
				"y": 144,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "red"
			},
			"stats": {
				"rFlatMagicPenetrationMod": 0.87
			},
			"tags": ["magic",
			"flat",
			"mark"],
			"colloq": null,
			"plaintext": null
		},
		"5275": {
			"name": "Greater Glyph of Attack Damage",
			"description": "+0.28 attack damage",
			"image": {
				"full": "b_1_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 384,
				"y": 144,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "blue"
			},
			"stats": {
				"FlatPhysicalDamageMod": 0.2835
			},
			"tags": ["physicalAttack",
			"flat",
			"glyph"],
			"colloq": null,
			"plaintext": null
		},
		"5276": {
			"name": "Greater Glyph of Scaling Attack Damage",
			"description": "+0.04 attack damage per level (+0.73 at champion level 18)",
			"image": {
				"full": "b_2_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 432,
				"y": 144,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "blue"
			},
			"stats": {
				"rFlatPhysicalDamageModPerLevel": 0.0405
			},
			"tags": ["physicalAttack",
			"perLevel",
			"glyph"],
			"colloq": null,
			"plaintext": null
		},
		"5277": {
			"name": "Greater Glyph of Attack Speed",
			"description": "+0.64% attack speed",
			"image": {
				"full": "b_3_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 0,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "blue"
			},
			"stats": {
				"PercentAttackSpeedMod": 0.006368
			},
			"tags": ["physicalAttack",
			"percent",
			"glyph"],
			"colloq": null,
			"plaintext": null
		},
		"5279": {
			"name": "Greater Glyph of Critical Damage",
			"description": "+0.56% critical damage",
			"image": {
				"full": "b_1_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 384,
				"y": 144,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "blue"
			},
			"stats": {
				"FlatCritDamageMod": 0.005579
			},
			"tags": ["physicalAttack",
			"percent",
			"glyph"],
			"colloq": null,
			"plaintext": null
		},
		"5281": {
			"name": "Greater Glyph of Critical Chance",
			"description": "+0.28% critical chance",
			"image": {
				"full": "b_3_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 0,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "blue"
			},
			"stats": {
				"FlatCritChanceMod": 0.002784
			},
			"tags": ["physicalAttack",
			"percent",
			"glyph"],
			"colloq": null,
			"plaintext": null
		},
		"5285": {
			"name": "Greater Glyph of Health",
			"description": "+2.67 health",
			"image": {
				"full": "b_3_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 0,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "blue"
			},
			"stats": {
				"FlatHPPoolMod": 2.673
			},
			"tags": ["defense",
			"flat",
			"glyph"],
			"colloq": null,
			"plaintext": null
		},
		"5286": {
			"name": "Greater Glyph of Scaling Health",
			"description": "+0.54 health per level (+9.72 at champion level 18)",
			"image": {
				"full": "b_4_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 48,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "blue"
			},
			"stats": {
				"rFlatHPModPerLevel": 0.5409
			},
			"tags": ["defense",
			"perLevel",
			"glyph"],
			"colloq": null,
			"plaintext": null
		},
		"5287": {
			"name": "Greater Glyph of Armor",
			"description": "+0.7 armor",
			"image": {
				"full": "b_1_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 384,
				"y": 144,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "blue"
			},
			"stats": {
				"FlatArmorMod": 0.7034
			},
			"tags": ["defense",
			"flat",
			"glyph"],
			"colloq": null,
			"plaintext": null
		},
		"5289": {
			"name": "Greater Glyph of Magic Resist",
			"description": "+1.34 magic resist",
			"image": {
				"full": "b_3_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 0,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "blue"
			},
			"stats": {
				"FlatSpellBlockMod": 1.34
			},
			"tags": ["defense",
			"flat",
			"glyph"],
			"colloq": null,
			"plaintext": null
		},
		"5290": {
			"name": "Greater Glyph of Scaling Magic Resist",
			"description": "+0.16 magic resist per level (+3 at champion level 18)",
			"image": {
				"full": "b_4_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 48,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "blue"
			},
			"stats": {
				"rFlatSpellBlockModPerLevel": 0.16667
			},
			"tags": ["defense",
			"perLevel",
			"glyph"],
			"colloq": null,
			"plaintext": null
		},
		"5291": {
			"name": "Greater Glyph of Health Regeneration",
			"description": "+0.27 health regen / 5 sec.",
			"image": {
				"full": "b_1_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 384,
				"y": 144,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "blue"
			},
			"stats": {
				"FlatHPRegenMod": 0.054
			},
			"tags": ["defense",
			"flat",
			"glyph"],
			"colloq": null,
			"plaintext": null
		},
		"5295": {
			"name": "Greater Glyph of Cooldown Reduction",
			"description": "-0.83% cooldowns",
			"image": {
				"full": "b_1_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 384,
				"y": 144,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "blue"
			},
			"stats": {
				"rPercentCooldownMod": -0.008334
			},
			"tags": ["utility",
			"percent",
			"glyph"],
			"colloq": null,
			"plaintext": null
		},
		"5296": {
			"name": "Greater Glyph of Scaling Cooldown Reduction",
			"description": "-0.09% cooldowns per level (-1.67% at champion level 18)",
			"image": {
				"full": "b_2_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 432,
				"y": 144,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "blue"
			},
			"stats": {
				"rPercentCooldownModPerLevel": -0.0009278
			},
			"tags": ["utility",
			"percent",
			"perLevel",
			"glyph"],
			"colloq": null,
			"plaintext": null
		},
		"5297": {
			"name": "Greater Glyph of Ability Power",
			"description": "+1.19 ability power",
			"image": {
				"full": "b_3_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 0,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "blue"
			},
			"stats": {
				"FlatMagicDamageMod": 1.19
			},
			"tags": ["magic",
			"flat",
			"glyph"],
			"colloq": null,
			"plaintext": null
		},
		"5298": {
			"name": "Greater Glyph of Scaling Ability Power",
			"description": "+0.17 ability power per level (+3.06 at champion level 18)",
			"image": {
				"full": "b_4_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 48,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "blue"
			},
			"stats": {
				"rFlatMagicDamageModPerLevel": 0.1731
			},
			"tags": ["magic",
			"perLevel",
			"glyph"],
			"colloq": null,
			"plaintext": null
		},
		"5299": {
			"name": "Greater Glyph of Mana",
			"description": "+11.25 mana",
			"image": {
				"full": "b_1_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 384,
				"y": 144,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "blue"
			},
			"stats": {
				"FlatMPPoolMod": 11.25
			},
			"tags": ["magic",
			"flat",
			"glyph"],
			"colloq": null,
			"plaintext": null
		},
		"5300": {
			"name": "Greater Glyph of Scaling Mana",
			"description": "+1.42 mana per level (+25.56 at champion level 18)",
			"image": {
				"full": "b_2_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 432,
				"y": 144,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "blue"
			},
			"stats": {
				"rFlatMPModPerLevel": 1.4167
			},
			"tags": ["magic",
			"perLevel",
			"glyph"],
			"colloq": null,
			"plaintext": null
		},
		"5301": {
			"name": "Greater Glyph of Mana Regeneration",
			"description": "+0.33 mana regen / 5 sec.",
			"image": {
				"full": "b_3_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 0,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "blue"
			},
			"stats": {
				"FlatMPRegenMod": 0.066
			},
			"tags": ["magic",
			"flat",
			"glyph"],
			"colloq": null,
			"plaintext": null
		},
		"5302": {
			"name": "Greater Glyph of Scaling Mana Regeneration",
			"description": "+0.06 mana regen / 5 sec. per level (+1.2 at champion level 18)",
			"image": {
				"full": "b_4_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 48,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "blue"
			},
			"stats": {
				"rFlatMPRegenModPerLevel": 0.01334
			},
			"tags": ["magic",
			"perLevel",
			"glyph"],
			"colloq": null,
			"plaintext": null
		},
		"5303": {
			"name": "Greater Glyph of Magic Penetration",
			"description": "+0.63 magic penetration",
			"image": {
				"full": "b_1_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 384,
				"y": 144,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "blue"
			},
			"stats": {
				"rFlatMagicPenetrationMod": 0.63
			},
			"tags": ["magic",
			"flat",
			"glyph"],
			"colloq": null,
			"plaintext": null
		},
		"5305": {
			"name": "Greater Seal of Attack Damage",
			"description": "+0.43 attack damage",
			"image": {
				"full": "y_1_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 96,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "yellow"
			},
			"stats": {
				"FlatPhysicalDamageMod": 0.4254
			},
			"tags": ["physicalAttack",
			"flat",
			"seal"],
			"colloq": null,
			"plaintext": null
		},
		"5306": {
			"name": "Greater Seal of Scaling Attack Damage",
			"description": "+0.06 attack damage per level (+1.09 at champion level 18)",
			"image": {
				"full": "y_2_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 144,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "yellow"
			},
			"stats": {
				"rFlatPhysicalDamageModPerLevel": 0.0608
			},
			"tags": ["physicalAttack",
			"perLevel",
			"seal"],
			"colloq": null,
			"plaintext": null
		},
		"5307": {
			"name": "Greater Seal of Attack Speed",
			"description": "+0.76% attack speed",
			"image": {
				"full": "y_3_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 192,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "yellow"
			},
			"stats": {
				"PercentAttackSpeedMod": 0.007642
			},
			"tags": ["physicalAttack",
			"percent",
			"seal"],
			"colloq": null,
			"plaintext": null
		},
		"5309": {
			"name": "Greater Seal of Critical Damage",
			"description": "+0.78% critical damage",
			"image": {
				"full": "y_1_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 96,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "yellow"
			},
			"stats": {
				"FlatCritDamageMod": 0.00781
			},
			"tags": ["physicalAttack",
			"percent",
			"seal"],
			"colloq": null,
			"plaintext": null
		},
		"5311": {
			"name": "Greater Seal of Critical Chance",
			"description": "+0.42% critical chance",
			"image": {
				"full": "y_3_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 192,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "yellow"
			},
			"stats": {
				"FlatCritChanceMod": 0.004175
			},
			"tags": ["physicalAttack",
			"percent",
			"seal"],
			"colloq": null,
			"plaintext": null
		},
		"5315": {
			"name": "Greater Seal of Health",
			"description": "+8 health",
			"image": {
				"full": "y_3_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 192,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "yellow"
			},
			"stats": {
				"FlatHPPoolMod": 8.0
			},
			"tags": ["defense",
			"flat",
			"seal"],
			"colloq": null,
			"plaintext": null
		},
		"5316": {
			"name": "Greater Seal of Scaling Health",
			"description": "+1.33 health per level (+24 at champion level 18)",
			"image": {
				"full": "y_4_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 240,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "yellow"
			},
			"stats": {
				"rFlatHPModPerLevel": 1.3334
			},
			"tags": ["defense",
			"perLevel",
			"seal"],
			"colloq": null,
			"plaintext": null
		},
		"5317": {
			"name": "Greater Seal of Armor",
			"description": "+1 armor",
			"image": {
				"full": "y_1_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 96,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "yellow"
			},
			"stats": {
				"FlatArmorMod": 1.0
			},
			"tags": ["defense",
			"flat",
			"seal"],
			"colloq": null,
			"plaintext": null
		},
		"5318": {
			"name": "Greater Seal of Scaling Armor",
			"description": "+0.16 armor per level (+3 at champion level 18)",
			"image": {
				"full": "y_2_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 144,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "yellow"
			},
			"stats": {
				"rFlatArmorModPerLevel": 0.16667
			},
			"tags": ["defense",
			"perLevel",
			"seal"],
			"colloq": null,
			"plaintext": null
		},
		"5319": {
			"name": "Greater Seal of Magic Resist",
			"description": "+0.74 magic resist",
			"image": {
				"full": "y_3_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 192,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "yellow"
			},
			"stats": {
				"FlatSpellBlockMod": 0.7425
			},
			"tags": ["defense",
			"flat",
			"seal"],
			"colloq": null,
			"plaintext": null
		},
		"5320": {
			"name": "Greater Seal of Scaling Magic Resist",
			"description": "+0.1 magic resist per level (+1.8 at champion level 18)",
			"image": {
				"full": "y_4_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 240,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "yellow"
			},
			"stats": {
				"rFlatSpellBlockModPerLevel": 0.0965
			},
			"tags": ["defense",
			"perLevel",
			"seal"],
			"colloq": null,
			"plaintext": null
		},
		"5321": {
			"name": "Greater Seal of Health Regeneration",
			"description": "+0.56 health regen / 5 sec.",
			"image": {
				"full": "y_1_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 96,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "yellow"
			},
			"stats": {
				"FlatHPRegenMod": 0.1112
			},
			"tags": ["defense",
			"flat",
			"seal"],
			"colloq": null,
			"plaintext": null
		},
		"5322": {
			"name": "Greater Seal of Scaling Health Regeneration",
			"description": "+0.11 health regen / 5 sec. per level (+1.98 at champion level 18)",
			"image": {
				"full": "y_2_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 144,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "yellow"
			},
			"stats": {
				"rFlatHPRegenModPerLevel": 0.0225
			},
			"tags": ["defense",
			"perLevel",
			"seal"],
			"colloq": null,
			"plaintext": null
		},
		"5325": {
			"name": "Greater Seal of Cooldown Reduction",
			"description": "-0.36% cooldowns",
			"image": {
				"full": "y_1_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 96,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "yellow"
			},
			"stats": {
				"rPercentCooldownMod": -0.003556
			},
			"tags": ["utility",
			"percent",
			"seal"],
			"colloq": null,
			"plaintext": null
		},
		"5327": {
			"name": "Greater Seal of Ability Power",
			"description": "+0.59 ability power",
			"image": {
				"full": "y_3_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 192,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "yellow"
			},
			"stats": {
				"FlatMagicDamageMod": 0.594
			},
			"tags": ["magic",
			"flat",
			"seal"],
			"colloq": null,
			"plaintext": null
		},
		"5328": {
			"name": "Greater Seal of Scaling Ability Power",
			"description": "+0.1 ability power per level (+1.8 at champion level 18)",
			"image": {
				"full": "y_4_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 240,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "yellow"
			},
			"stats": {
				"rFlatMagicDamageModPerLevel": 0.1038
			},
			"tags": ["magic",
			"perLevel",
			"seal"],
			"colloq": null,
			"plaintext": null
		},
		"5329": {
			"name": "Greater Seal of Mana",
			"description": "+6.89 mana",
			"image": {
				"full": "y_1_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 96,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "yellow"
			},
			"stats": {
				"FlatMPPoolMod": 6.8906
			},
			"tags": ["magic",
			"flat",
			"seal"],
			"colloq": null,
			"plaintext": null
		},
		"5330": {
			"name": "Greater Seal of Scaling Mana",
			"description": "+1.17 mana per level (+21.06 at champion level 18)",
			"image": {
				"full": "y_2_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 144,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "yellow"
			},
			"stats": {
				"rFlatMPModPerLevel": 1.1667
			},
			"tags": ["magic",
			"perLevel",
			"seal"],
			"colloq": null,
			"plaintext": null
		},
		"5331": {
			"name": "Greater Seal of Mana Regeneration",
			"description": "+0.41 mana regen / 5 sec.",
			"image": {
				"full": "y_3_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 192,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "yellow"
			},
			"stats": {
				"FlatMPRegenMod": 0.08126
			},
			"tags": ["magic",
			"flat",
			"seal"],
			"colloq": null,
			"plaintext": null
		},
		"5332": {
			"name": "Greater Seal of Scaling Mana Regeneration",
			"description": "+0.065 mana regen / 5 sec. per level (+1.17 at champion level 18)",
			"image": {
				"full": "y_4_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 240,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "yellow"
			},
			"stats": {
				"rFlatMPRegenModPerLevel": 0.013
			},
			"tags": ["magic",
			"perLevel",
			"seal"],
			"colloq": null,
			"plaintext": null
		},
		"5335": {
			"name": "Greater Quintessence of Attack Damage",
			"description": "+2.25 attack damage",
			"image": {
				"full": "bl_1_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 288,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "black"
			},
			"stats": {
				"FlatPhysicalDamageMod": 2.25
			},
			"tags": ["physicalAttack",
			"flat",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5336": {
			"name": "Greater Quintessence of Scaling Attack Damage",
			"description": "+0.25 attack damage per level (+4.5 at champion level 18)",
			"image": {
				"full": "bl_2_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 336,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "black"
			},
			"stats": {
				"rFlatPhysicalDamageModPerLevel": 0.25
			},
			"tags": ["physicalAttack",
			"perLevel",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5337": {
			"name": "Greater Quintessence of Attack Speed",
			"description": "+4.5% attack speed",
			"image": {
				"full": "bl_3_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 384,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "black"
			},
			"stats": {
				"PercentAttackSpeedMod": 0.045
			},
			"tags": ["physicalAttack",
			"percent",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5339": {
			"name": "Greater Quintessence of Critical Damage",
			"description": "+4.46% critical damage",
			"image": {
				"full": "bl_1_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 288,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "black"
			},
			"stats": {
				"FlatCritDamageMod": 0.044628
			},
			"tags": ["physicalAttack",
			"percent",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5341": {
			"name": "Greater Quintessence of Critical Chance",
			"description": "+1.86% critical chance",
			"image": {
				"full": "bl_3_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 384,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "black"
			},
			"stats": {
				"FlatCritChanceMod": 0.018557
			},
			"tags": ["physicalAttack",
			"percent",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5343": {
			"name": "Greater Quintessence of Armor Penetration",
			"description": "+2.56 armor penetration",
			"image": {
				"full": "bl_1_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 288,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "black"
			},
			"stats": {
				"rFlatArmorPenetrationMod": 2.56
			},
			"tags": ["physicalAttack",
			"flat",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5345": {
			"name": "Greater Quintessence of Health",
			"description": "+26 health",
			"image": {
				"full": "bl_3_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 384,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "black"
			},
			"stats": {
				"FlatHPPoolMod": 26.0
			},
			"tags": ["defense",
			"flat",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5346": {
			"name": "Greater Quintessence of Scaling Health",
			"description": "+2.7 health per level (+48.6 at champion level 18)",
			"image": {
				"full": "bl_4_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 432,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "black"
			},
			"stats": {
				"rFlatHPModPerLevel": 2.7043
			},
			"tags": ["defense",
			"perLevel",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5347": {
			"name": "Greater Quintessence of Armor",
			"description": "+4.26 armor",
			"image": {
				"full": "bl_1_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 288,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "black"
			},
			"stats": {
				"FlatArmorMod": 4.2632
			},
			"tags": ["defense",
			"flat",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5348": {
			"name": "Greater Quintessence of Scaling Armor",
			"description": "+0.38 armor per level (+6.84 at champion level 18)",
			"image": {
				"full": "bl_2_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 336,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "black"
			},
			"stats": {
				"rFlatArmorModPerLevel": 0.375
			},
			"tags": ["defense",
			"perLevel",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5349": {
			"name": "Greater Quintessence of Magic Resist",
			"description": "+4 magic resist",
			"image": {
				"full": "bl_3_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 384,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "black"
			},
			"stats": {
				"FlatSpellBlockMod": 4.0
			},
			"tags": ["defense",
			"flat",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5350": {
			"name": "Greater Quintessence of Scaling Magic Resist",
			"description": "+0.37 magic resist per level (+6.66 at champion level 18)",
			"image": {
				"full": "bl_4_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 432,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "black"
			},
			"stats": {
				"rFlatSpellBlockModPerLevel": 0.3711
			},
			"tags": ["defense",
			"perLevel",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5351": {
			"name": "Greater Quintessence of Health Regeneration",
			"description": "+2.7 health regen / 5 sec.",
			"image": {
				"full": "bl_1_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 288,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "black"
			},
			"stats": {
				"FlatHPRegenMod": 0.54
			},
			"tags": ["defense",
			"flat",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5352": {
			"name": "Greater Quintessence of Scaling Health Regeneration",
			"description": "+0.28 health regen / 5 sec. per level (+5.04 at champion level 18)",
			"image": {
				"full": "bl_2_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 336,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "black"
			},
			"stats": {
				"rFlatHPRegenModPerLevel": 0.05626
			},
			"tags": ["defense",
			"perLevel",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5355": {
			"name": "Greater Quintessence of Cooldown Reduction",
			"description": "-2.5% cooldowns",
			"image": {
				"full": "bl_1_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 288,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "black"
			},
			"stats": {
				"rPercentCooldownMod": -0.025
			},
			"tags": ["utility",
			"percent",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5356": {
			"name": "Greater Quintessence of Scaling Cooldown Reduction",
			"description": "-0.28% cooldowns per level (-5% at champion level 18)",
			"image": {
				"full": "bl_2_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 336,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "black"
			},
			"stats": {
				"rPercentCooldownModPerLevel": -0.002778
			},
			"tags": ["utility",
			"percent",
			"perLevel",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5357": {
			"name": "Greater Quintessence of Ability Power",
			"description": "+4.95 ability power",
			"image": {
				"full": "bl_3_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 384,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "black"
			},
			"stats": {
				"FlatMagicDamageMod": 4.95
			},
			"tags": ["magic",
			"flat",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5358": {
			"name": "Greater Quintessence of Scaling Ability Power",
			"description": "+0.43 ability power per level (+7.74 at champion level 18)",
			"image": {
				"full": "bl_4_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 432,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "black"
			},
			"stats": {
				"rFlatMagicDamageModPerLevel": 0.4327
			},
			"tags": ["magic",
			"perLevel",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5359": {
			"name": "Greater Quintessence of Mana",
			"description": "+37.5 mana",
			"image": {
				"full": "bl_1_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 288,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "black"
			},
			"stats": {
				"FlatMPPoolMod": 37.5
			},
			"tags": ["magic",
			"flat",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5360": {
			"name": "Greater Quintessence of Scaling Mana",
			"description": "+4.17 mana per level (+75.06 at champion level 18)",
			"image": {
				"full": "bl_2_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 336,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "black"
			},
			"stats": {
				"rFlatMPModPerLevel": 4.1667
			},
			"tags": ["magic",
			"perLevel",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5361": {
			"name": "Greater Quintessence of Mana Regeneration",
			"description": "+1.25 mana regen / 5 sec.",
			"image": {
				"full": "bl_3_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 384,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "black"
			},
			"stats": {
				"FlatMPRegenMod": 0.25
			},
			"tags": ["magic",
			"flat",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5362": {
			"name": "Greater Quintessence of Scaling Mana Regeneration",
			"description": "+0.24 mana regen / 5 sec. per level (+4.32 at champion level 18)",
			"image": {
				"full": "bl_4_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 432,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "black"
			},
			"stats": {
				"rFlatMPRegenModPerLevel": 0.04882
			},
			"tags": ["magic",
			"perLevel",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5363": {
			"name": "Greater Quintessence of Magic Penetration",
			"description": "+2.01 magic penetration",
			"image": {
				"full": "bl_1_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 288,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "black"
			},
			"stats": {
				"rFlatMagicPenetrationMod": 2.01
			},
			"tags": ["magic",
			"flat",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5365": {
			"name": "Greater Quintessence of Movement Speed",
			"description": "+1.5% movement speed",
			"image": {
				"full": "bl_3_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 384,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "black"
			},
			"stats": {
				"PercentMovementSpeedMod": 0.015
			},
			"tags": ["utility",
			"percent",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5366": {
			"name": "Greater Quintessence of Revival",
			"description": "-5% time dead",
			"image": {
				"full": "bl_1_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 288,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "black"
			},
			"stats": {
				"rPercentTimeDeadMod": 0.05
			},
			"tags": ["utility",
			"percent",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5367": {
			"name": "Greater Quintessence of Gold",
			"description": "+1 gold / 10 sec.",
			"image": {
				"full": "bl_4_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 432,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "black"
			},
			"stats": {
				"rFlatGoldPer10Mod": 1.0
			},
			"tags": ["utility",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5368": {
			"name": "Greater Quintessence of Experience",
			"description": "+2% experience gained",
			"image": {
				"full": "bl_2_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 336,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "black"
			},
			"stats": {
				"PercentEXPBonus": 0.02
			},
			"tags": ["utility",
			"percent",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5369": {
			"name": "Greater Seal of Energy Regeneration",
			"description": "+0.63 Energy regen/5 sec",
			"image": {
				"full": "y_1_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 96,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "yellow"
			},
			"stats": {
				"FlatEnergyRegenMod": 0.126
			},
			"tags": ["seal"],
			"colloq": null,
			"plaintext": null
		},
		"5370": {
			"name": "Greater Seal of Scaling Energy Regeneration",
			"description": "+0.064 Energy regen/5 sec per level (+1.15 at champion level 18)",
			"image": {
				"full": "y_3_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 192,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "yellow"
			},
			"stats": {
				"rFlatEnergyRegenModPerLevel": 0.01283
			},
			"tags": ["seal"],
			"colloq": null,
			"plaintext": null
		},
		"5371": {
			"name": "Greater Glyph of Energy",
			"description": "+2.2 Energy",
			"image": {
				"full": "b_3_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 0,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "blue"
			},
			"stats": {
				"FlatEnergyPoolMod": 2.2
			},
			"tags": ["glyph"],
			"colloq": null,
			"plaintext": null
		},
		"5372": {
			"name": "Greater Glyph of Scaling Energy",
			"description": "+0.161 Energy/level (+2.89 at level 18)",
			"image": {
				"full": "b_2_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 432,
				"y": 144,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "blue"
			},
			"stats": {
				"rFlatEnergyModPerLevel": 0.161
			},
			"tags": ["glyph"],
			"colloq": null,
			"plaintext": null
		},
		"5373": {
			"name": "Greater Quintessence of Energy Regeneration",
			"description": "+1.575 Energy regen/5 sec",
			"image": {
				"full": "bl_2_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 336,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "black"
			},
			"stats": {
				"FlatEnergyRegenMod": 0.315
			},
			"tags": ["quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5374": {
			"name": "Greater Quintessence of Energy",
			"description": "+5.4 Energy",
			"image": {
				"full": "bl_3_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 384,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "black"
			},
			"stats": {
				"FlatEnergyPoolMod": 5.4
			},
			"tags": ["quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5400": {
			"name": "Lesser Mark of Hybrid Penetration",
			"description": "+0.5 Armor Penetration / +0.34 Magic Penetration",
			"image": {
				"full": "r_1_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 96,
				"y": 0,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "red"
			},
			"stats": {
				"rFlatArmorPenetrationMod": 0.5,
				"rFlatMagicPenetrationMod": 0.34
			},
			"tags": ["physicalAttack",
			"flat",
			"magic",
			"mark"],
			"colloq": null,
			"plaintext": null
		},
		"5401": {
			"name": "Mark of Hybrid Penetration",
			"description": "+0.7 Armor Penetration / +0.48 Magic Penetration",
			"image": {
				"full": "r_1_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 384,
				"y": 48,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "red"
			},
			"stats": {
				"rFlatArmorPenetrationMod": 0.7,
				"rFlatMagicPenetrationMod": 0.48
			},
			"tags": ["physicalAttack",
			"flat",
			"magic",
			"mark"],
			"colloq": null,
			"plaintext": null
		},
		"5402": {
			"name": "Greater Mark of Hybrid Penetration",
			"description": "+0.9 Armor Penetration / +0.62 Magic Penetration",
			"image": {
				"full": "r_1_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 192,
				"y": 144,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "red"
			},
			"stats": {
				"rFlatArmorPenetrationMod": 0.9,
				"rFlatMagicPenetrationMod": 0.61
			},
			"tags": ["physicalAttack",
			"flat",
			"magic",
			"mark"],
			"colloq": null,
			"plaintext": null
		},
		"5403": {
			"name": "Greater Seal of Gold",
			"description": "+0.25 gold / 10 sec.",
			"image": {
				"full": "y_3_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 192,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "yellow"
			},
			"stats": {
				"rFlatGoldPer10Mod": 0.25
			},
			"tags": ["utility",
			"seal"],
			"colloq": null,
			"plaintext": null
		},
		"5404": {
			"name": "Lesser Quintessence of Percent Health",
			"description": "+0.84% increased health.",
			"image": {
				"full": "bl_2_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 240,
				"y": 48,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "black"
			},
			"stats": {
				"PercentHPPoolMod": 0.0084
			},
			"tags": ["defense",
			"percent",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5405": {
			"name": "Quintessence of Percent Health",
			"description": "+1.17% increased health.",
			"image": {
				"full": "bl_2_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 48,
				"y": 144,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "black"
			},
			"stats": {
				"PercentHPPoolMod": 0.0117
			},
			"tags": ["defense",
			"percent",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5406": {
			"name": "Greater Quintessence of Percent Health",
			"description": "+1.5% increased health.",
			"image": {
				"full": "bl_3_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 384,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "black"
			},
			"stats": {
				"PercentHPPoolMod": 0.015
			},
			"tags": ["defense",
			"percent",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5407": {
			"name": "Lesser Quintessence of Spell Vamp",
			"description": "+1.12% Spellvamp.",
			"image": {
				"full": "bl_4_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 336,
				"y": 48,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "black"
			},
			"stats": {
				"PercentSpellVampMod": 0.0112
			},
			"tags": ["magic",
			"percent",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5408": {
			"name": "Quintessence of Spell Vamp",
			"description": "+1.56% Spellvamp.",
			"image": {
				"full": "bl_4_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 144,
				"y": 144,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "black"
			},
			"stats": {
				"PercentSpellVampMod": 0.0156
			},
			"tags": ["magic",
			"percent",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5409": {
			"name": "Greater Quintessence of Spell Vamp",
			"description": "+2% Spellvamp.",
			"image": {
				"full": "bl_4_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 432,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "black"
			},
			"stats": {
				"PercentSpellVampMod": 0.02
			},
			"tags": ["magic",
			"percent",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5410": {
			"name": "Lesser Quintessence of Life Steal",
			"description": "+0.84% Life Steal",
			"image": {
				"full": "bl_1_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 192,
				"y": 48,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "black"
			},
			"stats": {
				"PercentLifeStealMod": 0.0084
			},
			"tags": ["physicalAttack",
			"percent",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5411": {
			"name": "Quintessence of Life Steal",
			"description": "+1.17% Life Steal",
			"image": {
				"full": "bl_1_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 0,
				"y": 144,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "black"
			},
			"stats": {
				"PercentLifeStealMod": 0.0117
			},
			"tags": ["physicalAttack",
			"percent",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5412": {
			"name": "Greater Quintessence of Life Steal",
			"description": "+1.5% Life Steal.",
			"image": {
				"full": "bl_1_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 288,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "black"
			},
			"stats": {
				"PercentLifeStealMod": 0.015
			},
			"tags": ["physicalAttack",
			"percent",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5413": {
			"name": "Lesser Seal of Percent Health",
			"description": "+0.28% Health.",
			"image": {
				"full": "y_2_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 48,
				"y": 48,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "yellow"
			},
			"stats": {
				"PercentHPPoolMod": 0.0028
			},
			"tags": ["defense",
			"percent",
			"seal"],
			"colloq": null,
			"plaintext": null
		},
		"5414": {
			"name": "Seal of Percent Health",
			"description": "+0.39% Health.",
			"image": {
				"full": "y_2_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 336,
				"y": 96,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "yellow"
			},
			"stats": {
				"PercentHPPoolMod": 0.0039
			},
			"tags": ["defense",
			"percent",
			"seal"],
			"colloq": null,
			"plaintext": null
		},
		"5415": {
			"name": "Greater Seal of Percent Health",
			"description": "+0.5% Health.",
			"image": {
				"full": "y_3_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 192,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "yellow"
			},
			"stats": {
				"PercentHPPoolMod": 0.005
			},
			"tags": ["defense",
			"percent",
			"seal"],
			"colloq": null,
			"plaintext": null
		},
		"5416": {
			"name": "Lesser Quintessence of Hybrid Penetration",
			"description": "+0.99 Armor Penetration / +0.78 Magic Penetration",
			"image": {
				"full": "bl_4_1.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 336,
				"y": 48,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "black"
			},
			"stats": {
				"rFlatArmorPenetrationMod": 0.99,
				"rFlatMagicPenetrationMod": 0.78
			},
			"tags": ["physicalAttack",
			"flat",
			"magic",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5417": {
			"name": "Quintessence of Hybrid Penetration",
			"description": "+1.39 Armor Penetration / +1.09 Magic Penetration",
			"image": {
				"full": "bl_4_2.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 144,
				"y": 144,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "black"
			},
			"stats": {
				"rFlatArmorPenetrationMod": 1.39,
				"rFlatMagicPenetrationMod": 1.09
			},
			"tags": ["physicalAttack",
			"flat",
			"magic",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"5418": {
			"name": "Greater Quintessence of Hybrid Penetration",
			"description": "+1.79 Armor Penetration / +1.4 Magic Penetration",
			"image": {
				"full": "bl_4_3.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 432,
				"y": 192,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "black"
			},
			"stats": {
				"rFlatArmorPenetrationMod": 1.79,
				"rFlatMagicPenetrationMod": 1.4
			},
			"tags": ["physicalAttack",
			"flat",
			"magic",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"8001": {
			"name": "Mark of the Crippling Candy Cane",
			"description": "+2% critical damage",
			"image": {
				"full": "8001.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 0,
				"y": 240,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "red"
			},
			"stats": {
				"FlatCritDamageMod": 0.019835
			},
			"tags": ["physicalAttack",
			"percent",
			"mark"],
			"colloq": null,
			"plaintext": null
		},
		"8002": {
			"name": "Lesser Mark of the Yuletide Tannenbaum ",
			"description": "+0.62% critical chance",
			"image": {
				"full": "8002.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 48,
				"y": 240,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "red"
			},
			"stats": {
				"FlatCritChanceMod": 0.0061855
			},
			"tags": ["physicalAttack",
			"percent",
			"mark"],
			"colloq": null,
			"plaintext": null
		},
		"8003": {
			"name": "Glyph of the Special Stocking",
			"description": "-0.75% cooldowns",
			"image": {
				"full": "8003.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 96,
				"y": 240,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "blue"
			},
			"stats": {
				"rPercentCooldownMod": -0.0075
			},
			"tags": ["utility",
			"percent",
			"glyph"],
			"colloq": null,
			"plaintext": null
		},
		"8005": {
			"name": "Lesser Glyph of the Gracious Gift",
			"description": "+0.12 ability power per level (+2.16 at champion level 18)",
			"image": {
				"full": "8005.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 144,
				"y": 240,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "blue"
			},
			"stats": {
				"rFlatMagicDamageModPerLevel": 0.1154
			},
			"tags": ["magic",
			"perLevel",
			"glyph"],
			"colloq": null,
			"plaintext": null
		},
		"8006": {
			"name": "Lesser Seal of the Stout Snowman",
			"description": "+0.72 health per level (+12.96 at champion level 18)",
			"image": {
				"full": "8006.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 192,
				"y": 240,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "yellow"
			},
			"stats": {
				"rFlatHPModPerLevel": 0.72115
			},
			"tags": ["defense",
			"perLevel",
			"seal"],
			"colloq": null,
			"plaintext": null
		},
		"8007": {
			"name": "Lesser Mark of Alpine Attack Speed",
			"description": "+1.13% attack speed",
			"image": {
				"full": "8007.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 240,
				"y": 240,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "red"
			},
			"stats": {
				"PercentAttackSpeedMod": 0.011321
			},
			"tags": ["physicalAttack",
			"percent",
			"mark"],
			"colloq": null,
			"plaintext": null
		},
		"8008": {
			"name": "Mark of the Combatant",
			"description": "+2% critical damage",
			"image": {
				"full": "8008.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 288,
				"y": 240,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "red"
			},
			"stats": {
				"FlatCritDamageMod": 0.019835
			},
			"tags": ["physicalAttack",
			"percent",
			"mark"],
			"colloq": null,
			"plaintext": null
		},
		"8009": {
			"name": "Lesser Seal of the Medalist",
			"description": "+3.56 health",
			"image": {
				"full": "8009.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 336,
				"y": 240,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "yellow"
			},
			"stats": {
				"FlatHPPoolMod": 3.564
			},
			"tags": ["defense",
			"flat",
			"seal"],
			"colloq": null,
			"plaintext": null
		},
		"8011": {
			"name": "Lesser Glyph of the Challenger",
			"description": "+0.66 ability power",
			"image": {
				"full": "8011.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 384,
				"y": 240,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "1",
				"type": "blue"
			},
			"stats": {
				"FlatMagicDamageMod": 0.66
			},
			"tags": ["magic",
			"flat",
			"glyph"],
			"colloq": null,
			"plaintext": null
		},
		"8012": {
			"name": "Glyph of the Soaring Slalom",
			"description": "-0.75% cooldowns",
			"image": {
				"full": "8012.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 432,
				"y": 240,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "blue"
			},
			"stats": {
				"rPercentCooldownMod": -0.0075
			},
			"tags": ["utility",
			"percent",
			"glyph"],
			"colloq": null,
			"plaintext": null
		},
		"8013": {
			"name": "Quintessence of the Headless Horseman",
			"description": "+2.37 armor penetration",
			"image": {
				"full": "8013.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 0,
				"y": 288,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "black"
			},
			"stats": {
				"rFlatArmorPenetrationMod": 2.37
			},
			"tags": ["physicalAttack",
			"flat",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"8014": {
			"name": "Quintessence of the Piercing Screech",
			"description": "+1.85 magic penetration",
			"image": {
				"full": "8014.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 48,
				"y": 288,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "black"
			},
			"stats": {
				"rFlatMagicPenetrationMod": 1.85
			},
			"tags": ["magic",
			"flat",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"8015": {
			"name": "Quintessence of Bountiful Treats",
			"description": "+24 health",
			"image": {
				"full": "8015.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 96,
				"y": 288,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "black"
			},
			"stats": {
				"FlatHPPoolMod": 24.0
			},
			"tags": ["defense",
			"flat",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"8016": {
			"name": "Quintessence of the Speedy Specter",
			"description": "+1.39% movement speed",
			"image": {
				"full": "8016.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 144,
				"y": 288,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "black"
			},
			"stats": {
				"PercentMovementSpeedMod": 0.0139
			},
			"tags": ["utility",
			"percent",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"8017": {
			"name": "Quintessence of the Witches Brew",
			"description": "+4.56 ability power",
			"image": {
				"full": "8017.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 192,
				"y": 288,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "2",
				"type": "black"
			},
			"stats": {
				"FlatMagicDamageMod": 4.56
			},
			"tags": ["magic",
			"flat",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"8019": {
			"name": "Greater Quintessence of the Piercing Present",
			"description": "+2.01 magic penetration",
			"image": {
				"full": "8019.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 240,
				"y": 288,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "black"
			},
			"stats": {
				"rFlatMagicPenetrationMod": 2.01
			},
			"tags": ["magic",
			"flat",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"8020": {
			"name": "Greater Quintessence of the Deadly Wreath",
			"description": "+2.56 armor penetration",
			"image": {
				"full": "8020.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 288,
				"y": 288,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "black"
			},
			"stats": {
				"rFlatArmorPenetrationMod": 2.56
			},
			"tags": ["physicalAttack",
			"flat",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"8021": {
			"name": "Greater Quintessence of Frosty Health",
			"description": "+26 health",
			"image": {
				"full": "8021.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 336,
				"y": 288,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "black"
			},
			"stats": {
				"FlatHPPoolMod": 26.0
			},
			"tags": ["defense",
			"flat",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"8022": {
			"name": "Greater Quintessence of Sugar Rush",
			"description": "+1.5% movement speed",
			"image": {
				"full": "8022.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 384,
				"y": 288,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "black"
			},
			"stats": {
				"PercentMovementSpeedMod": 0.015
			},
			"tags": ["utility",
			"percent",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		},
		"8035": {
			"name": "Greater Quintessence of Studio Rumble",
			"description": "+1.5% movement speed",
			"image": {
				"full": "8035.png",
				"sprite": "rune0.png",
				"group": "rune",
				"x": 0,
				"y": 384,
				"w": 48,
				"h": 48
			},
			"rune": {
				"isrune": true,
				"tier": "3",
				"type": "black"
			},
			"stats": {
				"PercentMovementSpeedMod": 0.015
			},
			"tags": ["utility",
			"percent",
			"quintessence"],
			"colloq": null,
			"plaintext": null
		}
	}
}';
$list = json_decode($data);

		foreach ($list->data as $key => $value){
			$this->{$key} = new stdClass();
			$this->{$key}->value		=$value->name;
			$this->{$key}->description	=$value->description;
			foreach ($value->stats as $stat => $effect){
				$this->{$key}->stats[$stat]		=$effect;
			}
		}
	}	
}


class AllMasteries{
	public function __construct(){
		$data='{
			"type": "mastery",
			"version": "5.3.1",
			"tree": {
				"Offense": [[{
					"masteryId": "4111",
					"prereq": "0"
				},
				{
					"masteryId": "4112",
					"prereq": "0"
				},
				{
					"masteryId": "4113",
					"prereq": "0"
				},
				{
					"masteryId": "4114",
					"prereq": "0"
				}],
				[{
					"masteryId": "4121",
					"prereq": "0"
				},
				{
					"masteryId": "4122",
					"prereq": "0"
				},
				{
					"masteryId": "4123",
					"prereq": "0"
				},
				{
					"masteryId": "4124",
					"prereq": "4114"
				}],
				[{
					"masteryId": "4131",
					"prereq": "0"
				},
				{
					"masteryId": "4132",
					"prereq": "4122"
				},
				{
					"masteryId": "4133",
					"prereq": "4123"
				},
				{
					"masteryId": "4134",
					"prereq": "0"
				}],
				[{
					"masteryId": "4141",
					"prereq": "4131"
				},
				{
					"masteryId": "4142",
					"prereq": "0"
				},
				{
					"masteryId": "4143",
					"prereq": "0"
				},
				{
					"masteryId": "4144",
					"prereq": "4134"
				}],
				[{
					"masteryId": "4151",
					"prereq": "0"
				},
				{
					"masteryId": "4152",
					"prereq": "0"
				},
				null,
				{
					"masteryId": "4154",
					"prereq": "0"
				}],
				[null,
				{
					"masteryId": "4162",
					"prereq": "0"
				}]],
				"Defense": [[{
					"masteryId": "4211",
					"prereq": "0"
				},
				{
					"masteryId": "4212",
					"prereq": "0"
				},
				{
					"masteryId": "4213",
					"prereq": "0"
				},
				{
					"masteryId": "4214",
					"prereq": "0"
				}],
				[{
					"masteryId": "4221",
					"prereq": "4211"
				},
				{
					"masteryId": "4222",
					"prereq": "0"
				},
				null,
				{
					"masteryId": "4224",
					"prereq": "4214"
				}],
				[{
					"masteryId": "4231",
					"prereq": "0"
				},
				{
					"masteryId": "4232",
					"prereq": "4222"
				},
				{
					"masteryId": "4233",
					"prereq": "0"
				},
				{
					"masteryId": "4234",
					"prereq": "0"
				}],
				[{
					"masteryId": "4241",
					"prereq": "0"
				},
				{
					"masteryId": "4242",
					"prereq": "0"
				},
				{
					"masteryId": "4243",
					"prereq": "4233"
				},
				{
					"masteryId": "4244",
					"prereq": "4234"
				}],
				[{
					"masteryId": "4251",
					"prereq": "4241"
				},
				{
					"masteryId": "4252",
					"prereq": "0"
				},
				{
					"masteryId": "4253",
					"prereq": "0"
				}],
				[null,
				{
					"masteryId": "4262",
					"prereq": "0"
				}]],
				"Utility": [[{
					"masteryId": "4311",
					"prereq": "0"
				},
				{
					"masteryId": "4312",
					"prereq": "0"
				},
				{
					"masteryId": "4313",
					"prereq": "0"
				},
				{
					"masteryId": "4314",
					"prereq": "0"
				}],
				[null,
				{
					"masteryId": "4322",
					"prereq": "0"
				},
				{
					"masteryId": "4323",
					"prereq": "4313"
				},
				{
					"masteryId": "4324",
					"prereq": "0"
				}],
				[{
					"masteryId": "4331",
					"prereq": "0"
				},
				{
					"masteryId": "4332",
					"prereq": "0"
				},
				{
					"masteryId": "4333",
					"prereq": "0"
				},
				{
					"masteryId": "4334",
					"prereq": "4324"
				}],
				[{
					"masteryId": "4341",
					"prereq": "4331"
				},
				{
					"masteryId": "4342",
					"prereq": "0"
				},
				{
					"masteryId": "4343",
					"prereq": "0"
				},
				{
					"masteryId": "4344",
					"prereq": "0"
				}],
				[null,
				{
					"masteryId": "4352",
					"prereq": "4342"
				},
				{
					"masteryId": "4353",
					"prereq": "0"
				}],
				[null,
				{
					"masteryId": "4362",
					"prereq": "0"
				}]]
			},
			"data": {
				"4111": {
					"id": 4111,
					"name": "Double-Edged Sword",
					"description": ["Melee - Deal an additional 2% damage and receive an additional 1% damage<br>Ranged - Deal an additional 1.5% damage and receive an additional 1.5% damage"],
					"image": {
						"full": "4111.png",
						"sprite": "mastery0.png",
						"group": "gray_mastery",
						"x": 0,
						"y": 0,
						"w": 48,
						"h": 48
					},
					"ranks": 1,
					"prereq": "0"
				},
				"4112": {
					"id": 4112,
					"name": "Fury",
					"description": ["+1.25% Attack Speed",
					"+2.5% Attack Speed",
					"+3.75% Attack Speed",
					"+5% Attack Speed"],
					"image": {
						"full": "4112.png",
						"sprite": "mastery0.png",
						"group": "gray_mastery",
						"x": 48,
						"y": 0,
						"w": 48,
						"h": 48
					},
					"ranks": 4,
					"prereq": "0"
				},
				"4113": {
					"id": 4113,
					"name": "Sorcery",
					"description": ["+1.25% Cooldown Reduction",
					"+2.5% Cooldown Reduction",
					"+3.75% Cooldown Reduction",
					"+5% Cooldown Reduction"],
					"image": {
						"full": "4113.png",
						"sprite": "mastery0.png",
						"group": "gray_mastery",
						"x": 96,
						"y": 0,
						"w": 48,
						"h": 48
					},
					"ranks": 4,
					"prereq": "0"
				},
				"4114": {
					"id": 4114,
					"name": "Butcher",
					"description": ["Basic attacks and single target spells deal an additional 2 damage to minions and monsters<br><br>This does not trigger off of area of effect damage or damage over time effects"],
					"image": {
						"full": "4114.png",
						"sprite": "mastery0.png",
						"group": "gray_mastery",
						"x": 144,
						"y": 0,
						"w": 48,
						"h": 48
					},
					"ranks": 1,
					"prereq": "0"
				},
				"4121": {
					"id": 4121,
					"name": "Expose Weakness",
					"description": ["Damaging an enemy with a spell increases allied champions&#39; damage to that enemy by 1% for the next 3 seconds"],
					"image": {
						"full": "4121.png",
						"sprite": "mastery0.png",
						"group": "gray_mastery",
						"x": 192,
						"y": 0,
						"w": 48,
						"h": 48
					},
					"ranks": 1,
					"prereq": "0"
				},
				"4122": {
					"id": 4122,
					"name": "Brute Force",
					"description": ["+4 Attack Damage at level 18 (+0.22 Attack Damage per level)",
					"+7 Attack Damage at level 18 (+0.39 Attack Damage per level)",
					"+10 Attack Damage at level 18 (+0.55 Attack Damage per level)"],
					"image": {
						"full": "4122.png",
						"sprite": "mastery0.png",
						"group": "gray_mastery",
						"x": 240,
						"y": 0,
						"w": 48,
						"h": 48
					},
					"ranks": 3,
					"prereq": "0"
				},
				"4123": {
					"id": 4123,
					"name": "Mental Force",
					"description": ["+6 Ability Power at level 18 (+0.33 Ability Power per level)",
					"+11 Ability Power at level 18 (+0.61 Ability Power per level)",
					"+16 Ability Power at level 18 (+0.89 Ability Power per level)"],
					"image": {
						"full": "4123.png",
						"sprite": "mastery0.png",
						"group": "gray_mastery",
						"x": 288,
						"y": 0,
						"w": 48,
						"h": 48
					},
					"ranks": 3,
					"prereq": "0"
				},
				"4124": {
					"id": 4124,
					"name": "Feast",
					"description": ["Killing a unit restores 3 Health and 1 Mana"],
					"image": {
						"full": "4124.png",
						"sprite": "mastery0.png",
						"group": "gray_mastery",
						"x": 336,
						"y": 0,
						"w": 48,
						"h": 48
					},
					"ranks": 1,
					"prereq": "4114"
				},
				"4131": {
					"id": 4131,
					"name": "Spell Weaving",
					"description": ["Damaging an enemy champion with a Basic Attack increases Spell Damage by 1%, stacking up to 3 times (max 3% damage increase)"],
					"image": {
						"full": "4131.png",
						"sprite": "mastery0.png",
						"group": "gray_mastery",
						"x": 384,
						"y": 0,
						"w": 48,
						"h": 48
					},
					"ranks": 1,
					"prereq": "0"
				},
				"4132": {
					"id": 4132,
					"name": "Martial Mastery",
					"description": ["+4 Attack Damage"],
					"image": {
						"full": "4132.png",
						"sprite": "mastery0.png",
						"group": "gray_mastery",
						"x": 432,
						"y": 0,
						"w": 48,
						"h": 48
					},
					"ranks": 1,
					"prereq": "4122"
				},
				"4133": {
					"id": 4133,
					"name": "Arcane Mastery",
					"description": ["+6 Ability Power"],
					"image": {
						"full": "4133.png",
						"sprite": "mastery0.png",
						"group": "gray_mastery",
						"x": 0,
						"y": 48,
						"w": 48,
						"h": 48
					},
					"ranks": 1,
					"prereq": "4123"
				},
				"4134": {
					"id": 4134,
					"name": "Executioner",
					"description": ["Increases damage dealt to champions below 20% Health by 5%",
					"Increases damage dealt to champions below 35% Health by 5%",
					"Increases damage dealt to champions below 50% Health by 5%"],
					"image": {
						"full": "4134.png",
						"sprite": "mastery0.png",
						"group": "gray_mastery",
						"x": 48,
						"y": 48,
						"w": 48,
						"h": 48
					},
					"ranks": 3,
					"prereq": "0"
				},
				"4141": {
					"id": 4141,
					"name": "Blade Weaving",
					"description": ["Damaging an enemy champion with a spell increases Basic Attack Damage by 1%, stacking up to 3 times (max 3% damage increase)"],
					"image": {
						"full": "4141.png",
						"sprite": "mastery0.png",
						"group": "gray_mastery",
						"x": 96,
						"y": 48,
						"w": 48,
						"h": 48
					},
					"ranks": 1,
					"prereq": "4131"
				},
				"4142": {
					"id": 4142,
					"name": "Warlord",
					"description": ["Increases bonus Attack Damage by 2%",
					"Increases Bonus Attack Damage by 3.5%",
					"Increases Bonus Attack Damage by 5%"],
					"image": {
						"full": "4142.png",
						"sprite": "mastery0.png",
						"group": "gray_mastery",
						"x": 144,
						"y": 48,
						"w": 48,
						"h": 48
					},
					"ranks": 3,
					"prereq": "0"
				},
				"4143": {
					"id": 4143,
					"name": "Archmage",
					"description": ["Increases Ability Power by 2%",
					"Increases Ability Power by 3.5%",
					"Increases Ability Power by 5%"],
					"image": {
						"full": "4143.png",
						"sprite": "mastery0.png",
						"group": "gray_mastery",
						"x": 192,
						"y": 48,
						"w": 48,
						"h": 48
					},
					"ranks": 3,
					"prereq": "0"
				},
				"4144": {
					"id": 4144,
					"name": "Dangerous Game",
					"description": ["Champion kills and assists restore 5% missing Health and Mana"],
					"image": {
						"full": "4144.png",
						"sprite": "mastery0.png",
						"group": "gray_mastery",
						"x": 240,
						"y": 48,
						"w": 48,
						"h": 48
					},
					"ranks": 1,
					"prereq": "4134"
				},
				"4151": {
					"id": 4151,
					"name": "Frenzy",
					"description": ["Critical hits grant +5% Attack Speed for 3 seconds (stacks up to 3 times)"],
					"image": {
						"full": "4151.png",
						"sprite": "mastery0.png",
						"group": "gray_mastery",
						"x": 288,
						"y": 48,
						"w": 48,
						"h": 48
					},
					"ranks": 1,
					"prereq": "0"
				},
				"4152": {
					"id": 4152,
					"name": "Devastating Strikes",
					"description": ["+2% Armor and Magic Penetration",
					"+4% Armor and Magic Penetration",
					"+6% Armor and Magic Penetration"],
					"image": {
						"full": "4152.png",
						"sprite": "mastery0.png",
						"group": "gray_mastery",
						"x": 336,
						"y": 48,
						"w": 48,
						"h": 48
					},
					"ranks": 3,
					"prereq": "0"
				},
				"4154": {
					"id": 4154,
					"name": "Arcane Blade",
					"description": ["Basic Attacks also deal bonus magic damage equal to 5% of Ability Power"],
					"image": {
						"full": "4154.png",
						"sprite": "mastery0.png",
						"group": "gray_mastery",
						"x": 384,
						"y": 48,
						"w": 48,
						"h": 48
					},
					"ranks": 1,
					"prereq": "0"
				},
				"4162": {
					"id": 4162,
					"name": "Havoc",
					"description": ["+3% increased damage"],
					"image": {
						"full": "4162.png",
						"sprite": "mastery0.png",
						"group": "gray_mastery",
						"x": 432,
						"y": 48,
						"w": 48,
						"h": 48
					},
					"ranks": 1,
					"prereq": "0"
				},
				"4211": {
					"id": 4211,
					"name": "Block",
					"description": ["Reduces incoming damage from champion basic attacks by 1",
					"Reduces incoming damage from champion basic attacks by 2"],
					"image": {
						"full": "4211.png",
						"sprite": "mastery0.png",
						"group": "gray_mastery",
						"x": 0,
						"y": 96,
						"w": 48,
						"h": 48
					},
					"ranks": 2,
					"prereq": "0"
				},
				"4212": {
					"id": 4212,
					"name": "Recovery",
					"description": ["+1 Health per 5 seconds",
					"+2 Health per 5 seconds"],
					"image": {
						"full": "4212.png",
						"sprite": "mastery0.png",
						"group": "gray_mastery",
						"x": 48,
						"y": 96,
						"w": 48,
						"h": 48
					},
					"ranks": 2,
					"prereq": "0"
				},
				"4213": {
					"id": 4213,
					"name": "Enchanted Armor",
					"description": ["Increases bonus Armor and Magic Resist by 2.5%",
					"Increases bonus Armor and Magic Resist by 5%"],
					"image": {
						"full": "4213.png",
						"sprite": "mastery0.png",
						"group": "gray_mastery",
						"x": 96,
						"y": 96,
						"w": 48,
						"h": 48
					},
					"ranks": 2,
					"prereq": "0"
				},
				"4214": {
					"id": 4214,
					"name": "Tough Skin",
					"description": ["Reduces damage taken from neutral monsters by 1<br><br>This does not affect lane minions",
					"Reduces damage taken from neutral monsters by 2<br><br>This does not affect lane minions"],
					"image": {
						"full": "4214.png",
						"sprite": "mastery0.png",
						"group": "gray_mastery",
						"x": 144,
						"y": 96,
						"w": 48,
						"h": 48
					},
					"ranks": 2,
					"prereq": "0"
				},
				"4221": {
					"id": 4221,
					"name": "Unyielding",
					"description": ["Melee - Reduces all incoming damage from champions by 2<br>Ranged - Reduces all incoming damage from champions by 1"],
					"image": {
						"full": "4221.png",
						"sprite": "mastery0.png",
						"group": "gray_mastery",
						"x": 192,
						"y": 96,
						"w": 48,
						"h": 48
					},
					"ranks": 1,
					"prereq": "4211"
				},
				"4222": {
					"id": 4222,
					"name": "Veteran&#39;s Scars",
					"description": ["+12 Health",
					"+24 Health",
					"+36 Health"],
					"image": {
						"full": "4222.png",
						"sprite": "mastery0.png",
						"group": "gray_mastery",
						"x": 240,
						"y": 96,
						"w": 48,
						"h": 48
					},
					"ranks": 3,
					"prereq": "0"
				},
				"4224": {
					"id": 4224,
					"name": "Bladed Armor",
					"description": ["Taking Basic Attack Damage from neutral monsters cause them to bleed, dealing physical damage equal to 1% of their current Health each second<br>This does not work against lane minions"],
					"image": {
						"full": "4224.png",
						"sprite": "mastery0.png",
						"group": "gray_mastery",
						"x": 288,
						"y": 96,
						"w": 48,
						"h": 48
					},
					"ranks": 1,
					"prereq": "4214"
				},
				"4231": {
					"id": 4231,
					"name": "Oppression",
					"description": ["Reduces damage taken by 3% from enemies that have impaired movement (slows, snares, taunts, stuns, etc.)"],
					"image": {
						"full": "4231.png",
						"sprite": "mastery0.png",
						"group": "gray_mastery",
						"x": 336,
						"y": 96,
						"w": 48,
						"h": 48
					},
					"ranks": 1,
					"prereq": "0"
				},
				"4232": {
					"id": 4232,
					"name": "Juggernaut",
					"description": ["+3% Maximum Health"],
					"image": {
						"full": "4232.png",
						"sprite": "mastery0.png",
						"group": "gray_mastery",
						"x": 384,
						"y": 96,
						"w": 48,
						"h": 48
					},
					"ranks": 1,
					"prereq": "4222"
				},
				"4233": {
					"id": 4233,
					"name": "Hardiness",
					"description": ["+2 Armor",
					"+3.5 Armor",
					"+5 Armor"],
					"image": {
						"full": "4233.png",
						"sprite": "mastery0.png",
						"group": "gray_mastery",
						"x": 432,
						"y": 96,
						"w": 48,
						"h": 48
					},
					"ranks": 3,
					"prereq": "0"
				},
				"4234": {
					"id": 4234,
					"name": "Resistance",
					"description": ["+2 Magic Resist",
					"+3.5 Magic Resist",
					"+5 Magic Resist"],
					"image": {
						"full": "4234.png",
						"sprite": "mastery0.png",
						"group": "gray_mastery",
						"x": 0,
						"y": 144,
						"w": 48,
						"h": 48
					},
					"ranks": 3,
					"prereq": "0"
				},
				"4241": {
					"id": 4241,
					"name": "Perseverance ",
					"description": ["Regenerates 0.35% of missing Health every 5 seconds",
					"Regenerates 0.675% of missing Health every 5 seconds",
					"Regenerates 1% of missing Health every 5 seconds"],
					"image": {
						"full": "4241.png",
						"sprite": "mastery0.png",
						"group": "gray_mastery",
						"x": 48,
						"y": 144,
						"w": 48,
						"h": 48
					},
					"ranks": 3,
					"prereq": "0"
				},
				"4242": {
					"id": 4242,
					"name": "Swiftness",
					"description": ["Reduces the effectiveness of slows by 10%"],
					"image": {
						"full": "4242.png",
						"sprite": "mastery0.png",
						"group": "gray_mastery",
						"x": 96,
						"y": 144,
						"w": 48,
						"h": 48
					},
					"ranks": 1,
					"prereq": "0"
				},
				"4243": {
					"id": 4243,
					"name": "Reinforced Armor",
					"description": ["Reduces the total damage taken from critical strikes by 10%"],
					"image": {
						"full": "4243.png",
						"sprite": "mastery0.png",
						"group": "gray_mastery",
						"x": 144,
						"y": 144,
						"w": 48,
						"h": 48
					},
					"ranks": 1,
					"prereq": "4233"
				},
				"4244": {
					"id": 4244,
					"name": "Evasive",
					"description": ["Reduces damage taken by 4% from Area of Effect magic damage"],
					"image": {
						"full": "4244.png",
						"sprite": "mastery0.png",
						"group": "gray_mastery",
						"x": 192,
						"y": 144,
						"w": 48,
						"h": 48
					},
					"ranks": 1,
					"prereq": "4234"
				},
				"4251": {
					"id": 4251,
					"name": "Second Wind",
					"description": ["Increases self-healing, Health Regen, Lifesteal, and Spellvamp by 10% when below 25% Health"],
					"image": {
						"full": "4251.png",
						"sprite": "mastery0.png",
						"group": "gray_mastery",
						"x": 240,
						"y": 144,
						"w": 48,
						"h": 48
					},
					"ranks": 1,
					"prereq": "4241"
				},
				"4252": {
					"id": 4252,
					"name": "Legendary Guardian",
					"description": ["+1 Armor and 0.5 Magic Resist for each nearby enemy champion",
					"+2 Armor and 1 Magic Resist for each nearby enemy champion",
					"+3 Armor and 1.5 Magic Resist for each nearby enemy champion",
					"+4 Armor and 2 Magic Resist for each nearby enemy champion"],
					"image": {
						"full": "4252.png",
						"sprite": "mastery0.png",
						"group": "gray_mastery",
						"x": 288,
						"y": 144,
						"w": 48,
						"h": 48
					},
					"ranks": 4,
					"prereq": "0"
				},
				"4253": {
					"id": 4253,
					"name": "Runic Blessing",
					"description": ["Start the game with a 50 Health shield. This shield regenerates each time after respawning"],
					"image": {
						"full": "4253.png",
						"sprite": "mastery0.png",
						"group": "gray_mastery",
						"x": 336,
						"y": 144,
						"w": 48,
						"h": 48
					},
					"ranks": 1,
					"prereq": "0"
				},
				"4262": {
					"id": 4262,
					"name": "Tenacious",
					"description": ["Reduces the duration of crowd control effects by 15%"],
					"image": {
						"full": "4262.png",
						"sprite": "mastery0.png",
						"group": "gray_mastery",
						"x": 384,
						"y": 144,
						"w": 48,
						"h": 48
					},
					"ranks": 1,
					"prereq": "0"
				},
				"4311": {
					"id": 4311,
					"name": "Phasewalker",
					"description": ["Reduces the casting time of Recall by 1 second<br><br>Dominion - Reduces the casting time of Enhanced Recall by 0.5 seconds"],
					"image": {
						"full": "4311.png",
						"sprite": "mastery0.png",
						"group": "gray_mastery",
						"x": 432,
						"y": 144,
						"w": 48,
						"h": 48
					},
					"ranks": 1,
					"prereq": "0"
				},
				"4312": {
					"id": 4312,
					"name": "Fleet of Foot",
					"description": ["+0.5% Movement Speed",
					"+1% Movement Speed",
					"+1.5% Movement Speed"],
					"image": {
						"full": "4312.png",
						"sprite": "mastery0.png",
						"group": "gray_mastery",
						"x": 0,
						"y": 192,
						"w": 48,
						"h": 48
					},
					"ranks": 3,
					"prereq": "0"
				},
				"4313": {
					"id": 4313,
					"name": "Meditation",
					"description": ["+1 Mana Regen per 5 seconds",
					"+2 Mana Regen per 5 seconds",
					"+3 Mana Regen per 5 seconds"],
					"image": {
						"full": "4313.png",
						"sprite": "mastery0.png",
						"group": "gray_mastery",
						"x": 48,
						"y": 192,
						"w": 48,
						"h": 48
					},
					"ranks": 3,
					"prereq": "0"
				},
				"4314": {
					"id": 4314,
					"name": "Scout",
					"description": ["Increases the cast range of trinket items by 15%"],
					"image": {
						"full": "4314.png",
						"sprite": "mastery0.png",
						"group": "gray_mastery",
						"x": 96,
						"y": 192,
						"w": 48,
						"h": 48
					},
					"ranks": 1,
					"prereq": "0"
				},
				"4322": {
					"id": 4322,
					"name": "Summoner&#39;s Insight",
					"description": ["Reduces the cooldown of Summoner Spells by 4%",
					"Reduces the cooldown of Summoner Spells by 7%",
					"Reduces the cooldown of Summoner Spells by 10%"],
					"image": {
						"full": "4322.png",
						"sprite": "mastery0.png",
						"group": "gray_mastery",
						"x": 144,
						"y": 192,
						"w": 48,
						"h": 48
					},
					"ranks": 3,
					"prereq": "0"
				},
				"4323": {
					"id": 4323,
					"name": "Strength of Spirit",
					"description": ["+1 Health Regen per 5 seconds for every 300 maximum Mana"],
					"image": {
						"full": "4323.png",
						"sprite": "mastery0.png",
						"group": "gray_mastery",
						"x": 192,
						"y": 192,
						"w": 48,
						"h": 48
					},
					"ranks": 1,
					"prereq": "4313"
				},
				"4324": {
					"id": 4324,
					"name": "Alchemist",
					"description": ["Increases the duration of potions and elixirs by 10%"],
					"image": {
						"full": "4324.png",
						"sprite": "mastery0.png",
						"group": "gray_mastery",
						"x": 240,
						"y": 192,
						"w": 48,
						"h": 48
					},
					"ranks": 1,
					"prereq": "0"
				},
				"4331": {
					"id": 4331,
					"name": "Greed",
					"description": ["+0.5 Gold every 10 seconds",
					"+1 Gold every 10 seconds",
					"+1.5 Gold every 10 seconds"],
					"image": {
						"full": "4331.png",
						"sprite": "mastery0.png",
						"group": "gray_mastery",
						"x": 288,
						"y": 192,
						"w": 48,
						"h": 48
					},
					"ranks": 3,
					"prereq": "0"
				},
				"4332": {
					"id": 4332,
					"name": "Runic Affinity",
					"description": ["Increases the duration of shrine, relic, quest, and neutral monster buffs by 20%"],
					"image": {
						"full": "4332.png",
						"sprite": "mastery0.png",
						"group": "gray_mastery",
						"x": 336,
						"y": 192,
						"w": 48,
						"h": 48
					},
					"ranks": 1,
					"prereq": "0"
				},
				"4333": {
					"id": 4333,
					"name": "Vampirism",
					"description": ["+1% Lifesteal and Spellvamp",
					"+2% Lifesteal and Spellvamp",
					"+3% Lifesteal and Spellvamp"],
					"image": {
						"full": "4333.png",
						"sprite": "mastery0.png",
						"group": "gray_mastery",
						"x": 384,
						"y": 192,
						"w": 48,
						"h": 48
					},
					"ranks": 3,
					"prereq": "0"
				},
				"4334": {
					"id": 4334,
					"name": "Culinary Master",
					"description": ["Health potions are upgraded into Biscuits that restore an additional 20 Health and 10 Mana instantly upon consumption"],
					"image": {
						"full": "4334.png",
						"sprite": "mastery0.png",
						"group": "gray_mastery",
						"x": 432,
						"y": 192,
						"w": 48,
						"h": 48
					},
					"ranks": 1,
					"prereq": "4324"
				},
				"4341": {
					"id": 4341,
					"name": "Scavenger",
					"description": ["+1 Gold each time an ally kills a nearby lane minion"],
					"image": {
						"full": "4341.png",
						"sprite": "mastery0.png",
						"group": "gray_mastery",
						"x": 0,
						"y": 240,
						"w": 48,
						"h": 48
					},
					"ranks": 1,
					"prereq": "4331"
				},
				"4342": {
					"id": 4342,
					"name": "Wealth",
					"description": ["+40 Starting Gold"],
					"image": {
						"full": "4342.png",
						"sprite": "mastery0.png",
						"group": "gray_mastery",
						"x": 48,
						"y": 240,
						"w": 48,
						"h": 48
					},
					"ranks": 1,
					"prereq": "0"
				},
				"4343": {
					"id": 4343,
					"name": "Expanded Mind",
					"description": ["+2% increased maximum Mana",
					"+3.5% increased maximum Mana",
					"+5% increased maximum Mana"],
					"image": {
						"full": "4343.png",
						"sprite": "mastery0.png",
						"group": "gray_mastery",
						"x": 96,
						"y": 240,
						"w": 48,
						"h": 48
					},
					"ranks": 3,
					"prereq": "0"
				},
				"4344": {
					"id": 4344,
					"name": "Inspiration",
					"description": ["+5 Experience every 10 seconds while near a higher level allied champion",
					"+10 Experience every 10 seconds while near a higher level allied champion"],
					"image": {
						"full": "4344.png",
						"sprite": "mastery0.png",
						"group": "gray_mastery",
						"x": 144,
						"y": 240,
						"w": 48,
						"h": 48
					},
					"ranks": 2,
					"prereq": "0"
				},
				"4352": {
					"id": 4352,
					"name": "Bandit",
					"description": ["Melee - Grants +15 Gold on champion kill or assist<br>Ranged - Grants +3 Gold each time an enemy champion is attacked. This cannot trigger on the same champion more than once every 5 seconds"],
					"image": {
						"full": "4352.png",
						"sprite": "mastery0.png",
						"group": "gray_mastery",
						"x": 192,
						"y": 240,
						"w": 48,
						"h": 48
					},
					"ranks": 1,
					"prereq": "4342"
				},
				"4353": {
					"id": 4353,
					"name": "Intelligence",
					"description": ["+2% Cooldown Reduction and reduces the cooldown of Activated Items by 4%",
					"+3.5% Cooldown Reduction and reduces the cooldown of Activated Items by 7%",
					"+5% Cooldown Reduction and reduces the cooldown of Activated Items by 10%"],
					"image": {
						"full": "4353.png",
						"sprite": "mastery0.png",
						"group": "gray_mastery",
						"x": 240,
						"y": 240,
						"w": 48,
						"h": 48
					},
					"ranks": 3,
					"prereq": "0"
				},
				"4362": {
					"id": 4362,
					"name": "Wanderer",
					"description": ["+5% Movement Speed out of combat"],
					"image": {
						"full": "4362.png",
						"sprite": "mastery0.png",
						"group": "gray_mastery",
						"x": 288,
						"y": 240,
						"w": 48,
						"h": 48
					},
					"ranks": 1,
					"prereq": "0"
				}
			}
		}';
		$masterieslist = json_decode($data);
		foreach ($masterieslist->data as $key => $value){
			$this->{$key}->id=$value->id;
			$this->{$key}->name=$value->name;
			$this->{$key}->description=$value->description;
			$this->{$key}->imageX=$value->image->x;
			$this->{$key}->imageY=$value->image->y;
		}      
    }
}
?>