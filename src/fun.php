<?php
include_once("db.php");
date_default_timezone_set("Africa/Algiers");
function map(){
    global $connect;
    $wileya = mysqli_query($connect,"SELECT * FROM wileya ORDER BY confirm Desc");
    while($co = mysqli_fetch_object($wileya)){
        $name = $co->name_ar;
		$map = $co->map;
        $confirm = number_format($co->confirm);
        $death = number_format($co->death);
        $recover = number_format($co->recover);
		$active = number_format($co->confirm-$co->death-$co->recover);
        if($co->confirm < 10){
            $rad = 10000;
        }elseif($co->confirm < 25){
            $rad = 15000;
        }elseif($co->confirm < 50){
            $rad = 20000;
        }elseif($co->confirm < 100){
            $rad = 25000;
        }elseif($co->confirm < 200){
            $rad = 30000;
        }elseif($co->confirm < 500){
            $rad = 35000;
        }elseif($co->confirm < 1000){
            $rad = 40000;
        }elseif($co->confirm < 2000){
            $rad = 45000;
        }elseif($co->confirm < 5000){
            $rad = 50000;
        }elseif($co->confirm < 10000){
            $rad = 55000;
        }
        $card = '<div class="ar font-weight-bold mb-3" style="width:120px;"> <p class="h5 font-weight-bold text-center mt-0 mb-2">'.$name.'</p><div class="row text-danger mb-1 h6"> <div class="col-7 text-left">مؤكدة</div><div class="col-5 pl-0">'.$confirm.'</div></div><hr class="mt-0 mb-2"> <div class="row text-warning mb-1 h6"> <div class="col-7 text-left">نشطة</div><div class="col-5 pl-0">'.$active.'</div></div><div class="row text-success mb-1 h6"> <div class="col-7 text-left">شفاء</div><div class="col-5 pl-0">'.$recover.'</div></div><div class="row text-gray mb-1 h6"> <div class="col-7 text-left">وفاة</div><div class="col-5 pl-0 text-right">'.$death.'</div></div></div>';
        echo "
            var circle = L.circle([$map], {
            color: 'red',
            stroke: false,
            radius: $rad,
            fillColor: 'red',
            fillOpacity: 0.3,
            }).addTo(covid);
            circle.bindPopup('".$card."');  
        ";
	}
		
	$world = mysqli_query($connect,"SELECT * FROM world ORDER BY confirm Desc");
	while($co = mysqli_fetch_object($world)){
			$name = $co->name_ar;
			$map = $co->map;
			$confirm = number_format($co->confirm);
			$death = number_format($co->death);
			$recover = number_format($co->recover);
			$active = number_format($co->confirm-$co->death-$co->recover);
			if($co->confirm > 100000){
				$rad = 2*$co->confirm;
			}elseif($co->confirm > 50000){
				$rad = 3*$co->confirm;
			}elseif($co->confirm > 25000){
				$rad = 4*$co->confirm;
			}elseif($co->confirm > 10000){
				$rad = 5*$co->confirm;
			}
			$card = '<div class="ar font-weight-bold mb-3" style="width:120px;"> <p class="h5 font-weight-bold text-center mt-0 mb-2">'.$name.'</p><div class="row text-danger mb-1 h6"> <div class="col-7 text-left">مؤكدة</div><div class="col-5 pl-0">'.$confirm.'</div></div><hr class="mt-0 mb-2"> <div class="row text-warning mb-1 h6"> <div class="col-7 text-left">نشطة</div><div class="col-5 pl-0">'.$active.'</div></div><div class="row text-success mb-1 h6"> <div class="col-7 text-left">شفاء</div><div class="col-5 pl-0">'.$recover.'</div></div><div class="row text-gray mb-1 h6"> <div class="col-7 text-left">وفاة</div><div class="col-5 pl-0 text-right">'.$death.'</div></div></div>';
			echo "
				var circle = L.circle([$map], {
				color: '#FF9F21',
				stroke: false,
				radius: $rad,
				fillColor: '#FF9F21',
				fillOpacity: 0.5,
				}).addTo(covid);
				circle.bindPopup('".$card."');  
			";
	}
}

