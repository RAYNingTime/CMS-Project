<form action="" method = "post">
	<div class="form-group">
		<label for="cat-title">Edit Category </label>
		<?php
			if (isset($_GET['edit'])){
				$cat_id = escape($_GET['edit']);

				$query = "SELECT * FROM categories WHERE cat_id = {$cat_id}";
				$select_categories_id = mysqli_query($connect, $query);

				while($row = mysqli_fetch_assoc($select_categories_id)) {
					$cat_id = $row['cat_id'];
					$cat_title = $row['cat_title']; 
										
		?>

					<input value="<?php if(isset($cat_title)) echo $cat_title;?>" class = "form-control" type="text" name = "cat_title">
																				

					<?php }} ?>

				<?php
										
					//Update QUERY

					if (isset($_POST['update_category'])) {
						$get_cat_title = escape($_POST['cat_title']);
										
	
						$query = "UPDATE categories SET cat_title = '{$get_cat_title}' WHERE cat_id = {$cat_id}";
						$update_query = mysqli_query($connect, $query);
						header("Location: categories.php");
					}
										
				?>

	</div>
		<div class="form-group">
			<input class = "btn btn-primary" type="submit" name = "update_category" value = "Update Category">
		</div>
</form>