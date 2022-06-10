<?php include "db.php";?>
<?php session_start();?>

<?php
	if(isset($_POST['login'])){
		$username = $_POST['username'];
		$password = $_POST['password'];

		$username = mysqli_real_escape_string($connect, $username);
		$password = mysqli_real_escape_string($connect, $password);

		$query = "SELECT * FROM users WHERE username = '{$username}'";
		$select_user_query = mysqli_query($connect, $query);

		if(!$select_user_query) {
			die("QUERY FAILED " . mysqli_error($connect));
		}

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
			$_SESSION['username'] = $db_username;
			$_SESSION['first_name'] = $db_user_firstname;
			$_SESSION['last_name'] = $db_user_lastname;
			$_SESSION['user_role'] = $db_user_role;
			
			header("Location: ../admin");
		}
		else header("Location: ../index.php"); 

		
	}


?>