function map_local($m){
    global $connect;
    $country = mysqli_query($connect,"SELECT * FROM country where code = 'DZ'");
    $co = mysqli_fetch_object($country);
    if($m == "D"){
        $map = $co->map;
        $map = str_replace("[","",$map);
        $map = str_replace("]","",$map);
        $map = explode(",",$map);
        echo '
        var Map_A = '.$map[0].';
        var Map_B = '.$map[1].';
        var Map_C = '.$map[2].';
        ';
    }elseif($m == "M"){
        $map = $co->map_m;
        $map = str_replace("[","",$map);
        $map = str_replace("]","",$map);
        $map = explode(",",$map);
        echo '
        var Map_A = '.$map[0].';
        var Map_B = '.$map[1].';
        var Map_C = '.$map[2].';
        ';
    }
}

function wilayet($zip){
	global $connect;
    $day = date("Y-m-d");
    $wileya = mysqli_query($connect,"SELECT * FROM wileya WHERE zip='$zip' ORDER BY confirm Desc");
	while($wil = mysqli_fetch_object($wileya)){
        $confirm = number_format($wil->confirm);
		$death = number_format($wil->death);
		$recover = number_format($wil->recover);
		$active = $wil->confirm-$wil->death-$wil->recover;
        $id = $wil->wil;
        $name = $wil->name_ar;
		if($zip == 'MA'){
			echo '
				<div class="alert-sha rounded py-2 px-4 my-3">
					<div class="row">
						<div class="col-8 ar">'.$name.'</div>
						<div class="col-4 text-right en">'.$confirm.'</div>
					</div>
				</div>
			';
		}else{
			echo '
			<a class="btn-block accordion" type="button" data-toggle="collapse" data-target="#but-'.$id.'">
				<div class="alert-sha rounded py-2 px-4 mt-3">
					<div class="row">
						<div class="col-8 ar">'.$id.' - '.$name.'</div>
						<div class="col-4 text-right en">'.$confirm.'</div>
					</div>
				</div>
			</a>
			<div class="collapse" id="but-'.$id.'">
			  <div class="card card-body py-2">
				<div class="row text-center p-0">
					<div class="col-4 px-1">
						<div class="card text-white bg-warning">
							<div class="card-header px-0 py-1">نشطة</div>
							<div class="card-body px-0 py-0">
								<div class="py-2"></div>
								<h5 class="font-weight-bold text-center mb-0">'.$active.'</h5>
								<div class="text-right font-weight-bold" style="padding-top:27px;padding-bottum:27px;"></div>
							</div>
						</div>
					</div>
					<div class="col-4 px-1">
						<div class="card text-white bg-success">
							<div class="card-header px-0 py-1">شفاء</div>
							<div class="card-body px-0 py-0">
								<div class="py-2"></div>
								<h5 class="font-weight-bold text-center mb-0">'.$recover.'</h5>
								<div class="text-right font-weight-bold" style="padding-top:27px;padding-bottum:27px;"></div>
							</div>
						</div>
					</div>
					<div class="col-4 px-1">
						<div class="card text-white bg-dark">
							<div class="card-header px-0 py-1">وفاة</div>
							<div class="card-body px-0 py-0">
								<div class="py-2"></div>
								<h5 class="font-weight-bold text-center mb-0">'.$death.'</h5>
								<div class="text-right font-weight-bold" style="padding-top:27px;padding-bottum:27px;"></div>
							</div>
						</div>
					</div>
				</div>
			  </div>
			</div>
			';
		}
	}
}

function world(){
	global $connect;
    $day = date("Y-m-d");
    $world = mysqli_query($connect,"SELECT * FROM world where confirm > '0' ORDER BY confirm Desc");
	$x=1;
	while($wil = mysqli_fetch_object($world)){
        $confirm = number_format($wil->confirm);
        $name = $wil->name_ar;
			echo '
				<div class="alert-sha rounded py-2 px-4 my-3">
					<div class="row">
						<div class="col-8 ar">'.$x.'- '.$name.'</div>
						<div class="col-4 text-right en">'.$confirm.'</div>
					</div>
				</div>
			';
		$x++;
	}
}

