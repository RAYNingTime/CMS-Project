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

        $username = escape($username);
        $email = escape($email);
        $password = escape($password);
        $firstname = escape($firstname);
        $lastname = escape($lastname);

        $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));

        // OLD CRYPT
        // $query = "SELECT user_randSalt FROM users";
        // $select_randsalt_query = mysqli_query($connect, $query);
        // if(!$select_randsalt_query) {
        //     die("QUERY FAILED " . mysqli_error($connect));
        // }

        // $row = mysqli_fetch_assoc($select_randsalt_query);
        // $randSalt = $row['user_randSalt'];
        // $password = crypt($password, $randSalt);

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
                <h1>Contact</h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">

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
