<?php

//===== DATABASE HELPERS =====//

function escape($string) {
	global $connect;

	return mysqli_real_escape_string($connect, trim($string));
}

function query($query){
	global $connect;
	$result = mysqli_query($connect, $query);
	if(!$result) 
		die("QUERY FAILED " . mysqli_error($connect));

	return $result;
}

function redirect($location) {
	header("Location: " . $location);
	exit;
}

function fetchRecord($result){
	return mysqli_fetch_array($result);
}

//===== END DATABASE HELPERS =====//

//===== GENERAL HELPERS =====//

function recordCount($table){
   $select_all = query("SELECT * FROM " . $table);
	$result = mysqli_num_rows($select_all);

	return $result;
}

function checkStatus($table, $column, $value){
	$select_all = query("SELECT * FROM $table WHERE $column = '$value'");
	$result = mysqli_num_rows($select_all);

	return $result;
}

function get_username(){
	return isset($_SESSION['username']) ? $_SESSION['username'] : null;
}

//===== END GENERAL HELPERS =====//

//===== AUTHENTIFICATION HELPERS =====//

function usernameExists($username) {
	$result = query("SELECT username FROM users WHERE username = '{$username}'");

	if(mysqli_num_rows($result) > 0) {
		return true;
	}

	return false;
}

function emailExists($email) {
	$result = query("SELECT user_email FROM users WHERE user_email = '{$email}'");

	if(mysqli_num_rows($result) > 0) {
		return true;
	}

	return false;
}


function ifItIsMethod($method = null){
	if($_SERVER['REQUEST_METHOD'] == strtoupper($method)){
		return true;
	}

	return false;
}

function isLoggedIn(){
	if(isset($_SESSION['user_role'])){
		return true;
	}

	return false;
}

function checkIfUserIsLoggedInAndRedirect($redirectLocation=null){
	if(isLoggedIn())
		redirect($redirectLocation);
}

function is_admin(){
	if(isLoggedIn()){
		$result = query("SELECT user_role FROM users WHERE user_id=" . $_SESSION['user_id']);

		$row = fetchRecord($result);

		if($row['user_role'] == 'admin')
			return true;
	}

	return false;
}

function register_user($username, $email, $password, $firstname, $lastname) {
	if(!empty($username) && !empty($email) && !empty($password) && !empty($firstname) && !empty($lastname)) {
		if (!usernameExists($username)) {
			if(!emailExists($email)) {
				if (strlen($password) > 5) {
				

					//After all the validation

					$password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));

					// ---- OLD CRYPT ----
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
					$register_user_query = query($query);


			} else $message = "Your password should be longer than 5 digits!";

		} else $message = "This email already taken!";

	} else $message = "This username already taken!";
  } else {
		// echo "<strong><p style='color:red;font-size:25px;' class='text-center'>You should fill all the fields!</p></strong>";
		$message = "You should fill all the fields!";
  }

  if(!empty($message))
  	$new_message = "<strong><p style='color:red;font-size:25px;' class='text-center'>" . $message . "</p></strong>";
	else $new_message = '';

	return $new_message;
}

function login_user($username, $password) {
	$select_user_query = query( "SELECT * FROM users WHERE username = '{$username}'");

	while($row = mysqli_fetch_array($select_user_query)) {
		$db_user_id = $row['user_id'];
		$db_username = $row['username'];
		$db_user_firstname = $row['user_firstname'];
		$db_user_lastname = $row['user_lastname'];
		$db_user_role = $row['user_role'];
		$db_user_password = $row['user_password'];
	}
		//Used for the old verification
		// $db_user_randSalt = $row['user_randSalt'];

		// OLD VERIFY
		// $password = crypt($password, $db_user_randSalt);

	if ($username == $db_username && password_verify($password, $db_user_password)){
		$_SESSION['user_id'] = $db_user_id;
		$_SESSION['username'] = $db_username;
		$_SESSION['first_name'] = $db_user_firstname;
		$_SESSION['last_name'] = $db_user_lastname;
		$_SESSION['user_role'] = $db_user_role;
		
		redirect("/cms/admin");
	}
	else {
		
		redirect("/cms/login.php?incorrect_pass=true");
	}

}

function loggedInUserId(){
	if(isLoggedIn()){
		$result = query("SELECT * FROM users WHERE username='" . $_SESSION['username'] . "'" );

		$user = mysqli_fetch_array($result);
		return mysqli_num_rows($result) >= 1 ? $user['user_id'] : false;
	}
	return false;
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

//===== END AUTHENTIFICATION HELPERS =====//


//===== USER SPECIFIC HELPERS =====//

function get_all_user_smth($table){
	$select_all_for_user = query("SELECT * FROM " . $table . " WHERE user_id=" . loggedInUserId());
	return mysqli_num_rows($select_all_for_user);
}

function get_all_posts_user_comments(){
	$result = query("SELECT * FROM posts INNER JOIN comments ON posts.post_id=comments.comment_post_id WHERE user_id=".loggedInUserId());
	return mysqli_num_rows($result);
}

function personalCheckStatus($table, $column, $value){
	$select_all = query("SELECT * FROM $table WHERE $column = '$value' AND user_id=" . loggedInUserId());
	$result = mysqli_num_rows($select_all);

	return $result;
}

function personalCheckCommentStatus(){
	$result = query("SELECT * FROM posts INNER JOIN comments ON posts.post_id=comments.comment_post_id WHERE comment_status='unapproved' AND user_id=".loggedInUserId());
	return mysqli_num_rows($result);
}

//===== END USER SPECIFIC HELPERS =====//

//===== LIKES HELPERS =====//

function userLikedThisPost($post_id =''){
	$result = query("SELECT * FROM likes WHERE user_id=" . loggedInUserId() . " AND post_id=$post_id");

	return mysqli_num_rows($result) >= 1 ? true : false;
}

function getPostLikes($post_id){
	$result = query("SELECT * FROM likes WHERE post_id=$post_id");

	echo mysqli_num_rows($result);
}
//===== END LIKES HELPERS =====//

//===== CATEGORIES HELPERS =====//

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
			$query = "INSERT INTO categories(cat_title,user_id) VALUES ('{$cat_title}', " . loggedInUserId() . ")";

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

//===== END CATEGORIES HELPERS =====//

?>




<?php users_online();?>