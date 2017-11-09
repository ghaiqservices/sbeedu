<?php require('includes/config.php'); 

//if logged in redirect to members page
if( $user->is_logged_in() ){ header('Location: memberpage.php'); exit(); }

$resetToken = hash('SHA256', ($_GET['key']));

$stmt = $db->prepare('SELECT resetToken, resetComplete FROM members WHERE resetToken = :token');
$stmt->execute(array(':token' => $resetToken));
$row = $stmt->fetch(PDO::FETCH_ASSOC);

//if no token from db then kill the page
if(empty($row['resetToken'])){
	$stop = 'Invalid token provided, please use the link provided in the reset email.';
} elseif($row['resetComplete'] == 'Yes') {
	$stop = 'Your password has already been changed!';
}

//if form has been submitted process it
if(isset($_POST['submit'])){

	if (!isset($_POST['password']) || !isset($_POST['passwordConfirm']))
		$error[] = 'Both Password fields are required to be entered';

	//basic validation
	if(strlen($_POST['password']) < 3){
		$error[] = 'Password is too short.';
	}

	if(strlen($_POST['passwordConfirm']) < 3){
		$error[] = 'Confirm password is too short.';
	}

	if($_POST['password'] != $_POST['passwordConfirm']){
		$error[] = 'Passwords do not match.';
	}

	//if no errors have been created carry on
	if(!isset($error)){

		//hash the password
		$hashedpassword = $user->password_hash($_POST['password'], PASSWORD_BCRYPT);

		try {

			$stmt = $db->prepare("UPDATE members SET password = :hashedpassword, resetComplete = 'Yes'  WHERE resetToken = :token");
			$stmt->execute(array(
				':hashedpassword' => $hashedpassword,
				':token' => $row['resetToken']
			));

			//redirect to index page
			header('Location: login.php?action=resetAccount');
			exit;

		//else catch the exception and show the error.
		} catch(PDOException $e) {
		    $error[] = $e->getMessage();
		}

	}

}

//define page title
$title = 'Reset Account';

//include header template
require('layout/header.php'); 
?>

	<div class="container-fluid bg-white">
        <div class="row no-gutters ">
		<?php if(isset($stop)){
	    	echo "<p class='bg-danger'>$stop</p>";
		}else{ 
		?>
            <div class="col-sm-3">
                <div class="login_bg sign_up">
                    <div class="logo">
                         <a href="#"><img src="images/logo.png" class="img-responsive" /></a>
                    </div>
                    <form role="form" method="post" action="" autocomplete="off">
						<h2>Change Password</h2>
						<?php
							//check for any errors
							if(isset($error)){
								foreach($error as $error){
									echo '<p class="bg-danger">'.$error.'</p>';
								}
							}

							//check the action
							switch ($_GET['action']) {
								case 'active':
									echo "<h2 class='bg-success'>Your account is now active you may now log in.</h2>";
									break;
								case 'reset':
									echo "<h2 class='bg-success'>Please check your inbox for a reset link.</h2>";
									break;
							}
						?>                        
                        <div class="form-group input_border">
                            <span><label for="inputPassword3" class="col-form-label">Password</label></span>
							<span><input type="password" name="password" class="form-control" id="password" placeholder="Password" required tabindex="1"></span>
                        </div>
						<div class="form-group input_border">
                            <span><label for="inputPassword3" class="col-form-label">Password</label></span>
							<span><input type="password" name="passwordConfirm" class="form-control" id="passwordConfirm" placeholder="Confirm Password" required tabindex="1"></span>
                        </div>
						
                        <div class="form-group">
							<input type="submit" name="submit" value="Change Password" class="text-uppercase btn btn-default btn-lg btn-block" tabindex="5">
							<!--<a href="#" class="text-uppercase btn btn-default btn-lg btn-block">Submit</a>-->
                        </div>
                    </form>
                    <div class="text-center forgot_password">
                        <p>Already a member? <a href='login.php'>Login</a></p>
                    </div>
                </div>
            </div>
		<?php } ?>
			<div class="col-sm-9 no_padding ">
				<div class="right_content">					
					<h1>Learning <br/>Management System</h1>
					<p>Provides courses that are designed and delivered by professionals <br/>
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