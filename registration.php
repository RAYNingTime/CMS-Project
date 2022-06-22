<?php  include "includes/header.php"; ?>
<?php  include "includes/navigation.php"; ?>

<?php
//Setting Language Variables

if(isset($_GET['lang']) && !empty($_GET['lang'])){
    $_SESSION['lang'] = $_GET['lang'];

    if(isset($_SESSION['lang']) && $_SESSION['lang'] != $_GET['lang']){
        echo "<script type='text/javascript'>location.reload()</script>";
    }
}

if(isset($_SESSION['lang'])){
    include "includes/languages/".$_SESSION['lang'].".php";
} else {
    include "includes/languages/en.php";
}




if(isset($_POST['submit'])) {

    $username = escape($_POST['username']);
    $email = escape($_POST['email']);
    $password = escape($_POST['password']);
    $firstname = escape($_POST['firstname']);
    $lastname = escape($_POST['lastname']);

    $message = register_user($username, $email, $password, $firstname, $lastname);

    if (empty($message)) {
        login_user($username, $password);
        header("Location: index.php");
    }
}



?>

    <!-- Navigation -->
    
    <!-- Page Content -->
<div class="container">
<form method="get" class="navbar-form navbar-right" action=""  id="language_form">
    <div class="form-group">
        <select name="lang" class="form-control" onchange="changeLanguage()">
            <option value="en" <?php if(isset($_SESSION['lang']) && $_SESSION['lang']=='en') echo "Selected";?>>English</option>
            <option value="ukr" <?php if(isset($_SESSION['lang']) && $_SESSION['lang']=='ukr') echo "Selected";?>>Український</option>
        </select>
    </div>
</form>

<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1><?php echo _REGISTER;?></h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                        <?php if (!empty($message)) echo $message;?>
                        <div class="form-group">
                            <label for="username" class="sr-only">username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="<?php echo _USERNAME;?>" 
                            autocomplete = "on" value = <?php echo isset($username) ? $username : ''; ?> >
                        </div>
                        <div class="form-group">
                            <label for="firstname" class="sr-only">firstname</label>
                            <input type="text" name="firstname" id="firstname" class="form-control" placeholder="<?php echo _FIRSTNAME;?>"
                            autocomplete = "on" value = <?php echo isset($firstname) ? $firstname : ''; ?> >
                        </div>
                        <div class="form-group">
                            <label for="lastname" class="sr-only">lastname</label>
                            <input type="text" name="lastname" id="lastname" class="form-control" placeholder="<?php echo _SECONDNAME;?>" 
                            autocomplete = "on" value = <?php echo isset($lastname) ? $lastname : ''; ?> >
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="<?php echo _EMAIL;?>" 
                            autocomplete = "on" value = <?php echo isset($email) ? $email : ''; ?> >
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="<?php echo _PASSWORD;?>">
                        </div>
                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="<?php echo _REGISTER;?>">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>

<hr>

<script>
    function changeLanguage(){
        document.getElementById('language_form').submit();
    }
</script>

<?php include "includes/footer.php";?>
