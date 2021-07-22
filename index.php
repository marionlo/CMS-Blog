<?php include "includes/db.php";?>
<?php include "includes/header.php";?>


    <!-- Navigation -->
    <?php include "includes/navigation.php"; ?>

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

            // Find how many published posts we have
            $post_query_count = "SELECT * FROM posts WHERE post_status = 'published' ";
            $find_count = mysqli_query($connection, $query);
            $count = mysqli_num_rows($find_count);


            // Make a query to the DB to find all the posts with the published status
            $query = "SELECT * FROM posts WHERE post_status = 'published' LIMIT 5";
            $select_all_posts_query = mysqli_query($connection, $query);
             // Fetch all the Data we need from the query
                    while($row = mysqli_fetch_assoc($select_all_posts_query)) {
                        $post_id = $row['post_id'];
                        $post_title = $row['post_title'];
                        $post_author = $row['post_author'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_content = substr($row['post_content'],0,150);
                        $post_status = $row['post_status'];

                        ?>

                

                <!-- First Blog Post -->
                <h2>
                    <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title ?></a>
                </h2>
                <p class="lead">
                    by <a href="author_posts.php?author=<?php echo $post_author ?>&p_id=<?php echo $post_id ?>"><?php echo $post_author ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date ?></p>
                <hr>
                <a href="post.php?p_id=<?php echo $post_id; ?>">
                <img class="img-responsive" src="images/<?php echo $post_image ?>" alt="">
                    </a>
                <hr>
                <p><?php echo $post_content ?>...</p>
                <a class="btn btn-primary" href="post.php?p_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>

                    <?php } if (mysqli_num_rows($select_all_posts_query)==0) {
                            echo "<h1 class='text-center'>There is no post published yet</h1>";
                            // Displays a message if there is no post published yet
                        } ?>

            </div>



            <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php" ?>

        </div>
        <!-- /.row -->

        <hr>
   <!-- Footer -->
     <?php include "includes/footer.php"; ?>
