<?php 
$post_author = $_SESSION['username'];
if(isset($_POST['create_post'])) {
    $post_author = escape($_POST['post_author']);
    $post_title = escape($_POST['post_title']);
    $post_category_id = escape($_POST['post_category']);
    $post_status = escape($_POST['post_status']); 

    $post_image = $_FILES['image']['name'];
    $post_image_temp = $_FILES['image']['tmp_name'];

    $post_tags = escape($_POST['post_tags']);
    $post_content = escape($_POST['post_content']);
    // $post_comments = 4;
    $post_date = escape(date('d-m-y'));

    move_uploaded_file($post_image_temp, "../images/$post_image"); //Move the temporary file to the images folder


    //Pass the variables from the form into the query
    $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_status) ";
    $query .="VALUES({$post_category_id},'{$post_title}','{$post_author}', now(), '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_status}' ) ";
    //Send the query
    $create_post_query = mysqli_query($connection, $query);

    confirm($create_post_query);

    //Pull the latest created id in this table
    $the_post_id = mysqli_insert_id($connection);

    echo "<p class='bg-success'>Your post has been created. <a href='../post.php?p_id={$the_post_id}'>View Post</a> or <a href='posts.php'>Edit other Posts.</a> </p>";
}


?>


<form action="" method="post" enctype="multipart/form-data">
      <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" class="form-control" name="post_title" />
      </div>
     
      <div class="form-group">
        <label for="cateogry">Category</label>
      <select name="post_category" id="post_category">
            <?php 
                // Display the categories titles on the select option
                $query = "SELECT * FROM categories ";
                $select_categories = mysqli_query($connection, $query);   
                
                confirm($select_categories);

                while($row = mysqli_fetch_assoc($select_categories )) {
                $cat_title = $row['cat_title'];
                $cat_id = $row['cat_id'];
                echo "<option value='{$cat_id}'>{$cat_title}</option>";

                }
            
            ?>
        </select>
      </div>
     
      <div class="form-group">
        <label for="post_author">Post Author</label>
        <input type="text" class="form-control" name="post_author" readonly="readonly" value="<?php echo $post_author ?>"/>
      </div>
     
      <div class="form-group">  
        <select name="post_status" id="">
          <option value="draft">Post Status</option>
          <option value="published">Publish</option>
          <option value="draft">Draft</option>
        </select>    
      </div>
     
      <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file" name="image" />
      </div>
     
      <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control" name="post_tags" />
      </div>
     
      <div class="form-group">
        <label for="post_content">Post Content</label>
          <textarea class="form-control" name="post_content" id="summernote" rows="10" cols="30"></textarea>
        </div>
     
        <div class="form-group">
          <input class="btn btn-primary" type="submit" name="create_post" value="Publish Post">
        </div>
</form>