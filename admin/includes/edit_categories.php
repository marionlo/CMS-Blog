                            <!-- Edit Category Form -->
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="cat-title">Edit Category</label>
                                    <?php 
                                    // Make a query for the category title to pass it into the input
                                    if(isset($_GET['edit'])) {
                                        $cat_id = escape($_GET['edit']);
                                        $query = "SELECT * FROM categories WHERE cat_id = $cat_id ";
                                        $select_categories_id = mysqli_query($connection, $query);     
                                         while($row = mysqli_fetch_assoc($select_categories_id )) {
                                         $cat_title = $row['cat_title'];
                                         $cat_id = $row['cat_id'];
                                         ?>
                                 <input class="form-control" type="text" name="cat_title" value="<?php if(isset($cat_title)){ echo $cat_title;} ?>">
                                   <?php }} ?>

                                   <?php //Update the category into the DB
                                    if(isset($_POST['update_category'])) {
                                        $cat_title = escape($_POST['cat_title']);
                                        $stmt = mysqli_prepare($connection, "UPDATE categories SET cat_title = ? WHERE cat_id = ? ");
                                        mysqli_stmt_bind_param($stmt, "si", $cat_title, $cat_id);
                                        mysqli_stmt_execute($stmt);
                                        mysqli_stmt_close($stmt);
                                        redirect("categories.php");              
                                    }
                                    
                                   ?>
                                                                                   
                                </div>
                                <div class="form-group">
                                    <input class="btn btn-primary" type="submit" name="update_category" value="Edit Category">
                                </div>
                            </form>