<?php include('../../includes/configMysqli.php');

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

// datatable column index  => database column name
$columns = array(
	0=>'memberID', 
	1=>'roleID',
	2=>'categoryID',
	3=>'firstName',
	4=>'lastName',	
	5=>'username',
	6=>'password',
	7=>'email',
    8=>'active',
	9=>'imgName',
	10=>'imgUrl',
    11=>'resetToken',
    12=>'resetComplete'
);

// getting total number records without any search
$sql =  "SELECT memberID, roleID, username, password, email, active, imgName, imgUrl, resetToken, resetComplete";
$sql.=" FROM members";
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get members");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql =  "SELECT memberID, roleID, username, password, email, active, imgName, imgUrl, resetToken, resetComplete";
$sql.=" FROM members WHERE 1=1";
if( !empty($requestData['search']['value']) ) {
	// if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( username LIKE '".$requestData['search']['value']."%' "; 

	$sql.=" OR password LIKE '".$requestData['search']['value']."%' )";
	$sql.=" OR email LIKE '".$requestData['search']['value']."%' )";
 	$sql.=" OR active LIKE '".$requestData['search']['value']."%' )";

	$sql.=" OR resetToken LIKE '".$requestData['search']['value']."%' )";
	$sql.=" OR resetComplete LIKE '".$requestData['search']['value']."%' )";
}

$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get members");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. */

$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */
	
$query=mysqli_query($conn, $sql) or die("employee-grid-data.php: get register");
$count=1;
$data = array();
while($row=mysqli_fetch_array($query)){  
	
	// preparing an array
	$nestedData=array(); 
	// $nestedData[] = $row[0];
	$nestedData[] = $count;
	$nestedData[] = "<img src='".$row['imgUrl']."' alt='user image' class='img-responsive img-circle sngImg' width='40' height='40'>";
	//$nestedData[] = $row["memberID"];
	//$nestedData[] = $row["roleID"];
	$nestedData[] = $row["username"];
	//$nestedData[] = $row["password"];
	$nestedData[] = $row["email"];
	$nestedData[] = $row["active"];	
	//$nestedData[] = $row["resetToken"];
	//$nestedData[] = $row["resetComplete"];
	//$nestedData[] = echo "<button>".""."</button>"
	$nestedData[] = '<a href="javascript:void(0)"  onclick="editlab('.$row['memberID'].')" type="button"  class="btn btn-primary" <span class="glyphicon glyphicon-edit"></span> Edit</a>';
	$nestedData[] = "<a href='javascript:void(0)' type='button' onclick='deletelab(".$row['memberID'].")'  class=' btn btn-danger btn btn-info btn-lg delete' <span class='glyphicon glyphicon-delete'></span> Delete</a>";
	
	// if($row['status']=='1')            
	// {                  
	// $nestedData[] = '<button data-id="'.$row['status'].'" type="button" class="btn btn-primary">'.$row['status'].'</button>';  
	//           }
	//           elseif($row['status']=='0')
	//           {
	//           	$nestedData[] = '<button data-id="'.$row['status'].'" type="button" class="btn btn-danger">'.$row['status'].'</button>';  

	//           }
	//           elseif($row['status']=='')
	//           {
	//           	$nestedData[] = '<button data-id="'.$row['status'].'" type="button"   class="btn btn-warning">null'.$row['status'].'</button>';  

	//           }
	
	$data[] = $nestedData;
	$count++;
}

$json_data = array(
	"draw"	=>	intval( $requestData['draw'] ),
	// for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
	"recordsTotal"	=>	intval( $totalData ),
	// total number of records
	"recordsFiltered"	=>	intval( $totalFiltered ),
	// total number of records after searching, if there is no searching then totalFiltered = totalData
	"data"	=>	$data
	// total data array
);
echo json_encode($json_data);  // send data as json format
?>