 <?php
  $storeID = isset($_GET['store']) ? $_GET['store'] : '';
  if ($storeID=='') {
    $store="";
  }else{
    $sql = "SELECT `UserID`, `FullName`, `Username`, `Password`, `Role`, `PicLoc` FROM `tblusers` WHERE `UserID`='{$storeID}'" ;
    $mydb->setQuery($sql);
    $result = $mydb->loadSingleResult();
    $store = $result->Username;
  }

 ?>
 <form action="controller.php?action=sendmessage" method="POST">
 <div class="content-wrapper"> 
    <!-- Main content -->
    <section class="content">
      <div class="row"> 
      	<div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Create New Message</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="form-group">
                <input class="form-control" name="messageTo"  id="messageTo" placeholder="To: Store" value="<?php echo $store;?>">
              </div>
              <div class="form-group">
                <input class="form-control" name="messageSubject" placeholder="Subject:">
              </div>
              <div class="form-group">
                    <textarea id="compose-textarea" name="MessageText" class="form-control" style="height: 300px"></textarea>
              </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <div class="pull-right">
                <button type="submit" class="btn btn-primary"><i class="fa fa-envelope-o"></i> Send</button>
              </div>
              <button type="reset" class="btn btn-default"><i class="fa fa-times"></i> Discard</button>
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /. box -->
        </div>
    </div>
</section>
</div>
</form>