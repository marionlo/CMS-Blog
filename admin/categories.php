<?php include "includes/admin_header.php" ?>
<div id="wrapper">

        <!-- Navigation -->
    <?php include "includes/admin_navigation.php" ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to admin
                            <small><?php echo $_SESSION['username']; ?></small>
                        </h1>
                        <div class="col-xs-6">
                             <!-- Create Category Feature -->
                            <?php insert_categories();?>
                            <!-- Add Category Form -->
                            <form action="" method="post">
                                <div class="form-group">
                                    <label for="cat-title">Add Category</label>
                                    <input class="form-control" type="text" name="cat_title">
                                </div>
                                <div class="form-group">
                                    <input class="btn btn-primary" type="submit" name="submit" value="Add Category">
                                </div>
                            </form>

                            <?php // Include the edit form when we click on the edit button
                        
                        if(isset($_GET['edit'])) {
                            $cat_id = $_GET['edit'];
                            include "includes/edit_categories.php";
                        }
                        
                             ?>
                        </div>

                    <div class="col-xs-6">

                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Category Title</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                            <?php findAllCategories() // Find all Categories and Display Categories Feature ?>
                            <?php deleteCategories() //Delete the category ?>   
             
                            </tbody>
                        </table>
                    </div>
                        
                    </div>
                    </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    <?php include "includes/admin_footer.php" ?>
