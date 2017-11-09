<?php require('includes/config.php');

//if logged in redirect to members page
if( $user->is_logged_in() ){ header('Location: memberpage.php'); exit(); }

//if form has been submitted process it
if(isset($_POST['submit'])){

	//Make sure all POSTS are declared
	if (!isset($_POST['email'])) $error[] = "Please fill out all fields";


	//email validation
	if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
	    $error[] = 'Please enter a valid email address';
	} else {
		$stmt = $db->prepare('SELECT email FROM members WHERE email = :email');
		$stmt->execute(array(':email' => $_POST['email']));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if(empty($row['email'])){
			$error[] = 'Email provided is not recognised.';
		}

	}

	//if no errors have been created carry on
	if(!isset($error)){

		//create the activation code
		$stmt = $db->prepare('SELECT password, email FROM members WHERE email = :email');
		$stmt->execute(array(':email' => $_POST['email']));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		$token = hash_hmac('SHA256', $user->generate_entropy(8), $row['password']);//Hash and Key the random data
        $storedToken = hash('SHA256', ($token));//Hash the key stored in the database, the normal value is sent to the user

		try {

			$stmt = $db->prepare("UPDATE members SET resetToken = :token, resetComplete='No' WHERE email = :email");
			$stmt->execute(array(
				':email' => $row['email'],
				':token' => $storedToken
			));

			//send email
			$to = $row['email'];
			$subject = "Password Reset";
			$body = "<p>Someone requested that the password be reset.</p>
			<p>If this was a mistake, just ignore this email and nothing will happen.</p>
			<p>To reset your password, visit the following address: <a href='".DIR."resetPassword.php?key=$token'>".DIR."resetPassword.php?key=$token</a></p>";

			$mail = new Mail();
			$mail->setFrom(SITEEMAIL);
			$mail->addAddress($to);
			$mail->subject($subject);
			$mail->body($body);
			$mail->send();

			//redirect to index page
			header('Location: login.php?action=reset');
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
            <div class="col-sm-3">
                <div class="login_bg ">
                    <div class="logo">
                         <a href="#"><img src="images/logo.png" class="img-responsive" /></a>
                    </div>
                    <form role="form" method="post" action="" autocomplete="off">
						<p><a href='login.php'>Back to login page</a></p>
						<?php
						//check for any errors
						if(isset($error)){
							foreach($error as $error){
								echo '<p class="bg-danger">'.$error.'</p>';
							}
						}

						if(isset($_GET['action'])){

							//check the action
							switch ($_GET['action']) {
								case 'active':
									echo "<h2 class='bg-success'>Your account is now active you may now log in.</h2>";
									break;
								case 'reset':
									echo "<h2 class='bg-success'>Please check your inbox for a reset link.</h2>";
									break;
							}
						}
						?>
                        <div class="form-group input_border">
							<span><label for="inputEmail3" class="col-form-label">Email</label></span>
                             <span><input type="email" name="email" id="email" class="form-control" placeholder="Email" value="" tabindex="1">
                        </div>
                        <div class="form-group">
							<input type="submit" name="submit" value="Submit" class="text-uppercase btn btn-default btn-lg btn-block" tabindex="2">
							<!--<a href="#" class="text-uppercase btn btn-default btn-lg btn-block">Submit</a>-->
                        </div>
                    </form>
                </div>
            </div>
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
