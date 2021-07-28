<?php include "includes/admin_header.php" ?>
<?php 
if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    // Query to fetch the user information from the DB
    $query = "SELECT * FROM users WHERE username = '{$username}' ";
    $select_user_profile_query = mysqli_query($connection, $query); 

    while($row = mysqli_fetch_array($select_user_profile_query)) {
        $user_id = $row['user_id'];
        $username = $row['username'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
        $user_password = $row['password'];

    }
}

   // Update the data on the DB with the data from the form
if(isset($_POST['edit_user'])) {
    $user_firstname =  escape($_POST['user_firstname']);
    $user_lastname =  escape($_POST['user_lastname']);
    $username =  escape($_POST['username']);
    $user_email =  escape($_POST['user_email']);
    $user_password =  escape($_POST['user_password']);
    
    // Crypt the password
    if(!empty($user_password)) { 

        $query_password = "SELECT password FROM users WHERE user_id =  $user_id";
        $get_user_query = mysqli_query($connection, $query_password);
        confirm($get_user_query);

        $row = mysqli_fetch_array($get_user_query);

        $db_user_password = $row['password'];

    //Send the query to the DB when the user wants to change his password
      if($db_user_password != $user_password) {

    $hashed_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));
    //Pass the variables from the form into the query
    $query = "UPDATE users SET user_firstname='{$user_firstname}', user_lastname='{$user_lastname}', ";
    $query .="username='{$username}', user_email='{$user_email}', password='{$hashed_password}' WHERE user_id = {$user_id} ";
    //Send the query to the DB
    $update_user_query = mysqli_query($connection, $query);

    confirm($update_user_query);



    //Send the query to the DB when the user doesnt want to change his password
      } else if($db_user_password = $user_password) {
    $query = "UPDATE users SET user_firstname='{$user_firstname}', user_lastname='{$user_lastname}', ";
    $query .="username='{$username}', user_email='{$user_email}' WHERE user_id = {$user_id} ";
    //Send the query to the DB
    $update_user_query = mysqli_query($connection, $query);

    confirm($update_user_query);


        }  
      } 
    }
  

?>

<div id="wrapper">

        <!-- Navigation -->
    <?php include "includes/admin_navigation.php" ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                                Welcome to admin
                                <small><?php echo get_username(); ?></small>
                        </h1>
                            <form action="" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="user_firtname">First name</label>
                                <input type="text" class="form-control" name="user_firstname" value="<?php echo htmlspecialchars(stripslashes($user_firstname));?>" />
                            </div>
                            
                            <div class="form-group">
                                <label for="user_lastname">Last name</label>
                                <input type="text" class="form-control" name="user_lastname" value="<?php echo htmlspecialchars(stripslashes($user_lastname));?>"/>
                            </div>
                            
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" name="username" value="<?php echo htmlspecialchars(stripslashes($username));?>" />
                            </div>
                            
                            <div class="form-group">
                                <label for="user_email">Email</label>
                                <input type="email" class="form-control" name="user_email" value="<?php echo htmlspecialchars(stripslashes($user_email));?>"/>
                                </div>

                                <div class="form-group">
                                    <label for="user_password">Password</label>
                                    <input type="password" class="form-control" name="user_password" value="<?php echo $user_password;?>" />
                                </div>
                            
                                <div class="form-group">
                                <input class="btn btn-primary" type="submit" name="edit_user" value="Update Profile">
                                </div>
                             </form>
                    </div>
                    </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    <?php include "includes/admin_footer.php" ?>
