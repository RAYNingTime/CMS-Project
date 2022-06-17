<?php include "db.php";?>
<?php session_start();?>
<?php include "../admin/includes/functions.php"?>

<?php
	if(isset($_POST['login'])){
		$username = escape($_POST['username']);
		$password = escape($_POST['password']);

		login_user($username,$password);
	}


?>