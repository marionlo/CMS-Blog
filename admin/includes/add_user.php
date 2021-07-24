<?php 

if(isset($_POST['create_user'])) {
    $user_firstname = escape($_POST['user_firstname']);
    $user_lastname = escape($_POST['user_lastname']);
    $user_role = escape($_POST['user_role']); 
    $username = escape($_POST['username']);
    $user_email = escape($_POST['user_email']);
    $user_password = escape($_POST['user_password']);

    // Crypt the password
    $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 10) );

    //Pass the variables from the form into the query
    $query = "INSERT INTO users(user_firstname, user_lastname, user_role, username, user_email, password ) ";
    $query .="VALUES('{$user_firstname}','{$user_lastname}','{$user_role}', '{$username}', '{$user_email}', '{$user_password}' ) ";
    //Send the query
    $create_user_query = mysqli_query($connection, $query);

    confirm($create_user_query);

    echo "User created: " . " " . "<a href='users.php'>View Users</a>";
}


?>


<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="user_firtname">First name</label>
        <input type="text" class="form-control" name="user_firstname" />
      </div>
     
      <div class="form-group">
        <label for="user_lastname">Last name</label>
        <input type="text" class="form-control" name="user_lastname" />
      </div>
     
      <div class="form-group">
      <select name="user_role" id="user_role">
      <option value="subscriber">Select Options</option>
            <option value="admin">Admin</option>
            <option value="subscriber">Subscriber</option>
        </select>
      </div>  
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" name="username" />
      </div>
     
      <div class="form-group">
        <label for="user_email">Email</label>
        <input type="email" class="form-control" name="user_email" />
        </div>

        <div class="form-group">
            <label for="user_password">Password</label>
            <input type="password" class="form-control" name="user_password" />
        </div>
     
        <div class="form-group">
          <input class="btn btn-primary" type="submit" name="create_user" value="Create User">
        </div>
</form>