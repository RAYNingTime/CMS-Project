<?php
	if(isset($_GET['edit_user'])){
		$the_user_id = escape($_GET['edit_user']);

		$query = "SELECT * FROM users WHERE user_id = $the_user_id";
		$select_users_query = mysqli_query($connect, $query);
	
		$row = mysqli_fetch_assoc($select_users_query);

		$user_id = $row['user_id'];
		$username = $row['username']; 
		$user_password = $row['user_password']; 
		$user_firstname = $row['user_firstname'];
		$user_lastname = $row['user_lastname']; 
		$user_email = $row['user_email']; 
		$user_image = $row['user_image']; 
		$user_role = $row['user_role'];


	if (isset(escape($_POST['edit_user']))) {
		if (!empty(escape($_POST['user_old_password'])) && !empty(escape($_POST['user_new_password']))) {

		// OLD ENCRYPTING SYSTEM
		// $query = "SELECT user_randSalt FROM users";
		// $select_randSalt_query = mysqli_query($connect, $query);
		// if(!$select_randSalt_query){
		// 	die("QUERY FAILED ". mysqli_error($connect));
		// }
		// $row = mysqli_fetch_array($select_randSalt_query);
		// $salt = $row['user_randSalt'];


		$old_password = escape($_POST['user_old_password']);
		$hashed_new_password =  password_hash($_POST['user_new_password'], PASSWORD_BCRYPT, array('cost' => 10));

		if (password_verify($old_password, $user_password)) {
			$user_firstname = escape($_POST['user_firstname']);
			$user_lastname = escape($_POST['user_lastname']);
			$user_role = escape($_POST['user_role']);
			$username = escape($_POST['username']);
			$user_email = escape($_POST['user_email']);
			$user_password = escape($_POST['user_new_password']);
	
			$query = "UPDATE users SET ";
			$query .="user_firstname = '{$user_firstname}', ";
			$query .="user_lastname  = '{$user_lastname}', ";
			$query .="username       = '{$username}', ";
			$query .="user_password  = '{$hashed_new_password}', ";
			$query .="user_email     = '{$user_email}', ";
			$query .="user_role      = '{$user_role}' ";
			$query .="WHERE user_id  = {$the_user_id} ";
		
			$update_user = mysqli_query($connect, $query);
	
			if(!$update_user)
			 die("QUERY FAILED " . mysqli_error($connect));
	
			 echo "User Updated: ". " " . " <a href='users.php'> View Users </a>";
		} else
		echo "<script>alert('You entered an incorrect old password!')</script>";

		} else if (empty($_POST['user_old_password']))
		echo "<script>alert('You should enter your old password!')</script>";
	else if (empty($_POST['user_new_password']))
		echo "<script>alert('You should enter your old password!')</script>";


	}
	} else header("Location: index.php");
?>

<form action="" method="post" enctype="multipart/form-data">

	<div class="form-group">
		<label for="title">First name</label>
		<input type="text" value=<?php echo $user_firstname;?> class="form-control" name="user_firstname">
	</div>

	<div class="form-group">
		<label for="title">Last name</label>
		<input type="text" value=<?php echo $user_lastname;?> class="form-control" name="user_lastname">
	</div>

	<div class="form-group">
	<label for="title">User Role</label>
		<select name="user_role" id="">
			<?php

			switch ($user_role) { 
				case 'admin': {
					echo "<option value='admin' selected>Admin</option>";
					echo "<option value='subscriber'>Subscriber</option>";
					break;
				}
				case 'subscriber': {
					echo "<option value='admin'>Admin</option>";
					echo "<option value='subscriber' selected>Subscriber</option>";
					break;
				}

				default: {
					echo "<option value='admin'>Admin</option>";
					echo "<option value='subscriber'>Subscriber</option>";
					break;
				}
			}
			?>

		</select>
	</div>



	<!-- <div class="form-group">
		<label for="title">Post Image</label>
		<input type="file" name="image">
	</div> -->

	<div class="form-group">
		<label for="title">Username</label>
		<input type="text" value=<?php echo $username;?> class="form-control" name="username">
	</div>
	
	<div class="form-group">
		<label for="title">Email</label>
		<input type="email" value=<?php echo $user_email;?> class="form-control" name="user_email">
	</div>

	<div class="form-group">
		<label for="title">Old Password</label>
		<input autocomplete=off type="password" class="form-control" name="user_old_password">
	</div>

	<div class="form-group">
		<label for="title">New Password</label>
		<input type="password" class="form-control" name="user_new_password">
	</div>

	<div class="form-group">
		<input type="submit" class="btn btn-primary" name="edit_user" value="Edit User">
	</div>

</form>