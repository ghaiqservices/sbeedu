<?php include('../../includes/config.php'); 

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: ../../login.php'); exit(); }

//if form has been submitted process it
if(isset($_POST['submit'])){

    if (!isset($_POST['username'])) $error[] = "Please fill out all fields";
    if (!isset($_POST['email'])) $error[] = "Please fill out all fields";
    if (!isset($_POST['password'])) $error[] = "Please fill out all fields";
	if (!isset($_POST['category'])) $error[] = "Please fill out all fields";
	if (!isset($_POST['firstName'])) $error[] = "Please fill out all fields";
	if (!isset($_POST['lastName'])) $error[] = "Please fill out all fields";
	//if (!isset($_POST['roleID'])) $error[] = "Please fill out all fields";
	
	$username = $_POST['username'];
	$firstName = $_POST['firstName'];
	$lastName = $_POST['lastName'];
	$categoryID = $_POST['category'];
	$pass = $_POST['password'];
	//very basic validation
	if(!$user->isValidUsername($username)){
		$error[] = 'Usernames must be at least 3 Alphanumeric characters';
	} else {
		$stmt = $db->prepare('SELECT username FROM members WHERE username = :username');
		$stmt->execute(array(':username' => $username));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if(!empty($row['username'])){
			$error[] = 'Username provided is already in use.';
		}

	}

	if(strlen($_POST['password']) < 3){
		$error[] = 'Password is too short.';
	}

	if(strlen($_POST['passwordConfirm']) < 3){
		$error[] = 'Confirm password is too short.';
	}

	if($_POST['password'] != $_POST['passwordConfirm']){
		$error[] = 'Passwords do not match.';
	}

	//email validation
	$email = htmlspecialchars_decode($_POST['email'], ENT_QUOTES);
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
	    $error[] = 'Please enter a valid email address';
	} else {
		$stmt = $db->prepare('SELECT email FROM members WHERE email = :email');
		$stmt->execute(array(':email' => $email));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if(!empty($row['email'])){
			$error[] = 'Email provided is already in use.';
		}

	}
	
	//image upload
			
	//image upload
	if (empty($_FILES['fileToUpload']['name']) && $_FILES['fileToUpload']['name']=='') {
		$imageupload = 'User-blue-icon.png';
		$pth = 'User-blue-icon.png';
		$current_url = explode("?",$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]);	
		$current_url=str_replace("/addUser/adduser.php", "/", $current_url[0]);		
		$current_url_one = 'https://'.$current_url.'images/'.$pth;
	}else{
		$imageupload = $_FILES["fileToUpload"]["name"];
		$userprofile->imageupload($imageupload);
		$current_url = explode("?",$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]);	
		$current_url=str_replace("/adduser.php", "/", $current_url[0]);
		$current_url_one = 'https://'.$current_url.'uploads/'.$_FILES["fileToUpload"]["name"];
	}

	//if no errors have been created carry on
	if(!isset($error)){

		//hash the password
		$hashedpassword = $user->password_hash($_POST['password'], PASSWORD_BCRYPT);

		//create the activasion code
		$activasion = md5(uniqid(rand(),true));

		try {

			//insert into database with a prepared statement
			$stmt = $db->prepare('INSERT INTO members (roleID,categoryID,firstName,lastName,username,password,email,active,imgName,imgUrl) VALUES (:roleID, :categoryID, :firstName, :lastName, :username, :password, :email, :active, :imgName, :imgUrl)');
			$stmt->execute(array(
				':roleID' => 101,
				':categoryID' => $categoryID,
				':firstName' => $firstName,
				':lastName' => $lastName,
				':username' => $username,
				':password' => $hashedpassword,
				':email' => $email,
				':active' => $activasion,
				':imgName' => $imageupload,
				':imgUrl' => $current_url_one
			));
			$id = $db->lastInsertId('memberID');

			//send email
			$to = $_POST['email'];
			$subject = "Registration Confirmation";
			$body = "<p>Thank you for registering at demo site.</p>
			<p>Your Username: $username</p>
			<p>Your Password: $pass</p>
			<p>To activate your account, please click on this link: <a href='".DIR."activate.php?x=$id&y=$activasion'>".DIR."activate.php?x=$id&y=$activasion</a></p>
			<p>Regards Site Admin</p>";

			$mail = new Mail();
			$mail->setFrom(SITEEMAIL);
			$mail->addAddress($to);
			$mail->subject($subject);
			$mail->body($body);
			$mail->send();

			//redirect to index page
			header('Location: adduser.php?action=succesfull');
			exit;

		//else catch the exception and show the error.
		} catch(PDOException $e) {
		    $error[] = $e->getMessage();
		}

	}

}

