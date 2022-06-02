<?php
	if (isset($_POST['create_post'])) {
		$post_title = $_POST['title'];
		$post_author = $_POST['author'];
		$post_category_id = $_POST['post_category'];
		$post_status = $_POST['post_status'];

		$post_image = $_FILES['image']['name'];
		$post_image_temp = $_FILES['image']['tmp_name'];

		$post_tags = $_POST['post_tags'];
		$post_content = $_POST['post_content'];
		$post_date = date('d-m-y');

		move_uploaded_file($post_image_temp, "../images/$post_image");

		$query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_status)";
		$query .= "VALUES({$post_category_id},'{$post_title}','{$post_author}', now() ,'{$post_image}','{$post_content}','{$post_tags}','{$post_status}')";

		$create_post_query = mysqli_query($connect, $query);

		if(!$create_post_query)
			die("QUERY FAILED   " . mysqli_error($connect));
	}
?>

<form action="" method="post" enctype="multipart/form-data">

	<div class="form-group">
		<label for="title">First name</label>
		<input type="text" class="form-control" name="user_firstname">
	</div>

	<div class="form-group">
		<label for="title">Last name</label>
		<input type="text" class="form-control" name="user_lastname">
	</div>

	<div class="form-group">
	<label for="title">Post Category</label>
		<select name="user_role" id="">
			<?php
				$query = "SELECT * FROM users";
				$select_users = mysqli_query($connect, $query);

				if(!$select_users){
					die("QUERY FAILED " . mysqli_error($connect));
				}

				while($row = mysqli_fetch_assoc($select_users)) {
					$user_id = $row['user_id'];
					$user_role = $row['user_role'];
					
					echo "<option value='{$user_id}'>$user_role</option>";
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
		<input type="text" class="form-control" name="username">
	</div>
	
	<div class="form-group">
		<label for="title">Email</label>
		<input type="email" class="form-control" name="user_email">
	</div>

	<div class="form-group">
		<label for="title">Password</label>
		<input type="password" class="form-control" name="password">
	</div>

	<div class="form-group">
		<input type="submit" class="btn btn-primary" name="create_user" value="Add User">
	</div>

</form>