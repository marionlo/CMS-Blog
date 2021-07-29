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
                            <small> <?php echo get_username(); ?></small>
                        </h1>
                       
                    </div>
                    </div>
                <!-- /.row -->
                       
                <!-- /.row -->
                
<div class="row">
    <div class="col-lg-4 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-file-text fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">                             
                            <div class='huge'><?php echo $posts_count =  count_records(get_all_user_posts());?></div>
                        <div> My Posts</div>
                    </div>
                </div>
            </div>
            <a href="posts.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-4 col-md-6">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-comments fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                    <div class='huge'><?php echo $comments_count =  count_records(get_all_posts_user_comments());?></div>                 
                      <div> My Comments</div>
                    </div>
                </div>
            </div>
            <a href="comments.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>

    <div class="col-lg-4 col-md-6">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-list fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                    <div class='huge'><?php echo $categories_count = count_records(get_all_user_categories());?></div>       
                         <div>My Categories</div>
                    </div>
                </div>
            </div>
            <a href="categories.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
</div>
                <!-- /.row -->

<?php 
    
    $posts_draft_count =  count_records(get_all_user_draft_posts());
    $posts_published_count = count_records(get_all_user_published_posts());
    $approved_comments = count_records(get_all_user_approved_posts_comments());
    $unapproved_comments = count_records(get_all_user_unapproved_posts_comments());
    
?>


<!-- Graph to display Blog Stats -->
<div class="row">
<script type="text/javascript">
    google.charts.load('current', {'packages':['bar']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
        ['Data', 'Count'],
        <?php 
        
        $element_text = ['My Posts','My Published Posts', 'My Draft Posts', 'My Comments','My Approved Comments', 'My Unapproved Comments', 'My Categories'];
        $element_count = [$posts_count, $posts_published_count, $posts_draft_count, $comments_count, $approved_comments, $unapproved_comments, $categories_count];

        for($i=0; $i<6; $i++) {
            echo "['{$element_text[$i]}'" . "," . "{$element_count[$i]}],";
        }
        
        ?>
        
        ]);

        var options = {
        chart: {
            title: '',
            subtitle: '',
        }
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
    }
</script>
        <div id="columnchart_material" style="width: 'auto'; height: 500px;"></div>
</div>
</div>
<!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->

    <?php include "includes/admin_footer.php" ?>
