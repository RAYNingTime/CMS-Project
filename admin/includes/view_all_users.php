<table class = "table table-bordered table-hover">
	<thead>
		<tr>
			<th>ID</th>
			<th>Username</th>
			<th>First name</th>
			<th>Last name</th>
			<th>Email</th>
			<th>Role</th>
		</tr>
	</thead>
	<tbody>
		<tr>

			<?php
			$query = "SELECT * FROM users";
			$select_users = mysqli_query($connect, $query);
		
			while($row = mysqli_fetch_assoc($select_users)) {
				$user_id = $row['user_id'];
				$username = $row['username']; 
				$user_password = $row['user_password']; 
				$user_firstname = $row['user_firstname'];
				$user_lastname = $row['user_lastname']; 
				$user_email = $row['user_email']; 
				$user_image = $row['user_image']; 
				$user_role = $row['user_role']; 

				echo "<tr>";
				echo "<td>$user_id</td>";
				echo "<td>$username</td>";
				echo "<td>$user_firstname</td>";
				echo "<td>$user_lastname</td>";
				echo "<td>$user_email</td>";
				echo "<td>$user_role</td>";

				echo "<td><a href='comments.php?approve='>Approve</a></td>";
				echo "<td><a href='comments.php?unapprove='>Unapprove</a></td>";
				echo "<td><a href='users.php?delete=$user_id'>Delete</a></td>";
				echo "</tr>";
			}
			?>

	</tbody>
</table>

<?php 

if(isset($_GET['delete'])) {
	$get_user_id = $_GET['delete'];
	$query = "DELETE FROM users WHERE user_id = {$get_user_id}";
	$delete_query = mysqli_query($connect, $query);
	header("Location: users.php");
}

if(isset($_GET['unapprove'])) {
	$get_comment_id = $_GET['unapprove'];
	$query = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = '{$get_comment_id}'";
	$unaprove_query = mysqli_query($connect, $query);
	header("Location: comments.php");
}

if(isset($_GET['approve'])) {
	$get_comment_id = $_GET['approve'];
	$query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = '{$get_comment_id}'";
	$aprove_query = mysqli_query($connect, $query);
	header("Location: comments.php");
}

?>