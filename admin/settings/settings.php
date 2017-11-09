<?php include('../../includes/configMysqli.php'); 

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: ../../login.php'); exit(); }
if(isset($_POST['submit'])){

    if (!isset($_POST['settingLogoImg'])) $error[] = "Please fill out all fields";
    if (!isset($_POST['settingLogoText'])) $error[] = "Please fill out all fields";
    if (!isset($_POST['settingTitle'])) $error[] = "Please fill out all fields";
	if (!isset($_POST['settingCopy'])) $error[] = "Please fill out all fields";
	//if (!isset($_POST['roleID'])) $error[] = "Please fill out all fields";
	
	$settingLogoImg = $_POST['settingLogoImg'];
	$categoryID = $_POST['settingLogoText'];
	$settingTitle = $_POST['settingTitle'];
	$settingCopy = $_POST['settingCopy'];
	//very basic validation

	
	//image upload
			
	//image upload
	if (empty($_FILES['settingLogoImg']['name']) && $_FILES['settingLogoImg']['name']=='') {
		$imageupload = 'User-blue-icon.png';
		$pth = 'User-blue-icon.png';
		$current_url = explode("?",$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]);	
		$current_url=str_replace("/settings/settings.php", "/", $current_url[0]);		
		$current_url_one = 'https://'.$current_url.'images/'.$pth;
	}else{
		$imageupload = $_FILES["settingLogoImg"]["name"];
		$userprofile->imageupload($imageupload);
		$current_url = explode("?",$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]);	
		$current_url=str_replace("/settings.php", "/", $current_url[0]);
		$current_url_one = 'https://'.$current_url.'uploads/'.$_FILES["settingLogoImg"]["name"];
	}

	//if no errors have been created carry on
	if(!isset($error)){

		//hash the password
		//$hashedpassword = $user->password_hash($_POST['password'], PASSWORD_BCRYPT);

		//create the activasion code
		//$activasion = md5(uniqid(rand(),true));

		try {

			//insert into database with a prepared statement
			$stmt = $db->prepare('INSERT INTO setting (settingLogoImg,settingLogoText,settingTitle,settingCopy) VALUES ( :settingLogoImg, :settingLogoText, :settingTitle, :settingCopy)');
			
			$stmt->execute(array(
				
				':settingLogoImg' => $settingLogoImg,
				':settingLogoText' => $settingLogoText,
				':settingTitle' => $settingTitle,
				':settingCopy' => $settingCopy
				
			));
			$id = $db->lastInsertId('memberID');

			//send email
			

			//redirect to index page
			header('Location: settings.php?action=succesfull');
			exit;

		//else catch the exception and show the error.
		} catch(PDOException $e) {
		    $error[] = $e->getMessage();
		}

	}

}

//define page title
$title = 'Role Page';
?>
<?php 
 
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
							
							<h2 class="up_image">Settings</h2>
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
								<span><label for="inputEmail3" class="col-form-label">Logo Image</label></span>
								 <span><input type="file" name="settingLogoImg" id="settingLogoImg" class="form-control input_profile" placeholder="Logo Image" required value="<?php if(isset($error)){ echo htmlspecialchars($_POST['settingLogoImg'], ENT_QUOTES); } ?>" tabindex="1"></span>
							</div>
							</div>
							<div class="col-xs-12 col-sm-6 col-md-4">
							<div class="form-group input_border">
								<span><label for="inputPassword3" class="col-form-label">Logo Text</label></span>
								<span><input type="text" name="settingLogoText" class="form-control input_profile" id="settingLogoText" placeholder="Logo Text" required value="<?php if(isset($error)){ echo htmlspecialchars($_POST['settingLogoText'], ENT_QUOTES); } ?>" tabindex="2"></span>
							</div>
							</div>
							<div class="col-xs-12 col-sm-6 col-md-4">
							<div class="form-group input_border">
								<span><label for="inputPassword3" class="col-form-label">Title</label></span>
								<span><input type="text" name="settingTitle" class="form-control input_profile" id="settingTitle" placeholder="Title" required tabindex="4"></span>
							</div>
							</div>
							<div class="col-xs-12 col-sm-6 col-md-4">
							<div class="form-group input_border">
								<span><label for="inputPassword3" class="col-form-label">Copyright</label></span>
								<span><input type="text" name="settingCopy" class="form-control input_profile" id="settingCopy" placeholder="Copyright" required tabindex="5"></span>
							</div>
							</div>
							<!--div class="col-xs-12 col-sm-6 col-md-4">
							<div class="form-group input_border">
								<span><label for="inputPassword3" class="col-form-label">Profile Image</label></span>
								<span><input type="file" name="fileToUpload" class="form-control input_profile" id="fileToUpload" placeholder="Profile Image" required value="<?php //if(isset($error)){ echo htmlspecialchars($_POST['fileToUpload'], ENT_QUOTES); } ?>" tabindex="3"></span>
							</div>
							</div>
											
							<div class="col-xs-12 col-sm-6 col-md-4">
							<div class="form-group input_border" style="border-bottom: 0;">
	    						<input name="fileToUpload" class="file" type="file" onchange="readURL(this);"  value="<?php echo $query['imgUrl']; ?>">
	      						<span class="input-group-addon"><i class="glyphicon glyphicon-picture"></i></span>
	      						<input class="form-control input-lg" disabled="" placeholder="Upload Image" type="text">
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
										//$stmt = $db->prepare('SELECT * FROM category where categoryID != :categoryID');
										//$stmt->execute((array(':categoryID' => 0)));
										//$result = $stmt->fetchAll();
									?>
									<select name="category" class="form-control" required>
									<option value="">Please select a category</option>
										<?php 
											//while ($row = $stmt->fetch()){
												//echo "<option name=".$row['categoryID']." value=".$row['categoryID'].">".$row['categoryName']."</option>";
											//}
										?>        
									</select>
								</span>
							</div>
							</div>-->
							<div class="col-xs-12 col-sm-offset-3 col-sm-6">
							<div class="form-group">
								<input type="submit" name="submit" value="Submit" class="text-uppercase btn btn-default btn-lg btn-block" tabindex="6">
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
							<p>All Settings.</p>
						</div>
						<div class="course_content">
							<div class="availablity_main">
								<table id="employee-grid-user"  cellpadding="0" cellspacing="0" border="0" class="display" width="100%">
									<thead>
										<tr>
											<th>SettingID.</th>
											<th>settingLogoImg/th>
											<th>settingLogoText</th>																
											<th>settingTitle</th>
											<th>settingCopy</th>
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