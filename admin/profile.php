<?php include "includes/admin_header.php";?>
<?php 

if(isset($_SESSION['username'])) {
	$username = $_SESSION['username'];
	
	$query = "SELECT * FROM users WHERE username = '{$username}'";
	$select_user_profile = mysqli_query($connect, $query);

	if(!$select_user_profile)
		die("QUERY FAILED " . mysqli_error($connect));

	while ($row = mysqli_fetch_array($select_user_profile)){
		$user_id = $row['user_id'];
		$username = $row['username']; 
		$user_password = $row['user_password']; 
		$user_firstname = $row['user_firstname'];
		$user_lastname = $row['user_lastname']; 
		$user_email = $row['user_email']; 
		$user_image = $row['user_image']; 
		$user_role = $row['user_role']; 
	}
}


?>

    <div id="wrapper">

        <?php include "includes/admin_navigation.php";?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                    
						  	<h1 class="page-header">
                            Welcome to admin
                            <small>Author</small>
                     </h1>

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
								<label for="title">Post Category</label>
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
									<label for="title">Password</label>
									<input type="password" value=<?php echo $user_password;?> class="form-control" name="user_password">
								</div>

								<div class="form-group">
									<input type="submit" class="btn btn-primary" name="edit_user" value="Update Profile">
								</div>

							</form>

                     </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

<?php include "includes/admin_footer.php";?>