<?php include('../../includes/configMysqli.php'); 

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: ../../login.php'); exit(); }

//if form has been submitted process it
if(isset($_POST['submit'])){

    if (!isset($_POST['courseName'])) $error[] = "Please fill out all fields";
    if (!isset($_POST['courseUnits'])) $error[] = "Please fill out all fields";
	if (!isset($_POST['courseDesc'])) $error[] = "Please fill out all fields";
	if (!isset($_POST['courseMode'])) $error[] = "Please fill out all fields";
	if (!isset($_POST['courseStart'])) $error[] = "Please fill out all fields";
	if (!isset($_POST['courseExpiry'])) $error[] = "Please fill out all fields";
	if (!isset($_POST['courseProcess'])) $error[] = "Please fill out all fields";
	if (!isset($_POST['courseStatus'])) $error[] = "Please fill out all fields";
	if (!isset($_FILES['courseDocsName'])) $error[] = "Please fill out all fields";
	
	$courseName = $_POST['courseName'];
	$courseUnits = $_POST['courseUnits'];
	$courseDesc = $_POST['courseDesc'];
	$courseMode = $_POST['courseMode'];
	//$courseDocsName = $_POST['courseDocsName'];
	$courseStart = $_POST['courseStart'];
	$courseExpiry = $_POST['courseExpiry'];
	$courseProcess = $_POST['courseProcess'];
	$courseStatus = $_POST['courseStatus'];
	
	//if no errors have been created carry on
	if(!isset($error)){

		try {
			
			// Check connection
			if($conn === false){
				die("ERROR: Could not connect. " . mysqli_connect_error());
			}
			
			/**Upload Multiple Files Here**/
			
			/*$valid_formats = array("jpg", "png", "gif", "zip", "bmp", "docx", "xlsx", "pptx", "pdf");
			$max_file_size = 5120*10; //51200 KB
			$upload_dir = "uploads/"; // Upload directory
			$count = 0;
			
			if ($_FILES['courseDocsName']['size'][$key] > $max_file_size) {
	            $message[] = "$name is too large!.";
	            continue; // Skip large courseDocsName
	        }
			elseif( ! in_array(pathinfo($name, PATHINFO_EXTENSION), $valid_formats) ){
				$message[] = "$name is not a valid format";
				continue; // Skip invalid file formats
			}*/
			
			// Loop $_FILES to exeicute all courseDocsName
			$uploads_dir = "uploads/";
			$name = "";
			$j = 0;
			foreach ($_FILES['courseDocsName']["error"] as $key => $errors) {     
				if ($errors == UPLOAD_ERR_OK) {					
					$tmp_name = $_FILES["courseDocsName"]["tmp_name"][$key];
					$nameOne = $_FILES["courseDocsName"]["name"][$key];
					// I don't want to overwrite the existing file
					$i = 0;
					$parts = pathinfo($nameOne);
					while (file_exists($uploads_dir . "/" . $nameOne)) {
						$i++;						
						$nameOne= $parts["filename"] . "-" . $i . "." . $parts["extension"];						
					}
					move_uploaded_file($tmp_name, "$uploads_dir/$nameOne");					
				}				
				if($j==0){
					$name=$nameOne;
				}else{
					$name = $name.",".$nameOne;
				}
			$j++;
			}
			$sql =  "INSERT courses set courseName='".$courseName."', courseUnits='".$courseUnits."', courseDesc='".$courseDesc."', courseMode='".$courseMode."', courseStart='".$courseStart."', courseExpiry='".$courseExpiry."', courseProcess='".$courseProcess."', courseStatus='".$courseStatus."', courseDocsName='".$name."', dateTime=NOW()";
			mysqli_query($conn, $sql);
				
			//redirect to index page
			header('Location: course.php?action=successful');
			

		//else catch the exception and show the error.
		} catch(Exception $e) {
		    $error[] = $e->getMessage();
		}

	}

}

