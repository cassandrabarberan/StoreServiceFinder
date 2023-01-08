<style type="text/css">
    .mailbox-controls .btn {
      padding: 3px 8px;
      margin: 0px 2px;
    }
  </style> 
 
      <div class="row"> 
        <!-- /.col -->
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Inbox</h3>

              <div class="box-tools pull-right" style="margin-bottom: 5px;">
                <div class="has-feedback">
                  <input type="text" class="form-control input-sm" placeholder="Search Mail">
                  <span class="fa fa-search form-control-feedback" style=""></span>
                </div>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <div class="mailbox-controls">
                <!-- Check all button -->
                <!-- <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i></button> -->
                <div class="btn-group">
                  <!-- <button type="button" class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button> -->
              <!--     <button type="button" class="btn btn-default btn-sm"><i class="fa fa-reply"></i></button>
                  <button type="button" class="btn btn-default btn-sm"><i class="fa fa-share"></i></button> -->
                </div>
                <!-- /.btn-group -->
                <!-- <button type="button" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button> -->
              <!--   <div class="pull-right">
                  1-50/200
                  <div class="btn-group">
                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button>
                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></button>
                  </div> 
                </div> -->
                <!-- /.pull-right -->
              </div>
              <div class="table-responsive mailbox-messages">
                <table class="table table-hover table-striped">
                  <tbody>
                    <?php 

                        $sql = "SELECT * FROM `tblmessages` WHERE  MessageTo LIKE '%".$_SESSION['ADMIN_USERNAME']."%'"; 
                        $mydb->setQuery($sql);
                        $cur = $mydb->loadResultList();
                        foreach ($cur as $result) {
                          # code...
                          echo '<tr>'; 
                          // echo '<td class="mailbox-star"><a href="#"><i class="fa fa-star text-yellow"></i></a></td>';
                          echo '<td class="mailbox-name"><a href="index.php?view=readmessage&id='.$result->MessageID.'">'.$result->MessageFrom.'</a></td>';
                          echo '<td class="mailbox-subject">'.$result->MessageSubject.'</td>'; 
                          echo '<td class="mailbox-date">'.$result->MessageDate.'</td>';
                          echo '</tr>';
                        }
                    ?> 
                  </tbody>
                </table>
                <!-- /.table -->
              </div>
              <!-- /.mail-box-messages -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer no-padding">
              <div class="mailbox-controls">
                <!-- Check all button -->
                <!-- <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i> -->
                </button>
                <div class="btn-group">
                  <!-- <button type="button" class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button> -->
                 <!--  <button type="button" class="btn btn-default btn-sm"><i class="fa fa-reply"></i></button>
                  <button type="button" class="btn btn-default btn-sm"><i class="fa fa-share"></i></button> -->
                </div>
                <!-- /.btn-group -->
                <!-- <a href="index.php?view=message" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></a> -->
   <!--              <div class="pull-right">
                  1-50/200
                  <div class="btn-group">
                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button>
                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></button>
                  </div>
                  
                </div>
              -->
              </div>
            </div>
          </div>
          <!-- /. box -->
        </div>
        <!-- /.col -->
      </div>
 
 