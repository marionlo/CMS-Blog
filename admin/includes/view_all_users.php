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
                            <?php $query = "SELECT * FROM users";
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
                               
                                echo "<td><a href='users.php?change_to_admin={$user_id}'>Promote to Admin</a></td>";  
                                echo "<td><a href='users.php?change_to_sub={$user_id}'>Promote to Subscriber</a></td>"; 
                                echo "<td><a href='users.php?source=edit_user&edit_user={$user_id}'>Edit</a></td>"; 
                                echo "<td><a href='users.php?delete={$user_id}'>Delete</a></td>";  
                                echo "</tr>";
                            } ?>

                            <?php 
                            
                            // DELETE USER
                            if(isset($_GET['delete'])) {
                                // Prevent people from deleting when they are not logged in
                                if(isset($_SESSION['user_role'])) {
                                if($_SESSION['user_role'] == 'admin') {
                                        $the_user_id = mysqli_real_escape_string($connection, $_GET['delete']);
                                        $query = "DELETE FROM users WHERE user_id = {$the_user_id} ";
                                        $delete_query = mysqli_query($connection, $query);
                                        header("Location: users.php"); //This will refresh the page
                                    }
                               
                                }
                                
                            }

                            //PROMOTE USER TO ADMIN
                           
                            if(isset($_GET['change_to_admin'])) {
                                // Prevent people from promoting when they are not logged in
                                if(isset($_SESSION['user_role'])) {
                                if($_SESSION['user_role'] == 'admin') {
                                        $the_user_id = $_GET['change_to_admin'];
                                        $query = "UPDATE users SET user_role = 'admin' WHERE user_id = {$the_user_id} ";
                                        $change_to_admin_query = mysqli_query($connection, $query);
                                        header("Location: users.php"); //This will refresh the page
                                    }
                                }         
                            }

                            // PROMOTE USER TO SUBSCRIBER
                              
                            if(isset($_GET['change_to_sub'])) {
                                // Prevent people from promoting when they are not logged in
                                if(isset($_SESSION['user_role'])) {
                                if($_SESSION['user_role'] == 'admin') {
                                $the_user_id = $_GET['change_to_sub'];
                                $query = "UPDATE users SET user_role = 'subscriber' WHERE user_id = {$the_user_id} ";
                                $change_to_subscriber_query = mysqli_query($connection, $query);
                                header("Location: users.php"); //This will refresh the page
                            }
                        }
                    }
                            
                            
                            ?>
                          
                            </tbody>
</table>