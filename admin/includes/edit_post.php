<?php
if(isset($_GET['p_id'])) {

	$the_post_id = $_GET['p_id'];
	
	$query = "SELECT * FROM posts WHERE post_id = $the_post_id";
	$select_posts_by_id = mysqli_query($connect, $query);

	$row = mysqli_fetch_assoc($select_posts_by_id);
	
	$post_id = $row['post_id'];
	$post_category_id = $row['post_category_id']; 
	$post_title = $row['post_title']; 
	$post_author = $row['post_author']; 
	$post_date = $row['post_date']; 
	$post_image = $row['post_image']; 
	$post_content = $row['post_content']; 
	$post_tags = $row['post_tags']; 
	$post_comment_count = $row['post_comment_count']; 
	$post_status = $row['post_status']; 

}

if(isset($_POST['update_post'])) {
	 
	$post_author = $_POST['post_author'];
	$post_title = $_POST['post_title'];
	$post_category_id = $_POST['post_category'];
	$post_status = $_POST['post_status'];
	$post_image = $_FILES['image']['name'];
	$post_image_temp = $_FILES['image']['tmp_name'];
	$post_content = $_POST['post_content'];
	$post_tags = $_POST['post_tags'];

	move_uploaded_file($post_image_temp, "../images/$post_image");

	if(empty($post_image)){
		$query = "SELECT * FROM posts WHERE post_id = $the_post_id";
		$select_image = mysqli_query($connect, $query);

		while($row = mysqli_fetch_assoc($select_image)){
			$post_image = $row['post_image'];
		}

	}

	$query = "UPDATE posts SET ";
	$query .="post_title   = '{$post_title}', ";
	$query .="post_category_id = '{$post_category_id}', ";
	$query .="post_date    = now(), ";
	$query .="post_author  = '{$post_author}', ";
	$query .="post_status  = '{$post_status}', ";
	$query .="post_tags    = '{$post_tags}', ";
	$query .="post_content = '{$post_content}',";
	$query .="post_image   = '{$post_image}' ";
	$query .="WHERE post_id = {$the_post_id} ";

	$update_post = mysqli_query($connect, $query);

	if(!$update_post){
		die("QUERY FAILED" . mysqli_error($connect));
	}

	echo "Post Updated: ". " " . " <a href='posts.php'> View Posts </a>";
}
?>

<form action="" method="post" enctype="multipart/form-data">

	<div class="form-group">
		<label for="title">Post Title</label>
		<input value=<?php echo "'{$post_title}'"?> type="text" class="form-control" name="post_title">
	</div>

	<div class="form-group">
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
					
					if ($post_category_id == $cat_id)
						echo "<option value='{$cat_id}' selected>$cat_title</option>";
					else
						echo "<option value='{$cat_id}'>$cat_title</option>";
				}

			?>
		</select>
	</div>

	<div class="form-group">
		<label for="title">Post Author</label>
		<input value=<?php echo "'{$post_author}'"?> type="text" class="form-control" name="post_author">
	</div>

	<div class="form-group">
		<label for="title">Post Status</label>
		<select name="post_status" id="">
			<?php

			switch ($post_status) { 
				case 'draft': {
					echo "<option value='draft' selected>Draft</option>";
					echo "<option value='published'>Published</option>";
					break;
				}
				case 'published': {
					echo "<option value='draft'>Draft</option>";
					echo "<option value='published' selected>Published</option>";
					break;
				}

				default: {
					echo "<option value='draft'>Draft</option>";
					echo "<option value='published'>Published</option>";
					break;
				}
			}
			?>

		</select>
	</div>

	<div class="form-group">
		<label for="title">Post Image</label>
		</br>
		<img width = "300" src="../images/<?php echo $post_image?>" alt="">
		<input type="file" name="image">
	</div>

	<div class="form-group">
		<label for="title">Post Tags</label>
		<input value=<?php echo "'{$post_tags}'"?> type="text" class="form-control" name="post_tags">
	</div>

	<div class="form-group">
		<label for="summernote">Post Content</label>
		<textarea class="form-control" name="post_content" id="summernote" cols="30" rows="10"><?php echo "{$post_content}"?></textarea>
	</div>

	<div class="form-group">
		<input type="submit" class="btn btn-primary" name="update_post" value="Update Post">
	</div>

</form>