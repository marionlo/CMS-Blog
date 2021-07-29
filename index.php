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
            // Pagination - Check if the page is set
            if(isset($_GET['page'])) {
            // Take the value from the page
                $page = $_GET['page'];
            // If the page is not set we are setting it to an empty string
            } else {
                $page = "";
            }

            // Check if the page is set to an empty string or number one, it means that we are on the homepage
            if($page == "" || $page == 1) {
                $page_1 = 0;
            //  If the page is not the homepage, we calculate the variable page_1 to limit the number of posts displayed
            } else {
                $page_1 = ($page * 5) - 5;
            }

            // Find how many published posts we have
            $post_query_count = "SELECT * FROM posts WHERE post_status = 'published' ";
            $find_count = mysqli_query($connection, $post_query_count);
            $count = mysqli_num_rows($find_count);

            $count = ceil($count / 5);


            // Make a query to the DB to find all the posts with the published status
            $query = "SELECT * FROM posts WHERE post_status = 'published' ORDER BY post_date DESC LIMIT $page_1, 5 ";
            $select_all_posts_query = mysqli_query($connection, $query);
             // Fetch all the Data we need from the query
                    while($row = mysqli_fetch_assoc($select_all_posts_query)) {
                        $post_id = $row['post_id'];
                        $post_title = $row['post_title'];
                        $post_author = $row['post_author'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_content = substr($row['post_content'],0,300);
                        $post_status = $row['post_status'];

                        ?>

                

                <!-- First Blog Post -->
                
                <h2>
                    <a href="post/<?php echo $post_id; ?>"><?php echo $post_title ?></a>
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
                <a class="btn btn-primary" href="post/<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                <hr>

                    <?php } if (mysqli_num_rows($select_all_posts_query)==0) {
                            echo "<h1 class='text-center'>No Posts available</h1>";
                            // Displays a message if there is no post published yet
                        } ?>

            </div>



            <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php" ?>

        </div>
        <!-- /.row -->

        <hr>

           <!-- Pagination -->
           <ul class="pager">
            <?php 
            
            for($i=1; $i <= $count; $i++){
                // Create the pagination and add a class of active if the page is selected
                if($i == $page) {
                    echo "<li><a href='index.php?page={$i}' class='active-link'>{$i}</a></li>";}
                 else {
                    echo "<li><a href='index.php?page={$i}'>{$i}</a></li>";}
                }
              

            
            
            ?>
           </ul>
   <!-- Footer -->
     <?php include "includes/footer.php"; ?>
