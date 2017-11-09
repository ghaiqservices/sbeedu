<?php include('../../includes/configMysqli.php'); 

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: ../../login.php'); exit(); }

$_SESSION['categoryID']=$_GET['id'];
$sql="SELECT * FROM category where categoryID=".$_SESSION['categoryID'];
$query=mysqli_query($conn, $sql);
$query=mysqli_fetch_array($query);

//if form has been submitted process it
if(isset($_POST['submit'])){

    //if (!isset($_POST['categoryName'])) $error[] = "Please fill out all fields";
    //if (!isset($_POST['status'])) $error[] = "Please fill out all fields";
	
	$categoryName = $_POST['categoryName'];
	$status = $_POST['status'];
	
	//if no errors have been created carry on
	if(!isset($error)){

		try {
			
			// Check connection
			if($conn === false){
				die("ERROR: Could not connect. " . mysqli_connect_error());
			}

			$sql =  "UPDATE category set categoryName='".$categoryName."', status='".$status."' where categoryID=".$_SESSION['categoryID'];
			
			if(mysqli_query($conn, $sql)){
			//redirect to index page
			header('Location: category.php?action=catedit');
			exit;
			}

		//else catch the exception and show the error.
		} catch(Exception $e) {
		    $error[] = $e->getMessage();
		}

	}

}

//define page title
$title = 'Category Page';

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
						<div class="availablity_main">
							
							<h2 class="up_image">Please Add Category</h2>
							<hr>
							<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.4/sweetalert2.all.js"></script>
							<?php
							//check for any errors
							if(isset($error)){
								foreach($error as $error){
									echo '<p class="bg-danger">'.$error.'</p>';
								}
							}
							?>
						<div class="col-sm-6 col-xs-12">
							<div class="form-group input_border">
								<span><label for="inputEmail3" class="col-form-label">Category Name</label></span>
								<span><input type="text" name="categoryName" class="form-control input_profile" id="category" placeholder="Category Name" required value="<?php echo $query['categoryName']; ?>" tabindex="1"></span>
							</div>
						</div>
						<div class="col-sm-6 col-xs-12">
							<div class="form-group input_border">
								<span><label for="inputEmail3" class="col-form-label">Status</label></span>							
								<span><select name="status" class="form-control" required tabindex="2">
								<option value="">Please Select the status.</option>
								<option value="active" <?php if($query['status']=="active") echo 'selected="selected"'; ?>>Active</option>
								<option value="deactive" <?php if($query['status']=="deactive") echo 'selected="selected"'; ?>>Deactive</option>
								</select></span>
							</div>
						</div>
						<div class=" col-sm-offset-3 col-sm-6 col-xs-12">
							<div class="form-group">
								<input type="submit" name="submit" value="Submit" class="text-uppercase btn btn-default btn-lg btn-block " tabindex="3">
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
								<table id="employee-grid-category"  cellpadding="0" cellspacing="0" border="0" class="display" width="100%">
									<thead>
										<tr>
											<th>Sr No.</th>
											<th>Category Name</th>
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
