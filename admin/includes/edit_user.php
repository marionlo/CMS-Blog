<?php 

if(isset($_GET['p_id'])) {
    $the_post_id = $_GET['p_id'];
}
        // Query the keys from the database and pass it to the form
      $query = "SELECT * FROM posts WHERE post_id = $the_post_id ";
      $select_posts = mysqli_query($connection, $query);     
      while($row = mysqli_fetch_assoc($select_posts )) {
      $post_id = $row['post_id'];
      $post_author = $row['post_author'];
      $post_title = $row['post_title'];
      $post_category_id = $row['post_category_id'];
      $post_status = $row['post_status'];
      $post_image = $row['post_image'];
      $post_tags = $row['post_tags'];
      $post_content = $row['post_content'];
      $post_comments = $row['post_comment_count'];
      $post_date = $row['post_date'];
      }
      // Update the DB with the content of the edit page
      if(isset($_POST['edit_post'])) {
        $post_author = $_POST['post_author'];
        $post_title = $_POST['post_title'];
        $post_category_id = $_POST['post_category'];
        $post_status = $_POST['post_status']; 
        $post_image = $_FILES['image']['name'];
        $post_image_temp = $_FILES['image']['tmp_name'];
        $post_tags = $_POST['post_tags'];
        $post_content = $_POST['post_content'];

        move_uploaded_file($post_image_temp, "../images/$post_image"); //Move the temporary file to the images folder


        //If there's no new picture upload, keep the previous one
        if(empty($post_image)) {
            $query = "SELECT * FROM posts where post_id = $the_post_id ";
            $select_image = mysqli_query($connection, $query);

            while($row = mysqli_fetch_array($select_image)) {
                $post_image = $row['post_image'];
            }

        }

         //Pass the variables from the form into the query
    $query = "UPDATE posts SET post_category_id='{$post_category_id}', post_title='{$post_title}', post_author='{$post_author}', ";
    $query .="post_date=now(), post_image='{$post_image}', post_content='{$post_content}', post_tags='{$post_tags}', post_status='{$post_status}' WHERE post_id = {$the_post_id} ";
    //Send the query to the DB
    $update_post_query = mysqli_query($connection, $query);

    confirm($update_post_query);

      }
?>

<form action="" method="post" enctype="multipart/form-data">
      <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" class="form-control" name="post_title" value="<?php echo $post_title;?>" />
      </div>
     
      <div class="form-group">
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
        <input type="text" class="form-control" name="post_author" value="<?php echo $post_author;?>"/>
      </div>
     
      <div class="form-group">
        <label for="post_status">Post Status</label>
        <input type="text" class="form-control" name="post_status" value="<?php echo $post_status;?>"/>
      </div>

      <div class="form-group">
      <select name="user_role" id="user_role">
            <?php 
                // Display the categories titles on the select option
                $query = "SELECT * FROM users ";
                $select_users = mysqli_query($connection, $query);   
                
                confirm($select_users);

                while($row = mysqli_fetch_assoc($select_users )) {
                $user_id = $row['user_id'];
                $user_role = $row['user_role'];

                echo "<option value='{$user_id}'>{$user_role}</option>";

                }
            
            ?>
        </select>
      </div>
     
      <div class="form-group">
        
        <img src="../images/<?php echo $post_image; ?>" width="200"/>
        <input type="file" name="image">
      </div>
     
      <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control" name="post_tags" value="<?php echo $post_tags;?>"/>
      </div>
     
      <div class="form-group">
        <label for="post_content">Post Content</label>
          <textarea class="form-control" name="post_content" id="" rows="10" cols="30"><?php echo $post_content;?></textarea>
        </div>
     
        <div class="form-group">
          <input class="btn btn-primary" type="submit" name="edit_post" value="Publish Post">
        </div>
</form>