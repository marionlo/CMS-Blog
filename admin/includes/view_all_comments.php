<table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Author</th>
                                    <th>Comment</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>In response to</th>
                                    <th>Date</th>
                                    <th>Approve</th>
                                    <th>Unapprove</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $query = "SELECT * FROM comments";
                                $select_comments = mysqli_query($connection, $query);     
                                while($row = mysqli_fetch_assoc($select_comments)) {
                                $comment_id = $row['comment_id'];
                                $comment_author = $row['comment_author'];
                                $comment_post_id = $row['comment_post_id'];
                                $comment_email = $row['comment_email'];
                                $comment_date = $row['comment_date'];
                                $comment_content = $row['comment_content'];
                                $comment_status = $row['comment_status'];
                                echo "<tr>";
                                echo "<td>{$comment_id}</td>";   
                                echo "<td>{$comment_author}</td>";
                                echo "<td>{$comment_content}</td>";
                                echo "<td>{$comment_email}</td>";
                                echo "<td>{$comment_status}</td>";

                                $query = "SELECT * FROM posts WHERE post_id = $comment_post_id ";
                                         $select_post_id = mysqli_query($connection, $query);     
                                          while($row = mysqli_fetch_assoc($select_post_id)) {
                                          $post_title = $row['post_title'];
                                          $post_id = $row['post_id'];
                                 echo "<td><a href='../post.php?p_id={$post_id}'>{$post_title}</a></td>";
                                          }
                                echo "<td>{$comment_date}</td>";
                                echo "<td><a href='posts.php?source=edit_post&p_id={}'>Approve</a></td>"; 
                                echo "<td><a href='posts.php?unapprove={}'>Unapprove</a></td>";  
                                echo "<td><a href='posts.php?delete={}'>Delete</a></td>";  
                                echo "</tr>";
                            } ?>

                            <?php 
                            
                            if(isset($_GET['delete'])) {
                                $the_post_id = $_GET['delete'];
                                $query = "DELETE FROM posts WHERE post_id = {$the_post_id} ";
                                $delete_query = mysqli_query($connection, $query);
                                header("Location: posts.php"); //This will refresh the page
                            }
                            
                            
                            ?>
                          
                            </tbody>
</table>