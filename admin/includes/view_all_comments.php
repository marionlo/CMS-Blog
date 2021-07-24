<?php // Prevent the subscribers to access the view all comments page
if (!is_admin( $_SESSION ['username'])){     
    header ("location: index.php"); 
}

?>

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
                                    // Add the post title for each comment
                                $query = "SELECT * FROM posts WHERE post_id = $comment_post_id ";
                                         $select_post_id = mysqli_query($connection, $query);     
                                          while($row = mysqli_fetch_assoc($select_post_id)) {
                                          $post_title = $row['post_title'];
                                          $post_id = $row['post_id'];
                                 echo "<td><a href='../post.php?p_id={$post_id}'>{$post_title}</a></td>";
                                          }
                                echo "<td>{$comment_date}</td>";
                                echo "<td><a href='comments.php?approve={$comment_id}'>Approve</a></td>"; 
                                echo "<td><a href='comments.php?unapprove={$comment_id}'>Unapprove</a></td>";  
                                echo "<td><a href='comments.php?delete={$comment_id}'>Delete</a></td>";  
                                echo "</tr>";
                            } ?>

                            <?php 
                            
                            // DELETE COMMENT
                            if(isset($_GET['delete'])) {
                                 // Prevent people from deleting when they are not logged in
                                    if(isset($_SESSION['user_role'])) {
                                    if($_SESSION['user_role'] == 'admin') {
                                $the_comment_id = $_GET['delete'];
                                $query = "DELETE FROM comments WHERE comment_id = {$the_comment_id} ";
                                $delete_query = mysqli_query($connection, $query);
                                header("Location: comments.php"); //This will refresh the page
                            }
                        }
                    }

                            //APPROVE COMMENT
                            if(isset($_GET['approve'])) {
                                 // Prevent people from approving when they are not logged in
                                    if(isset($_SESSION['user_role'])) {
                                    if($_SESSION['user_role'] == 'admin') {
                                $the_comment_id = $_GET['approve'];
                                $query = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = {$the_comment_id} ";
                                $unapprove_query = mysqli_query($connection, $query);
                                header("Location: comments.php"); //This will refresh the page
                            }
                        }
                    }

                            // UNAPPROVE COMMENT
                            if(isset($_GET['unapprove'])) {
                                 // Prevent people from unapproving when they are not logged in
                                    if(isset($_SESSION['user_role'])) {
                                    if($_SESSION['user_role'] == 'admin') {
                                $the_comment_id = $_GET['unapprove'];
                                $query = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = {$the_comment_id} ";
                                $unapprove_query = mysqli_query($connection, $query);
                                header("Location: comments.php"); //This will refresh the page
                            }
                        }
                    }
                            
                            
                            ?>
                          
                            </tbody>
</table>