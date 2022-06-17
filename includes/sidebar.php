<div class="col-md-4">
    <!-- Blog Search Well -->
    <div class="well">
        <h4>Blog Search</h4>
        <form action="search.php" method ="post">
        <div class="input-group">
            <input name ="search" type="text" class="form-control">
            <span class="input-group-btn">
                <button name ="submit" class="btn btn-default" type="submit">
                    <span class="glyphicon glyphicon-search"></span>
            </button>
            </span>
        </div>
                </form><!-- search form -->
        <!-- /.input-group -->
    </div>

    <?php if (empty($_SESSION['username'])){?>
    <!-- Blog Search Well -->
    <div class="well">
        <h4>Login</h4>
        <form action="includes/login.php" method ="post">
            <?php if(isset($_GET['incorrect_pass'])) echo "<strong><p style='color:red;'> You've entered an incorrect login or password! </p></strong>";?>
        <div class="form-group">
            <input name ="username" type="text" class="form-control" placeholder="Enter username" autocomplete = "on">
        </div>
        <div class="input-group">
            <input name ="password" type="password" class="form-control" placeholder="Enter password">
            <span class ="input-group-btn">
                <button class="btn btn-primary" name="login" type="submit">Submit</button>
            </span>
        </div>
        </form><!-- search form -->
        <!-- /.input-group -->
    </div>
    <?php } else {?>

    <!-- Blog Search Well -->
    <div class="well">
        <h4>Profile</h4>
        <p style="font-size:20px;"><strong>Welcome, </strong><?php echo "{$_SESSION['first_name']}!";?></p>
        <p style="font-size:16px;">Hope you're having a great day!</p>
        <br>
        <h4>Menu</h4>
        <a href="includes/logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
        <!-- /.input-group -->
    </div>

    <?php }?>
    <!-- Blog Categories Well -->
    <div class="well">
        <h4>Blog Categories</h4>
        <div class="row">
            <div class="col-lg-12">
                <ul class="list-unstyled">

                        <?php
                            $query = "SELECT * FROM categories LIMIT 3";
                            $select_categories_sidebar = mysqli_query($connect, $query);

                            while($row = mysqli_fetch_assoc($select_categories_sidebar)) {
                                $cat_title = $row['cat_title'];
                                $cat_id = $row['cat_id'];

                                echo "<li><a href='category.php?category={$cat_id}'>{$cat_title}</a></li>";
                            }
                        ?>
                </ul>
            </div>
            <!-- /.col-lg-6 -->

        </div>
        <!-- /.row -->
    </div>


    <!-- Side Widget Well -->
            <?php include "widget.php";?>
</div>