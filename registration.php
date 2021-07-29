<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>


 <?php 
 
 if($_SERVER['REQUEST_METHOD'] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $error = [
        'username' => '',
        'email' => '',
        'password' => ''
    ];

    if(strlen($username) < 4) {
        $error['username'] = '<div class="form-control alert-danger">Username needs to be longer.</div>';
    }

    if($username=='') {
        $error['username'] = '<div class="form-control alert-danger">Username cannot be empty.</div>';
    }

    if(username_exists($username)) {
        $error['username'] = '<div class="form-control alert-danger">Username already exists.</div>';
    }

    if($email=='') {
        $error['email'] = '<div class="form-control alert-danger">The email cannot be empty.</div>';
    }

    if(email_exists($email)) {
        $error['email'] = '<div class="form-control alert-danger">The email already exists, <a href="index.php">please login</a></div>';
    }

    if($password=='') {
        $error['password'] = '<div class="form-control alert-danger">The password cannot be empty.</div>';
    }

     // Loop through the array of errors and make sure that they are empty
    foreach($error as $key => $value) {
    if(empty($value)) {
        unset($error[$key]);
    }
}

 // When there is no error, register the user
    if(empty($error)) {
        register_user($username, $email, $password);
        login_user($username, $password);
    }
    
 } 
 
 ?>

    <!-- Navigation -->
    
    <?php  include "includes/navigation.php"; ?>
    
 
    <!-- Page Content -->
    <div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Register</h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="on">
                        <div class="form-group">
                            <label for="username" class="sr-only">username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username" autocomplete="on"
                            value="<?php echo isset($username) ? $username : '' ?>"> 
                            <div><?php echo isset($error['username']) ? $error['username'] : '' ?></div>
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com" autocomplete="on"
                            value="<?php echo isset($email) ? $email : '' ?>">
                            <div><?php echo isset($error['email']) ? $error['email'] : '' ?></div>
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                            <div><?php echo isset($error['password']) ? $error['password'] : '' ?></div>
                        </div>
                
                        <input type="submit" name="register" id="btn-login" class="btn btn-primary btn-lg btn-block" value="Register">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php";?>
