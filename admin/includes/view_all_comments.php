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
                            <?php findAllComments(); ?>

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