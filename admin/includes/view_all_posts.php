<table class = "table table-bordered table-hover">
	<thead>
		<tr>
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

				echo "<tr>";
				echo "<td>{$post_id}</td>";
				echo "<td>{$post_category_id}</td>";
				echo "<td>{$post_title}</td>";
				echo "<td>{$post_author}</td>";
				echo "<td>{$post_date}</td>";
				echo "<td><img src ='../images/{$post_image}' alt = 'images' width='200'></td>";
				echo "<td>{$post_content}</td>";
				echo "<td>{$post_tags}</td>";
				echo "<td>{$post_comment_count}</td>";
				echo "<td>{$post_status}</td>";
				echo "<td><a href='posts.php?delete={$post_id}'>Delete</a></td>";
				echo "</tr>";
			}
			?>

	</tbody>
</table>

<?php 

if(isset($_GET['delete'])) {
	$get_post_id = $_GET['delete'];
	$query = "DELETE FROM posts WHERE post_id = {$get_post_id}";
	$delete_query = mysqli_query($connect, $query);
}
?>