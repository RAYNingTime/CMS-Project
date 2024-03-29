
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

                const PER_PAGE = 3;

                if(isset($_GET['page'])) {
                    $page = escape($_GET['page']);
                } else {
                    $page = "";
                }

                if($page == "" || $page == 1){
                    $page_1 = 0;
                } else {
                    $page_1 = ($page * PER_PAGE) - PER_PAGE;
                }

                if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin')
                    $query = "SELECT * FROM posts";
                else 
                    $query = "SELECT * FROM posts WHERE post_status = 'published'";
                    
                

                $find_count = mysqli_query($connect,$query);
                $count = mysqli_num_rows($find_count);
                
                $count = ceil($count/PER_PAGE);
                $per_page = PER_PAGE;

                if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin')
                    $query_per_page = "SELECT * FROM posts LIMIT $page_1, $per_page";
                else 
                    $query_per_page = "SELECT * FROM posts WHERE post_status = 'published' LIMIT $page_1, $per_page";
                    
                $select_all_posts_query = mysqli_query($connect, $query_per_page);


                $posted = FALSE;
                while($row = mysqli_fetch_assoc($select_all_posts_query)) {
                    $post_id = $row['post_id'];
                    $post_title = $row['post_title'];
                    $post_user = $row['post_user'];
                    $post_date = $row['post_date'];
                    $post_image = $row['post_image'];
                    
                    if (strlen($row['post_content']) > 150)
                        $post_content = substr($row['post_content'],0,150) . "..."; 
                    else 
                        $post_content = substr($row['post_content'],0,150);
                        
                    $post_status = $row['post_status'];

                    if($post_status == 'published' || ($_SESSION['user_role'] == 'admin' && $post_status == 'draft')  || ($_SESSION['username'] == $post_user)) {
                        $posted = TRUE;
            ?>
                <!-- First Blog Post -->
                <h2>
                    <a href="post.php?p_id=<?php echo $post_id;?>"><?php echo $post_title;?></a>
                    <?php if(($_SESSION['username'] == $post_user) && $post_status == 'draft') echo "<small>YOUR DRAFT</small>";?>
                </h2>
                <p class="lead">
                    
                <?php 
				    echo "by <a href='author_posts.php?author=" .  $post_user . "&p_id=" . $post_id . "' >" . $post_user . "</a>";
                ?>
                    
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date;?></p>
                <hr>
                <a href="post.php?p_id=<?php echo $post_id;?>">
                <img class="img-responsive" src=<?php echo "'images/". $post_image. "'";?> alt="">
                </a>
                <hr>
                <p><?php echo $post_content;?></p>
                <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id;?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>
            <?php
            }}

            if ($posted == FALSE){
                echo "</br></br><h4 class='text-center'>Currently, there are no posts.</h4>";
                echo "<strong><p style='color:grey;' class='text-center'>Return later.</p></strong>";
            }

            ?>

            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php";?>

        </div>
        <!-- /.row -->

        <hr>
        

        <ul class="pager">
            <?php 
            for($i =1; $i <= $count; $i++){

                if($i == $page){
                    echo "<li><a class='active_link' href='index.php?page={$i}'>{$i}</a></li>";
                } else
                    echo "<li><a href='index.php?page={$i}'>{$i}</a></li>";
            }

            ?>
        </ul>
<?php include "includes/footer.php";?>
