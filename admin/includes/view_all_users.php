<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Id</th>
            <th>Username</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Promote to Admin</th>
            <th>Promote to Subscriber</th>
            <th>Edit User</th>
            <th>Delete User</th>
        </tr>
    </thead>
    <tbody>
    <?php 
         // Display all the users
        $query = "SELECT * FROM users";
        $select_users = mysqli_query($connection, $query);     
        while($row = mysqli_fetch_assoc($select_users)) {
        $user_id = $row['user_id'];
        $username = $row['username'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
        $user_role = $row['user_role'];
        echo "<tr>";
        echo "<td>{$user_id}</td>";   
        echo "<td>{$username}</td>";
        echo "<td>{$user_firstname}</td>";
        echo "<td>{$user_lastname}</td>";
        echo "<td>{$user_email}</td>";
        echo "<td>{$user_role}</td>";
        echo "<td><a href='users.php?change_to_admin={$user_id}' class='btn btn-success'>Promote to Admin</a></td>";  
        echo "<td><a href='users.php?change_to_sub={$user_id}' class='btn btn-warning'>Promote to Subscriber</a></td>"; 
        echo "<td><a href='users.php?source=edit_user&edit_user={$user_id}' class='btn btn-info'>Edit</a></td>"; 
        echo "<td><a href='users.php?delete={$user_id}' class='btn btn-danger'>Delete</a></td>";  
        echo "</tr>";
    } ?>

    <?php 
    
    // DELETE USER
    deleteUser();

    //PROMOTE USER TO ADMIN
    promoteToAdmin();

    // PROMOTE USER TO SUBSCRIBER
    promoteToSub();
    
    
    ?>
    
    </tbody>
</table>