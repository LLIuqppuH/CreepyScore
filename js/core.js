$(document).ready(function() {

if (typeof(Storage) != "undefined") {
lastsearch=JSON.parse(localStorage.getItem("lastsearch"));
$("#name-search").attr( "value", lastsearch.name );
$("#"+lastsearch.region).attr( "checked","checked" );
}
});

$("form").submit(function (event){	
	event.preventDefault();	
	//console.log(timer=Date.now());
	$('#submitButton').val("Checking...");
	var str = $( "form" ).serializeArray();
	if ((str[0]["value"].indexOf("maxrengar")>-1)||(str[0]["value"].indexOf("sofky")>-1)){
		$('html, body').css('background-image', 'url("http://i.imgbox.com/aYRcvxHf.jpg")');
		$('html, body').css('background-size', 'contain');
	}
	$.post("main.php",str,function( data ) {		
		$('#submitButton').val("OKAY");
		var fill=JSON.parse(data);
		//$("#otvet").append(data);		
		if (fill[0]['result']=='OK')
		{	
			$("#contact").css("display", "block");	
			$("#contact").trigger("click");				
			$("#gamePage").css("display", "block");	

			$('#nameserver').html(fill[0]['name']+" @"+fill[0]['server']);
			
			currentGame=new CurrentGame(fill);
			currentGame.init(fill);			

			$("<div>", {class: 'grad'}).appendTo($gamecard);
			
			$( "#scr" ). load( "progress.php", { server: fill[0]['server'], ids: fill[0]['allIDs']} );
			if (typeof(Storage) != "undefined") {localStorage.setItem("lastsearch",fill[0]['localstorage']);}
			//console.log(Date.now()-timer);
		}else{
			$("#name-search").val('');
			$("#name-search").attr('placeholder',fill[0]['result']);
		}
	});	
	return false;
});


