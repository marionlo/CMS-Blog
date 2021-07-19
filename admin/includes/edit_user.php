<?php 

if(isset($_GET['edit_user'])) {
  $the_user_id = $_GET['edit_user'];
}


 // Query the data from the DB and display it to the edit user form
$query = "SELECT * FROM users where user_id = $the_user_id ";
$select_users_query = mysqli_query($connection, $query);     
while($row = mysqli_fetch_assoc($select_users_query)) {
$user_id = $row['user_id'];
$username = $row['username'];
$user_firstname = $row['user_firstname'];
$user_lastname = $row['user_lastname'];
$user_email = $row['user_email'];
$user_role = $row['user_role'];
$user_password = $row['password'];
} 


 // Update the data on the DB with the data from the form
if(isset($_POST['edit_user'])) {
    $user_firstname = $_POST['user_firstname'];
    $user_lastname = $_POST['user_lastname'];
    $user_role = $_POST['user_role']; 
    $username = $_POST['username'];
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];

    //Pass the variables from the form into the query
    $query = "UPDATE users SET user_firstname='{$user_firstname}', user_lastname='{$user_lastname}', user_role='{$user_role}', ";
    $query .="username='{$username}', user_email='{$user_email}', password='{$user_password}' WHERE user_id = {$the_user_id} ";
    //Send the query to the DB
    $update_user_query = mysqli_query($connection, $query);

    confirm($update_user_query);

      }


?>


<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="user_firtname">First name</label>
        <input type="text" class="form-control" name="user_firstname" value="<?php echo $user_firstname;?>" />
      </div>
     
      <div class="form-group">
        <label for="user_lastname">Last name</label>
        <input type="text" class="form-control" name="user_lastname" value="<?php echo $user_lastname;?>"/>
      </div>
     
      <div class="form-group">
      <select name="user_role" id="user_role">
      <option value="subscriber"><?php echo $user_role;?></option>
        <?php 
        if ($user_role == 'admin') {
          echo '<option value="subscriber">subscriber</option>';
        } else {
          echo '<option value="admin">admin</option>';   
        }
           ?> 
        
        </select>
      </div>
   
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" name="username" value="<?php echo $username;?>" />
      </div>
     
      <div class="form-group">
        <label for="user_email">Email</label>
        <input type="email" class="form-control" name="user_email" value="<?php echo $user_email;?>"/>
        </div>

        <div class="form-group">
            <label for="user_password">Password</label>
            <input type="password" class="form-control" name="user_password" value="<?php echo $user_password;?>" />
        </div>
     
        <div class="form-group">
          <input class="btn btn-primary" type="submit" name="edit_user" value="Edit User">
        </div>
</form>