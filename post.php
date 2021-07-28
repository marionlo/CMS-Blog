<?php include "includes/db.php";?>
<?php include "includes/header.php";?>
    <!-- Navigation -->
    <?php include "includes/navigation.php"; ?>

    <?php 
    // LIKE THE POST
    if(isset($_POST['liked'])) {
        
        // Select the post
        $post_id = $_POST['post_id'];
        $user_id = $_POST['user_id'];
        $query = "SELECT * FROM posts WHERE post_id = $post_id";
        $searchPostQuery = mysqli_query($connection, $query);
        $row = mysqli_fetch_array($searchPostQuery);
        $likes = $row['likes'];

        if(mysqli_num_rows( $searchPostQuery) >= 1) {
            echo $_POST['post_id'];
        }
        // Update post table with likes
        mysqli_query($connection, "UPDATE posts SET likes = $likes +1 WHERE post_id = $post_id");

        // Update Likes table with user_id and post_id
        mysqli_query($connection, "INSERT INTO likes(user_id, post_id) VALUES($user_id, $post_id)");
        exit();

    }

     // UNLIKE THE POST
     if(isset($_POST['unliked'])) {
        
        // Select the post
        $post_id = $_POST['post_id'];
        $user_id = $_POST['user_id'];
        $query = "SELECT * FROM posts WHERE post_id = $post_id";
        $searchPostQuery = mysqli_query($connection, $query);
        $row = mysqli_fetch_array($searchPostQuery);
        $likes = $row['likes'];

        if(mysqli_num_rows( $searchPostQuery) >= 1) {
            echo $_POST['post_id'];
        }
        // Update Likes table with user_id and post_id
        mysqli_query($connection, "DELETE FROM likes WHERE post_id = $post_id AND user_id=$user_id");

        // Update post table with likes
        mysqli_query($connection, "UPDATE posts SET likes = $likes -1 WHERE post_id = $post_id");
        exit();

    }
    
    
    ?>




    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
            <h1 class="page-header">
                    Welcome to
                    <small>Dkz's blog</small>
            </h1>

            <?php 

                        // Catch the id of the post
            if(isset($_GET['p_id'])) {
            $the_post_id = $_GET['p_id'];
            
            // Update the post views count everytime a visitor visits the page
            $view_query = "UPDATE posts SET post_views_count = post_views_count+1 WHERE post_id =  $the_post_id ";
            $send_query = mysqli_query($connection, $view_query);

            if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') {
                 // Make the query to the DB to fetch the required post
            $query = "SELECT * FROM posts WHERE post_id = $the_post_id ";

            } else {
                 // For not admin people just show the published posts
            $query = "SELECT * FROM posts WHERE post_id = $the_post_id AND post_status = 'published' ";
            }
            
            $select_all_posts_query = mysqli_query($connection, $query);

            if (mysqli_num_rows($select_all_posts_query)==0) {
                echo "<h1 class='text-center'>No Post available</h1>";
                // Displays a message if there is no post published yet
            } else {

                    while($row = mysqli_fetch_assoc($select_all_posts_query)) {
                        $post_title = $row['post_title'];
                        $post_author = $row['post_author'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_content = $row['post_content'];

                        ?>


                <!-- First Blog Post -->
                <h2>
                <a href="post.php?p_id=<?php echo $the_post_id; ?>"><?php echo $post_title ?></a>
                </h2>
                <p class="lead">
                    by <a href="author_posts.php?author=<?php echo $post_author ?>&p_id=<?php echo $the_post_id ?>"><?php echo $post_author ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date ?></p>
                <hr>
                <img class="img-responsive" src="images/<?php echo $post_image ?>" alt="">
                <hr>
                <p><?php echo $post_content ?></p>
                <div class="row">
                <p class="pull-right"><a class="<?php echo userLikePost($the_post_id) ? 'unlike' : 'like'; ?>" href="post/<?php echo $the_post_id ?>"><span class="glyphicon <?php echo userLikePost($the_post_id) ? 'glyphicon-thumbs-down' : 'glyphicon-thumbs-up'; ?> "></span><?php echo userLikePost($the_post_id) ? ' Unlike' : ' Like'; ?></a></p>
                </div>
                
                <div class="row">
                   <p class="pull-right">Likes : <?php fetchLikes($the_post_id) ?></p> 
                </div>
 
                <div class="clearfix">
                    
                </div>
                   
                <hr>


                    <?php }  
                    
                    
                    ?>

                                    <!-- Blog Comments -->
                    <?php 
                    // Send the data of the comment form to the DB
                    if(isset($_POST['create_comment'])) {
                        $the_post_id = $_GET['p_id'];
                        $comment_author =  escape($_POST['comment_author']);
                        $comment_email =  escape($_POST['comment_email']); 
                        $comment_content =  escape($_POST['comment_content']);  
 
                        if(!empty($comment_author) && !empty($comment_email) && !empty($comment_content)) {

                            $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) ";
                            $query .="VALUES ($the_post_id, '$comment_author', '$comment_email', '$comment_content', 'unapproved', now()) ";
    
                            $create_comment_query = mysqli_query($connection, $query);
                            if(!$create_comment_query) {
                                die("QUERY FAILED" . mysqli_error($connection));
                            }
                            
                        } else {
                            echo "<div class='alert-danger form-control'>Fields cannot be empty</div>";
                        }
                        
                       
                    }

                    ?>

                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form action="" method="post" role="form">
                        <div class="form-group">
                            <label for="author">Author</label>
                            <input type="text" name="comment_author" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="comment_email" class="form-control">
                        </div>
                        <div class="form-group">
                          <label for="comment">Your comment</label>
                            <textarea class="form-control" rows="3" name="comment_content"></textarea>
                        </div>
                        <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
                    </form>
                </div>

                <hr>

                                    <!-- Posted Comments -->

                <!-- Comment -->
                <?php 
                
                $query = "SELECT * FROM comments WHERE comment_post_id = {$the_post_id} ";
                $query .= "AND comment_status = 'approved' ";
                $query .= "ORDER BY comment_id DESC ";
                $select_comment_query = mysqli_query($connection, $query);
                if(!$select_comment_query) {
                    die('QUERY FAILED' . mysqli_error($connection));
                }
                while ($row = mysqli_fetch_array($select_comment_query)) {
                    $comment_date = $row['comment_date'];
                    $comment_author = $row['comment_author'];
                    $comment_content = $row['comment_content'];

                    ?>

                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading"><?php echo $comment_author; ?>
                            <small><?php echo $comment_date; ?></small>
                        </h4>
                        <?php echo $comment_content; ?>
                    </div>
                </div>




                <?php } } } else {
                        // Redirect the user if he's going to this page without post id
                        header("Location: index.php"); }
                    
                     ?>
                
                
                
            </div>



            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php" ?>

        </div>
        <!-- /.row -->

        <hr>
   <!-- Footer -->
   <?php include "includes/footer.php"; ?>

   <script>
     // JQUERY is used header with AJAX for the "LIKE button"
  var post_id = <?php echo $the_post_id; ?>;
  var user_id = 0;

  
 // Like the post
  $('.like').click(function(e) {

    
    $.ajax({
      url: "post.php?p_id=" + post_id,
      type: 'POST',
      data: {
        liked: 1,
        post_id: post_id,
        user_id: user_id
      }, 
    });
    
  });

  // Unlike the post
   // Like the post
   $('.unlike').click(function(e) {
    
    $.ajax({
      url: "post.php?p_id=" + post_id,
      type: 'POST',
      data: {
        unliked: 1,
        post_id: post_id,
        user_id: user_id
      }, 
    });
    
  });

   </script>
