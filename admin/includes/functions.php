<?php

function escape($string) {
	global $connect;

	return mysqli_real_escape_string($connect, trim($string));
}

function users_online(){

	if(isset($_GET['onlineusers'])) {
		global $connect;

		if(!$connect){
			session_start();
			include("../../includes/db.php");
		}
		

		$session = session_id();
		$time = time();
		$time_out_in_seconds = 30;
		$time_out = $time - $time_out_in_seconds;

		$query = "SELECT * FROM users_online WHERE session = '$session'";
		$send_query = mysqli_query($connect, $query);
		$count = mysqli_num_rows($send_query);

		if($count == 0) {
				mysqli_query($connect, "INSERT INTO users_online(session, time) VALUES('$session', '$time')");
		} else
				mysqli_query($connect, "UPDATE users_online SET time = '$time' WHERE session = '$session'");

		$users_online_query = mysqli_query($connect, "SELECT * FROM users_online WHERE time > '$time_out'");
		$count_user = mysqli_num_rows($users_online_query);
		echo $count_user;
	
	}
}

function insertCategories(){
	global $connect;
	if (isset($_POST['submit'])) {
		$cat_title = escape($_POST['cat_title']);

		$query = "SELECT DISTINCT cat_title FROM categories";
		$all_cat_titles = mysqli_query($connect, $query);

		if ($cat_title == "" || empty($cat_title)){
			echo "This field should not be empty!";
		} else { 
			$already_taken = false;
			while($row = mysqli_fetch_assoc($all_cat_titles)) {
				$check_title = $row['cat_title'];
				if($cat_title == $check_title) {
					$already_taken = true;
				}
			}
			if($already_taken == false) {
			$query = "INSERT INTO categories(cat_title) VALUES ('{$cat_title}')";

			$create_category = mysqli_query($connect , $query);

			if (!$create_category)
				die('QUERY FAILED'. mysqli_error($connect));
			} else echo "This category name already taken!";
		}
	 }
}

function findAllCategories(){
	global $connect;
	$query = "SELECT * FROM categories";
	$select_categories = mysqli_query($connect, $query);

	while($row = mysqli_fetch_assoc($select_categories)) {
		$cat_id = $row['cat_id'];
		$cat_title = $row['cat_title']; 

		echo "<tr><td>{$cat_id}</td>";
		echo "<td>{$cat_title}</td>";
		echo "<td><a href='categories.php?delete={$cat_id}'> Delete </a></td>";
		echo "<td><a href='categories.php?edit={$cat_id}'> Edit </a></td></tr>";
	}
}

function deleteCategories(){
	global $connect;
	
	if (isset($_GET['delete'])) {
		$get_cat_id = escape($_GET['delete']);
		$query = "DELETE FROM categories WHERE cat_id = {$get_cat_id}";
		$delete_query = mysqli_query($connect, $query);
		header("Location: categories.php");
	}
}


function recordCount($table){
	global $connect;

	$query = "SELECT * FROM " . $table;
   $select_all = mysqli_query($connect, $query);
	$result = mysqli_num_rows($select_all);

	if(!$select_all) {
		die("QUERY FAILED " . mysqli_error($connect));
	}

	return $result;
}

function checkStatus($table, $column, $value){
	global $connect;

	$query = "SELECT * FROM $table WHERE $column = '$value'";
	$select_all = mysqli_query($connect, $query);
	$result = mysqli_num_rows($select_all);

	if(!$select_all) {
		die("QUERY FAILED " . mysqli_error($connect));
	}

	return $result;
}

function is_admin($username){
	global $connect;

	$query = "SELECT user_role FROM users WHERE username = '{$username}'";
	$result = mysqli_query($connect, $query);

	if(!$result) 
		die("QUERY FAILED " . mysqli_error($connect));

	$row = mysqli_fetch_array($result);

	if($row['user_role'] == 'admin')
		return true;
	
	return false;
}

function usernameExists($username) {
	global $connect;

	$query = "SELECT username FROM users WHERE username = '{$username}'";
	$result = mysqli_query($connect, $query);

	if(!$result) 
		die("QUERY FAILED " . mysqli_error($connect));

	if(mysqli_num_rows($result) > 0) {
		return true;
	}

	return false;
}

function emailExists($email) {
	global $connect;

	$query = "SELECT user_email FROM users WHERE user_email = '{$email}'";
	$result = mysqli_query($connect, $query);

	if(!$result) 
		die("QUERY FAILED " . mysqli_error($connect));

	if(mysqli_num_rows($result) > 0) {
		return true;
	}

	return false;
}

function redirect($location) {
	return header("Location: " . $location);
}

function register_user($username, $email, $password) {
	global $connect;

	if(!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password'])) {
		if (!usernameExists($_POST['username'])) {
			if(!emailExists($_POST['email'])) {
		  		$username = $_POST['username'];
				$email = $_POST['email'];
				$password = $_POST['password'];
				$firstname = $_POST['firstname'];
				$lastname = $_POST['lastname'];

				$username = escape($username);
				$email = escape($email);
				$password = escape($password);
				$firstname = escape($firstname);
				$lastname = escape($lastname);

				$password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));

				// OLD CRYPT
				// $query = "SELECT user_randSalt FROM users";
				// $select_randsalt_query = mysqli_query($connect, $query);
				// if(!$select_randsalt_query) {
				//     die("QUERY FAILED " . mysqli_error($connect));
				// }

				// $row = mysqli_fetch_assoc($select_randsalt_query);
				// $randSalt = $row['user_randSalt'];
				// $password = crypt($password, $randSalt);

				$query = "INSERT INTO users (username, user_email, user_password, user_role, user_firstname, user_lastname) ";
				$query .= "VALUES('{$username}', '{$email}', '{$password}', 'subscriber', '{$firstname}', '{$lastname}')";
				$register_user_query = mysqli_query($connect, $query);

				if(!$register_user_query) {
						die("QUERY FAILED " . mysqli_error($connect)) . ' ' . mysqli_errno($connect);
				}

				header("Location: index.php");

		} else return "<strong><p style='color:red;font-size:25px;' class='text-center'>This email already taken!</p></strong>";

  	} else return "<strong><p style='color:red;font-size:25px;' class='text-center'>This username already taken!</p></strong>";

  } else {
		// echo "<strong><p style='color:red;font-size:25px;' class='text-center'>You should fill all the fields!</p></strong>";
		return "<strong><p style='color:red;font-size:25px;' class='text-center'>You should fill all the fields!</p></strong>";
  }
}
?>




<?php users_online();?>