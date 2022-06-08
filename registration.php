<?php  include "includes/header.php"; ?>
<?php  include "includes/navigation.php"; ?>

<?php

if(isset($_POST['submit'])) {
    if(!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];

        $username = mysqli_real_escape_string($connect, $username);
        $email = mysqli_real_escape_string($connect, $email);
        $password = mysqli_real_escape_string($connect, $password);
        $firstname = mysqli_real_escape_string($connect, $firstname);
        $lastname = mysqli_real_escape_string($connect, $lastname);

        $query = "SELECT user_randSalt FROM users";
        $select_randsalt_query = mysqli_query($connect, $query);

        if(!$select_randsalt_query) {
            die("QUERY FAILED " . mysqli_error($connect));
        }

        $row = mysqli_fetch_assoc($select_randsalt_query);
        $randSalt = $row['user_randSalt'];

        $query = "INSERT INTO users (username, user_email, user_password, user_role, user_firstname, user_lastname) ";
        $query .= "VALUES('{$username}', '{$email}', '{$password}', 'subscriber', '{$firstname}', '{$lastname}')";
        $register_user_query = mysqli_query($connect, $query);

        if(!$register_user_query) {
            die("QUERY FAILED " . mysqli_error($connect)) . ' ' . mysqli_errno($connect);
        }

        header("Location: index.php");

        
    } else {
        // echo "<strong><p style='color:red;font-size:25px;' class='text-center'>You should fill all the fields!</p></strong>";
        echo "<script>alert('Fields cannot be empty')</script>";
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
                <h1>Register</h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                        <div class="form-group">
                            <label for="username" class="sr-only">username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username">
                        </div>
                        <div class="form-group">
                            <label for="firstname" class="sr-only">firstname</label>
                            <input type="text" name="firstname" id="firstname" class="form-control" placeholder="Enter Firstname">
                        </div>
                        <div class="form-group">
                            <label for="lastname" class="sr-only">lastname</label>
                            <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Enter Lastname">
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com">
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                        </div>
                
                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>

<hr>



<?php include "includes/footer.php";?>
