<?php
if (isset($_POST)){
	new LeaguesLevels();
}
exit;

class LeaguesLevels
{
	public function __construct() {  
		$this->listIDsarray	=$_POST[ids];
		$this->listIDs=implode (",",$this->listIDsarray );
		//echo $this->listIDsarray;
		//echo $this->listIDs;
		$this->server		=$_POST[server];
		//$explodinIntoObjects=explode (',', $this->listIDs);
		$this->player=new stdClass();
		for ($i = 0; $i <= 9; $i++) {			
			$this->player->$i=new stdClass();
			#$this->player->$i->id=new stdClass();
			$this->player->$i->id=$this->listIDsarray[$i];
		}
		$this->riotapirequest();
		$this->output();
		#print_r($this);
	}

	private function riotapirequest() {
		$key			="377050fe-b182-4796-bf4c-efdaf944278d";
		$req1			=@file_get_contents('https://'.$this->server.'.api.pvp.net:443/api/lol/'.$this->server.'/v1.4/summoner/'.$this->listIDs.'?api_key='.$key);
		$summonerByName	=json_decode ($req1,true);
		$tries=0;
		do{		
		$req2			=@file_get_contents('https://'.$this->server.'.api.pvp.net:443/api/lol/'.$this->server.'/v2.5/league/by-summoner/'.$this->listIDs.'/entry?api_key='.$key);
		$tries++;
		}while ((strrpos ( $http_response_header[0] , '200')==false)&&($tries<5));		
		$leagueBySummoner=json_decode ($req2,true);
		
		foreach ($this->player as $playernumber) {
			$playernumber->level	=$summonerByName[$playernumber->id][summonerLevel];
			$playernumber->league	=$leagueBySummoner[$playernumber->id][0][tier];
			$playernumber->queue	=$leagueBySummoner[$playernumber->id][0][queue];
			$playernumber->division	=$leagueBySummoner[$playernumber->id][0][entries][0][division];
			if ($playernumber->level<30){
				$playernumber->output='<div class="level">Level '.$playernumber->level.'</div>';
			}else{
				if (isset($playernumber->league) && ($playernumber->queue=='RANKED_SOLO_5x5')){
					$playernumber->output='<div class="rank" style="background:url(icons/'.$playernumber->league.'_I.png);background-size: 100% auto;"></div><div class="division">'.$playernumber->division.'</div>';
				}else{
					$playernumber->output='<div class="rank" style="background:url(icons/unknown.png);background-size: 100% auto;"></div>';
				}		
			}
		}
	}
	private function output() {
		echo <<<EOL
		<script>			
			$(document).ready(function() {		
			$("#"+{$this->player->{0}->id}).append('{$this->player->{0}->output}');
			$("#"+{$this->player->{1}->id}).append('{$this->player->{1}->output}');
			$("#"+{$this->player->{2}->id}).append('{$this->player->{2}->output}');
			$("#"+{$this->player->{3}->id}).append('{$this->player->{3}->output}');
			$("#"+{$this->player->{4}->id}).append('{$this->player->{4}->output}');
			$("#"+{$this->player->{5}->id}).append('{$this->player->{5}->output}');
			$("#"+{$this->player->{6}->id}).append('{$this->player->{6}->output}');
			$("#"+{$this->player->{7}->id}).append('{$this->player->{7}->output}');
			$("#"+{$this->player->{8}->id}).append('{$this->player->{8}->output}');
			$("#"+{$this->player->{9}->id}).append('{$this->player->{9}->output}');  
		  });
		</script>
EOL;
	}
}
?>