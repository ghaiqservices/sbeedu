<?php require('includes/config.php');

//if logged in redirect to members page
if( $user->is_logged_in() ){
	$user = $_SESSION['username'];
	$stmt = $db->prepare('SELECT r.roleID FROM members as m inner join roles as r on m.roleID=r.roleID WHERE m.username = :username');
	$stmt->execute(array(':username' => $user));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	if($row['roleID'] == 100){
		header('Location: admin/adminDashboard/adminDasboard.php'); exit();
	}else{
		echo "Coming Soon. Please Wait for User Section!!!!!!!";
		//header('Location: memberpage.php');
		exit();
	}
}

//if form has been submitted process it
if(isset($_POST['submit'])){

    if (!isset($_POST['username'])) $error[] = "Please fill out all fields";
    if (!isset($_POST['email'])) $error[] = "Please fill out all fields";
    if (!isset($_POST['password'])) $error[] = "Please fill out all fields";
	//if (!isset($_POST['roleID'])) $error[] = "Please fill out all fields";
	
	$username = $_POST['username'];
	$rID = $_POST['roleID'];
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
	
	$imageupload = 'User-blue-icon.png';
	$pth = 'User-blue-icon.png';
	$current_url = explode("?",$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]);	
	$current_url=str_replace("/index.php", "/", $current_url[0]);		
	$current_url_one = 'https://'.$current_url.'images/'.$pth;
	
	$_SESSION['imgUrl']=$current_url_one;

	//if no errors have been created carry on
	if(!isset($error)){

		//hash the password
		$hashedpassword = $user->password_hash($_POST['password'], PASSWORD_BCRYPT);
		//$enc = base64_encode($_POST['password']);
		//create the activasion code
		$activasion = md5(uniqid(rand(),true));

		try {

			//insert into database with a prepared statement
			$stmt = $db->prepare('INSERT INTO members (roleID,categoryID,username,password,email,active,imgName,imgUrl) VALUES (:roleID, :categoryID, :username, :password, :email, :active, :imgName, :imgUrl)');
			$stmt->execute(array(
				':roleID' => $rID,
				':categoryID' => 0,
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
			<p>To activate your account, please click on this link: <a href='".DIR."activate.php?x=$id&y=$activasion'>".DIR."activate.php?x=$id&y=$activasion</a></p>
			<p>Regards Site Admin</p>";

			$mail = new Mail();
			$mail->setFrom(SITEEMAIL);
			$mail->addAddress($to);
			$mail->subject($subject);
			$mail->body($body);
			$mail->send();

			//redirect to index page
			header('Location: index.php?action=joined');
			exit;

		//else catch the exception and show the error.
		} catch(PDOException $e) {
		    $error[] = $e->getMessage();
		}

	}

}

//define page title
$title = 'Demo';

//include header template
require('layout/header.php');
?>

	<div class="container-fluid bg-white">
        <div class="row no-gutters ">
            <div class="col-sm-3">
                <div class="login_bg sign_up">
                    <div class="logo">
                         <a href="#"><img src="images/logo.png" class="img-responsive" /></a>
                    </div>
                    <form role="form" method="post" action="" autocomplete="off">
						<h2>Please Sign Up</h2>
						<hr>

						<?php
						//check for any errors
						if(isset($error)){
							foreach($error as $error){
								echo '<p class="bg-danger">'.$error.'</p>';
							}
						}

						//if action is joined show sucess
						if(isset($_GET['action']) && $_GET['action'] == 'joined'){
							echo "<h2 class='bg-success'>Registration successful, please check your email to activate your account.</h2>";
						}
						?>
                        <div class="form-group input_border">
							<span><label for="inputEmail3" class="col-form-label">Username</label></span>
                             <span><input type="text" name="username" id="username" class="form-control" placeholder="User Name" required value="<?php if(isset($error)){ echo htmlspecialchars($_POST['username'], ENT_QUOTES); } ?>" tabindex="1"></span>
                        </div>
						<div class="form-group input_border">
                            <span><label for="inputPassword3" class="col-form-label">Email</label></span>
							<span><input type="email" name="email" class="form-control" id="email" placeholder="Email" required value="<?php if(isset($error)){ echo htmlspecialchars($_POST['email'], ENT_QUOTES); } ?>" tabindex="2"></span>
                        </div>						
                        <div class="form-group input_border">
                            <span><label for="inputPassword3" class="col-form-label">Password</label></span>
							<span><input type="password" name="password" class="form-control" id="password" placeholder="Password" required tabindex="3"></span>
                        </div>
						<div class="form-group input_border">
                            <span><label for="inputPassword3" class="col-form-label">Password</label></span>
							<span><input type="password" name="passwordConfirm" class="form-control" id="passwordConfirm" placeholder="Confirm Password" required tabindex="4"></span>
                        </div>
						
						<div class="form-group input_border">
                            <span><label for="inputPassword3" class="col-form-label">Category</label></span>
							<span>
								<?php 
									$stmt = $db->prepare('SELECT roleID, roleName FROM roles WHERE roleID = :roleID');
									$stmt->execute(array(':roleID' => 100));
									$row = $stmt->fetch(PDO::FETCH_ASSOC);
								?>
								<select name="roleID" tabindex="5" required>
									<?php									
											echo "<option name=".$row['roleID']." value=".$row['roleID'].">".$row['roleName']."</option>";
									?>        
								</select>
							</span>
                        </div>
                        <div class="form-group">
							<input type="submit" name="submit" value="Register" class="text-uppercase btn btn-default btn-lg btn-block" tabindex="6">
							<!--<a href="#" class="text-uppercase btn btn-default btn-lg btn-block">Submit</a>-->
                        </div>
                    </form>
                    <div class="text-center forgot_password">
                        <p>Already a member? <a href='login.php'>Login</a></p>
                    </div>
                </div>
            </div>
			<div class="col-sm-9 no_padding ">
				<div class="right_content">					
					<h1>Learning <br/>Management System</h1>
					<p>Provide courses that are designed and delivered by professionals <br/>
						from the different field of education. All you need is entirely online, <br/>
						in a range of subject areas. 
					</p>
				</div>
			</div>
		</div>
    </div>

<?php
//include header template
require('layout/footer.php');
?>