function status($now,$zip){
	global $connect;
	$day = "2021-01-30";
	//$day = date("Y-m-d");
	$tt1 = mysqli_query($connect,"SELECT * FROM total WHERE day='$day' and zip='$zip'");
	$tt = mysqli_fetch_object($tt1);
	if($now == "confirm"){
		return number_format($tt->confirm,0);
	}elseif($now == "active"){
		$active = $tt->confirm-$tt->death-$tt->recover;
		return number_format($active,0);
	}elseif($now == "death"){
		return number_format($tt->death,0);
	}elseif($now == "recover"){
		return number_format($tt->recover,0);
	}
}
function news($now,$zip){
	global $connect;
	$day = "2021-01-30";
	$yday = "2021-01-30";
	$xday = "2021-01-30";
	//$day = date("Y-m-d");
	//$yday = date("Y-m-d", strtotime("yesterday"));
	//$xday = date("Y-m-d", strtotime("-2 day"));
	$tt1 = mysqli_query($connect,"SELECT * FROM total WHERE day='$day' and zip='$zip';");
	$tt2 = mysqli_query($connect,"SELECT * FROM total WHERE day='$yday' and zip='$zip';");
	$tt = mysqli_fetch_object($tt1);
	$tty = mysqli_fetch_object($tt2);
	if($tt->confirm != $tty->confirm){
		if($now == "confirm"){
			$return = number_format($tt->confirm-$tty->confirm,0);
			if($return < 0){
				return $return;
			}else{
				return "+".$return;
			}
		}elseif($now == "death"){
			$return = number_format($tt->death-$tty->death,0);
			if($return < 0){
				return $return;
			}else{
				return "+".$return;
			}
		}elseif($now == "recover"){
			$return = number_format($tt->recover-$tty->recover,0);
			if($return < 0){
				return $return;
			}else{
				return "+".$return;
			}
		}
	}else{
		$tt1 = mysqli_query($connect,"SELECT * FROM total WHERE day='$day' and zip='$zip';");
		$tt2 = mysqli_query($connect,"SELECT * FROM total WHERE day='$xday' and zip='$zip';");
		$tt = mysqli_fetch_object($tt1);
		$tty = mysqli_fetch_object($tt2);
		if($now == "confirm"){
			$return = number_format($tt->confirm-$tty->confirm,0);
			if($return < 0){
				return $return;
			}else{
				return "+".$return;
			}
		}elseif($now == "death"){
			$return = number_format($tt->death-$tty->death,0);
			if($return < 0){
				return $return;
			}else{
				return "+".$return;
			}
		}elseif($now == "recover"){
			$return = number_format($tt->recover-$tty->recover,0);
			if($return < 0){
				return $return;
			}else{
				return "+".$return;
			}
		}
	}
}

function graph_label($zip){
	global $connect;
	$tt1 = mysqli_query($connect,"SELECT * FROM total WHERE zip='$zip' ORDER BY id Asc");
	while($tt = mysqli_fetch_object($tt1)){
		$day = $tt->day;
		$day = explode("-",$day);
		echo "'".$day[1]."-".$day[2]."',";
	}
}

function graph_data($zip){
	global $connect;
	$tt1 = mysqli_query($connect,"SELECT * FROM total WHERE zip='$zip' ORDER BY id Asc");
	while($tt = mysqli_fetch_object($tt1)){
		$confirm = $tt->confirm;
		echo $confirm.",";
	}
}
function fb_img(){
	global $connect;
	$day = date("Y-m-d");
	$qry1 = mysqli_query($connect, "SELECT confirm FROM total WHERE day='$day' and zip='DZ'");
	return mysqli_fetch_object($qry1)->confirm;
}
?>