<?php 

if(isset($_GET['edit_user'])) {
  $the_user_id = escape($_GET['edit_user']);



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
  $user_firstname = escape($_POST['user_firstname']);
  $user_lastname = escape($_POST['user_lastname']);
  $user_role = escape($_POST['user_role']); 
  $username = escape($_POST['username']);
  $user_email = escape($_POST['user_email']);
  $user_password = escape($_POST['user_password']);
    
  // Crypt the password
  if(!empty($user_password)) { 

  $query_password = "SELECT password FROM users WHERE user_id =  $the_user_id";
  $get_user_query = mysqli_query($connection, $query_password);
  confirm($get_user_query);

  $row = mysqli_fetch_array($get_user_query);

  $db_user_password = $row['password'];

  //Send the query to the DB when the user wants to change his password
  if($db_user_password != $user_password) {

  $hashed_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));
  //Pass the variables from the form into the query
  $query = "UPDATE users SET user_firstname='{$user_firstname}', user_lastname='{$user_lastname}', user_role='{$user_role}', ";
  $query .="username='{$username}', user_email='{$user_email}', password='{$hashed_password}' WHERE user_id = {$the_user_id} ";
  //Send the query to the DB
  $update_user_query = mysqli_query($connection, $query);

  confirm($update_user_query);
  echo "<p class='bg-success'>User updated. <a href='users.php'>View Users?</a> </p>";


  //Send the query to the DB when the user doesnt want to change his password
  } else if($db_user_password = $user_password) {
  $query = "UPDATE users SET user_firstname='{$user_firstname}', user_lastname='{$user_lastname}', user_role='{$user_role}', ";
  $query .="username='{$username}', user_email='{$user_email}' WHERE user_id = {$the_user_id} ";
  //Send the query to the DB
  $update_user_query = mysqli_query($connection, $query);

  confirm($update_user_query);
  echo "<p class='bg-success'>User updated. <a href='users.php'>View Users?</a> </p>";

        }  
      } 
    }
  } else {
    header("Location: index .php");
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
      <option value="<?php echo $user_role;?>"><?php echo $user_role;?></option>
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