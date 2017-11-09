<?php include('../../includes/configMysqli.php'); 

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: ../../login.php'); exit(); }

$userID=$_GET['id'];
$sql="SELECT * FROM members where memberID=".$userID;
$result=mysqli_query($conn, $sql);
while($query=mysqli_fetch_array($result)){
	$memberID_query = $query['memberID'];
	$roleID_query = $query['roleID'];
	$categoryID_query = $query['categoryID'];
	$firstName_query = $query['firstName'];
	$lastName_query = $query['lastName'];
	$username_query = $query['username'];
	$password_query = $query['password'];
	$email_query = $query['email'];
	$active_query = $query['active'];
	$imgName_query = $query['imgName'];
	$imgUrl_query = $query['imgUrl'];
	$resetToken_query = $query['resetToken'];
	$resetComplete_query = $query['resetComplete'];
}
//if form has been submitted process it
if(isset($_POST['submit'])){
	
	$memberID = $_POST['memberID'];
	$roleID = $_POST['roleID'];
	$categoryID = $_POST['categoryName'];
	$firstName = $_POST['firstName'];
	$lastName = $_POST['lastName'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	$email = $_POST['email'];
	$active = $_POST['active'];
	$imgName = $_POST['imgName'];
	$imgUrl = $_POST['imgUrl'];
	$resetToken = $_POST['resetToken'];
	$resetComplete = $_POST['resetComplete'];
	
	//image upload
	if (empty($_FILES['fileToUpload']['name']) && $_FILES['fileToUpload']['name']=='') {
		$imageupload = $imgName_query;
		$current_url_one = $imgUrl_query;
	}elseif(!empty($_FILES['fileToUpload']['name']) && $_FILES['fileToUpload']['name'] !=''){
		$imageupload = $_FILES["fileToUpload"]["name"];
		$userprofile->imageupload($imageupload);
		$current_url = explode("?",$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]);	
		$current_url=str_replace("/userEdit.php", "/", $current_url[0]);
		$current_url_one = 'https://'.$current_url.'uploads/'.$_FILES["fileToUpload"]["name"];
	}else{
		$imageupload = 'User-blue-icon.png';
		$pth = 'User-blue-icon.png';
		$current_url = explode("?",$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]);	
		$current_url=str_replace("/addUser/userEdit", "/", $current_url[0]);		
		$current_url_one = 'https://'.$current_url.'images/'.$pth;
	}
	

	//if no errors have been created carry on
	if(!isset($error)){
	
		if(empty($_POST['password']) || $_POST['password'] == ''){
			$hashedpassword = $password_query;
		}else{
			$hashedpassword = $user->password_hash($password, PASSWORD_BCRYPT);
		}

		try {
			
			// Check connection
			if($conn === false){
				die("ERROR: Could not connect. " . mysqli_connect_error());
			}
			
			$sql = "UPDATE members SET categoryID =".$categoryID.", lastName ='".$lastName."', firstName ='".$firstName."', password ='".$hashedpassword."', imgName ='".$imageupload."', imgUrl ='".$current_url_one."'  WHERE memberID=".$userID;
			
			$query=mysqli_query($conn, $sql);			
			
			//redirect to index page
			header('Location: adduser.php');
		
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
					<h4><?php echo htmlspecialchars($username_query, ENT_QUOTES); ?> dashbaord</h4>
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
										<span><label for="inputEmail3" class="col-form-label">First Name</label></span>
									 	<span><input type="text" name="firstName" class="form-control input_profile" value="<?php echo $firstName_query; ?>" tabindex="1" Placeholder="First Name"></span>
									</div>
								</div>
								<div class="col-sm-6 col-xs-12">
									<div class="form-group input_border">
										<span><label for="inputEmail3" class="col-form-label">Last Name</label></span>
									 	<span><input type="text" name="lastName" class="form-control input_profile" value="<?php echo $lastName_query; ?>" tabindex="1" Placeholder="Last Name"></span>
									</div>
								</div>
								<div class="col-sm-6 col-xs-12">
									<div class="form-group input_border">
										<span><label for="inputEmail3" class="col-form-label">Username</label></span>
									 	<span><input type="text" class="form-control input_profile" value="<?php echo $username_query; ?>" tabindex="2" readonly></span>
									</div>
								</div>
								<div class="col-sm-6 col-xs-12">
									<div class="form-group input_border">
										<span><label for="inputPassword3" class="col-form-label">Email</label></span>
										<span><input type="text" class="form-control input_profile" value="<?php echo $email_query; ?>" tabindex="3" readonly></span>
									</div>
								</div>
								<div class="col-sm-6 col-xs-12">
									<div class="form-group input_border">
										<span><label for="inputPassword3" class="col-form-label">Password</label></span>
										<span><input type="password" name="password" class="form-control input_profile" id="password" placeholder="***********" tabindex="4"></span>
										<input class="form-control input-lg" disabled="" placeholder="password" name="password" type="hidden" value="<?php echo $password_query; ?>">
									</div>
								</div>
								<div class="col-sm-6 col-xs-12">
									<div class="form-group input_border">
										<span><label for="inputPassword3" class="col-form-label">Category</label></span>
										<span>
											<select name="categoryName" tabindex="5">
													<option value="">Please selec the category.</option>
											<?php	$userID=$_GET['id'];
													$sqlcat="SELECT * FROM category where categoryID <> 0";
													$result=mysqli_query($conn, $sqlcat);
													while($row=mysqli_fetch_array($result)){ ?>
													
													<option value="<?php echo $row['categoryID'];?>"
															<?php if($row['categoryID'] == $categoryID_query)
																	echo 'selected = "selected"'; ?>>
															<?php echo $row['categoryName'];?>
													</option>
													
											<?php } ?>
											</select>
										</span>
									</div>
								</div>
								<div class="col-sm-6 col-xs-12">
									<div class="form-group input_border" style="border-bottom: 0;">										
	    									<input name="fileToUpload" class="file" type="file" onchange="readURL(this);"  value="<?php echo $imgName_query; ?>">
	      									<span class="input-group-addon"><i class="glyphicon glyphicon-picture"></i></span>
	      									<input class="form-control input-lg" disabled="" placeholder="Upload Image" type="text" value="<?php echo $imgName_query; ?>">
	      									<span class="input-group-btn">
	        									<button class="browse btn btn-primary input-lg" type="button"><i class="glyphicon glyphicon-search"></i> Browse</button>
	      									</span>
									</div>
								</div>
								<div class="col-xs-12 col-sm-offset-3 col-sm-6 text-center">
									<div class="form-group">
										<input type="submit" name="submit" value="Register" class="text-uppercase btn btn-default btn-lg btn-block btn_register" tabindex="7">
										<!--<a href="#" class="text-uppercase btn btn-default btn-lg btn-block">Submit</a>-->
									</div>
								</div>
							</div>						
						</div>
					</div>
					<div class="col-sm-3 col-xs-12">
						<span>
							<img id="blah" class="img-responsive img-circle sngImg" src="<?php echo $imgUrl_query; ?>" alt="your image"/>
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
								<table id="employee-grid-user"  cellpadding="0" cellspacing="0" border="0" class="display" width="100%">
									<thead>
										<tr>
											<th>Sr No.</th>
											<th>Profile Image</th>
											<th>First Name</th>
											<th>Last Name</th>
											<th>User Name</th>																	
											<th>Email</th>
											<th>Category</th>									
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