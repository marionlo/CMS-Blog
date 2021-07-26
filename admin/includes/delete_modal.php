
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Delete Post</h4>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this post?</p>
      </div>
      <div class="modal-footer">
        <form action ="posts.php" method="post">
          <input type="hidden" class="modal_delete_link" name="post_id" value="">
          <input class='btn btn-danger' type='submit' name='delete' value='Delete'>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        </form>
       
      </div>
    </div>

  </div>
</div>