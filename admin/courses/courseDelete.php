<?php include('../../includes/configMysqli.php');

	//if not logged in redirect to login page
	if(!$user->is_logged_in()){ header('Location: ../../login.php'); exit(); }

	$_SESSION['courseID']=$_GET['id'];
	$sql="DELETE FROM courses where courseID=".$_SESSION['courseID'];
	$query=mysqli_query($conn, $sql);

	//redirect to index page
	header('Location: course.php');

?>
