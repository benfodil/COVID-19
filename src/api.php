<?php
if($_GET['key'] == "adel") {
    include_once("db.php");
	date_default_timezone_set("Africa/Algiers");
	function covid19api($zip){
		global $connect;
		if($zip == "DZ"){
			$url = 'https://api.covid19api.com/dayone/country/algeria/status/confirmed';
		}elseif($zip == "MA"){
			$url = 'https://api.covid19api.com/dayone/country/morocco/status/confirmed';
		}elseif($zip == "TN"){
			$url = 'https://api.covid19api.com/dayone/country/tunisia/status/confirmed';
		}elseif($zip == "WW"){
			// now work for all just day!
			$url = 'https://api.covid19api.com/world/total';
		}
		$cSession = curl_init();
        curl_setopt($cSession, CURLOPT_URL, $url);
        curl_setopt($cSession, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cSession, CURLOPT_HEADER, false);
        $result = curl_exec($cSession);
        curl_close($cSession);
		$result = json_decode($result, true);
		$c = count($result);
		$x = 0;
		while($x < $c){
			$conf = $result[$x][Cases];
			$day = $result[$x][Date];
			$day = explode("T",$day);
			$day = $day[0];
			$qry1 = mysqli_query($connect, "SELECT * FROM total WHERE day='$day' and zip='$zip'");
			$row = mysqli_num_rows($qry1);
			if($row == 0){
				mysqli_query($connect,"INSERT INTO total (zip,confirm,day)VALUES ('$zip','$conf','$day');");
			}else{
				mysqli_query($connect,"UPDATE total SET confirm='$conf' WHERE day='$day' and zip='$zip'");
			}
			echo $day.' | '.$conf.'<br>';
			$x++;
		}
	
	}
	
    function total($or){
        global $connect;
		$url = 'https://bing.com/covid/data';
		$cSession = curl_init();
        curl_setopt($cSession, CURLOPT_URL, $url);
        curl_setopt($cSession, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cSession, CURLOPT_HEADER, false);
        $result = curl_exec($cSession);
        curl_close($cSession);
		$result = json_decode($result, true);
		$c = count($result[areas]);
		$x = 0;
		$day = date("Y-m-d");
		while($x < $c){
			$name_en = $result[areas][$x][id];
			$name_ar = $result[areas][$x][displayName];
			$confirm = $result[areas][$x][totalConfirmed];
			$death = $result[areas][$x][totalDeaths];
			$recover = $result[areas][$x][totalRecovered];
			$confirm_new = $result[areas][$x][totalRecoveredDelta];
			$death_new = $result[areas][$x][totalDeathsDelta];
			$recover_new = $result[areas][$x][totalRecovered];
			$map = $result[areas][$x][lat].','.$result[areas][$x][long];
			//mysqli_query($connect, "INSERT INTO world (name_en,name_ar,confirm,death,recover,confirm_new,death_new,recover_new,map)VALUES ('$name_en','$name_ar','$confirm','$death','$recover','$confirm_new','$death_new','$recover_new','$map');");
			mysqli_query($connect, "UPDATE world SET confirm= '$confirm',death= '$death',recover= '$recover',confirm_new= '$confirm_new',death_new= '$death_new',recover_new= '$recover_new' WHERE name_en='$name_en';");
			If($name_en == 'algeria'){
				$qry1 = mysqli_query($connect, "SELECT * FROM total WHERE day='$day' and zip='DZ';");
				$row1 = mysqli_num_rows($qry1);
				if ($row1 == 0) {
					mysqli_query($connect, "INSERT INTO total (confirm,death,recover,zip,day)VALUES ('$confirm','$death','$recover','DZ','$day');");
				} else {
					$conf = mysqli_fetch_object($qry1)-confirm;
					if($conf < $confirm){
						$qry1 = mysqli_query($connect, "SELECT * FROM total WHERE day='$day' and zip='DZ';");
						mysqli_query($connect, "UPDATE total SET confirm= '$confirm',death= '$death',recover= '$recover' WHERE day='$day' and zip='DZ';");
					}
				}
			}elseif($name_en == 'tunisia'){
				$qry1 = mysqli_query($connect, "SELECT * FROM total WHERE day='$day' and zip='TN';");
				$row1 = mysqli_num_rows($qry1);
				if ($row1 == 0) {
					mysqli_query($connect, "INSERT INTO total (confirm,death,recover,zip,day)VALUES ('$confirm','$death','$recover','TN','$day');");
				} else {
					$qry1 = mysqli_query($connect, "SELECT * FROM total WHERE day='$day' and zip='TN';");
					$conf = mysqli_fetch_object($qry1)-confirm;
					if($conf < $confirm){
						mysqli_query($connect, "UPDATE total SET confirm= '$confirm',death= '$death',recover= '$recover' WHERE day='$day' and zip='TN';");
					}
				}
			}elseif($name_en == 'morocco'){
				$qry1 = mysqli_query($connect, "SELECT * FROM total WHERE day='$day' and zip='MA';");
				$row1 = mysqli_num_rows($qry1);
				if ($row1 == 0) {
					mysqli_query($connect, "INSERT INTO total (confirm,death,recover,zip,day)VALUES ('$confirm','$death','$recover','MA','$day');");
				} else {
					$qry1 = mysqli_query($connect, "SELECT * FROM total WHERE day='$day' and zip='MA';");
					$conf = mysqli_fetch_object($qry1)-confirm;
					if($conf < $confirm){
						mysqli_query($connect, "UPDATE total SET confirm= '$confirm',death= '$death',recover= '$recover' WHERE day='$day' and zip='MA';");
					}
				}
			}
			$x++;
		}
		$confirm = $result[totalConfirmed];
		$death = $result[totalDeaths];
		$recover = $result[totalRecovered];
		$confirm_new = $result[totalRecoveredDelta];
		$death_new = $result[totalDeathsDelta];
		$recover_new = $result[totalRecovered];
        $qry1 = mysqli_query($connect, "SELECT * FROM total WHERE day='$day' and zip='WW';");
        $row1 = mysqli_num_rows($qry1);
        if ($row1 == 0) {
            mysqli_query($connect, "INSERT INTO total (confirm,death,recover,zip,day)VALUES ('$confirm','$death','$recover','WW','$day');");
		} else {
            mysqli_query($connect, "UPDATE total SET confirm= '$confirm',death= '$death',recover= '$recover' WHERE day='$day' and zip='WW';");
		}
        echo "total: Done.</br>";
		
		if($or == 1){
			$url = 'https://api.covid19api.com/world/total';
			$cSession = curl_init();
			curl_setopt($cSession, CURLOPT_URL, $url);
			curl_setopt($cSession, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($cSession, CURLOPT_HEADER, false);
			$result = curl_exec($cSession);
			curl_close($cSession);
			$result = json_decode($result, true);
			$confirm = $result[TotalConfirmed];
			$death = $result[TotalDeaths];
			$recover = $result[TotalRecovered];
			$qry1 = mysqli_query($connect, "SELECT * FROM total WHERE day='$day' and zip='WW';");
			$row1 = mysqli_num_rows($qry1);
			if ($row1 == 0) {
				mysqli_query($connect, "INSERT INTO total (confirm,death,recover,zip,day)VALUES ('$confirm','$death','$recover','WW','$day');");
			} else {
				mysqli_query($connect, "UPDATE total SET confirm= '$confirm',death= '$death',recover= '$recover' WHERE day='$day' and zip='WW';");
			}
			echo "total: OR Done.</br>";
		}
    }
	function tn_total(){
        global $connect;
		$zip = 'TN';
		$day = date("Y-m-d");
		$cSession = curl_init();
        curl_setopt($cSession, CURLOPT_URL, "https://en.wikipedia.org/wiki/2020_coronavirus_pandemic_in_Tunisia");
        curl_setopt($cSession, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cSession, CURLOPT_HEADER, false);
        $result = curl_exec($cSession);
        curl_close($cSession);
        $a1 = explode('<th scope="col"><a href="/wiki/Governorates_of_Tunisia" title="Governorates of Tunisia">Governorate</a>', $result);
        $a2 = explode('<td colspan="4"><i>Source', $a1[1]);
        $part1 = explode('<td align="left">', $a2[0]);
		$part1 = $part1[0];
		$part = explode('<td><a href="', $part1);
			$confirm = explode('<th><b>', $part[24]);
            $confirm = explode('</b>', $confirm[2]);
            $confirm = trim($confirm[0]);
            $confirm = str_replace(",", "", $confirm);
			$death = explode('<th><b>', $part[24]);
            $death = explode('</b>', $death[3]);
            $death = trim($death[0]);
            $death = str_replace(",", "", $death);
			$recover = explode('<th><b>', $part[24]);
            $recover = explode('</b>', $recover[4]);
            $recover = trim($recover[0]);
            $recover = str_replace(",", "", $recover);
		mysqli_query($connect, "UPDATE world SET confirm= '$confirm',death= '$death',recover= '$recover' WHERE name_en='tunisia';");
		$qry1 = mysqli_query($connect, "SELECT * FROM total WHERE day='$day' and zip='$zip';");
        $row1 = mysqli_num_rows($qry1);
        if ($row1 == 0) {
            mysqli_query($connect, "INSERT INTO total (confirm,death,recover,zip,day)VALUES ('$confirm','$death','$recover','$zip','$day');");
		} else {
            mysqli_query($connect, "UPDATE total SET confirm= '$confirm',death= '$death',recover= '$recover' WHERE day='$day' and zip='$zip';");
		}
		echo "TN total: Done.</br>";
    }
	
	function ma_total(){
        global $connect;
		$zip = 'MA';
		$day = date("Y-m-d");
		$cSession = curl_init();
        curl_setopt($cSession, CURLOPT_URL, "https://en.wikipedia.org/wiki/2020_coronavirus_pandemic_in_Morocco");
        curl_setopt($cSession, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cSession, CURLOPT_HEADER, false);
        $result = curl_exec($cSession);
        curl_close($cSession);
        $a1 = explode('<table class="infobox"', $result);
        $a2 = explode('</td></tr><tr><th colspan="2"', $a1[1]);
        $parto = explode('</td></tr><tr><th scope="row">', $a2[0]);

			$part1 = $parto[7];
			$part1 = explode('</th><td>', $part1);
			$part = explode(' (', $part1[1]);
            $part = trim($part[0]);
            $confirm = str_replace(",", "", $part);
			
			$part1 = $parto[10];
			$part1 = explode('</th><td>', $part1);
			$part = explode(' (', $part1[1]);
            $part = trim($part[0]);
            $death = str_replace(",", "", $part);
			
			$part1 = $parto[9];
			$part1 = explode('</th><td>', $part1);
			$part = explode(' (', $part1[1]);
            $part = trim($part[0]);
            $recover = str_replace(",", "", $part);
		mysqli_query($connect, "UPDATE world SET confirm= '$confirm',death= '$death',recover= '$recover' WHERE name_en='morocco';");
		$qry1 = mysqli_query($connect, "SELECT * FROM total WHERE day='$day' and zip='$zip';");
        $row1 = mysqli_num_rows($qry1);
        if ($row1 == 0) {
            mysqli_query($connect, "INSERT INTO total (confirm,death,recover,zip,day)VALUES ('$confirm','$death','$recover','$zip','$day');");
		} else {
            mysqli_query($connect, "UPDATE total SET confirm= '$confirm',death= '$death',recover= '$recover' WHERE day='$day' and zip='$zip';");
		}
		echo "MA total: Done.</br>";
    }

    function dz_wileya(){
        global $connect;
		$zip = 'DZ';
		$day = date("Y-m-d");
        $cSession = curl_init();
        curl_setopt($cSession, CURLOPT_URL, "https://en.wikipedia.org/wiki/2020_coronavirus_pandemic_in_Algeria");
        curl_setopt($cSession, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cSession, CURLOPT_HEADER, false);
        $result = curl_exec($cSession);
        curl_close($cSession);

        $a1 = explode('<span class="mw-headline" id="Location_of_cases">Location of cases</span>', $result);
        $a2 = explode('<tr class="sortbottom">', $a1[0]);
        $part = explode('<td align="left">', $a2[0]);

        $p = 1;
        while ($p < count($part)) {
            $name = explode('">', $part[$p]);
            $name = explode('</a>', $name[1]);
            $name = trim($name[0]);
            $name = str_replace("'", "", $name);

            $confirm = explode('<td>', $part[$p]);
            $confirm = explode('</td>', $confirm[2]);
            $confirm = trim($confirm[0]);
            $confirm = str_replace(",", "", $confirm);

            $death = explode('<td>', $part[$p]);
            $death = explode('</td>', $death[3]);
            $death = trim($death[0]);
            $death = str_replace(",", "", $death);

            $recover = explode('<td>', $part[$p]);
            $recover = explode('</td>', $recover[4]);
            $recover = trim($recover[0]);
            $recover = str_replace(",", "", $recover);

            $active = $confirm - $death - $recover;
            $day = date("Y-m-d");

            mysqli_query($connect, "UPDATE wileya SET confirm= '$confirm',death= '$death',recover= '$recover'WHERE name_en='$name' and zip='$zip' ;");
			//echo $p." | ".$name." | ".$confirm." | ".$death." | ".$recover."</br>";
            $p++;
        }
		$confirm = explode('<th>', $part[$p-1]);
        $confirm = explode('</th>', $confirm[3]);
        $confirm = trim($confirm[0]);
        $confirm = str_replace(",", "", $confirm);
		
		$death = explode('<th>', $part[$p-1]);
        $death = explode('</th>', $death[4]);
        $death = trim($death[0]);
        $death = str_replace(",", "", $death);
		
		$recover = explode('<th>', $part[$p-1]);
        $recover = explode('</th>', $recover[5]);
        $recover = trim($recover[0]);
        $recover = str_replace(",", "", $recover);
		
		$qry1 = mysqli_query($connect, "SELECT * FROM total WHERE day='$day' and zip='$zip';");
				$row1 = mysqli_num_rows($qry1);
				if ($row1 == 0) {
					mysqli_query($connect, "INSERT INTO total (confirm,death,recover,zip,day)VALUES ('$confirm','$death','$recover','$zip','$day');");
				} else {
					mysqli_query($connect, "UPDATE total SET confirm= '$confirm',death= '$death',recover= '$recover' WHERE day='$day' and zip='$zip';");
				}
		mysqli_query($connect, "UPDATE world SET confirm= '$confirm',death= '$death',recover= '$recover' WHERE name_en='algeria';");
        echo "DZ : wileya : Done.</br>";
    }
	
	function tn_wileya(){
        global $connect;
		$zip = 'TN';
		$cSession = curl_init();
        curl_setopt($cSession, CURLOPT_URL, "https://en.wikipedia.org/wiki/2020_coronavirus_pandemic_in_Tunisia");
        curl_setopt($cSession, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cSession, CURLOPT_HEADER, false);
        $result = curl_exec($cSession);
        curl_close($cSession);
		
        $a1 = explode('<th scope="col"><a href="/wiki/Governorates_of_Tunisia" title="Governorates of Tunisia">Governorate</a>', $result);
        $a2 = explode('<td colspan="4"><i>Source', $a1[1]);
        $part1 = explode('<td align="left">', $a2[0]);
		$part1 = $part1[0];
		$part = explode('<td><a href="', $part1);

        $p = 1;
        while ($p < count($part)) {
            $name = explode('">', $part[$p]);
            $name = explode('</a>', $name[1]);
            $name = trim($name[0]);
            $name = str_replace("'", "", $name);
			$confirm = explode('<td>', $part[$p]);
            $confirm = explode('</td>', $confirm[1]);
            $confirm = trim($confirm[0]);
            $confirm = str_replace(",", "", $confirm);
			$death = explode('<td>', $part[$p]);
            $death = explode('</td>', $death[2]);
            $death = trim($death[0]);
            $death = str_replace(",", "", $death);
			mysqli_query($connect, "UPDATE wileya SET confirm= '$confirm',death= '$death' WHERE name_en='$name' and zip='$zip';");
            $p++;
        }
        echo "TN : wileya : Done.</br>";
    }
	
	function ma_wileya(){
        global $connect;
		$zip = 'MA';
		$cSession = curl_init();
        curl_setopt($cSession, CURLOPT_URL, "https://en.wikipedia.org/wiki/2020_coronavirus_pandemic_in_Morocco");
        curl_setopt($cSession, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($cSession, CURLOPT_HEADER, false);
        $result = curl_exec($cSession);
        curl_close($cSession);
        $a1 = explode('class="nowrap">2020 coronavirus pandemic in Morocco by region</span></span></div>', $result);
        $a2 = explode('<tr class="sortbottom">', $a1[1]);
        $part1 = explode('<td align="left">', $a2[0]);
		$part1 = $part1[0];
		$part = explode('<th scope="row"><a href="', $part1);
        $p = 1;
        while ($p < count($part)) {
            $name = explode('">', $part[$p]);
            $name = explode('</a>', $name[1]);
            $name = trim($name[0]);
			$confirm = explode('<td>', $part[$p]);
            $confirm = explode('</td>', $confirm[1]);
            $confirm = trim($confirm[0]);
			$confirm = str_replace(",", "", $confirm);
			mysqli_query($connect, "UPDATE wileya SET confirm= '$confirm' WHERE name_en='$name' and zip='$zip';");
			$p++;
        }
        echo "MA : wileya : Done.</br>";
    }

//RUN!
    //total(1);
	tn_total();
	ma_total();
    dz_wileya();
	tn_wileya();
	ma_wileya();
}
?>
