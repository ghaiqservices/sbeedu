    // This Code use for employee-grid-data.php
	$(document).ready(function() {
        var dataTable = $('#employee-grid').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax":{
                url :"/lms/admin/adminDashboard/employee-grid-data.php", // json datasource
                type: "post",  // method  , by default get
                error: function(){  // error handling
                    $(".employee-grid-error").html("");
                    $("#employee-grid").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                    $("#employee-grid_processing").css("display","none");
                }
            }
        });
	});
	function deletelab(id){           
		swal({              
			title: "Delete",              
			text: "Are you sure you want to delete this ?",              
			type: "warning",              
			showCancelButton: true,              
			confirmButtonClass: "btn-danger",              
			confirmButtonText: "Yes, delete it!",              
			closeOnConfirm: false            
		},function(){                
			//location.href="delete.php?id="+id;            
		});       
	}
	function editlab(id){           
		swal({              
			title: "Edit Profile",              
			text: "Please click to edit profile.",              
			type: "",              
			showCancelButton: true,              
			confirmButtonClass: "",              
			confirmButtonText: "Yes, edit profile.",              
			closeOnConfirm: false            
		},function(){                
			//location.href="edit.php?id="+id;            
		});       
	}
	// End Code Here
	
	// This Code use for category-grid-data.php
	$(document).ready(function() {
        var dataTable = $('#employee-grid-category').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax":{
                url :"/lms/admin/category/category-grid-data.php", // json datasource
                type: "post",  // method  , by default get
                error: function(){  // error handling
                    $(".employee-grid-error").html("");
                    $("#employee-grid").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                    $("#employee-grid_processing").css("display","none");
                }
            }
        });

	});
	function deletelabcategory(id){           
		swal({              
			title: "Delete",              
			text: "Are you sure you want to delete this ?",              
			type: "warning",              
			showCancelButton: true,              
			confirmButtonClass: "btn-danger",              
			confirmButtonText: "Yes, delete it!",              
			closeOnConfirm: false            
		},function(){                
			//location.href="delete.php?id="+id;            
		});       
	}
	function editlabcategory(id){           
		swal({              
			title: "Edit Profile",              
			text: "Please click to edit profile.",              
			type: "",              
			showCancelButton: true,              
			confirmButtonClass: "",              
			confirmButtonText: "Yes, edit profile.",              
			closeOnConfirm: false            
		},function(){                
			//location.href="edit.php?id="+id;            
		});       
	}
	// end code
	
	// This Code use for user-grid-data.php
	$(document).ready(function() {
        var dataTable = $('#employee-grid-user').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax":{
                url :"/lms/admin/addUser/user-grid-data.php", // json datasource
                type: "post",  // method  , by default get
                error: function(){  // error handling
                    $(".employee-grid-error").html("");
                    $("#employee-grid").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                    $("#employee-grid_processing").css("display","none");
                }
            }
        });
	});
	function deletelabuser(id){           
		swal({              
			title: "Delete",              
			text: "Are you sure you want to delete this ?",              
			type: "warning",              
			showCancelButton: true,              
			confirmButtonClass: "btn-danger",              
			confirmButtonText: "Yes, delete it!",              
			closeOnConfirm: false            
		},function(){                
			//location.href="delete.php?id="+id;            
		});       
	}
	function editlabuser(id){           
		swal({              
			title: "Edit Profile",              
			text: "Please click to edit profile.",              
			type: "",              
			showCancelButton: true,              
			confirmButtonClass: "",              
			confirmButtonText: "Yes, edit profile.",              
			closeOnConfirm: false            
		},function(){                
			//location.href="edit.php?id="+id;            
		});       
	}
	// End Code Here
	
	// This Code use for course-grid-data.php
	$(document).ready(function() {		
        var dataTable = $('#employee-grid-course').DataTable( {			
            "processing": true,
            "serverSide": true,
            "ajax":{
                url :"/lms/admin/courses/course-grid-data.php", // json datasource
                type: "post",  // method  , by default get
                error: function(){  // error handling
                    $(".employee-grid-error").html("");
                    $("#employee-grid").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                    $("#employee-grid_processing").css("display","none");
                }
            }
        });
	});
	function deletelabcourse(id){           
		swal({              
			title: "Delete",              
			text: "Are you sure you want to delete this ?",              
			type: "warning",              
			showCancelButton: true,              
			confirmButtonClass: "btn-danger",              
			confirmButtonText: "Yes, delete it!",              
			closeOnConfirm: false            
		},function(){                
			//location.href="delete.php?id="+id;            
		});       
	}
	function editlabcourse(id){           
		swal({              
			title: "Edit Profile",              
			text: "Please click to edit profile.",              
			type: "",              
			showCancelButton: true,              
			confirmButtonClass: "",              
			confirmButtonText: "Yes, edit profile.",              
			closeOnConfirm: false            
		},function(){                
			//location.href="edit.php?id="+id;            
		});       
	}
	// End Code Here