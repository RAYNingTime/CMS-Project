
<?php include "includes/header.php";?>


<!-- Navigation -->
<?php include "includes/navigation.php";?>

<?php
if(isset($_POST['liked'])) {
 
    $post_id = $_POST['post_id'];
    $user_id = $_POST['user_id'];
 
     //1 =  FETCHING THE RIGHT POST
 
    $query = "SELECT * FROM posts WHERE post_id=$post_id";
    $postResult = mysqli_query($connect, $query);
    $post = mysqli_fetch_array($postResult);
    $likes = $post['likes'];
 
    // 2 = UPDATE - INCREMENTING WITH LIKES
 
    mysqli_query($connect, "UPDATE posts SET likes= $likes+1 WHERE post_id=$post_id");
 
    // 3 = CREATE LIKES FOR POST
    
   mysqli_query($connect, "INSERT INTO likes(user_id, post_id) VALUES($user_id, $post_id)");
   exit();
}

if(isset($_POST['unliked'])) {
 
    $post_id = $_POST['post_id'];
    $user_id = $_POST['user_id'];
 
     //1 =  FETCHING THE RIGHT POST
 
    $query = "SELECT * FROM posts WHERE post_id=$post_id";
    $postResult = mysqli_query($connect, $query);
    $post = mysqli_fetch_array($postResult);
    $likes = $post['likes'];
 
    // 2 = UPDATE - DECRIMENTING LIKES
 
    mysqli_query($connect, "UPDATE posts SET likes= $likes-1 WHERE post_id=$post_id");
    
    // 3 = DELETE LIKES FROM POST
    
    mysqli_query($connect, "DELETE FROM likes WHERE post_id=$post_id AND user_id=$user_id");
   exit();
}
?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <h1 class="page-header">
                Posts
            </h1>
        <?php

        if(isset($_GET['p_id'])){
            $the_post_id = escape($_GET['p_id']);

            $view_query = "UPDATE posts SET post_view_count = post_view_count + 1 WHERE post_id = {$the_post_id}";
            $send_query = mysqli_query($connect, $view_query);
        
            if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin'){{
                $query = "SELECT * FROM posts WHERE post_id = $the_post_id";
                }
            } else { 
                $query = "SELECT * FROM posts WHERE post_id = $the_post_id AND post_status = 'published'";
            }
            $select_all_posts_query = mysqli_query($connect, $query);

            if(mysqli_num_rows($select_all_posts_query) < 1) {


                echo "</br></br><h4 class='text-center'>Currently, there are no posts.</h4>";
                echo "<strong><p style='color:grey;' class='text-center'>Return later.</p></strong>";
            }
        else {


            while($row = mysqli_fetch_assoc($select_all_posts_query)) {
                $post_title = $row['post_title'];
                $post_user = $row['post_user'];
                $post_date = $row['post_date'];
                $post_image = $row['post_image'];
                $post_content = $row['post_content'];
        ?>

       

            <!-- First Blog Post -->
            <h2>
                <h2><?php echo $post_title;?></h2>
            </h2>
            <p class="lead">
                by <a href="author_posts.php?author=<?php echo $post_user;?>&p_id=<?php echo $the_post_id;?>" ><?php echo $post_user;?></a>
            </p>
            <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date;?></p>
            <hr>
            <img class="img-responsive" src=<?php echo "'images/". $post_image. "'";?> alt="">
            <hr>
            <p><?php echo $post_content;?></p>

        <?php
            if(isLoggedIn()) {
        ?>
            <hr>
            <div class="row">
                <p class="pull-right">
                <strong><a style="font-size:22px;" class="<?php echo userLikedThisPost($the_post_id) ? 'unlike' : 'like';?>" href=""><span class="glyphicon glyphicon-thumbs-<?php echo userLikedThisPost($the_post_id) ? 'down' : 'up';?>" data-toggle='tooltip' data-placement='top' title="<?php echo userLikedThisPost($the_post_id) ? ' I liked this before' : ' Want to like it?';?>"></span> <?php echo userLikedThisPost($the_post_id) ? ' Unlike' : ' Like';?> 
                
                </a></strong>
                </p>
            </div>        
        <?php
          } else {
            ?>
            <div class="row">
                <p style="font-size:16px;" class="pull-right">
                    <strong>You need to <a  href="/cms/login.php">log in</a> to like the post.</strong>
                </p>
            </div>  
            
            <?php
          }
        }
        ?>
            <div class="row">
                <strong><p style="font-size:22px;"class="pull-right"> Likes: <?php getPostLikes($the_post_id);?> </p></strong>
            </div>

            <div class="clearfix"></div>

        <!-- Blog Comments -->

        <?php
        if(isset($_POST['create_comment'])){
            if(!empty($_POST['comment_author']) && !empty($_POST['comment_email']) && !empty($_POST['comment_content'])) {
                $the_post_id = escape($_GET['p_id']);

                $comment_author = escape($_POST['comment_author']);
                $comment_email = escape($_POST['comment_email']);
                $comment_content = escape($_POST['comment_content']);
    
                $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date)";
                $query .= "VALUES ($the_post_id, '{$comment_author}', '{$comment_email}', '{$comment_content}', 'unapproved', now())";
    
                $create_comment_query = mysqli_query($connect, $query);
    
                if(!$create_comment_query){
                    die("QUERY FAILED ". mysqli_error($connect));
                }
    
                //Updating comment system
                // $query = "UPDATE posts SET post_comment_count = post_comment_count + 1 WHERE post_id = $the_post_id";
                // $update_comment_count = mysqli_query($connect,$query);

                $view_query = "UPDATE posts SET post_view_count = post_view_count - 1 WHERE post_id = {$the_post_id}";
                $send_query = mysqli_query($connect, $view_query);

               ?> 

                <script> header("Location:/cms/post.php?p_id=".$the_post_id) </script>

               <?php
            } else {
            echo "<script>alert('Fields cannot be empty')</script>";
        }
        }
        ?>

        <!-- Comments Form -->
        <div class="well">
            <h4>Leave a Comment:</h4>
            <form action ="" method="post" role="form">
                <label for="author">Author</label>
                <div class="form-group">
                    <input type="text" name="comment_author" class="form-control" >
                </div>
                <label for="email">Email</label>
                <div class="form-group">
                    <input type="email" name="comment_email" class="form-control" >
                </div>
                <label for="comment">Your Comment</label>
                <div class="form-group">
                    <textarea name="comment_content" class="form-control" rows="3"></textarea>
                </div>
                <button type="submit" name="create_comment" class="btn btn-primary" >Submit</button>
            </form>
        </div>

        <hr>

        <!-- Posted Comments -->

        <?php
        
        $query = "SELECT * FROM comments WHERE comment_post_id = {$the_post_id} ";
        $query .= "AND comment_status = 'approved' ";
        $query .= "ORDER BY comment_id DESC ";
        $select_comment_query = mysqli_query($connect, $query);

        if(!$select_comment_query) {
            die ('QUERY FAILED ' . mysqli_error($connect));
        }

        while($row = mysqli_fetch_assoc($select_comment_query)) {
            $comment_date = $row['comment_date'];
            $comment_content = $row['comment_content'];
            $comment_author = $row['comment_author'];
        ?>

                    <!-- Comment -->
        <div class="media">
            <a class="pull-left" href="#">
                <img class="media-object" width = "64" src="https://44.media.tumblr.com/276eeec6ab6ee2dce7373580e5ffa35c/tumblr_n2fx9yLS411tvfpg9o1_500.gif" alt="">
            </a>
            <div class="media-body">
                <h4 class="media-heading"><?php echo $comment_author;?>
                    <small><?php echo $comment_date;?></small>
                </h4>
                <?php echo $comment_content;?>
            </div>
        </div>


        <?php }}} else {
            header("Location: index.php");
        } ?>





        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php";?>

    </div>
    <!-- /.row -->

    <hr>

<?php include "includes/footer.php";?>

<script>
    $(document).ready(function(){

        $("[data-toggle='tooltip']").tooltip();

        var post_id = <?php echo $the_post_id; ?>;
        
        var user_id = <?php echo loggedInUserId(); ?>;
        // LIKING

        $('.like').click(function(){
            $.ajax({
                url: "/cms/post.php?p_id=<?php echo $the_post_id; ?>",
                type: 'post',
                data: {
                    'liked': 1,
                    'post_id': post_id,
                    'user_id': user_id
                }
            });
        });

            // UNLIKING

        $('.unlike').click(function(){
            $.ajax({
                url: "/cms/post.php?p_id=<?php echo $the_post_id; ?>",
                type: 'post',
                data: {
                    'unliked': 1,
                    'post_id': post_id,
                    'user_id': user_id
                }
            });
        });


    });
</script>
