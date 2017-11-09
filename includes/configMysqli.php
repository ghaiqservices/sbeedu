<?php
ob_start();
session_start();

//set timezone
date_default_timezone_set('india/Chandigarh');

/* Database connection start */
$servername = "localhost";
$username = "qlh0kvwt_lmsyste";
$password = "93tAA6)i=Ds{";
$dbname = "qlh0kvwt_lmsystem";

/* Database connection end */

try {

	//create PDO connection
	$conn = mysqli_connect($servername, $username, $password, $dbname) or die("Connection failed: " . mysqli_connect_error());

} catch(Exception $e) {
	//show error
    echo '<p class="bg-danger">'.$e->getMessage().'</p>';
    exit;
}

//include the user class, pass in the database connection
include('../classes/user.php');
include('../classes/phpmailer/mail.php');
$user = new User($db);

//include the user class, pass in the database connection
include('function.inc.php');
$userprofile = new userprofile();
?>
