<table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Username</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Approve</th>
                                    <th>Unapprove</th>
                                    <th>Delete</th>
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
                                echo "<td><a href='users.php?approve={$user_id}'>Approve</a></td>"; 
                                echo "<td><a href='users.php?unapprove={$user_id}'>Unapprove</a></td>";  
                                echo "<td><a href='users.php?delete={$user_id}'>Delete</a></td>";  
                                echo "</tr>";
                            } ?>

                            <?php 
                            
                            // DELETE USER
                            if(isset($_GET['delete'])) {
                                $the_user_id = $_GET['delete'];
                                $query = "DELETE FROM users WHERE user_id = {$the_user_id} ";
                                $delete_query = mysqli_query($connection, $query);
                                header("Location: users.php"); //This will refresh the page
                            }

                            // //APPROVE COMMENT
                            // if(isset($_GET['approve'])) {
                            //     $the_comment_id = $_GET['approve'];
                            //     $query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = {$the_comment_id} ";
                            //     $unapprove_query = mysqli_query($connection, $query);
                            //     header("Location: comments.php"); //This will refresh the page
                            // }

                            // // UNAPPROVE COMMENT
                            // if(isset($_GET['unapprove'])) {
                            //     $the_comment_id = $_GET['unapprove'];
                            //     $query = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = {$the_comment_id} ";
                            //     $unapprove_query = mysqli_query($connection, $query);
                            //     header("Location: comments.php"); //This will refresh the page
                            // }
                            
                            
                            ?>
                          
                            </tbody>
</table>