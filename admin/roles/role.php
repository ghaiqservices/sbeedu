<?php include('../../includes/configMysqli.php'); 

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: ../../login.php'); exit(); }

//if form has been submitted process it
if(isset($_POST['submit'])){

    if (!isset($_POST['roleName'])) $error[] = "Please fill out all fields";
    if (!isset($_POST['roleStatus'])) $error[] = "Please fill out all fields";
	
	$roleName = $_POST['roleName'];
	$roleStatus = $_POST['roleStatus'];
	
	//if no errors have been created carry on
	if(!isset($error)){

		try {
			
			// Check connection
			if($conn === false){
				die("ERROR: Could not connect. " . mysqli_connect_error());
			}

			$sql =  "INSERT roles set roleName='".$roleName."', active='".$roleStatus."'";
			
			if(mysqli_query($conn, $sql)){
			//redirect to index page
			header('Location: role.php?action='.$roleStatus);
			exit;
			}

		//else catch the exception and show the error.
		} catch(Exception $e) {
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
			<form role="form" method="post" action="" autocomplete="off">
				<div class="row top_options">
					<div class="col-sm-4 col-lg-4 col-xs-12">
						<div class="availablity_main">
							
							<h2>Please Add Roles.</h2>
							<hr>
						
							<?php
							//check for any errors
							if(isset($error)){
								foreach($error as $error){
									echo '<p class="bg-danger">'.$error.'</p>';
								}
							}

							//if action is show sucess
							if(isset($_GET['action']) && $_GET['action']){
								echo "<h2 class='bg-success'>Add Category successful.</h2>";
							}
							?>
						
							<div class="form-group input_border">
								<span><label for="inputEmail3" class="col-form-label">Role Name</label></span>
								<span><input type="text" name="roleName" class="form-control" id="role" placeholder="Role Name" required value="" tabindex="1"></span>
							</div>
							<div class="form-group input_border">
								<span><label for="inputEmail3" class="col-form-label">Status</label></span>							
								<span><select name="roleStatus" class="form-control" required tabindex="2">
								<option value="">Please Select the status.</option>
								<option value="active">Active</option>
								<option value="deactive">Deactive</option>
								</select></span>
							</div>
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
								<table id="employee-grid-role"  cellpadding="0" cellspacing="0" border="0" class="display" width="100%">
									<thead>
										<tr>
											<th>Role ID</th>
											<th>Role Name</th>
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