//define page title
$title = 'Coruse Page';

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
							
							<h2 class="up_image">Please Add Course.</h2>
							<hr>
						
							<?php
							//check for any errors
							if(isset($error)){
								foreach($error as $error){
									echo '<p class="bg-danger">'.$error.'</p>';
								}
							}

							//if action is show sucess
							if(isset($_GET['action']) && $_GET['action'] == 'successful'){
								echo "<h2 class='bg-success'>Add Course successful.</h2>";
							}
							?>
						<div class="col-xs-12 col-sm-6 col-md-4">
							<div class="form-group input_border">
								<span><label for="inputEmail3" class="col-form-label">Title</label></span>
								<span><input type="text" name="courseName" class="form-control input_profile" id="courseName" placeholder="Course Name" required value="<?php if(isset($error)){ echo htmlspecialchars($_POST['courseName'], ENT_QUOTES); } ?>" tabindex="1"></span>
							</div>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-4">
							<div class="form-group input_border">
								<span><label for="inputEmail3" class="col-form-label">Units</label></span>
								<span><input type="text" name="courseUnits" class="form-control input_profile" id="courseUnits" placeholder="Course Units" required value="<?php if(isset($error)){ echo htmlspecialchars($_POST['courseUnits'], ENT_QUOTES); } ?>" tabindex="2"></span>
							</div>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-4">
							<div class="form-group input_border">
								<span><label for="inputEmail3" class="col-form-label">Description</label></span>
								<span><textarea name="courseDesc" class="form-control " id="courseDesc" placeholder="Course Description" required value="<?php if(isset($error)){ echo htmlspecialchars($_POST['courseDesc'], ENT_QUOTES); } ?>" tabindex="3"></textarea></span>
							</div>	
						</div>		
						<div class="col-xs-12 col-sm-6 col-md-4">				
							<div class="form-group input_border">
								<span><label for="inputEmail3" class="col-form-label">Mode</label></span>
								<span><select name="courseMode" class="form-control" required tabindex="4">
								<option value="">Please Select the Course Process.</option>
								<option value="readup">Readup</option>
								<option value="stream">Stream</option>								
								</select></span>
							</div>	
						</div>
						<div class="col-xs-12 col-sm-6 col-md-4">
							<div class="form-group input_border">
								<span><label for="inputPassword3" class="col-form-label">Start Date</label></span>
								<span><input type="date" name="courseStart" class="form-control" id="courseStart" placeholder="mm/dd/yyyy" value="" required tabindex="6"></span>
							</div>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-4">
							<div class="form-group input_border">
								<span><label for="inputPassword3" class="col-form-label">Expiry Date</label></span>
								<span><input type="date" name="courseExpiry" class="form-control" id="courseExpiry" placeholder="mm/dd/yyyy" value="" required tabindex="7"></span>
							</div>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-4">
							<div class="form-group input_border">
								<span><label for="inputEmail3" class="col-form-label">Process</label></span>
								<span><select name="courseProcess" class="form-control" required tabindex="8">
								<option value="">Please Select the Course Process.</option>
								<option value="not_started">Not Started</option>
								<option value="completed">Completed</option>
								<option value="expired">Expired</option>
								<option value="in_progress">In Progress</option>
								<option value="not_completed">Not Completed</option>								
								</select></span>
							</div>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-4">	
							<div class="form-group input_border">
								<span><label for="inputEmail3" class="col-form-label">Show Status</label></span>							
								<span><select name="courseStatus" class="form-control" required tabindex="9">
								<option value="">Please Select the status.</option>
								<option value="active">Active</option>
								<option value="deactive">Deactive</option>
								</select></span>
							</div>
						</div>
						<!-- div class="col-xs-12 col-sm-6 col-md-4">								
							<div class="form-group input_border">
								<span><label for="inputPassword3" class="col-form-label">Documents</label></span>
								<span><input type="file" name="courseDocsName[]" class="form-control" id="courseDocsName" placeholder="Profile Image" required value="<?php if(isset($error)){ echo htmlspecialchars($_POST['courseDocsName'], ENT_QUOTES); } ?>" tabindex="5" onchange="preview_image();" multiple="multiple"></span>
							</div>
						</div-->
						<div class="col-xs-12 col-sm-6 col-md-4">
							<span><label for="inputEmail3" class="col-form-label">Only pdf and image files supported.</h6></label></span>
							<div class="form-group input_border" style="border-bottom: 0;">
	    						<input name="courseDocsName[]" class="file" type="file" multiple="multiple" accept=".pdf, image/*, application/pdf">
								
	      						<span class="input-group-addon"><i class="glyphicon glyphicon-picture"></i></span>
	      						<input class="form-control input-lg" readonly placeholder="Upload Course Files" type="text" multiple="multiple" accept=".pdf, image/*, application/pdf">
	      						<span class="input-group-btn">
	        						<button class="browse btn btn-primary input-lg" type="button"><i class="glyphicon glyphicon-search"></i> Browse</button>
	      						</span>
							</div>
						</div>
						<div class="col-xs-12 col-sm-6 col-sm-offset-3">
							<div class="form-group">
								<input type="submit" name="submit" value="Submit" class="text-uppercase btn btn-default btn-lg btn-block" tabindex="3">
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
								<table id="employee-grid-course"  cellpadding="0" cellspacing="0" border="0" class="display" width="100%">
									<thead>
										<tr>
											<th>Course ID</th>
											<th>Title</th>
											<th>Units</th>
											<th>Description</th>
											<th>Mode</th>											
											<th>Start</th>
											<th>Expiry</th>
											<th>Process</th>
											<th>Document</th>
											<th>Status</th>
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
