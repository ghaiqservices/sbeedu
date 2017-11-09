<?php include('../../includes/configMysqli.php');

// storing  request (ie, get/post) global array to a variable  
$requestData= $_REQUEST;

// datatable column index  => database column name
$columns = array(
	0=>'categoryID', 
	1=>'categoryName', 
	2=>'status'
);

// getting total number records without any search
$sql =  "SELECT categoryID, categoryName, status";
$sql.=" FROM category where categoryID <> 0";
$query=mysqli_query($conn, $sql) or die("category-grid-data.php: get category");
$totalData = mysqli_num_rows($query);
$totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.


$sql =  "SELECT categoryID, categoryName, status";
$sql.=" FROM category WHERE 1=1 && categoryID <> 0";
if( !empty($requestData['search']['value']) ) {
	// if there is a search parameter, $requestData['search']['value'] contains search parameter
	$sql.=" AND ( categoryName LIKE '".$requestData['search']['value']."%' "; 

	$sql.=" OR categoryID LIKE '".$requestData['search']['value']."%' )";
	$sql.=" OR status LIKE '".$requestData['search']['value']."%' )";
}

$query=mysqli_query($conn, $sql) or die("category-grid-data.php: get category");
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result. */

$sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
/* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */
	
$query=mysqli_query($conn, $sql) or die("category-grid-data.php: get category");
$count=1;
$data = array();
while($row=mysqli_fetch_array($query)){  
	
	// preparing an array
	$nestedData=array();
	$nestedData[] = $count;
	//$nestedData[] = $row[0];
	//$nestedData[] = $row["categoryID"];
	$nestedData[] = $row["categoryName"];
	$nestedData[] = $row["status"];
	$nestedData[] = '<a href="javascript:void(0)"  onclick="editlabcategory('.$row['categoryID'].')" type="button"  class="btn btn-primary" <span class="glyphicon glyphicon-edit"></span> Edit</a>';
	$nestedData[] = "<a href='javascript:void(0)' type='button' onclick='deletelabcategory(".$row['categoryID'].")'  class=' btn btn-danger btn btn-info btn-lg delete' <span class='glyphicon glyphicon-delete'></span> Delete</a>";
	
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