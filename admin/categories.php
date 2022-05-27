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
								<form action="">
									<div class="form-group">
										<label for="cat-title">Add Category</label>
										<input class = "form-control" type="text" name = "cat_title">
									</div>
									<div class="form-group">
										<input class = "btn btn-primary" type="submit" name = "submit" value = "Add Category">
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
									<?php
										$query = "SELECT * FROM categories LIMIT 3";
										$select_categories = mysqli_query($connect, $query);

										while($row = mysqli_fetch_assoc($select_categories)) {
											$cat_id = $row['cat_id'];
											$cat_title = $row['cat_title']; 

											echo "<tr><th>{$cat_id}</th>";
											echo "<th>{$cat_title}</th></tr>";
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

<?php include "includes/admin_footer.php"; ?>