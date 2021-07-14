<?php
include_once("fun.php");
if($_GET[img] == 'ok'){
	$content = file_get_contents("http://api.screenshotlayer.com/api/capture?access_key=e8e9ad6128e491061d3571ca3aca555a&url=https://dzcovid.tk/src/card.php&viewport=600x315&width=600");
	$fp = fopen("FB/".$_GET[c].".png", "w");
	fwrite($fp, $content);
	fclose($fp);
	echo 'Done: <a target="_blank" href="FB/'.$_GET[c].'.png">'.$_GET[c].'</a>';
	exit;
}else{
?>
<!DOCTYPE html>
<html dir="rtl">
<head>
	<title>Algeria COVID Tracker</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdn.rtlcss.com/bootstrap/v4.2.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="src/style.css">
    <style>@import url(https://fonts.googleapis.com/css2?family=Cairo:wght@300&display=swap);.ar{font-family:'Cairo',sans-serif!important}</style>
</head>
<body class="ar container">
	<div class="row mt-3">
		<div class="col-1"></div>
		<div class="col-10">
			<div class="h4 text-center font-weight-bold mt-3">مجموع الحالات المؤكدة</div>
			<div class="h1 text-danger text-center mt-2 font-weight-bold" style="font-size: 60px;"><?php echo status('confirm','DZ');?><sub class="h6"><?php echo news('confirm','DZ');?></span></sub></div>
			<div class="row text-center p-2">
				<div class="col-4 p-1">
					<div class="card text-white bg-warning">
						<div class="card-header px-0 py-1">نشطة</div>
						<div class="card-body px-0 py-0">
							<div class="py-2"></div>
							<h4 class="font-weight-bold text-center mb-0"><?php echo status('active','DZ');?></h4>
							<div class="text-right font-weight-bold" style="padding-top:27px;padding-bottum:27px;"></div>
						</div>
					</div>
				</div>
				<div class="col-4 p-1">
					<div class="card text-white bg-success">
						<div class="card-header px-0 py-1">شفاء</div>
						<div class="card-body px-0 py-0">
							<div class="py-2"></div>
							<h4 class="font-weight-bold text-center mb-0"><?php echo status('recover','DZ');?></h4>
							<div class="text-right font-weight-bold mb-1 pr-1"><span class="badge badge-light" dir="ltr"><?php echo news('recover','DZ');?></span></div>
						</div>
					</div>
				</div>
				<div class="col-4 p-1">
					<div class="card text-white bg-dark">
						<div class="card-header px-0 py-1">وفاة</div>
						<div class="card-body px-0 py-0">
							<div class="py-2"></div>
							<h4 class="font-weight-bold text-center mb-0"><?php echo status('death','DZ');?></h4>
							<div class="text-right font-weight-bold mb-1 pr-1"><span class="badge badge-light" dir="ltr"><?php echo news('death','DZ');?></span></div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-1"></div>
	</div>
</body>
</html>

<?php 
}
?>