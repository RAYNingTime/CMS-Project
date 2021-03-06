<?php
	if (isset($_POST['create_post'])) {
		$post_title = escape($_POST['title']);
		$post_user = escape($_POST['post_users']);
		$post_category_id = escape($_POST['post_category']);
		$post_status = escape($_POST['post_status']);

		$post_image = $_FILES['image']['name'];
		$post_image_temp = $_FILES['image']['tmp_name'];

		$post_tags = escape($_POST['post_tags']);
		$post_content = escape($_POST['post_content']);
		$post_date = escape(date('d-m-y'));

		move_uploaded_file($post_image_temp, "../images/$post_image");


		//This is not included in lectures, so I should make it by myself

		if(isset($post_user)) {
			$query = "SELECT * FROM users WHERE username='$post_user'";
			$result = mysqli_query($connect, $query);
			$user = mysqli_fetch_array($result);
			if(mysqli_num_rows($result)>=1)
				$user_id = $user['user_id'];
		}


		$query = "INSERT INTO posts(post_category_id, user_id, post_title, post_user, post_date, post_image, post_content, post_tags, post_status)";
		$query .= "VALUES({$post_category_id},{$user_id},'{$post_title}','{$post_user}', now() ,'{$post_image}','{$post_content}','{$post_tags}','{$post_status}')";

		$create_post_query = mysqli_query($connect, $query);

		if(!$create_post_query)
			die("QUERY FAILED   " . mysqli_error($connect));

		$get_post_id = mysqli_insert_id($connect);
		
		echo "<p class='bg-success'>Post Created: <a href='posts.php'> View all posts </a> or <a href='../post.php?p_id={$get_post_id}'>View Post</a> </p>";
	}

	
?>

<form action="" method="post" enctype="multipart/form-data">

	<div class="form-group">
		<label for="title">Post Title</label>
		<input type="text" class="form-control" name="title">
	</div>

	<div class="form-group">
	<label for="category">Post Category</label>
		<select name="post_category" id="">
			<?php
				$query = "SELECT * FROM categories";
				$select_categories = mysqli_query($connect, $query);

				if(!$select_categories){
					die("QUERY FAILED " . mysqli_error($connect));
				}

				while($row = mysqli_fetch_assoc($select_categories)) {
					$cat_id = $row['cat_id'];
					$cat_title = $row['cat_title'];
					
					echo "<option value='{$cat_id}'>$cat_title</option>";
				}
			?>
		</select>
	</div>

	<div class="form-group">
	<label for="users">Users</label>
		<select name="post_users" id="">
			<?php
				$query = "SELECT * FROM users";
				$select_users = mysqli_query($connect, $query);

				if(!$select_users){
					die("QUERY FAILED " . mysqli_error($connect));
				}

				while($row = mysqli_fetch_assoc($select_users)) {
					$username = $row['username'];
					
					echo "<option value='{$username}'>$username</option>";
				}
			?>
		</select>
	</div>


	<div class="form-group">
	<label for="title">Post Status</label>
		<select name="post_status" id="">
			<option value="draft">Select Option</option>
			<option value="published">Published</option>
			<option value="draft">Draft</option>

		</select>
	</div>

	<div class="form-group">
		<label for="title">Post Image</label>
		<input type="file" name="image">
	</div>

	<div class="form-group">
		<label for="title">Post Tags</label>
		<input type="text" class="form-control" name="post_tags">
	</div>
	
	<div class="form-group">
		<label for="summernote">Post Content</label>
		<textarea class="form-control" name="post_content" id="summernote" cols="30" rows="10"></textarea>
	</div>

	<div class="form-group">
		<input type="submit" class="btn btn-primary" name="create_post" value="Publish Post">
	</div>

</form>