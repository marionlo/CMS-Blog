<?php include "includes/admin_header.php" ?>

<?php // Prevent the subscribers to access the view all comments page
if (!is_admin( $_SESSION ['username'])){     
    header ("location: index.php"); 
} ?>

<div id="wrapper">

        <!-- Navigation -->
    <?php include "includes/admin_navigation.php" ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                                View all the comments for this post
                                <small><?php echo get_username(); ?></small>
                        </h1>


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
                            <?php 
                                $query = "SELECT * FROM comments WHERE comment_post_id = " . mysqli_real_escape_string($connection, $_GET['id']) . " ";
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
                                echo "<td><a href='post_comments.php?delete={$comment_id}&id=". $_GET['id'] ."'>Delete</a></td>";  
                                echo "</tr>";
                            } ?>

                            <?php 
                            
                            // DELETE COMMENT
                            deleteComment();

                            //APPROVE COMMENT
                            approveComment();

                            // UNAPPROVE COMMENT
                            unapproveComment();
                            
                            
                            ?>
                          
                            </tbody>
</table>

</div>
                    </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    <?php include "includes/admin_footer.php" ?>