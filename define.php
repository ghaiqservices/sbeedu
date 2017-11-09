<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
define("WEB_BASEURL", "https://sbeedu.org/lms/login.php/");
$current_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
if ($current_url == "https://sbeedu.org/") {
	
	/** Login & logout **/
	define("adminLogout_BASEURL", "https://sbeedu.org/lms/logout.php");
	
	/**adminDashboard URL**/
    define("adminDashboard_BASEURL", "https://sbeedu.org/lms/admin/adminDashboard");
	define("adminDashboardList_BASEURL", "https://sbeedu.org/lms/admin/adminDashboard/adminDasboard.php");
	define("adminDashboardEdit_BASEURL", "https://sbeedu.org/lms/admin/adminDashboard/editAdmin.php");
	define("adminCourse_BASEURL", "https://sbeedu.org/lms/admin/courses/course.php");
	define("adminCategory_BASEURL", "https://sbeedu.org/lms/admin/category/category.php");
	define("adminAdduser_BASEURL", "https://sbeedu.org/lms/admin/addUser/adduser.php");
	define("adminSettings_BASEURL", "https://sbeedu.org/lms/admin/settings/settings.php");
	
	
	/**User URL**/
    define("userDashboard_BASEURL", "https://sbeedu.org/lms/user");
	define("userEdit_BASEURL", "https://sbeedu.org/lms/user/userEdit.php");
	
} else {
	/** Login & logout **/
	define("adminLogout_BASEURL", "https://sbeedu.org/lms/logout.php");
	
	/**adminDashboard URL**/
    define("adminDashboard_BASEURL", "https://sbeedu.org/lms/admin/adminDashboard");
	define("adminDashboardList_BASEURL", "https://sbeedu.org/lms/admin/adminDashboard/adminDasboard.php");
	define("adminDashboardEdit_BASEURL", "https://sbeedu.org/lms/admin/adminDashboard/editAdmin.php");
	define("adminCourse_BASEURL", "https://sbeedu.org/lms/admin/courses/course.php");
	define("adminCategory_BASEURL", "https://sbeedu.org/lms/admin/category/category.php");
	define("adminAdduser_BASEURL", "https://sbeedu.org/lms/admin/addUser/adduser.php");
	define("adminSettings_BASEURL", "https://sbeedu.org/lms/admin/settings/settings.php");
	
	/**User URL**/
    define("userDashboard_BASEURL", "https://sbeedu.org/lms/user");
	define("userEdit_BASEURL", "https://sbeedu.org/lms/user/userEdit.php");
	
}