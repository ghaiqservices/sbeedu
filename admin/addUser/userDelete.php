<?php include('../../includes/configMysqli.php');

	//if not logged in redirect to login page
	if(!$user->is_logged_in()){ header('Location: ../../login.php'); exit(); }

	$_SESSION['userID']=$_GET['id'];
	$sql="DELETE FROM members where memberID=".$_SESSION['userID'];
	$query=mysqli_query($conn, $sql);

	//redirect to index page
	header('Location: adduser.php');

?>
