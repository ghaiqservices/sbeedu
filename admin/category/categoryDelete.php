<?php include('../../includes/configMysqli.php');

	//if not logged in redirect to login page
	if(!$user->is_logged_in()){ header('Location: ../../login.php'); exit(); }

	$_SESSION['categoryID']=$_GET['id'];
	$sql="DELETE FROM category where categoryID=".$_SESSION['categoryID'];
	$query=mysqli_query($conn, $sql);
	if(mysqli_error($conn) != null){		
		//show error		
		header('Location: category.php?action=error');
	}else{
		//redirect to index page
		header('Location: category.php');
	}

?>