function CurrentGame(fill){
	
	this.init = function(fill) {
		this.clearPage(fill);
		$.each(fill[0]['allIDs'], function( index ) {
			$("<div>", {
				class:	'gamecard',
				id:	fill[0]['allIDs'][index],
				})
			.appendTo('#gameCards');
		});
		$gamecard=$('.gamecard');
		this.basicInfo(fill);
		this.addRunes(fill);
		this.addMasteries(fill);
	}
	
	
	this.basicInfo = function(fill) {
		$gamecard.each(function (index){
			id=this.id;
			
			$("<div>", {
				class:	'summonername',
				text:	fill[this.id]['summonerName']
				})
			.appendTo($gamecard[index]);
			
			$.ajax({
				type:	"POST",
				url: 	"performance.php",
				data: 	{ server: fill[0]['server'], summonerId: id, champ: fill[id]['champ'],
						champNumber: fill[id]['champInfo']['number'], name: fill[id]['summonerName'] }
			}).done(function(data) {
				console.log(data);
				if (data.length>1){
					var stats=JSON.parse(data);
					var tabledata='<tr><th colspan="3">Performance:</th></tr><tr class="dark"><td>K</td><td>D</td><td>A</td></tr><tr class="big"><td class="'+((stats.kD<-1.99)?'fail':((stats.kD>1.99)?'good':''))+'">'+stats.k+'</td><td class='+((stats.dD<-1.49)?'good':((stats.dD>1.49)?'fail':''))+'>'+stats.d+'</td><td class='+((stats.aD<-1.99)?'fail':((stats.aD>1.99)?'good':''))+'>'+stats.a+'</td></tr><tr class="splitter"><td>'+stats.kD+'</td><td>'+stats.dD+'</td><td>'+stats.aD+'</td></tr><tr class="dark"><td>Winrate</td><td>Cs</td><td>Gold</td></tr><tr class="big"><td class='+((stats.winrate<50)?'fail':((stats.winrate>54.99)?'good':''))+'>'+stats.won+'/'+stats.played+'</td><td class='+((stats.csD<-19.9)?'fail':((stats.csD>19.9)?'good':''))+'>'+stats.cs+'</td><td class='+((stats.goldD<-1.49)?'fail':((stats.goldD>1.49)?'good':''))+'>'+stats.gold+'k</td></tr><tr class="splitter"><td>'+stats.winrate+'%</td><td>'+stats.csD+'</td><td>'+stats.goldD+'k</td></tr>';
					$("<table>", {					
						html: tabledata,
					})
					.appendTo($gamecard[index]);
				}
			});
			
			$.ajax({
				type:	"POST",
				url:	"module.php",
				data: 	{region: fill[0]['server'], name: fill[this.id]['summonerName']}
			}).done(function(data) {
				$(data).appendTo($gamecard[index]);
			});
			
			$(this).css({"background-image": "url("+fill[this.id]['champInfo']['pic']+")",
						"background-position": ((fill[this.id]['champInfo']['backX']) || 50)+'% 0%'})
					.addClass(((Math.floor(fill[this.id]['num']) <5)? "blueteam" : "purpleteam"));				
		});	
	}
	
	this.runesData={
	"FlatHPPoolMod": ["HP","Health"],
	"rFlatHPModPerLevel": ["HP18","Health (at level 18)"],
	"FlatMPPoolMod": ["MANA","Mana"],
	"rFlatMPModPerLevel": ["MA18","Mana (at level 18)"],
	"PercentHPPoolMod": ["HP","Health %"],
	"FlatHPRegenMod": ["H5","Health regeneration"],
	"rFlatHPRegenModPerLevel": ["H518","Health regeneration (at level 18)"],
	"FlatMPRegenMod": ["M5","Mana regeneration"],
	"rFlatMPRegenModPerLevel": ["M518","Mana regeneration (at level 18)"],
	"FlatArmorMod": ["AR","Armor"],
	"rFlatArmorModPerLevel": ["AR18","Armor (at level 18)"],
	"rFlatArmorPenetrationMod": ["APEN","Armor penetration"],
	"FlatPhysicalDamageMod": ["AD","Attack damage"],
	"rFlatPhysicalDamageModPerLevel": ["AD18","Attack damage (at level 18)"],
	"PercentPhysicalDamageMod": ["-",""],
	"FlatMagicDamageMod": ["AP","Ability power"],
	"rFlatMagicDamageModPerLevel": ["AP18","Ability power (at level 18)"],
	"PercentMovementSpeedMod": ["MS","Movement speed"],
	"PercentAttackSpeedMod": ["AS","Attack speed"],
	"FlatCritChanceMod": ["CRC","Crit chance"],
	"FlatCritDamageMod": ["CRD","Crit damage"],
	"FlatSpellBlockMod": ["MR","Magic resistance"],
	"rFlatSpellBlockModPerLevel": ["MR18","Magic resistance (at level 18)"],
	"PercentEXPBonus": ["XP","Experience"],
	"rPercentCooldownMod": ["CD","Cooldown reduction"],
	"rPercentCooldownModPerLevel": ["CD18","Cooldown reduction (at level 18)"],
	"rFlatTimeDeadMod": ["TD","Time dead"],
	"rFlatTimeDeadModPerLevel": ["TD18","Time dead (at level 18)"],
	"rPercentTimeDeadMod": ["TD","Time dead %"],
	"rPercentTimeDeadModPerLevel": ["TD18","Time dead % (at level 18)"],
	"rFlatGoldPer10Mod": ["GPM","Gold per minute"],
	"rFlatMagicPenetrationMod": ["MPEN","Magic penetration"],
	"FlatEnergyRegenMod": ["ER","Energy regeneration"],
	"rFlatEnergyRegenModPerLevel": ["ER18","Energy regeneration (at level 18)"],
	"FlatEnergyPoolMod": ["EN","Energy"],
	"rFlatEnergyModPerLevel": ["EN18","Energy (at level 18)"],
	"PercentLifeStealMod": ["LS","Lifesteal"],
	"PercentSpellVampMod": ["SV","Spellvamp"]};
	
	this.addRunes = function(fill) {
		var self=this;
		$gamecard.each(function(index) {
			var text	=["",""];
			if ('runes' in fill[this.id]) {
				for (var key in fill[this.id]['runes']) {
					self.formatRunes(key, fill[this.id]['runes'][key], text, self);
				}
				$( "#"+this.id ).append( "<div class='runes' title='title'></div>" );
				$( "#"+this.id+" .runes" ).append(text[0]).qtip({
						content: {
							text: text[1],
							title: 'Runes'
						},
						position: {
							target: 'mouse',
							adjust: { x: -120, y: -30-20*Object.keys(fill[this.id]['runes']).length }
						}
				});
			}			
		});		
	}

	this.formatRunes	=function(key, value, text, self) {
		var percent	="";
		var sign	="+";
		if (key.indexOf("Percent")>-1 || key.indexOf("FlatCrit")>-1){
			value*=100;
			percent="%";
		}
		if (key.indexOf("PerLevel")>-1){value*=18;}
		if (key.indexOf("Cooldown")>-1){
			value*=-1;
			sign="-";
		}
		if (value>9.999){value=Math.round(value);}
		else{value=value.toFixed(1);}
		text[0]	+=self.runesData[key][0]+" "+value+percent+"<br>";	
		text[1]	+=sign+value+percent+" "+self.runesData[key][1]+"<br>";
	}	
	
	this.masteriesData={
		"4111":{"name":"Double-Edged Sword","description":["Melee - Deal an additional 2% damage<br>and receive an additional 1% damage<br>Ranged - Deal an additional 1.5% damage<br>and receive an additional 1.5% damage"],"x":0,"y":0},"4112":{"name":"Fury","description":["+1.25% Attack Speed","+2.5% Attack Speed","+3.75% Attack Speed","+5% Attack Speed"],"x":48,"y":0},"4113":{"name":"Sorcery","description":["+1.25% Cooldown Reduction","+2.5% Cooldown Reduction","+3.75% Cooldown Reduction","+5% Cooldown Reduction"],"x":96,"y":0},"4114":{"name":"Butcher","description":["Basic attacks and single target spells<br>deal an additional 2 damage to minions and monsters<br><br>This does not trigger off of area of effect damage<br>or damage over time effects"],"x":144,"y":0},"4121":{"name":"Expose Weakness","description":["Damaging an enemy with a spell increases allied champions&#39; damage<br>to that enemy by 1% for the next 3 seconds"],"x":192,"y":0},"4122":{"name":"Brute Force","description":["+4 Attack Damage at level 18<br>(+0.22 Attack Damage per level)","+7 Attack Damage at level 18<br>(+0.39 Attack Damage per level)","+10 Attack Damage at level 18<br>(+0.55 Attack Damage per level)"],"x":240,"y":0},"4123":{"name":"Mental Force","description":["+6 Ability Power at level 18<br>(+0.33 Ability Power per level)","+11 Ability Power at level 18<br>(+0.61 Ability Power per level)","+16 Ability Power at level 18<br>(+0.89 Ability Power per level)"],"x":288,"y":0},"4124":{"name":"Feast","description":["Killing a unit restores 3 Health and 1 Mana"],"x":336,"y":0},"4131":{"name":"Spell Weaving","description":["Damaging an enemy champion with a Basic Attack<br>increases Spell Damage by 1%, stacking up to 3 times<br>(max 3% damage increase)"],"x":384,"y":0},"4132":{"name":"Martial Mastery","description":["+4 Attack Damage"],"x":432,"y":0},"4133":{"name":"Arcane Mastery","description":["+6 Ability Power"],"x":0,"y":48},"4134":{"name":"Executioner","description":["Increases damage dealt to champions below 20% Health by 5%","Increases damage dealt to champions below 35% Health by 5%","Increases damage dealt to champions below 50% Health by 5%"],"x":48,"y":48},"4141":{"name":"Blade Weaving","description":["Damaging an enemy champion with a spell<br>increases Basic Attack Damage by 1%, stacking up to 3 times<br>(max 3% damage increase)"],"x":96,"y":48},"4142":{"name":"Warlord","description":["Increases bonus Attack Damage by 2%","Increases Bonus Attack Damage by 3.5%","Increases Bonus Attack Damage by 5%"],"x":144,"y":48},"4143":{"name":"Archmage","description":["Increases Ability Power by 2%","Increases Ability Power by 3.5%","Increases Ability Power by 5%"],"x":192,"y":48},"4144":{"name":"Dangerous Game","description":["Champion kills and assists<br>restore 5% missing Health and Mana"],"x":240,"y":48},"4151":{"name":"Frenzy","description":["Critical hits grant +5% Attack Speed for 3 seconds<br>(stacks up to 3 times)"],"x":288,"y":48},"4152":{"name":"Devastating Strikes","description":["+2% Armor and Magic Penetration","+4% Armor and Magic Penetration","+6% Armor and Magic Penetration"],"x":336,"y":48},"4154":{"name":"Arcane Blade","description":["Basic Attacks also deal bonus magic damage<br>equal to 5% of Ability Power"],"x":384,"y":48},"4162":{"name":"Havoc","description":["+3% increased damage"],"x":432,"y":48},"4211":{"name":"Block","description":["Reduces incoming damage from champion basic attacks by 1","Reduces incoming damage from champion basic attacks by 2"],"x":0,"y":96},"4212":{"name":"Recovery","description":["+1 Health per 5 seconds","+2 Health per 5 seconds"],"x":48,"y":96},"4213":{"name":"Enchanted Armor","description":["Increases bonus Armor and Magic Resist by 2.5%","Increases bonus Armor and Magic Resist by 5%"],"x":96,"y":96},"4214":{"name":"Tough Skin","description":["Reduces damage taken from neutral monsters by 1<br>This does not affect lane minions","Reduces damage taken from neutral monsters by 2<br>This does not affect lane minions"],"x":144,"y":96},"4221":{"name":"Unyielding","description":["Melee - Reduces all incoming damage from champions by 2<br>Ranged - Reduces all incoming damage from champions by 1"],"x":192,"y":96},"4222":{"name":"Veteran&#39;s Scars","description":["+12 Health","+24 Health","+36 Health"],"x":240,"y":96},"4224":{"name":"Bladed Armor","description":["Taking Basic Attack Damage from neutral monsters<br>cause them to bleed, dealing physical damage<br>equal to 1% of their current Health each second<br>This does not work against lane minions"],"x":288,"y":96},"4231":{"name":"Oppression","description":["Reduces damage taken by 3% from enemies<br>that have impaired movement<br>(slows, snares, taunts, stuns, etc.)"],"x":336,"y":96},"4232":{"name":"Juggernaut","description":["+3% Maximum Health"],"x":384,"y":96},"4233":{"name":"Hardiness","description":["+2 Armor","+3.5 Armor","+5 Armor"],"x":432,"y":96},"4234":{"name":"Resistance","description":["+2 Magic Resist","+3.5 Magic Resist","+5 Magic Resist"],"x":0,"y":144},"4241":{"name":"Perseverance ","description":["Regenerates 0.35% of missing Health every 5 seconds","Regenerates 0.675% of missing Health every 5 seconds","Regenerates 1% of missing Health every 5 seconds"],"x":48,"y":144},"4242":{"name":"Swiftness","description":["Reduces the effectiveness of slows by 10%"],"x":96,"y":144},"4243":{"name":"Reinforced Armor","description":["Reduces the total damage taken from critical strikes by 10%"],"x":144,"y":144},"4244":{"name":"Evasive","description":["Reduces damage taken by 4% from Area of Effect magic damage"],"x":192,"y":144},"4251":{"name":"Second Wind","description":["Increases self-healing, Health Regen, Lifesteal,<br>and Spellvamp by 10% when below 25% Health"],"x":240,"y":144},"4252":{"name":"Legendary Guardian","description":["+1 Armor and 0.5 Magic Resist for each nearby enemy champion","+2 Armor and 1 Magic Resist for each nearby enemy champion","+3 Armor and 1.5 Magic Resist for each nearby enemy champion","+4 Armor and 2 Magic Resist for each nearby enemy champion"],"x":288,"y":144},"4253":{"name":"Runic Blessing","description":["Start the game with a 50 Health shield.<br>This shield regenerates each time after respawning"],"x":336,"y":144},"4262":{"name":"Tenacious","description":["Reduces the duration of crowd control effects by 15%"],"x":384,"y":144},"4311":{"name":"Phasewalker","description":["Reduces the casting time of Recall by 1 second<br>Dominion - Reduces the casting time of Enhanced Recall by 0.5 seconds"],"x":432,"y":144},"4312":{"name":"Fleet of Foot","description":["+0.5% Movement Speed","+1% Movement Speed","+1.5% Movement Speed"],"x":0,"y":192},"4313":{"name":"Meditation","description":["+1 Mana Regen per 5 seconds","+2 Mana Regen per 5 seconds","+3 Mana Regen per 5 seconds"],"x":48,"y":192},"4314":{"name":"Scout","description":["Increases the cast range of trinket items by 15%"],"x":96,"y":192},"4322":{"name":"Summoner&#39;s Insight","description":["Reduces the cooldown of Summoner Spells by 4%","Reduces the cooldown of Summoner Spells by 7%","Reduces the cooldown of Summoner Spells by 10%"],"x":144,"y":192},"4323":{"name":"Strength of Spirit","description":["+1 Health Regen per 5 seconds for every 300 maximum Mana"],"x":192,"y":192},"4324":{"name":"Alchemist","description":["Increases the duration of potions and elixirs by 10%"],"x":240,"y":192},"4331":{"name":"Greed","description":["+0.5 Gold every 10 seconds","+1 Gold every 10 seconds","+1.5 Gold every 10 seconds"],"x":288,"y":192},"4332":{"name":"Runic Affinity","description":["Increases the duration of shrine, relic,<br>quest, and neutral monster buffs by 20%"],"x":336,"y":192},"4333":{"name":"Vampirism","description":["+1% Lifesteal and Spellvamp","+2% Lifesteal and Spellvamp","+3% Lifesteal and Spellvamp"],"x":384,"y":192},"4334":{"name":"Culinary Master","description":["Health potions are upgraded into Biscuits<br>that restore an additional 20 Health and 10 Mana<br>instantly upon consumption"],"x":432,"y":192},"4341":{"name":"Scavenger","description":["+1 Gold each time an ally kills a nearby lane minion"],"x":0,"y":240},"4342":{"name":"Wealth","description":["+40 Starting Gold"],"x":48,"y":240},"4343":{"name":"Expanded Mind","description":["+2% increased maximum Mana","+3.5% increased maximum Mana","+5% increased maximum Mana"],"x":96,"y":240},"4344":{"name":"Inspiration","description":["+5 Experience every 10 seconds while near a higher level allied champion","+10 Experience every 10 seconds while near a higher level allied champion"],"x":144,"y":240},"4352":{"name":"Bandit","description":["Melee - Grants +15 Gold on champion kill or assist<br>Ranged - Grants +3 Gold each time an enemy champion is attacked. This cannot trigger on the same champion more than once every 5 seconds"],"x":192,"y":240},"4353":{"name":"Intelligence","description":["+2% Cooldown Reduction and reduces the cooldown of Activated Items by 4%","+3.5% Cooldown Reduction and reduces the cooldown of Activated Items by 7%","+5% Cooldown Reduction and reduces the cooldown of Activated Items by 10%"],"x":240,"y":240},"4362":{"name":"Wanderer","description":["+5% Movement Speed out of combat"],"x":288,"y":240}};

	this.addMasteries = function(fill) {
		$( ".gamecard" ).append( "<div class='masteries'></div>" );
		$( ".gamecard" ).append( '<div class="tooltiptext"></div>' );
		$( ".tooltiptext" ).append( '<div class="allmast"></div>' );
		
		for (var key in this.masteriesData) {
			$( ".allmast" ).append( '<div class="mast mast'+key+'"></div>' );
			for (var key2 in fill) {
				if (key2>0) {
					var taken="";
					if (fill[key2]['masteries'][key]==undefined) {
						taken="gray_";			
					}
					if (fill[key2]['masteries'][key]>0) {
						$("#"+key2+" .mast"+key).qtip({
							content: {text: this.masteriesData[key]['description'][fill[key2]['masteries'][key]-1],title: this.masteriesData[key]['name']},
							position: {at: 'bottom center',my: 'top center'}
						});			
					}		
					if (fill[key2]['masteries'][key]>1) {
						$("#"+key2+" .mast"+key).append( '<div class="mp">'+fill[key2]['masteries'][key]+'</div>' );;			
					}
					$("#"+key2+" .mast"+key).css("background","url(http://ddragon.leagueoflegends.com/cdn/4.17.1/img/sprite/"+taken+"mastery0.png) -"+this.masteriesData[key]['x']+"px -"+this.masteriesData[key]['y']+"px no-repeat");	
				}
			}
		}
		$.each(fill, function( index, value ) {
			//alert(value );
			if (index!=0) {
				//console.log( value );
				var text="";
				text+=fill[index]['mast']['1']+"/"+fill[index]['mast']['2']+"/"+fill[index]['mast']['3'];
				$("#"+index+" .masteries" ).append(text).each(function() {
					$(this).qtip({
						content: {text: $(this).siblings('.tooltiptext').children()},
						hide: {fixed: true, delay: 300},
						position: {adjust: { x: -80-(Math.floor(fill[index]['num']/5)*452), y: -316 }},
						show: {solo: true}
					});
				});
			}			
		});
	}	
	
	this.clearPage = function(fill) {
		$(".gamecard").remove();
	}
	
	
}