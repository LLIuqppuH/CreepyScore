<?php
/*
$_POST["name"]="Action Svensei";
$_POST["server"]="euw";
$_POST["summonerId"]=21960917;
$_POST["champ"]=8;
$_POST["champNumber"]=111;*/

if (isset($_POST)){
	new PlayerInfo();
}
exit;
#http://localhost/lol/performance.php?champ=412&server=tr&summonerId=3516675&name=hyperactiveq&champNumber=96
class PlayerInfo
{
	public function __construct() {  
		//$this->name=$_POST["name"];
		//$this->server=$_POST["server"];
		$this->summonerId=$_POST["summonerId"];
		//$this->champ=$_POST["champ"];
		//$this->champNumber=$_POST["champNumber"];	   
		$this->RiotApiRequest();
		if (isset($this->k)){
			$this->CompareToAverage();
			$this->output();
		}
   }
   private function RiotApiRequest() {
		$key="377050fe-b182-4796-bf4c-efdaf944278d";
		$req = @file_get_contents('https://'.$_POST["server"].'.api.pvp.net:443/api/lol/'.$_POST["server"].'/v1.3/stats/by-summoner/'.$this->summonerId.'/ranked?season=SEASON2015&api_key='.$key);
		$statsBySummoner=json_decode ($req);
		if (isset($statsBySummoner->champions)){
			foreach ($statsBySummoner->champions as $value) {
				if ($value->id==$_POST["champ"]) {				
					$this->played=$value->stats->totalSessionsPlayed;
					if ($this->played>0){
						$this->won		=$value->stats->totalSessionsWon;
						$this->winrate	=number_format($this->won/$this->played*100,1);
						$this->k	=number_format($value->stats->totalChampionKills/$value->stats->totalSessionsPlayed,1);
						$this->d	=number_format($value->stats->totalDeathsPerSession/$value->stats->totalSessionsPlayed,1);
						$this->a	=number_format($value->stats->totalAssists/$value->stats->totalSessionsPlayed,1);	
						$this->cs		=number_format($value->stats->totalMinionKills/$value->stats->totalSessionsPlayed,0);	
						//$this->gold		=str_replace(",","",number_format($value->stats->totalGoldEarned/$value->stats->totalSessionsPlayed,0));	
						$this->gold		=number_format($value->stats->totalGoldEarned/$value->stats->totalSessionsPlayed,0,".","");
					}	
				}
			}
		}
	}
	private function CompareToAverage() {
		if (isset($this->k)){
			$averagestats		=json_decode ($this->AverageChampStatsJSONString(),true);
			//print_r($averagestats);
			$this->kD		=$this->k-$averagestats[$_POST["champNumber"]][1];
			$this->dD		=$this->d-$averagestats[$_POST["champNumber"]][2];
			$this->aD		=$this->a-$averagestats[$_POST["champNumber"]][3];
			$this->csD		=$this->cs-$averagestats[$_POST["champNumber"]][4];	
			$this->goldD	=$this->gold-$averagestats[$_POST["champNumber"]][5];
			if ($this->kD>0)	{$this->kD		='+'.$this->kD;}
			if ($this->dD>0)	{$this->dD		='+'.$this->dD;}
			if ($this->aD>0)	{$this->aD		='+'.$this->aD;}
			if ($this->csD>0)	{$this->csD		='+'.$this->csD;}
			$this->gold		=number_format($this->gold/1000,1);
			$this->goldD	=number_format($this->goldD/1000,1);
			if ($this->goldD>0)	{$this->goldD	='+'.$this->goldD;}
			//$this->gold.="k";
			//$this->goldD.="k";
		}
	}
	private function output() {
		echo json_encode($this);
		/*echo <<<EOL
			<tr><th colspan="2">Performance:</th></tr>
			<tr class="tooltip" title="{$this->name} has won {$this->won} out of {$this->played} ranked games. That's a winrate of {$this->winrate}.">
			<td>Games:</td>
			<td class="stat red">{$this->won} / {$this->played} <span class="small">({$this->winrate})</span></td>
			</tr>
			<tr class="tooltip" title="On average {$this->name} has killed 8.9 enemy champions per game. That's {$this->kD} than the average player's kills per game.">
			<td>Kills:</td>
			<td class="stat green">{$this->k} <span class="small">({$this->kD})</span></td>
			</tr>
			<tr class="tooltip" title="On average {$this->name} has died {$this->d} times per game. That's {$this->dD} than the average player's deaths per game.">
			<td>Deaths:</td>
			<td class="stat yellow">{$this->d} <span class="small">({$this->dD})</span></td>
			</tr>
			<tr class="tooltip" title="On average {$this->name} has had {$this->a} assists per game. That's {$this->aD} than the average player's assists per game.">
			<td>Assists:</td>
			<td class="stat green">{$this->a} <span class="small">({$this->aD})</span></td>
			</tr>
			<tr class="tooltip" title="On average {$this->name} has slain {$this->cs} minions per game. That's {$this->csD} than the average player's creep score per game.">
			<td>CS:</td>
			<td class="stat red">{$this->cs} <span class="small">({$this->csD})</span></td>
			</tr>
			<tr class="tooltip" title="On average {$this->name} has earned {$this->gold} gold per game. That's {$this->goldD} than the average player's gold earned per game.">
			<td>Gold:</td>
			<td class="stat yellow">{$this->gold} <span class="small">({$this->goldD})</span></td>
			</tr>
EOL;*/
	}
	private function AverageChampStatsJSONString(){
		$returndata='[["aatrox",6.3,6.1,7.7,148,12222],["ahri",7.7,6.1,8.7,166,12098],["akali",10.2,8.2,6.5,129,11878],["alistar",1.7,5.8,14.7,45,9189],["amumu",5,5.8,12.5,51,11956],["anivia",7.4,5.3,8.9,169,12392],["annie",7.1,7,9.4,116,11418],["ashe",7.7,7.3,10.2,175,13441],["azir",6.5,7.5,8.1,172,11937],["bard",1.7,7.1,12.1,20,8564],["blitzcrank",2.6,6.4,14.3,36,9640],["brand",8.1,7.3,9.3,136,11960],["braum",1.7,6.1,15.9,42,9244],["caitlyn",7.2,6.2,8.3,200,13045],["cassiopeia",7.8,7.1,7.3,168,12149],["chogath",6.9,5.4,7.6,175,12471],["corki",8.2,5.8,8.4,202,13277],["darius",8.3,7.2,6.7,172,12371],["diana",9.2,7.1,7.6,141,12630],["draven",8.7,7.1,7.6,184,13992],["drmundo",4.9,5.7,9.1,146,11403],["elise",5.9,7,8.2,60,11299],["evelynn",7.3,6.7,9.2,55,11962],["ezreal",8,5.8,9,185,12860],["fiddlesticks",5.8,7,10.3,53,11402],["fiora",9.2,7.8,5.9,169,12861],["fizz",9,7,6.6,101,12273],["galio",5.2,6.3,12,150,11651],["gangplank",6.9,6.5,11.1,177,13470],["garen",7.1,5.5,7.2,167,11945],["gnar",5.9,6.4,8.6,173,11825],["gragas",5.5,6.3,9.5,101,11200],["graves",8.4,6,7.8,209,13475],["hecarim",7.2,6,9.2,120,12486],["heimerdinger",6.2,7,8,177,12161],["irelia",7.6,5.9,7.1,185,12415],["janna",1,4.9,16,15,9253],["jarvaniv",5.6,6.5,12.9,69,11790],["jax",6.8,7.3,6.4,145,12100],["jayce",7.5,6.9,7.8,175,12266],["jinx",8.6,6.6,8.5,196,13387],["kalista",7.9,6.9,7.7,191,12804],["karma",3.4,6.5,12.8,66,10487],["karthus",8.5,7.6,9.8,188,13376],["kassadin",7.8,6.5,7.1,149,11445],["katarina",10.6,7,7.7,161,12594],["kayle",5.6,6.6,9.2,146,11763],["kennen",6.6,6.3,7.9,171,11798],["khazix",7.9,6.9,7.2,71,12197],["kogmaw",8.1,6.9,8.6,179,12943],["leblanc",9.7,6.4,6.9,138,11851],["leesin",6.7,7,10,57,11593],["leona",2.2,6.2,15,45,9398],["lissandra",6.1,6.8,9.2,188,12201],["lucian",7.8,6.4,7.6,207,13265],["lulu",2.7,5.8,13.3,68,10206],["lux",6.7,6.1,11,129,11597],["malphite",5,5.4,11.2,114,11158],["malzahar",7.5,6.4,8.4,177,12541],["maokai",4.6,6,11.1,135,11412],["masteryi",8.8,8.3,6.1,99,13403],["missfortune",8.7,7.1,8.9,184,13276],["mordekaiser",7.1,7.3,7.3,190,12553],["morgana",3.4,6.4,13.7,61,10500],["nami",1.7,5.7,16.4,15,9728],["nasus",5.8,5.6,7.1,196,12403],["nautilus",4.1,5.4,12.9,54,11115],["nidalee",8.2,6.8,7.7,95,11960],["nocturne",6.8,6.8,8.3,77,12541],["nunu",4.1,6,12,60,10978],["olaf",6.5,7.3,7.3,133,11837],["orianna",6.4,6.1,10.2,178,12233],["pantheon",8,7.1,8.2,99,11731],["poppy",7.6,6.5,6.4,108,11782],["quinn",9,7.3,7.2,180,13025],["rammus",4.4,6.3,12.7,52,11252],["reksai",5.9,6.2,9.8,60,11903],["renekton",5.6,5.8,8.1,200,12271],["rengar",7.9,7.3,7.5,93,12482],["riven",8.4,6.9,5.9,188,12820],["rumble",6.8,6.4,8.9,158,11616],["ryze",6.3,7.2,7.7,154,11503],["sejuani",5.6,5,12.6,56,12313],["shaco",7.8,6.8,7.9,68,12479],["shen",4.1,5.3,12.1,131,11018],["shyvana",5.7,5.6,8.5,130,12777],["singed",4.4,6.8,9.1,202,12108],["sion",5.2,5.5,10.7,161,12095],["sivir",7.3,6.1,9.7,211,13481],["skarner",5.7,5.5,11.3,57,12068],["sona",3,6.5,15.4,23,10070],["soraka",1.3,5.9,15.5,22,9229],["swain",7.9,6.3,8.6,139,11556],["syndra",8.2,7.2,7.2,178,12435],["talon",10.1,8.1,7.9,168,13054],["taric",1.9,5.8,15.4,46,9393],["teemo",6.9,7.7,7.6,158,12114],["thresh",2,6.4,15.3,33,9183],["tristana",7.9,6.4,7.1,187,12745],["trundle",5.3,6,8.7,129,11720],["tryndamere",7.1,6.9,6,177,13147],["twistedfate",7.6,7.4,8.7,164,12944],["twitch",8.6,7.4,7.6,162,12515],["udyr",5.8,5.9,8,68,12467],["urgot",6.6,6.8,7.3,161,11598],["varus",8.3,7.1,8.9,188,13169],["vayne",8.7,7.2,6.8,184,12917],["veigar",7.2,7.3,8,153,11805],["velkoz",6.6,6.7,10.4,122,11715],["vi",6.3,6.5,9.4,50,11877],["viktor",7.9,6.8,7.7,187,12597],["vladimir",6.9,7,7.4,193,12412],["volibear",6.6,6.1,10.3,81,11487],["warwick",5.8,6.4,10.2,53,11862],["wukong",7.3,6.3,8.6,123,12393],["xerath",7.5,6,8.9,173,12265],["xinzhao",6.8,7.5,9,63,11838],["yasuo",8.4,8.7,7.2,192,13069],["yorick",5.5,6.3,8.5,155,11598],["zac",5.1,5.1,11.4,78,11646],["zed",9,7.3,6.3,185,12861],["ziggs",6.9,6.4,9.1,179,12439],["zilean",2.4,6.5,12.1,54,9694]]';	
		return $returndata;
	}   
}
?>