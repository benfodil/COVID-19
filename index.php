<?php
include_once("src/fun.php");
if($_SERVER['HTTP_HOST'] != 'dzcovid.tk'){
	//header("Location: https://dzcovid.tk");
}
?>
<!DOCTYPE html>
<html dir="rtl">
<head>
	<title>Algeria COVID Tracker</title>
    <meta name="description" content="Algeria COVID Tracker - موقع جزائري لتقديم إحصائيات مباشرة و المساهمة في التوعية من فيروس كورونا العالمي">
    <meta name="keywords" content="covid-19,covid,dz,corona,algeria,كورونا,كرونا الجزائر,tracker">
    <meta name="author" content="AdeL Benfodil">
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="shortcut icon" type="image/x-icon" href="src/fav.png"/>
	<meta property="og:url" content="https://dzcovid.tk" />
	<meta property="og:type" content="COVID-19" />
	<meta property="og:title" content="Algeria COVID Tracker" />
	<meta property="og:description" content="موقع جزائري لتقديم إحصائيات مباشرة و المساهمة في التوعية من فيروس كورونا العالمي"/>
	<!-- <meta property="og:image" content="https://dzcovid.tk/src/FB/<?php echo fb_img(); ?>.png" /> !-->
	<meta property="og:image" content="https://dzcovid.tk/src/face.jpg" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"/>
	<link rel="stylesheet" href="https://cdn.rtlcss.com/bootstrap/v4.2.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="src/style.css">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
	<script src="https://cdn.rtlcss.com/bootstrap/v4.2.1/js/bootstrap.min.js"></script>
    <style>@import url(https://fonts.googleapis.com/css2?family=Cairo:wght@300&display=swap);.ar{font-family:'Cairo',sans-serif!important}</style>
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-40109668-6"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());
	  gtag('config', 'UA-40109668-6');
	</script>
	<div id="fb-root"></div>
	<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v6.0&appId=372047723608160&autoLogAppEvents=1"></script>
<style>
.accordion .card-header:after {
    font-family: 'FontAwesome';  
    content: "\f068";
    float: right; 
}
.accordion .card-header.collapsed:after {
    /* symbol for "collapsed" panels */
    content: "\f067"; 
}
</style>
</head>
<body class="ar">
<div id="covid"></div>
<div class="nav-side scrollbar scrollbar-deep-blue" id="nav-side">
<a style="color: #3498DB;" target="_blank" href="https://www.facebook.com/AlgeriaCOVIDTracker/"><img src="src/covid-logo.png" class="img-fluid mt-2" alt="DZ Covid"></a>
<center>
	<div class="fb-like" data-href="https://www.facebook.com/AlgeriaCOVIDTracker/" data-width="" data-layout="button" data-action="like" data-size="small" data-share="false"></div>
	<div class="fb-share-button" data-href="https://dzcovid.tk/" data-layout="button_count" data-size="small"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdzcovid.tk%2F&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore"></a></div>
</center>
<nav>
  <div class="nav nav-tabs mt-3" id="nav-tab">
    <a class="nav-item nav-link text-center nv-mu active" id="DZ-tab" data-toggle="tab" href="#DZ">الجزائر</a>
    <a class="nav-item nav-link text-center nv-mu" id="TN-tab" data-toggle="tab" href="#TN">تونس</a>
	<a class="nav-item nav-link text-center nv-mu" id="MA-tab" data-toggle="tab" href="#MA">المغرب</a>
	<a class="nav-item nav-link text-center nv-mu" id="WW-tab" data-toggle="tab" href="#WW">عالميا</a>
  </div>
</nav>
<div class="tab-content" id="nav-tabContent">
	<div class="tab-pane fade show active" id="DZ">
	<div class="text-center font-weight-bold mt-3">مجموع الحالات المؤكدة</div>
    <div class="h1 text-danger text-center mt-2 font-weight-bold" style="font-size: 50px;"><?php echo status('confirm','DZ');?><sub class="h6"><?php echo news('confirm','DZ');?></span></sub></div>
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
    <hr>
		<div>منحنى الحالات المؤكدة</div>
        <canvas id="DZChar" height="200"></canvas>
        <script>var ctx=document.getElementById('DZChar').getContext('2d');var chart=new Chart(ctx,{type:'line',data:{labels:[<?php graph_label('DZ');?>],datasets:[{label:'الحالات المؤكدة',backgroundColor:'rgb(205, 97, 85,0.1)',borderColor:'rgb(205, 97, 85)',pointBorderColor:'rgba(0, 0, 0, 0)',data:[<?php graph_data('DZ');?>]}]},options:{legend:!1,}});</script>
	<hr class="mt-0">
        <?php wilayet('DZ'); ?>
  </div>
  
    <div class="tab-pane fade" id="TN">
	<div class="text-center font-weight-bold mt-3">مجموع الحالات المؤكدة</div>
    <div class="h1 text-danger text-center mt-2 font-weight-bold" style="font-size: 50px;"><?php echo status('confirm','TN');?><sub class="h6"><?php echo news('confirm','TN');?></span></sub></div>
	<div class="row text-center p-2">
        <div class="col-4 p-1">
            <div class="card text-white bg-warning">
                <div class="card-header px-0 py-1">نشطة</div>
                <div class="card-body px-0 py-0">
					<div class="py-2"></div>
					<h4 class="font-weight-bold text-center mb-0"><?php echo status('active','TN');?></h4>
					<div class="text-right font-weight-bold" style="padding-top:27px;padding-bottum:27px;"></div>
				</div>
            </div>
        </div>
        <div class="col-4 p-1">
            <div class="card text-white bg-success">
                <div class="card-header px-0 py-1">شفاء</div>
                <div class="card-body px-0 py-0">
					<div class="py-2"></div>
					<h4 class="font-weight-bold text-center mb-0"><?php echo status('recover','TN');?></h4>
					<div class="text-right font-weight-bold mb-1 pr-1"><span class="badge badge-light" dir="ltr"><?php echo news('recover','TN');?></span></div>
				</div>
            </div>
        </div>
        <div class="col-4 p-1">
            <div class="card text-white bg-dark">
                <div class="card-header px-0 py-1">وفاة</div>
				<div class="card-body px-0 py-0">
					<div class="py-2"></div>
					<h4 class="font-weight-bold text-center mb-0"><?php echo status('death','TN');?></h4>
					<div class="text-right font-weight-bold mb-1 pr-1"><span class="badge badge-light" dir="ltr"><?php echo news('death','TN');?></span></div>
				</div>
            </div>
        </div>
    </div>
    <hr>
		<div>منحنى الحالات المؤكدة</div>
        <canvas id="TNChar" height="200"></canvas>
        <script>var ctx=document.getElementById('TNChar').getContext('2d');var chart=new Chart(ctx,{type:'line',data:{labels:[<?php graph_label('TN');?>],datasets:[{label:'الحالات المؤكدة',backgroundColor:'rgb(205, 97, 85,0.1)',borderColor:'rgb(205, 97, 85)',pointBorderColor:'rgba(0, 0, 0, 0)',data:[<?php graph_data('TN');?>]}]},options:{legend:!1,}});</script>
    <hr class="mt-0">
	<?php wilayet('TN'); ?>
  </div>
  <div class="tab-pane fade" id="MA">
	<div class="text-center font-weight-bold mt-3">مجموع الحالات المؤكدة</div>
    <div class="h1 text-danger text-center mt-2 font-weight-bold" style="font-size: 50px;"><?php echo status('confirm','MA');?><sub class="h6"><?php echo news('confirm','MA');?></span></sub></div>
	<div class="row text-center p-2">
        <div class="col-4 p-1">
            <div class="card text-white bg-warning">
                <div class="card-header px-0 py-1">نشطة</div>
                <div class="card-body px-0 py-0">
					<div class="py-2"></div>
					<h4 class="font-weight-bold text-center mb-0"><?php echo status('active','MA');?></h4>
					<div class="text-right font-weight-bold" style="padding-top:27px;padding-bottum:27px;"></div>
				</div>
            </div>
        </div>
        <div class="col-4 p-1">
            <div class="card text-white bg-success">
                <div class="card-header px-0 py-1">شفاء</div>
                <div class="card-body px-0 py-0">
					<div class="py-2"></div>
					<h4 class="font-weight-bold text-center mb-0"><?php echo status('recover','MA');?></h4>
					<div class="text-right font-weight-bold mb-1 pr-1"><span class="badge badge-light" dir="ltr"><?php echo news('recover','MA');?></span></div>
				</div>
            </div>
        </div>
        <div class="col-4 p-1">
            <div class="card text-white bg-dark">
                <div class="card-header px-0 py-1">وفاة</div>
				<div class="card-body px-0 py-0">
					<div class="py-2"></div>
					<h4 class="font-weight-bold text-center mb-0"><?php echo status('death','MA');?></h4>
					<div class="text-right font-weight-bold mb-1 pr-1"><span class="badge badge-light" dir="ltr"><?php echo news('death','MA');?></span></div>
				</div>
            </div>
        </div>
    </div>
    <hr>
		<div>منحنى الحالات المؤكدة</div>
        <canvas id="MAChar" height="200"></canvas>
        <script>var ctx=document.getElementById('MAChar').getContext('2d');var chart=new Chart(ctx,{type:'line',data:{labels:[<?php graph_label('MA');?>],datasets:[{label:'الحالات المؤكدة',backgroundColor:'rgb(205, 97, 85,0.1)',borderColor:'rgb(205, 97, 85)',pointBorderColor:'rgba(0, 0, 0, 0)',data:[<?php graph_data('MA');?>]}]},options:{legend:!1,}});</script>
    <hr class="mt-0">
	<?php wilayet('MA'); ?>
  </div>
  <div class="tab-pane fade" id="WW">
  <div class="text-center font-weight-bold mt-3">مجموع الحالات المؤكدة</div>
    <div class="h1 text-danger text-center mt-2 font-weight-bold" style="font-size: 50px;"><?php echo status('confirm','WW');?></div>
	<div class="row text-center p-2">
		<div class="col-12 p-1">
            <div class="card text-white bg-warning">
				<div class="row card-body py-2">
					<div class="col-5 text-left">
						<div>نشطة</div>
					</div>
					<div class="col-7 text-right font-weight-bold">
						<span dir="ltr"><?php echo status('active','WW');?></span>
					</div>
				</div>
            </div>
        </div>
		<div class="col-12 p-1">
            <div class="card text-white bg-success">
				<div class="row card-body py-2">
					<div class="col-5 text-left">
						<div>شفاء</div>
					</div>
					<div class="col-7 text-right font-weight-bold">
						<span dir="ltr"><?php echo status('recover','WW');?></span>
					</div>
				</div>
            </div>
        </div>
        <div class="col-12 p-1">
            <div class="card text-white bg-dark">
				<div class="row card-body py-2">
					<div class="col-5 text-left">
						<div>وفاة</div>
					</div>
					<div class="col-7 text-right font-weight-bold">
						<span dir="ltr"><?php echo status('death','WW');?></span>
					</div>
				</div>
            </div>
        </div>
    </div>
	<hr>
    <?php world(); ?>
  </div>
</div>
	
	
	
   
		
		
    <hr>
	<div class="text-center font-weight-bold"><a style="color: #3498DB;" target="_blank" href="https://www.facebook.com/AlgeriaCOVIDTracker/">Algeria COVID Tracker</a></div>
	<div class="en text-center text-black-50">Made in 
		<svg class="bi bi-heart-fill text-danger" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor">
		  <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z" clip-rule="evenodd"></path>
		</svg> Algeria , By <a style="color: #3498DB;" target="_blank" href="https://www.fb.com/adelbenfodil/">AdeL</a>
	</div>
    <div class="mobile-bar rounded-top">
        <div class="btn-group d-flex">
            <a href="#" class="btn btn-default w-100 py-3 border font-weight-bold">
			<svg width="13pt" height="13pt" viewBox="0 0 13 13">
				<g id="surface1">
				<path style=" stroke:none;fill-rule:nonzero;fill:rgb(0%,0%,0%);fill-opacity:1;" d="M 1.929688 6.09375 C 2.238281 6.09375 2.515625 5.96875 2.71875 5.773438 L 3.847656 6.335938 C 3.84375 6.382812 3.835938 6.425781 3.835938 6.476562 C 3.835938 7.105469 4.347656 7.617188 4.976562 7.617188 C 5.605469 7.617188 6.117188 7.105469 6.117188 6.476562 C 6.117188 6.296875 6.074219 6.132812 6.003906 5.984375 L 7.535156 4.457031 C 7.683594 4.527344 7.847656 4.570312 8.023438 4.570312 C 8.652344 4.570312 9.164062 4.058594 9.164062 3.429688 C 9.164062 3.308594 9.144531 3.195312 9.109375 3.089844 L 10.4375 2.09375 C 10.617188 2.214844 10.835938 2.285156 11.070312 2.285156 C 11.699219 2.285156 12.210938 1.773438 12.210938 1.140625 C 12.210938 0.511719 11.699219 0 11.070312 0 C 10.441406 0 9.929688 0.511719 9.929688 1.140625 C 9.929688 1.261719 9.949219 1.375 9.984375 1.480469 L 8.65625 2.476562 C 8.476562 2.355469 8.257812 2.285156 8.023438 2.285156 C 7.394531 2.285156 6.882812 2.796875 6.882812 3.429688 C 6.882812 3.605469 6.925781 3.769531 6.996094 3.917969 L 5.464844 5.445312 C 5.316406 5.375 5.152344 5.332031 4.976562 5.332031 C 4.667969 5.332031 4.390625 5.457031 4.1875 5.652344 L 3.058594 5.089844 C 3.0625 5.042969 3.074219 5 3.074219 4.953125 C 3.074219 4.320312 2.558594 3.808594 1.929688 3.808594 C 1.300781 3.808594 0.789062 4.320312 0.789062 4.953125 C 0.789062 5.582031 1.300781 6.09375 1.929688 6.09375 Z M 1.929688 6.09375 "/>
				<path style=" stroke:none;fill-rule:nonzero;fill:rgb(0%,0%,0%);fill-opacity:1;" d="M 12.617188 12.238281 L 12.210938 12.238281 L 12.210938 4.1875 C 12.210938 3.980469 12.042969 3.808594 11.832031 3.808594 L 10.308594 3.808594 C 10.097656 3.808594 9.929688 3.980469 9.929688 4.1875 L 9.929688 12.238281 L 9.164062 12.238281 L 9.164062 6.476562 C 9.164062 6.265625 8.996094 6.09375 8.785156 6.09375 L 7.261719 6.09375 C 7.050781 6.09375 6.882812 6.265625 6.882812 6.476562 L 6.882812 12.238281 L 6.117188 12.238281 L 6.117188 9.523438 C 6.117188 9.3125 5.949219 9.140625 5.738281 9.140625 L 4.214844 9.140625 C 4.003906 9.140625 3.835938 9.3125 3.835938 9.523438 L 3.835938 12.238281 L 3.070312 12.238281 L 3.070312 8 C 3.070312 7.789062 2.902344 7.617188 2.691406 7.617188 L 1.167969 7.617188 C 0.957031 7.617188 0.789062 7.789062 0.789062 8 L 0.789062 12.238281 L 0.382812 12.238281 C 0.171875 12.238281 0 12.410156 0 12.617188 C 0 12.828125 0.171875 13 0.382812 13 L 12.617188 13 C 12.828125 13 13 12.828125 13 12.617188 C 13 12.410156 12.828125 12.238281 12.617188 12.238281 Z M 12.617188 12.238281 "/>
				</g>
			</svg> <span class="pl-1">إحصائيات</span></a>
            <button type="button" onclick="mobile_hide()" class="btn btn-default w-100 py-3 border font-weight-bold">
			<svg width="13pt" height="13pt" viewBox="0 0 13 13" >
				<g id="surface1">
				<path style=" stroke:none;fill-rule:nonzero;fill:rgb(0%,0%,0%);fill-opacity:1;" d="M 6.5 0 C 3.902344 0 1.792969 2.113281 1.792969 4.707031 C 1.792969 7.929688 6.003906 12.660156 6.183594 12.859375 C 6.351562 13.046875 6.648438 13.046875 6.816406 12.859375 C 6.996094 12.660156 11.207031 7.929688 11.207031 4.707031 C 11.207031 2.113281 9.097656 0 6.5 0 Z M 6.5 7.078125 C 5.195312 7.078125 4.132812 6.015625 4.132812 4.707031 C 4.132812 3.402344 5.195312 2.339844 6.5 2.339844 C 7.804688 2.339844 8.867188 3.402344 8.867188 4.707031 C 8.867188 6.015625 7.804688 7.078125 6.5 7.078125 Z M 6.5 7.078125 "/>
				</g>
			</svg> <span class="">الخريطة</span></button>
        </div>
    </div>
</div>
<div class="mobile-bar rounded-top" id="map-menu">
		<div class="btn-group d-flex">
            <button type="button" onclick="mobile_show()" class="btn btn-default w-100 py-3 border font-weight-bold">
			<svg width="13pt" height="13pt" viewBox="0 0 13 13">
				<g id="surface1">
				<path style=" stroke:none;fill-rule:nonzero;fill:rgb(0%,0%,0%);fill-opacity:1;" d="M 1.929688 6.09375 C 2.238281 6.09375 2.515625 5.96875 2.71875 5.773438 L 3.847656 6.335938 C 3.84375 6.382812 3.835938 6.425781 3.835938 6.476562 C 3.835938 7.105469 4.347656 7.617188 4.976562 7.617188 C 5.605469 7.617188 6.117188 7.105469 6.117188 6.476562 C 6.117188 6.296875 6.074219 6.132812 6.003906 5.984375 L 7.535156 4.457031 C 7.683594 4.527344 7.847656 4.570312 8.023438 4.570312 C 8.652344 4.570312 9.164062 4.058594 9.164062 3.429688 C 9.164062 3.308594 9.144531 3.195312 9.109375 3.089844 L 10.4375 2.09375 C 10.617188 2.214844 10.835938 2.285156 11.070312 2.285156 C 11.699219 2.285156 12.210938 1.773438 12.210938 1.140625 C 12.210938 0.511719 11.699219 0 11.070312 0 C 10.441406 0 9.929688 0.511719 9.929688 1.140625 C 9.929688 1.261719 9.949219 1.375 9.984375 1.480469 L 8.65625 2.476562 C 8.476562 2.355469 8.257812 2.285156 8.023438 2.285156 C 7.394531 2.285156 6.882812 2.796875 6.882812 3.429688 C 6.882812 3.605469 6.925781 3.769531 6.996094 3.917969 L 5.464844 5.445312 C 5.316406 5.375 5.152344 5.332031 4.976562 5.332031 C 4.667969 5.332031 4.390625 5.457031 4.1875 5.652344 L 3.058594 5.089844 C 3.0625 5.042969 3.074219 5 3.074219 4.953125 C 3.074219 4.320312 2.558594 3.808594 1.929688 3.808594 C 1.300781 3.808594 0.789062 4.320312 0.789062 4.953125 C 0.789062 5.582031 1.300781 6.09375 1.929688 6.09375 Z M 1.929688 6.09375 "/>
				<path style=" stroke:none;fill-rule:nonzero;fill:rgb(0%,0%,0%);fill-opacity:1;" d="M 12.617188 12.238281 L 12.210938 12.238281 L 12.210938 4.1875 C 12.210938 3.980469 12.042969 3.808594 11.832031 3.808594 L 10.308594 3.808594 C 10.097656 3.808594 9.929688 3.980469 9.929688 4.1875 L 9.929688 12.238281 L 9.164062 12.238281 L 9.164062 6.476562 C 9.164062 6.265625 8.996094 6.09375 8.785156 6.09375 L 7.261719 6.09375 C 7.050781 6.09375 6.882812 6.265625 6.882812 6.476562 L 6.882812 12.238281 L 6.117188 12.238281 L 6.117188 9.523438 C 6.117188 9.3125 5.949219 9.140625 5.738281 9.140625 L 4.214844 9.140625 C 4.003906 9.140625 3.835938 9.3125 3.835938 9.523438 L 3.835938 12.238281 L 3.070312 12.238281 L 3.070312 8 C 3.070312 7.789062 2.902344 7.617188 2.691406 7.617188 L 1.167969 7.617188 C 0.957031 7.617188 0.789062 7.789062 0.789062 8 L 0.789062 12.238281 L 0.382812 12.238281 C 0.171875 12.238281 0 12.410156 0 12.617188 C 0 12.828125 0.171875 13 0.382812 13 L 12.617188 13 C 12.828125 13 13 12.828125 13 12.617188 C 13 12.410156 12.828125 12.238281 12.617188 12.238281 Z M 12.617188 12.238281 "/>
				</g>
			</svg> <span class="pl-1">إحصائيات</span></button>
            <button type="button" onclick="mobile_hide()" class="btn btn-default w-100 py-3 border font-weight-bold">
			<svg width="13pt" height="13pt" viewBox="0 0 13 13" >
				<g id="surface1">
				<path style=" stroke:none;fill-rule:nonzero;fill:rgb(0%,0%,0%);fill-opacity:1;" d="M 6.5 0 C 3.902344 0 1.792969 2.113281 1.792969 4.707031 C 1.792969 7.929688 6.003906 12.660156 6.183594 12.859375 C 6.351562 13.046875 6.648438 13.046875 6.816406 12.859375 C 6.996094 12.660156 11.207031 7.929688 11.207031 4.707031 C 11.207031 2.113281 9.097656 0 6.5 0 Z M 6.5 7.078125 C 5.195312 7.078125 4.132812 6.015625 4.132812 4.707031 C 4.132812 3.402344 5.195312 2.339844 6.5 2.339844 C 7.804688 2.339844 8.867188 3.402344 8.867188 4.707031 C 8.867188 6.015625 7.804688 7.078125 6.5 7.078125 Z M 6.5 7.078125 "/>
				</g>
			</svg> <span class="">الخريطة</span></button>
        </div>
</div>
<script>if(screen.width<766){<?php map_local("M");?>}else{<?php map_local("D");?>}
var covid=L.map('covid').setView([Map_A,Map_B],Map_C);L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw',{attribution:'',maxZoom:10,id:'mapbox/light-v9',tileSize:512,zoomOffset:-1,}).addTo(covid);<?php map();?>function mobile_hide(){document.getElementById("nav-side").style.display="none";document.getElementById("map-menu").style.display="block"}
function mobile_show(){document.getElementById("nav-side").style.display="block";document.getElementById("map-menu").style.display="none"}</script>
		<div class="footer py-2 px-4">
        <div class="en text-right">
		<a style="color: #3498DB;" target="_blank" href="policy.html">Privacy Policy</a> |
		Made in 
		<svg class="bi bi-heart-fill text-danger" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor">
		  <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314z" clip-rule="evenodd"></path>
		</svg> Algeria</div>
    </div>	
</body>
</html>