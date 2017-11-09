<?php include ('../define.php'); ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>:: LMS ::</title>
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="../css/style.css" />
		<link rel="stylesheet" type="text/css" href="../css/bootstrap-reboot.min.css" />
		<link rel="stylesheet" type="text/css" href="../css/font-awesome.min.css" />
		<link rel="stylesheet" type="text/css" href="../css/developerstyle.css" />
		 
		<!--<script type="text/javascript">
			window.alert = function(){};
			var defaultCSS = document.getElementById('bootstrap-css');
			function changeCSS(css){
				if(css) $('head > link').filter(':first').replaceWith('<link rel="stylesheet" href="'+ css +'" type="text/css" />'); 
				else $('head > link').filter(':first').replaceWith(defaultCSS); 
			}
			$( document ).ready(function() {
			  var iframe_height = parseInt($('html').height()); 
			  window.parent.postMessage( iframe_height, 'https://bootsnipp.com');
			});
		</script>-->
	</head>
	<body>
	<div class="container-fluid header">
		<div class="row">
			<div class="col-sm-3">
				<div id="logo">
					<a href="#"><img src="../images/logo.png" class="img-responsive" /></a>
				</div>
			</div>
			<div class="col-sm-5">
				<p class="LMS">Learning Management System</p> 
				<div class="text-rightht"></div>
			</div>
			<div class="col-sm-4 text_class">
				<div class="search_message">
					<div class="message_icon">
						<i class="fa fa-envelope-o"></i>
						<div class="badge_star">
							<img src="../images/badgh.png" class="img-responsive" />
						</div>
					</div>					
					<form class="form-inline d_inline_block">
						<input type="text" class="form-control text-center" id="exampleInputEmail3" placeholder="Search" />
					</form>					
				</div>
			</div>
		</div>		
	</div>
	<div class="all_main">
		<nav class="navbar navbar-default sidebar sidebar_bg" role="navigation">
			<div class="container-fluid">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-sidebar-navbar-collapse-1">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<div class="profile_photo">					
						<a href="<?php echo userEdit_BASEURL; ?>">
							<div class="menu_icons <?php echo  $_SESSION['role'];?>"><img src="<?php echo $_SESSION['img']; ?>" class="img-responsive img-circle" /></div>
							<span class="name"><?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES); ?></span>
							<div class="three_dots"><span></span> <span></span> <span></span></div>
						</a>
					
					</div>
				</div>
				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="navbar-collapse collapse " id="bs-sidebar-navbar-collapse-1">
					<ul class="nav navbar-nav ">
						<li class="active">
							<a href="/lms/user/user.php">
								<img src="../images/icon_1.png" />
								<span class="menu_image">Dashboard</span>
							</a>
						</li>
						<li>
							<a href="../logout.php">
								<img src="../images/icon_2.png" />
								<span class="menu_image">Logout</span>
							</a>
						</li>												
					</ul>
				</div>
			</div>
		</nav>