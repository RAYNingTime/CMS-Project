<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
<?php include "admin/includes/functions.php";?>

<?php
if(!ifItIsMethod('get') && !isset($_GET['forgot'])) {
	redirect('index.php');
}
if(ifItIsMethod('post')) {
	if(isset($_POST['email'])){

		$email = $_POST['email'];
		$length = 50;
		$token = bin2hex(openssl_random_pseudo_bytes($length));

		if(emailExists($email)){
            if($stmt = mysqli_prepare($connect, "UPDATE users SET token = '{$token}' WHERE user_email=?")){
                mysqli_stmt_bind_param($stmt,"s", $email);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
            } else echo die("Something is not correct. " . mysqli_error($connect));
		}
	}
}
?>
<!-- Page Content -->
<div class="container">
    <div class="form-gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">

                                <h3><i class="fa fa-lock fa-4x"></i></h3>
                                <h2 class="text-center">Forgot Password?</h2>
                                <p>You can reset your password here.</p>
                                <div class="panel-body">

                                    <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                                <input id="email" name="email" placeholder="email address" class="form-control"  type="email">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                        </div>

                                        <input type="hidden" class="hide" name="token" id="token" value="">
                                    </form>

                                </div><!-- Body-->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <hr>

    <?php include "includes/footer.php";?>

</div> <!-- /.container -->

