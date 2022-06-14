<?php

if(isset($_POST['checkBoxArray'])) {
	foreach($_POST['checkBoxArray'] as $checkBoxValue){
		$bulk_options = $_POST['bulk_option'];

		switch($bulk_options) {
			case 'published': {
				$query = "UPDATE posts SET post_status='{$bulk_options}' WHERE post_id = $checkBoxValue";
				$update_to_published_status = mysqli_query($connect, $query);
				break;
			}

			case 'draft': {
				$query = "UPDATE posts SET post_status='{$bulk_options}' WHERE post_id = $checkBoxValue";
				$update_to_draft_status = mysqli_query($connect, $query);
				break;
			}
			case 'delete': {
				$query = "DELETE FROM posts WHERE post_id = $checkBoxValue";
				$delete_post = mysqli_query($connect, $query);
				break;
			}
			case 'clone': {
				$query = "SELECT * FROM posts WHERE post_id = $checkBoxValue";
				$select_post_query = mysqli_query($connect, $query);

				while ($row = mysqli_fetch_array($select_post_query)){
					$post_category_id = $row['post_category_id']; 
					$post_title = $row['post_title']; 
					$post_author = $row['post_author']; 
					$post_date = $row['post_date']; 
					$post_image = $row['post_image']; 
					$post_content = $row['post_content']; 
					$post_tags = $row['post_tags']; 
					$post_status = $row['post_status']; 
				}

				$query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_status)";
				$query .= "VALUES({$post_category_id},'{$post_title}','{$post_author}', '{$post_date}' ,'{$post_image}','{$post_content}','{$post_tags}' ,'{$post_status}')";

				$copy_query = mysqli_query($connect, $query);
				if(!$copy_query) {
					die("QUERY FAILED " . mysqli_error($connect));
				}

				break;
			}
		}
	}
}

?>

<form action="" method="post">
	<table class = "table table-bordered table-hover">

		<div id="bulkOptionsContainer" class="col-xs-4">
			<select class ="form-control" name="bulk_option" id="">
				<option value="">Select Option</option>
				<option value="published">Publish</option>
				<option value="draft">Draft</option>
				<option value="delete">Delete</option>
				<option value="clone">Clone</option>
			</select>
		</div>


		<div class="col-xs-4">
			<input type="submit" name="submit" class="btn btn-success" value="Apply">
			<a class="btn btn-primary" href="posts.php?source=add_post">Add New</a>
		</div>

		<thead>
			<tr>
				<th><input type="checkbox" id="selectAllBoxes"></th>
				<th>ID</th>
				<th>Category</th>
				<th>Title</th>
				<th>Author</th>
				<th>Date</th>
				<th>Image</th>
				<th>Content</th>
				<th>Tags</th>
				<th>Comments</th>
				<th>Status</th>
				<th>View Count</th>
				<th>View post</th>
				<th>Edit</th>
				<th>Reset Views</th>
				<th>Delete</th>
			</tr>
		</thead>
		<tbody>
			<tr>

				<?php
				$query = "SELECT * FROM posts";
				$select_posts = mysqli_query($connect, $query);
			
				while($row = mysqli_fetch_assoc($select_posts)) {
					$post_id = $row['post_id'];
					$post_category_id = $row['post_category_id']; 
					$post_title = $row['post_title']; 
					$post_author = $row['post_author']; 
					$post_user = $row['post_user'];
					$post_date = $row['post_date']; 
					$post_image = $row['post_image']; 
					$post_content = $row['post_content']; 
					$post_tags = $row['post_tags']; 
					$post_status = $row['post_status']; 
					$post_view_count = $row['post_view_count']; 

					echo "<tr>"; ?>

					<td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value=<?php echo $post_id;?>>
					
					<?php 
					echo "<td>{$post_id}</td>";
					
					$query = "SELECT * FROM categories WHERE cat_id = {$post_category_id}";
					$select_categories_id = mysqli_query($connect, $query);

					$row = mysqli_fetch_assoc($select_categories_id);
					$cat_title = $row['cat_title'];

					echo "<td>{$cat_title}</td>";

					echo "<td>{$post_title}</td>";

					if(isset($post_author) || !empty($post_author)) {
						echo "<td>{$post_author}</td>";
					} else if (isset($post_user) || !empty($post_user)) {
						echo "<td>{$post_user}</td>";
					}
					
					

					echo "<td>{$post_date}</td>";
					echo "<td><img src ='../images/{$post_image}' alt = 'images' width='200'></td>";
					echo "<td>{$post_content}</td>";
					echo "<td>{$post_tags}</td>";

					$query = "SELECT * FROM comments WHERE comment_post_id = $post_id";
					$send_query_comment = mysqli_query($connect, $query);
					$count_comments = mysqli_num_rows($send_query_comment);
					$row = mysqli_fetch_assoc($send_query_comment);


					if($count_comments>0){
						echo "<td><a href='post_comments.php?id={$post_id}'>$count_comments</a></td>";
				  } else {
						echo "<td>$count_comments</td>";
				  }

					echo "<td>{$post_status}</td>";
					echo "<td>{$post_view_count}</td>";
					echo "<td><a href='../post.php?p_id={$post_id}'>View post</a></td>";
					echo "<td><a href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";
					echo "<td><a onClick=\"javascript: return confirm('Are you sure you reset views on this post?');\" href='posts.php?reset_views={$post_id}'>Reset Views</a></td>";
					echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete?');\" href='posts.php?delete={$post_id}'>Delete</a></td>";
					echo "</tr>";
				}
				?>

		</tbody>
	</table>
</form>

<?php 

if(isset($_GET['delete'])) {
	$get_post_id = $_GET['delete'];
	$query = "DELETE FROM posts WHERE post_id = {$get_post_id}";
	$delete_query = mysqli_query($connect, $query);
	header("Location: posts.php");
}

if(isset($_GET['reset_views'])) {
	$get_post_id = $_GET['reset_views'];
	$query = "UPDATE posts SET post_view_count=0 WHERE post_id = {$get_post_id}";
	$reset_views_query = mysqli_query($connect, $query);
	header("Location: posts.php");
}
?>