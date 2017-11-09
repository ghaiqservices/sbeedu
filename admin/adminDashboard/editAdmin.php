<?php include('../../includes/configMysqli.php'); 

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: ../../login.php'); exit(); }

$sql="SELECT * FROM members where roleID=100";
$query=mysqli_query($conn, $sql);
$query=mysqli_fetch_array($query);

//if form has been submitted process it
if(isset($_POST['submit'])){
    
    //if (!isset($_POST['password'])) $error[] = "Please fill out all fields";
	//if (!isset($_POST['roleID'])) $error[] = "Please fill out all fields";	
	
	$_SESSION['role'] = $query['roleID'];
	$email = $query['email'];
	$username = $query['username'];		
	$pass = $_POST['password'];
	
	
	//image upload
	if (empty($_FILES['fileToUpload']['name']) && $_FILES['fileToUpload']['name']=='') {
		$imageupload = $query['imgName'];
		$current_url_one = $query['imgUrl'];
	}elseif(!empty($_FILES['fileToUpload']['name']) && $_FILES['fileToUpload']['name'] !=''){
		$imageupload = $_FILES["fileToUpload"]["name"];
		$userprofile->imageupload($imageupload);
		$current_url = explode("?",$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]);	
		$current_url=str_replace("/editAdmin.php", "/", $current_url[0]);
		$current_url_one = 'https://'.$current_url.'uploads/'.$_FILES["fileToUpload"]["name"];
	}else{
		$imageupload = 'User-blue-icon.png';
		$pth = 'User-blue-icon.png';
		$current_url = explode("?",$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]);	
		$current_url=str_replace("/adminDashboard/editAdmin.php", "/", $current_url[0]);		
		$current_url_one = 'https://'.$current_url.'images/'.$pth;
	}
	

	//if no errors have been created carry on
	if(!isset($error)){
	
		if(empty($_POST['password']) || $_POST['password'] == ''){
			$hashedpassword = $query['password'];
		}else{
			$hashedpassword = $user->password_hash($pass, PASSWORD_BCRYPT);
		}
		//create the activasion code
		//$activasion = md5(uniqid(rand(),true));

		try {
			
			$sql = "UPDATE members SET password ='".$hashedpassword."', imgName ='".$imageupload."', imgUrl ='".$current_url_one."'  WHERE roleID =100";
			$queryone=mysqli_query($conn, $sql);
			//$query=mysqli_fetch_array($query);
			$_SESSION['img']= $current_url_one;
			//send email
			$to = $email;
			$subject = "Update Profile succesfull.";
			$body = "<p>Thank you for update Profile.</p>
			<p>Your Username: $username</p>
			<p>Your Password: $pass</p>
			<p>Regards Site Admin</p>";
				
			$mail = new Mail();
			$mail->setFrom(SITEEMAIL);
			$mail->addAddress($to);
			$mail->subject($subject);
			$mail->body($body);
			$mail->send();
			//redirect to index page
			header('Location: editAdmin.php?action=succesfull');
		
		//else catch the exception and show the error.
		} catch(PDOException $e) {
		    $error[] = $e->getMessage();
		}

	}

}

//define page title
$title = 'Edit Admin Page';

//include header template
include('../layout/header.php');
?>
	
	<div class="main">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xs-12 page_heading">
					<h4><?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES); ?> dashbaord</h4>
				</div>
			</div>
			<form role="form" method="post" action="" autocomplete="off" enctype="multipart/form-data">
				<div class="row top_options">
					<div class="col-sm-9 col-xs-12">
						<div class="row">
							<div class="availablity_main" style="border-bottom: none;">							
								<h2 class="up_image">Update Profile</h2>
								<hr>						
								<?php
								//check for any errors
								if(isset($error)){
									foreach($error as $error){
										echo '<p class="bg-danger">'.$error.'</p>';
									}
								}

								//if action is joined show sucess
								if(isset($_GET['action']) && $_GET['action'] == 'succesfull'){
									echo "<h2 class='bg-success'>Update Profile succesfull.</h2>";
								}
								?>
								<div class="col-sm-6 col-xs-12">
									<div class="form-group input_border">
										<span><label for="inputEmail3" class="col-form-label">Username</label></span>
									 	<span><input type="text" class="form-control input_profile" value="<?php echo $query['username']; ?>" tabindex="1" readonly></span>
									</div>
								</div>
								<div class="col-sm-6 col-xs-12">
									<div class="form-group input_border">
										<span><label for="inputPassword3" class="col-form-label">Email</label></span>
										<span><input type="text" class="form-control input_profile" value="<?php echo $query['email']; ?>" tabindex="2" readonly></span>
									</div>
								</div>
								<div class="col-sm-6 col-xs-12">
									<div class="form-group input_border">
										<span><label for="inputPassword3" class="col-form-label">Password</label></span>
										<span><input type="password" name="password" class="form-control input_profile" id="password" placeholder="***********" tabindex="4"></span>
										<input class="form-control input-lg" disabled="" placeholder="password" name="password" type="hidden" value="<?php echo $query['password']; ?>">
									</div>
								</div>
								<div class="col-sm-6 col-xs-12">
									<div class="form-group input_border" style="border-bottom: 0;">
										<!--span><label for="inputPassword3" class="col-form-label">Profile Image</label></span>
										<span><input type="file" name="fileToUpload" class="form-control input_profile" id="fileToUpload" placeholder="Profile Image" onchange="readURL(this);" value="<?php //echo $query['imgUrl']; ?>" tabindex="3">
										</span-->
	    									<input name="fileToUpload" class="file" type="file" onchange="readURL(this);"  value="<?php echo $query['imgUrl']; ?>">
	      									<span class="input-group-addon"><i class="glyphicon glyphicon-picture"></i></span>
	      									<input class="form-control input-lg" disabled="" placeholder="Upload Image" type="text" value="<?php echo $query['imgName']; ?>">
	      									<span class="input-group-btn">
	        									<button class="browse btn btn-primary input-lg" type="button"><i class="glyphicon glyphicon-search"></i> Browse</button>
	      									</span>
									</div>
								</div>
								<div class="col-xs-12 col-sm-offset-3 col-sm-6 text-center">
									<div class="form-group">
										<input type="submit" name="submit" value="Register" class="text-uppercase btn btn-default btn-lg btn-block btn_register" tabindex="6">
										<!--<a href="#" class="text-uppercase btn btn-default btn-lg btn-block">Submit</a>-->
									</div>
								</div>
							</div>						
						</div>
					</div>
					<div class="col-sm-3 col-xs-12">
						<span>
							<img id="blah" class="img-responsive img-circle sngImg" src="<?php echo $query['imgUrl']; ?>" alt="your image"/>
						</span>
					</div>
			</form>
			<div class="row course_section">
				<div class="col-sm-12">
					<div class="course_main">
						<div class="course_heading">
							<p>All User Accounts Details.</p>
						</div>
						<div class="course_content">
							<div class="availablity_main">
								<table id="employee-grid"  cellpadding="0" cellspacing="0" border="0" class="display" width="100%">
									<thead>
										<tr>											
											<th>Sr No.</th>
											<th>Username</th>
											<th>Email</th>
											<th>Active</th>
											<th>Edit</th>
											<th>Delete</th>
										</tr>
									</thead>
								</table>
							</div>							
						</div>
					</div>
				</div>
				
			</div>
		</div>

<?php 
//include header template
include('../layout/footer.php'); 
?>