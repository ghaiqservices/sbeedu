<?php
//include config
require_once('includes/config.php');
//check if already logged in move to home page
	if( $user->is_logged_in() ){
		if($_SESSION['role'] == 100 ){
			$_SESSION['img'] = $row['imgUrl'];
			$_SESSION['role'] = $row['roleID'];
			header('Location: admin/adminDashboard/adminDasboard.php'); exit();
		}elseif($row['roleID'] != 100){
			$_SESSION['img'] = $row['imgUrl'];
			$_SESSION['role'] = $row['roleID'];
			//echo "Coming Soon. Please Wait for User Section!!!!!!!";
			header('Location: user/user.php'); exit();				
		}
	 exit(); 
	}


//process login form if submitted
if(isset($_POST['submit'])){

	if (!isset($_POST['username'])) $error[] = "Please fill out all fields 1";
	if (!isset($_POST['password'])) $error[] = "Please fill out all fields 2";

	$username = $_POST['username'];
	if ( $user->isValidUsername($username)){
		if (!isset($_POST['password'])){
			$error[] = 'A password must be entered';
		}
		$password = $_POST['password'];

		if($user->login($username,$password)){		
			$_SESSION['username'] = $username;
			$stmt = $db->prepare('SELECT r.roleID, m.imgUrl FROM members as m inner join roles as r on m.roleID=r.roleID WHERE m.username = :username');
			$stmt->execute(array(':username' => $_SESSION['username']));
			$row = $stmt->fetch(PDO::FETCH_ASSOC);			
			if($row['roleID'] == 100 ){
				$_SESSION['img'] = $row['imgUrl'];
				$_SESSION['role'] = $row['roleID'];
				header('Location: admin/adminDashboard/adminDasboard.php'); exit();
			}elseif($row['roleID'] != 100){
				$_SESSION['img'] = $row['imgUrl'];
				$_SESSION['role'] = $row['roleID'];
				//echo "Coming Soon. Please Wait for User Section!!!!!!!";
				header('Location: user/user.php'); exit();				
			}else{
				$error[] = 'Wrong username or password or your account has not been activated.';
			}	
		exit();
		} else {
			$error[] = 'Wrong username or password or your account has not been activated.';
		}
	}else{
		$error[] = 'Usernames are required to be Alphanumeric, and between 3-16 characters long';
	}



}//end if submit

//define page title
$title = 'Login';

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
								case 'resetAccount':
									echo "<h2 class='bg-success'>Password changed, you may now login.</h2>";
									break;
							}
						}						
					?>
                        <div class="form-group input_border">
							<span><label for="inputEmail3" class="col-form-label">Username</label></span>
                             <span><input type="text" name="username" class="form-control" id="inputEmail3" placeholder="Username" required value="<?php if(isset($error)){ echo htmlspecialchars($_POST['username'], ENT_QUOTES); } ?>" tabindex="1"></span>
                        </div>
                        <div class="form-group input_border">
                            <span><label for="inputPassword3" class="col-form-label">Password</label></span>
							<span><input type="password" name="password" class="form-control" id="password" placeholder="Password" required tabindex="2"></span>
                        </div>
                        <div class="form-group">
							<input type="submit" name="submit" value="Submit" class="text-uppercase btn btn-default btn-lg btn-block" tabindex="3">
							<!--<a href="#" class="text-uppercase btn btn-default btn-lg btn-block">Submit</a>-->
                        </div>
                    </form>
                    <div class="text-center forgot_password">
                        <a href="reset.php" tabindex="4">Forgot Password ?</a>
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
//include footer template
require('layout/footer.php'); 
?>