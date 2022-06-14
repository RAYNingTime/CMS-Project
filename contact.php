<?php  include "includes/header.php"; ?>
<?php  include "includes/navigation.php"; ?>

<?php

if(isset($_POST['submit'])) {
    if(!empty($_POST['subject']) && !empty($_POST['email']) && !empty($_POST['body'])) {
        $subject = $_POST['subject'];
        $body = $_POST['body'];
		  $header = "From: ". $_POST['email'];
		  $to = "ivan0kosyakov@gmail.com";

		  $retval = mail ($to,$subject,$body,$header);
    }
}



?>

    <!-- Navigation -->
    

    
 
    <!-- Page Content -->
<div class="container">
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Contact</h1>
                    <form role="form" action="contact.php" method="post" id="login-form" autocomplete="off">
							
							<?php 
								if (isset($_POST['submit']))
									if( $retval == true ) {
										echo "Message sent successfully...";
									}else {
										echo "Message could not be sent...";
									}
							
							?>

                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email">
                        </div>
								<div class="form-group">
                            <label for="subject" class="sr-only">Subject</label>
                            <input type="text" name="subject" id="subject" class="form-control" placeholder="Enter your Subject">
                        </div>
                         <div class="form-group">
                            <label for="body" class="sr-only">Body</label>
                            <textarea class="form-control" name="body" id="body" cols="30" rows="10"></textarea>
                        </div>
                
                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Submit">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>

<hr>



<?php include "includes/footer.php";?>
