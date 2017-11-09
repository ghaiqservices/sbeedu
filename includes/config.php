<?php
ob_start();
session_start();

//set timezone
date_default_timezone_set('india/Chandigarh');

//database credentials
define('DBHOST','localhost');
define('DBUSER','qlh0kvwt_lmsyste');
define('DBPASS','93tAA6)i=Ds{');
define('DBNAME','qlh0kvwt_lmsystem');

//application address
define('DIR','https://sbeedu.org/lms/');
define('SITEEMAIL','testinguser03517@gmail.com');

try {

	//create PDO connection
	$db = new PDO("mysql:host=".DBHOST.";charset=utf8mb4;dbname=".DBNAME, DBUSER, DBPASS);
    //$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);//Suggested to uncomment on production websites
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//Suggested to comment on production websites
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

} catch(PDOException $e) {
	//show error
    echo '<p class="bg-danger">'.$e->getMessage().'</p>';
    exit;
}

//include the user class, pass in the database connection
include('classes/user.php');
include('classes/phpmailer/mail.php');
$user = new User($db);

//include the user class, pass in the database connection
include('function.inc.php');
$userprofile = new userprofile();
?>
