 <?php
  $store = isset($_GET['store']) ? $_GET['store'] : ''; 
  $id = isset($_GET['id']) ? $_GET['id'] :0; 
 
$sql = "SELECT `MessageID`, `MessageFrom`, `MessageTo`, `MessageSubject`, `MessageText`, `MessageDate`, `Viewed` FROM `tblmessages` WHERE MessageID='{$id}'";
$mydb->setQuery($sql);
$res = $mydb->loadSingleResult();
 

?> 
 <form action="controller.php?action=sendmessage" method="POST"> 
      <div class="row"> 
      	<div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Reply Message</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="form-group">
                  TO:
                <div class="form-group has-feedback">  
                  <span class="glyphicon glyphicon-user form-control-feedback"></span> 
                  <input readonly class="form-control" name="messageTo"  id="messageTo" placeholder="To: Store Name" value="<?php echo $store;?>">
                 </div> 
              </div> 
              <div class="form-group">
                <input type="hidden" name="MessageID" value="<?php echo $id;?>">
                    <textarea id="compose-textarea" name="MessageText" class="form-control" style="height: 300px" placeholder="message"></textarea>
              </div>
     <!--          <div class="form-group">
                <div class="btn btn-default btn-file">
                  <i class="fa fa-paperclip"></i> Attachment
                  <input type="file" name="attachment">
                </div>
                <p class="help-block">Max. 32MB</p>
              </div> -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <div class="pull-right">
                <!-- <button type="button" class="btn btn-default"><i class="fa fa-pencil"></i> Draft</button> -->
                <button type="submit" class="btn btn-primary"><i class="fa fa-envelope-o"></i> Send</button>
              </div>
              <a href="index.php?view=readmessage&id=<?php echo $id;?>" class="btn btn-default"><i class="fa fa-times"></i> Discard</a>
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /. box -->
        </div>
    </div> 
</form>