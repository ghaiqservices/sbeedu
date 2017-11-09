<?php include('../../includes/configMysqli.php'); 

//if not logged in redirect to login page
if(!$user->is_logged_in()){ header('Location: ../../login.php'); exit(); }

//define page title
$title = 'Members Page';

//include header template
include('../layout/header.php');
?>
	
	<div class="main">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xs-12 page_heading">
					<h4>Admin Dashbaord</h4>
				</div>
			</div>
			<div class="row course_section">
				<div class="col-sm-12">
					<div class="course_main">
						<div class="course_heading">
							<p>All User Accounts Details.</p>
						</div>
						<div class="course_content">
							<div class="availablity_main">
								<table id="employee-grid"  cellpadding="0" cellspacing="0" border="0" class="display" width="100%">
									<thead>
										<tr>											
											<th>Sr No.</th>
											<th>Profile Image</th>
											<th>Username</th>
											<th>Email</th>
											<th>Active</th>
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
