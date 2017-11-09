<?php require('../includes/configMysqli.php');
//define page title
$title = 'Coruse Page';

//include header template
include('layout/header.php');
?>
	<div class="main">
		<div class="container-fluid">
			<div class="container-fluid">
				<div class="row">
					<div class="col-xs-12 page_heading">
						<h4><?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES); ?> dashbaord</h4>
					</div>
				</div>
			</div>
			<div class="row top_options">
				<div class="col-sm-4">
					<div class="photo">
						<img src="images/image_1.png" class="img-responsive" />
						<div class="top_option_caption">
							<div class="caption_image ">
								<div class="top_photo ">
									<img src="images/icon_4.png" />
									<p>Facilitators</p>
								</div>
								
							</div>						
						</div>
					</div>
				</div>
				<div class="col-sm-4">
					<div class="photo">
						<img src="images/image_2.png" class="img-responsive" />
						<div class="top_option_caption">
							<div class="caption_image">
								<div class="top_photo">
									<img src="images/icon_5.png" />
									<p>Chat Room</p>
								</div>
								
							</div>						
						</div>
					</div>
				</div>
				<div class="col-sm-4">
					<div class="photo">
						<img src="images/image_3.png" class="img-responsive" />
						<div class="top_option_caption">
							<div class="caption_image">
								<div class="top_photo">
									<img src="images/icon_6.png" />
									<p>Discussion Forum</p>
								</div>
								
							</div>						
						</div>
					</div>
				</div>
			</div>
			<div class="row course_section">
				<div class="col-sm-4">
					<div class="course_main">
						<div class="course_heading">
							<p>Course Status</p>
						</div>
						<div class="course_content">
							<div class="availablity_main">
								<div class="seat_available text-center">
									<h1>5</h1>
									<p>Available</p>
								</div>
								<div class="seat_details">
									<p>Enrol a Course</p>
									<p><span class="red"><i class="fa fa-plus"></i>Enrol Now</span></p>
								</div>
							</div>
							<div class="availablity_main">
								<div class="seat_available text-center">
									<h1>2</h1>
									<p>Available</p>
								</div>
								<div class="seat_details">
									<p>Taken Competency Test</p>
									<p><span class="green"><i class="fa fa-plus"></i>Proceed</span></p>
								</div>
							</div>
							<div class="availablity_main">
								<div class="seat_available text-center">
									<h1>6</h1>
									<p>Expiring</p>
								</div>
								<div class="seat_details">
									<p>Course Expiring</p>
									<p><span class="blue"><i class="fa fa-plus"></i>complete Now</span></p>
								</div>
							</div>
							<div class="availablity_main border_bottom_none">
								<div class="seat_available text-center">
									<h1>12</h1>
									<p>Available</p>
								</div>
								<div class="seat_details">
									<p>Course Garding</p>
									<p><span class="red"><i class="fa fa-plus"></i>View Now</span></p>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-4">
					<div class="course_main">
						<div class="course_heading">
							<p>Course Progress</p>
						</div>
						<div class="course_content">
							<div class="progress_main">
								<div class="chart_image">
									<img src="images/chart.png" class="img-responsive" />
									<div class="progress_bg">
										<div class="progress_text">
											<p>In Progress<br /> 17</p>
										</div>
									</div>
								</div>
							</div>
							<div class="status_main text-center border_bottom_none">
								<div class="col-xs-6 col-sm-12 col-md-6">
									<div class="box_1"></div>
									<p>Not Started (20)</p>
								</div>
								<div class="col-xs-6 col-sm-12 col-md-6">
									<div class="box_2"></div>
									<p>In Progress (20)</p>
								</div>
								<div class="col-xs-6 col-sm-12 col-md-6">
									<div class="box_3"></div>
									<p>Completed (20)</p>
								</div>
								<div class="col-xs-6 col-sm-12 col-md-6">
									<div class="box_4"></div>
									<p>Not Completed (20)</p>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-4">
					<div class="course_main">
						<div class="course_heading">
							<p>Course Enrolment</p>
						</div>
						<div class="course_content">
							<div class="enrol_main">
								<div class="enroll_box">
									<div class="enrol_box_1">
										<h1>31</h1>
										<p>enrolees</p>
									</div>
									<div class="enroll_text">
										<p>Startegic Thinking Influencing &amp; Implimentation</p>
									</div>
								</div>							
							</div>
							<div class="enrol_main">
								<div class="enroll_box">
									<div class="enrol_box_2">
										<h1>31</h1>
										<p>enrolees</p>
									</div>
									<div class="enroll_text">
										<p>Client Service Skills in the Globel Banking Enviroment</p>
									</div>
								</div>							
							</div>
							<div class="enrol_main">
								<div class="enroll_box">
									<div class="enrol_box_3">
										<h1>31</h1>
										<p>enrolees</p>
									</div>
									<div class="enroll_text">
										<p>Service Excellence when On-Boarding Corporate Clients</p>
									</div>
								</div>							
							</div>
							<div class="enrol_main border_bottom_none">
								<div class="enroll_box">
									<div class="enrol_box_4">
										<h1>31</h1>
										<p>enrolees</p>
									</div>
									<div class="enroll_text">
										<p>The Organization's mission and startegy</p>
									</div>
								</div>							
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
<?php 
//include header template
include('layout/footer.php'); 
?>
