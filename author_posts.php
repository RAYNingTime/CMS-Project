
<?php include "includes/header.php";?>

<!-- Navigation -->
<?php include "includes/navigation.php";?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <h1 class="page-header">
                Page Heading
                <small>Secondary Text</small>
            </h1>
        <?php

        if(isset($_GET['p_id'])){
            $the_post_id = escape($_GET['p_id']);
			$post_author = escape($_GET['author']);

            $query = "SELECT * FROM posts WHERE post_author = '{$post_author}' OR post_user = '{$post_author}'";
            $select_all_posts_query = mysqli_query($connect, $query);

            while($row = mysqli_fetch_assoc($select_all_posts_query)) {
                $post_title = $row['post_title'];
                $post_author = $row['post_author'];
                $post_user = $row['post_user'];
                $post_date = $row['post_date'];
                $post_image = $row['post_image'];
                $post_content = $row['post_content'];
        ?>

       

                <!-- First Blog Post -->
                <h2>
                    <a href="post.php?p_id=<?php echo $the_post_id;?>"><?php echo $post_title;?></a>
                </h2>

                <p class ="lead">
                <?php 
                    if(!empty($post_author)) {
						echo "by <a href='author_posts.php?author=" . $post_author . "&p_id=" . $the_post_id . "' >" . $post_author . "</a>";
					} else if (!empty($post_user)) {
						echo "by <a href='author_posts.php?author=" .  $post_user . "&p_id=" . $the_post_id . "' >" . $post_user . "</a>";
					}
                ?>
                </p>

                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date;?></p>
                <hr>
                <a href="post.php?p_id=<?php echo $the_post_id;?>">
                <img class="img-responsive" src=<?php echo "'images/". $post_image. "'";?> alt="">
                </a>
                <hr>
                <p><?php echo $post_content;?></p>
                <a class="btn btn-primary" href="post.php?p_id=<?php echo $the_post_id;?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>
        <?php
        }}
        ?>



        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php";?>

    </div>
    <!-- /.row -->


<?php include "includes/footer.php";?>