//define page title
$title = 'Role Page';

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
						<div class="availablity_main">
							
							<h2 class="up_image">Please Add User</h2>
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
								echo "<h2 class='bg-success'>Registration successful, please check User email to activate your account.</h2>";
							}
							?>
							<div class="col-xs-12 col-sm-6 col-md-4">
							<div class="form-group input_border">
								<span><label for="inputEmail3" class="col-form-label">First Name</label></span>
								 <span><input type="text" name="firstName" id="firstName" class="form-control input_profile" placeholder="First Name" required value="<?php echo $_POST['firstName']; ?>" tabindex="1"></span>
							</div>
							</div>
							<div class="col-xs-12 col-sm-6 col-md-4">
							<div class="form-group input_border">
								<span><label for="inputEmail3" class="col-form-label">Last Name</label></span>
								 <span><input type="text" name="lastName" id="lastName" class="form-control input_profile" placeholder="User Name" required value="<?php echo $_POST['lastName']; ?>" tabindex="2"></span>
							</div>
							</div>
							<div class="col-xs-12 col-sm-6 col-md-4">
							<div class="form-group input_border">
								<span><label for="inputEmail3" class="col-form-label">Username</label></span>
								 <span><input type="text" name="username" id="username" class="form-control input_profile" placeholder="User Name" required value="<?php if(isset($error)){ echo htmlspecialchars($_POST['username'], ENT_QUOTES); } ?>" tabindex="3"></span>
							</div>
							</div>
							<div class="col-xs-12 col-sm-6 col-md-4">
							<div class="form-group input_border">
								<span><label for="inputPassword3" class="col-form-label">Email</label></span>
								<span><input type="email" name="email" class="form-control input_profile" id="email" placeholder="Email" required value="<?php if(isset($error)){ echo htmlspecialchars($_POST['email'], ENT_QUOTES); } ?>" tabindex="4"></span>
							</div>
							</div>
							<div class="col-xs-12 col-sm-6 col-md-4">
							<div class="form-group input_border">
								<span><label for="inputPassword3" class="col-form-label">Password</label></span>
								<span><input type="password" name="password" class="form-control input_profile" id="password" placeholder="Password" required tabindex="5"></span>
							</div>
							</div>
							<div class="col-xs-12 col-sm-6 col-md-4">
							<div class="form-group input_border">
								<span><label for="inputPassword3" class="col-form-label">Password</label></span>
								<span><input type="password" name="passwordConfirm" class="form-control input_profile" id="passwordConfirm" placeholder="Confirm Password" required tabindex="6"></span>
							</div>
							</div>											
							<div class="col-xs-12 col-sm-6 col-md-4">
							<span><label for="inputEmail3" class="col-form-label">Only image files supported.</h6></label></span>
							<div class="form-group input_border" style="border-bottom: 0;">
	    						<input name="fileToUpload" class="file" type="file" onchange="readURL(this);"  value="<?php echo $query['imgUrl']; ?>" accept="image/*">
	      						<span class="input-group-addon"><i class="glyphicon glyphicon-picture"></i></span>
	      						<input class="form-control input-lg" disabled="" placeholder="Upload Image" type="text" tabindex="7" accept="
								image/*">
	      						<span class="input-group-btn">
	        						<button class="browse btn btn-primary input-lg" type="button"><i class="glyphicon glyphicon-search"></i> Browse</button>
	      						</span>
							</div>
							</div>
							<div class="col-xs-12 col-sm-6 col-md-4">
							<div class="form-group input_border">
								<span><label for="inputPassword3" class="col-form-label">Category</label></span>
								<span>
									<?php 
										$stmt = $db->prepare('SELECT * FROM category where categoryID != :categoryID');
										$stmt->execute((array(':categoryID' => 0)));
										//$result = $stmt->fetchAll();
									?>
									<select name="category" class="form-control" required tabindex="8">
									<option value="">Please select a category</option>
										<?php 
											while ($row = $stmt->fetch()){
												echo "<option name=".$row['categoryID']." value=".$row['categoryID'].">".$row['categoryName']."</option>";
											}
										?>        
									</select>
								</span>
							</div>
							</div>
							<div class="col-xs-12 col-sm-offset-3 col-sm-6">
							<div class="form-group">
								<input type="submit" name="submit" value="Register" class="text-uppercase btn btn-default btn-lg btn-block" tabindex="9">
								<!--<a href="#" class="text-uppercase btn btn-default btn-lg btn-block">Submit</a>-->
							</div>
							</div>
						</div>
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