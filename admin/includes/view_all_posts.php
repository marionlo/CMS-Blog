<?php 

include ("delete_modal.php");

// Prevent the subscribers to access the view all posts page
if (!is_admin( $_SESSION ['username'])){     
    header ("location: index.php"); 
}

if(isset($_POST['checkBoxArray'])) {
    foreach($_POST['checkBoxArray'] as $postValueId){
        
    $bulk_options = $_POST['bulk_options'];

    switch($bulk_options) {
        case 'published':
            $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id= {$postValueId}";
            $update_to_published_status = mysqli_query($connection, $query);
            confirm($update_to_published_status);
            break;

            case 'draft':
                $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId} ";
                $update_to_draft_status = mysqli_query($connection, $query);
                confirm($update_to_draft_status);
                break;

            case 'delete':
                $query = "DELETE FROM posts WHERE post_id = {$postValueId} ";
                $delete_posts = mysqli_query($connection, $query);
                confirm($delete_posts);
                break;

            case 'clone':
                // Select the posts selected from the DB
                $query = "SELECT * FROM posts WHERE post_id = {$postValueId} ";
                $select_post_query = mysqli_query($connection, $query);
                   
                while($row = mysqli_fetch_assoc($select_post_query)) {
                $post_id = $row['post_id'];
                $post_author = $row['post_author'];
                $post_title = $row['post_title'];
                $post_category_id = $row['post_category_id'];
                $post_content = $row['post_content'];
                $post_status = $row['post_status'];
                $post_image = $row['post_image'];
                $post_tags = $row['post_tags'];
                $post_comments = $row['post_comment_count'];
                $post_date = $row['post_date'];
                
}               // Clone the posts into the DB
                $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_status) ";
                $query .="VALUES({$post_category_id},'{$post_title}','{$post_author}', now(), '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_status}' ) ";
                $clone_posts = mysqli_query($connection, $query);
                confirm($clone_posts);
                break;

        }
    }
}

?>

<form action="" method="post">
<table class="table table-bordered table-hover">
    <div id="bulk-options-container" class="col-xs-4">
        <select class="form-control" name="bulk_options" id="">
            <option value="">Select Options</option>
            <option value="published">Publish</option>
            <option value="draft">Draft</option>
            <option value="delete">Delete</option>
            <option value="clone">Duplicate</option>
        </select>
    </div>
    <div class="col-xs-4">
        <input type="submit" name="submit" class="btn btn-success" value="Apply">
        <a class="btn btn-primary" href="posts.php?source=add_post">Add New</a>
    </div>
                            <thead>
                                <tr>
                                    <th><input id="selectAllBoxes" type="checkbox">Select All</th>
                                    <th>Id</th>
                                    <th>Author</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Image</th>
                                    <th>Tags</th>
                                    <th>Comments</th>
                                    <th>Date</th>
                                    <th>Number of Views</th>
                                    <th>View Post</th>   
                                    <th>Edit</th>
                                    <th>Delete</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                // Display the posts on the table - latest created first
                                $query = "SELECT * FROM posts ORDER BY post_id DESC";
                                $select_posts = mysqli_query($connection, $query);     
                                while($row = mysqli_fetch_assoc($select_posts )) {
                                $post_id = $row['post_id'];
                                $post_author = $row['post_author'];
                                $post_title = $row['post_title'];
                                $post_category_id = $row['post_category_id'];
                                $post_status = $row['post_status'];
                                $post_image = $row['post_image'];
                                $post_tags = $row['post_tags'];
                                $post_comments = $row['post_comment_count'];
                                $post_date = $row['post_date'];
                                $post_views_count = $row['post_views_count'];
                                echo "<tr>";
                                ?>

                                
                                <td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $post_id; ?>'></td>

                                <?php
                                echo "<td>{$post_id}</td>";   
                                echo "<td>{$post_author}</td>";
                                echo "<td>{$post_title}</td>";

                                $query = "SELECT * FROM categories WHERE cat_id = $post_category_id ";
                                        $select_categories_id = mysqli_query($connection, $query);     
                                         while($row = mysqli_fetch_assoc($select_categories_id )) {
                                         $cat_title = $row['cat_title'];
                                         $cat_id = $row['cat_id'];

                                echo "<td>{$cat_title}</td>";
                                         }



                                echo "<td>{$post_status}</td>";
                                echo "<td><img src='../images/$post_image'  width='100' alt='{$post_title}'/></td>";
                                echo "<td>{$post_tags}</td>";

                                // Display the number of comments and fetch the comments from each posts
                                $query = "SELECT * FROM comments WHERE comment_post_id = $post_id ";
                                $send_comment_query = mysqli_query($connection, $query);
                                
                                $row = mysqli_fetch_array($send_comment_query);
                                $comment_id = $row['comment_id'];
                                $count_comments = mysqli_num_rows($send_comment_query);

                                echo "<td><a href='post_comments.php?id=$post_id'>{$count_comments}</a></td>";
                                echo "<td>{$post_date}</td>";
                                echo "<td>{$post_views_count}</td>";
                                echo "<td><a href='../post.php?p_id={$post_id}'>View Post</a></td>"; 
                                echo "<td><a href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>"; 
                                echo "<td><a rel='$post_id' href='#' class='delete-link'>Delete</a></td>";   
                                echo "</tr>";
                            } ?>

                            <?php 
                            
                            if(isset($_GET['delete'])) {
                                 // Prevent people from deleting when they are not logged in
                                    if(isset($_SESSION['user_role'])) {
                                    if($_SESSION['user_role'] == 'admin') {
                                $the_post_id = mysqli_real_escape_string($connection, $_GET['delete']);
                                $query = "DELETE FROM posts WHERE post_id = {$the_post_id} ";
                                $delete_query = mysqli_query($connection, $query);
                                header("Location: posts.php"); //This will refresh the page
                            }
                        }
                    }
                            
                            
                            ?>
                          
                            </tbody>
</table>
                        </form>


                        <script>
                            $(document).ready(function() {
                                $(".delete-link").on('click', function(){
                                   var id = $(this).attr("rel");;
                                   var delete_url = "posts.php?delete="+ id+" ";
                                    $(".modal_delete_link").attr("href", delete_url);
                                    $("#myModal").modal('show');
                                })
                            });


                        </script>