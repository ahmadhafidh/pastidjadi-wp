<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
                <meta charset="<?php bloginfo( 'charset' ); ?>">
                <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <link rel="profile" href="https://gmpg.org/xfn/11">
                
                <link href="//www.google-analytics.com" rel="dns-prefetch">
                <link href="<?php echo get_template_directory_uri(); ?>/assets/img/icons/favicon.ico" rel="shortcut icon">
                <link href="<?php echo get_template_directory_uri(); ?>/assets/img/icons/touch.png" rel="apple-touch-icon-precomposed">
				<link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
		<meta name="description" content="<?php bloginfo('description'); ?>">
                
                <?php wp_head(); ?>
                
		<script>
                        // conditionizr.com
                        // configure environment tests
                        conditionizr.config({
                            assets: '<?php echo get_template_directory_uri(); ?>',
                            tests: {}
                        });
                </script>
				<style>
			
			@import url(https://fonts.googleapis.com/css?family=Montserrat:400,700);
header {
	
	margin:0; font-family: 'Montserrat', sans-serif !important;}

.topnav {
	font-family: 'Montserrat', sans-serif !important;
  overflow: hidden;
  margin-top: 30px;
  margin-bottom: 100px;
}

.topnav a {
  float: right;
  display: block;
  color: #f2f2f2;
  font-weight: 700;
  text-align: center;
  padding: 10px 20px 10px 20px;
  text-decoration: none;
  font-size: 17px;
}

.active {
  background-color: #EF9F3D;
  color: white;
}

.topnav .icon {
  display: none;
  
}

.dropdown {
  float: right;
  overflow: hidden;
}


.dropdown .dropbtn {
  font-size: 17px;    
  border: none;
  outline: none;
  color: white;
  padding: 10px 20px 10px 20px;

  background-color: inherit;
  font-family: inherit;
  margin: 0;
}

.dropdown-content {
  display: none;
  position: absolute;
  background-color: transparent;
  border: 1px solid #EF9F3D;
  border-radius: 0 20px 20px 20px;
  min-width: 160px;
  padding-top:10px;
  padding-bottom:10px;

  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

.dropdown-content a {
  float: none;
  color: black;
  font-weight:600;
  padding-left: 20px;
  font-size: 12px !important;
  text-decoration: none;
  display: block;
  text-align: left;
}

.topnav a:hover, .dropdown:hover .dropbtn {
  /* background-color: #555; */
  color: #555;
}

 .dropdown-content a:hover {
  
  color: black;
} 

.dropdown:hover .dropdown-content {
  display: block;
}

@media screen and (max-width: 600px) {
	.topnav{
		margin-top: 0px;
		background-color: #EF9F3D;


	}
	.topnav a{
		margin: 0px;
		float: right;

	}
  .topnav a:not(:first-child), .dropdown .dropbtn {
    display: none;
	float: right;

	margin: 0px;

  }
  .topnav a.icon {
    float: left;
    display: block;
  }
}

@media screen and (max-width: 600px) {
  .topnav.responsive {position: relative;
  }
  .topnav.responsive .icon {
	
    position: absolute;
    right: 1;
    top: 0;
  }
  .topnav.responsive a {
    float: none;
    display: block;
    text-align: center;
	margin-right: 10%;
	color: white !important;
	font-size: 15px !important;
  }
  .topnav.responsive .dropdown {float: none; color: white;}
  .topnav.responsive .dropdown-content {position: relative; color: white;
	box-shadow: 0px 0px 0px 0px rgba(0,0,0,0);
  margin-left: 10%;
  border-radius:0px;
  text-align: center;}
  .topnav.responsive .dropdown .dropbtn { 
	  color: white !important;
    display: block;
    width: 100%;
    text-align: center;
	font-size: 15px !important;
	
	
  }
  .mycss3{
	  display: none;
  }
}

.mycss1{
	border-radius: 20px;
	font-size: 12px !important;
	margin-right:15%;

}

.mycss2{
	font-size: 12px !important;
	margin-right:40px;
	font-weight: bold;
	color: #EF9F3D !important;
}
.mycss3{
	  margin-left: 5%;
	  margin-top: -10px;
	  z-index: 1;
	  position: absolute;
	  
  }
</style>

	</head>
	<body <?php body_class(); ?>>

		<!-- wrapper -->
		<div class="wrapper" style="z-index: 1; background-color: transparent !important;">

			<!-- header -->
			<header class="header clear" role="banner">

			<div class="topnav" id="myTopnav">
			<img src="https://kitatechnology.com/staging/pastidjadi-wp/wp-content/uploads/elementor/thumbs/Logo-PT-Pasti-Djadi-ogbh3urg43390fuzlaot4hdhh6em68yki2dy24loo8.png" alt="" class="mycss3">
			<a href="#home" class="mycss1 active">CONTACT US</a>
			<a href="#news" class="mycss2">CAREERS</a>

			<div class="dropdown mycss2" >
				<button class="dropbtn mycss2">ABOUT US 
				<!-- <i class="fa fa-caret-down"></i> -->
				</button>
				<div class="dropdown-content">
				<a href="#">CUSTOM PAINT</a>
				<a href="#">APPLICATION IDEAS</a>
				<a href="#">PAINT-IT-YOURSELF</a>
				</div>
			</div> 
			
			<div class="dropdown mycss2">
				<button class="dropbtn mycss2">OUR PRODUCTS 
				<!-- <i class="fa fa-caret-down"></i> -->
				</button>
				<div class="dropdown-content">
				<a href="#">PRIMER COATING PAINT</a>
				<a href="#">FINISHING PAINT</a>
				<a href="#">SPECIALITY PAINT</a>
				</div>
			</div> 
  
  
  <a href="javascript:void(0);" style="font-size:15px;" class="icon" onclick="myFunction()">&#9776;</a>
</div>

<script>
function myFunction() {
  var x = document.getElementById("myTopnav");
  if (x.className === "topnav") {
    x.className += " responsive";
  } else {
    x.className = "topnav";
  }
}


</script>

			</header>
			<!-- /header -->
