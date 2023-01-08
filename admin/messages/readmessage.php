<?php 
  $id = isset($_GET['id']) ? $_GET['id'] :0;

$sql="UPDATE `tblmessages` SET Viewed=1 WHERE `MessageID`='{$id}'";
$mydb->setQuery($sql);
$mydb->executeQuery();


$sql = "SELECT `MessageID`, `MessageFrom`, `MessageTo`, `MessageSubject`, `MessageText`, `MessageDate`, `Viewed` FROM `tblmessages` WHERE MessageID='{$id}'";
$mydb->setQuery($sql);
$res = $mydb->loadSingleResult();
 

$sql = "SELECT `CustomerID`, `CustomerName`, `CustomerAddress`, `CustomerContact`, `Sex`, `Customer_Username`, `Customer_Password`, `Customer_Photo`, `Latitude`, `Longhitude`, `EmailAdd` FROM `tblcustomer` WHERE `CustomerName` LIKE '%{$res->MessageFrom}%'";
$mydb->setQuery($sql);
$cus = $mydb->loadSingleResult();



?> 

 
      <div class="row"> 
        <!-- /.col -->
        <div class="col-md-12">
          <div class="box box-primary direct-chat direct-chat-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Read Message</h3> 
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <div class="mailbox-read-info">
                <h3><?php  echo $res->MessageSubject; ?></h3>

                <h5>From: <?php  echo $res->MessageFrom; ?>
                  <span class="direct-chat-timestamp pull-right"><?php  echo date_format(date_create($res->MessageDate),'d M. Y h:i a'); ?></span></h5>
              </div>
              <!-- /.mailbox-read-info -->
<!--               <div class="mailbox-controls with-border text-center">
                <div class="btn-group">
                  <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body" title="Delete">
                    <i class="fa fa-trash-o"></i></button>
                  <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body" title="Reply">
                    <i class="fa fa-reply"></i></button>
                  <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" data-container="body" title="Forward">
                    <i class="fa fa-share"></i></button>
                </div> 
                <button type="button" class="btn btn-default btn-sm" data-toggle="tooltip" title="Print">
                  <i class="fa fa-print"></i></button>
              </div> -->
              <!-- /.mailbox-controls -->
              <div class="mailbox-read-message">
                <div class="direct-chat-messages"> 
                  <div class="direct-chat-msg">
                          <div class="direct-chat-info clearfix">
                            <span class="direct-chat-name pull-right"><?php echo $res->MessageFrom;?></span>
                            <span class="direct-chat-timestamp pull-left"><?php echo date_format(date_create($res->MessageDate),'d M. Y h:i a');?></span>
                          </div> 
                          <img class="direct-chat-img" src="<?php echo web_root.'customer/'.$cus->Customer_Photo; ?>" alt="Message User Image"> 
                          <div class="direct-chat-text">
                           <?php echo $res->MessageText; ?>
                          </div> 
                        </div>

                  <?php 
                  $position="";
                    $sql = "SELECT * FROM `tblreplymessages` WHERE `MessageID`='{$id}'";
                    $mydb->setQuery($sql);
                    $repResult = $mydb->loadResultList();
                    foreach ($repResult as $row) {
                      // code... 
$sql = "SELECT `CustomerID`, `CustomerName`, `CustomerAddress`, `CustomerContact`, `Sex`, `Customer_Username`, `Customer_Password`, `Customer_Photo`, `Latitude`, `Longhitude`, `EmailAdd` FROM `tblcustomer` WHERE `CustomerName`='{$row->CreatedBy}'";
$mydb->setQuery($sql);
$maxrow = $mydb->num_rows($mydb->executeQuery());

if($maxrow > 0){ 
$cus = $mydb->loadSingleResult(); ?>
<div class="direct-chat-msg  ">
                          <div class="direct-chat-info clearfix">
                            <span class="direct-chat-name pull-right"><?php echo $row->CreatedBy;?></span>
                            <span class="direct-chat-timestamp pull-left"><?php echo date_format(date_create($row->DateReply),'d M. Y h:i a');?></span>
                          </div> 
                          <img class="direct-chat-img" src="<?php echo web_root.'customer/'.$cus->Customer_Photo; ?>" alt="Message User Image"> 
                          <div class="direct-chat-text">
                           <?php echo $row->ReplyText ?>
                          </div> 
                        </div>

<?php
}else{
$position = 'right';
  ?>

<div class="direct-chat-msg <?php echo $position;?>">
                          <div class="direct-chat-info clearfix">
                            <span class="direct-chat-name pull-right"><?php echo $row->CreatedBy;?></span>
                            <span class="direct-chat-timestamp pull-left"><?php echo date_format(date_create($row->DateReply),'d M. Y h:i a');?></span>
                          </div> 
                          <img class="direct-chat-img" src="<?php echo web_root.'admin/user/'. $singleuser->PicLoc;?>" alt="Message User Image"> 
                          <div class="direct-chat-text">
                           <?php echo $row->ReplyText ?>
                          </div> 
                        </div>

  <?php 

} 
                    }
                  ?>
                </div>
  </div>
              </div>
              <!-- /.mailbox-read-message -->
            </div>
           
            <!-- /.box-footer -->
            <div class="box-footer"> 
                <a href="index.php?view=compose&store=<?php  echo $res->MessageFrom; ?>&id=<?php echo $id;?>" id="btnReplyMessage" class="btn btn-default"><i class="fa fa-reply"></i> Reply</a>
                <!-- <button type="button" class="btn btn-default"><i class="fa fa-share"></i> Forward</button> -->
               
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /. box -->
        </div>
        <!-- /.col -->
      </div>
 