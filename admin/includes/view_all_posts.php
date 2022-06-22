<?php

include("delete_modal.php");

if(isset($_POST['checkBoxArray'])) {
	foreach($_POST['checkBoxArray'] as $checkBoxValue){
		$bulk_options = escape($_POST['bulk_option']);

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
					$post_user = $row['post_user']; 
					$post_date = $row['post_date']; 
					$post_image = $row['post_image']; 
					$post_content = $row['post_content']; 
					$post_tags = $row['post_tags']; 
					$post_status = $row['post_status']; 
				}

				$query = "INSERT INTO posts(post_category_id, post_title, post_user, post_date, post_image, post_content, post_tags, post_status)";
				$query .= "VALUES({$post_category_id},'{$post_title}','{$post_user}', '{$post_date}' ,'{$post_image}','{$post_content}','{$post_tags}' ,'{$post_status}')";

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
				<th>User</th>
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
				// $query = "SELECT * FROM posts ORDER BY post_id DESC";

				$query = "SELECT posts.post_id, posts.post_category_id, posts.post_title, posts.post_user, posts.post_date, posts.post_image, posts.post_content, posts.post_tags, posts.post_status, posts.post_view_count, ";
				$query .= "categories.cat_id, categories.cat_title FROM posts LEFT JOIN categories ON posts.post_category_id = categories.cat_id ORDER BY posts.post_id DESC";
				$select_posts = mysqli_query($connect, $query);
			
				while($row = mysqli_fetch_assoc($select_posts)) {
					if((!is_admin() AND $row['post_user']==$_SESSION['username'])|| is_admin()) {
					$post_id = $row['post_id'];
					$post_category_id = $row['post_category_id']; 
					$post_title = $row['post_title']; 
					$post_user = $row['post_user']; 
					$post_date = $row['post_date']; 
					$post_image = $row['post_image']; 

					if (strlen($row['post_content']) > 150)
						$post_content = substr($row['post_content'],0,150) . "..."; 
					else 
						$post_content = substr($row['post_content'],0,150);

					$post_tags = $row['post_tags']; 
					$post_status = $row['post_status']; 
					$post_view_count = $row['post_view_count'];
					$cat_title = $row['cat_title']; 

					echo "<tr>"; ?>

					<td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value=<?php echo $post_id;?>>
					
					<?php 
					echo "<td>{$post_id}</td>";
					
					// $query = "SELECT * FROM categories WHERE cat_id = {$post_category_id}";
					// $select_categories_id = mysqli_query($connect, $query);

					// $row = mysqli_fetch_assoc($select_categories_id);
					// $cat_title = $row['cat_title'];

					echo "<td>{$cat_title}</td>";
					echo "<td>{$post_title}</td>";
					echo "<td>{$post_user}</td>";
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
					echo "<td><a class='btn btn-primary' href='../post.php?p_id={$post_id}'>View post</a></td>";
					echo "<td><a class='btn btn-info' href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";
					echo "<td><a class='btn btn-warning' onClick=\"javascript: return confirm('Are you sure you reset views on this post?');\" href='posts.php?reset_views={$post_id}'>Reset Views</a></td>";

					//First form of deleting
					// echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete?');\" href='posts.php?delete={$post_id}'>Delete</a></td>";

					//Second form of deleting
					// echo "<td><a rel='$post_id' href='javascript:void(0)' class='delete_link'>Delete</a></td>";

					//Newest form of deleting
				  ?>
				  
				  <form method="post">
				  <input type="hidden" name="post_id" value="<?php echo $post_id?>">
				  <?php
				 	 	echo '<td><input class="btn btn-danger" type="submit" name = "delete" value="Delete"></td>';
				  ?>
				  </form>
				  <?php
					echo "</tr>";
				}}
				?>
		</tbody>
	</table>
</form>


<script>
	$(document).ready(function(){
		$(".delete_link").on('click', function(){
			var id = $(this).attr("rel");
			var delete_url = "posts.php?delete=" + id;
			$(".modal_delete_link").attr("href", delete_url);

			$("#exampleModal").modal('show');
		});
	});
</script>

<?php 

if(isset($_POST['delete'])) {
	$get_post_id = escape($_POST['post_id']);
	$query = "DELETE FROM posts WHERE post_id = {$get_post_id}";
	$delete_query = mysqli_query($connect, $query);
	header("Location: posts.php");
}

if(isset($_GET['reset_views'])) {
	$get_post_id = escape($_GET['reset_views']);
	$query = "UPDATE posts SET post_view_count=0 WHERE post_id = {$get_post_id}";
	$reset_views_query = mysqli_query($connect, $query);
	header("Location: posts.php");
}

?>

