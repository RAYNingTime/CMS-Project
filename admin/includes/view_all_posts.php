<form action="" method="post">
	<table class = "table table-bordered table-hover">

		<div id="bulkOptionsContainer" class="col-xs-4">
			<select class ="form-control" name="" id="">
				<option value="">Select Option</option>
				<option value="">Publish</option>
				<option value="">Draft</option>
				<option value="">Delete</option>
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
				<th>Edit</th>
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
					$post_date = $row['post_date']; 
					$post_image = $row['post_image']; 
					$post_content = $row['post_content']; 
					$post_tags = $row['post_tags']; 
					$post_comment_count = $row['post_comment_count']; 
					$post_status = $row['post_status']; 

					echo "<tr>"; ?>

					<td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value=<?php echo {$post_id};?>>
					
					<?php 
					echo "<td>{$post_id}</td>";
					
					$query = "SELECT * FROM categories WHERE cat_id = {$post_category_id}";
					$select_categories_id = mysqli_query($connect, $query);

					$row = mysqli_fetch_assoc($select_categories_id);
					$cat_title = $row['cat_title'];

					echo "<td>{$cat_title}</td>";

					echo "<td>{$post_title}</td>";
					echo "<td>{$post_author}</td>";
					echo "<td>{$post_date}</td>";
					echo "<td><img src ='../images/{$post_image}' alt = 'images' width='200'></td>";
					echo "<td>{$post_content}</td>";
					echo "<td>{$post_tags}</td>";
					echo "<td>{$post_comment_count}</td>";
					echo "<td>{$post_status}</td>";
					echo "<td><a href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";
					echo "<td><a href='posts.php?delete={$post_id}'>Delete</a></td>";
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
?>