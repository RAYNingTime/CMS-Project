<?php include "includes/admin_header.php";?>

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
							<div class="col-xs-6">
							 <?php
							
							 if (isset($_POST['submit'])) {
								$cat_title = $_POST['cat_title'];

								if ($cat_title == "" || empty($cat_title)){
									echo "This field should not be empty!";
								} else {
									$query = "INSERT INTO categories(cat_title) VALUES ('{$cat_title}')";

									$create_category = mysqli_query($connect , $query);

									if (!$create_category)
										die('QUERY FAILED'. mysqli_error($connect));
								}
							 }

							 ?>
								
								<form action="" method = "post">
									<div class="form-group">
										<label for="cat-title">Add Category</label>
										<input class = "form-control" type="text" name = "cat_title">
									</div>
									<div class="form-group">
										<input class = "btn btn-primary" type="submit" name = "submit" value = "Add Category">
									</div>
								</form>
							

								<form action="" method = "post">
									<div class="form-group">
										<label for="cat-title">Edit Category </label>

										<?php


										if (isset($_GET['edit']))
										{
										$cat_id = $_GET['edit'];

										$query = "SELECT * FROM categories WHERE cat_id = {$cat_id}";
										$select_categories_id = mysqli_query($connect, $query);

										while($row = mysqli_fetch_assoc($select_categories_id)) {
											$cat_id = $row['cat_id'];
											$cat_title = $row['cat_title']; 
										}
										?>

									<input value="<?php if(isset($cat_title)) echo $cat_title;?>" class = "form-control" type="text" name = "cat_title">
																				

										<?php } ?>

										</div>
									<div class="form-group">
										<input class = "btn btn-primary" type="submit" name = "update" value = "Update Category">
									</div>
								</form>
							</div> <!-- Add Category Form-->

							<div class="col-xs-6">
								<table class ="table table-bordered table-hover">
									<thead>
										<tr>
											<th>Id</th>
											<th>Category Title</th>
										</tr>
									</thead>
									<tbody>
									<?php //FIND ALL CATEGORIES QUERY
										$query = "SELECT * FROM categories";
										$select_categories = mysqli_query($connect, $query);

										while($row = mysqli_fetch_assoc($select_categories)) {
											$cat_id = $row['cat_id'];
											$cat_title = $row['cat_title']; 

											echo "<tr><th>{$cat_id}</th>";
											echo "<th>{$cat_title}</th>";
											echo "<th><a href='categories.php?delete={$cat_id}'> Delete </a></th>";
											echo "<th><a href='categories.php?edit={$cat_id}'> Edit </a></th></tr>";
										}
									?>

									<?php
									
									if (isset($_GET['delete'])) {
										$get_cat_id = $_GET['delete'];

										$query = "DELETE FROM categories WHERE cat_id = {$get_cat_id}";
										$delete_query = mysqli_query($connect, $query);
										header("Location: categories.php");
									}

									?>
									</tbody>
								</table>
                     </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

<?php include "includes/admin_footer.php";?>