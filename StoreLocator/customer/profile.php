<?php   
    $view = isset($_GET['view']) ? $_GET['view'] :"";  
	  $cus = new Customer();
	  $customer = $cus->single_customer($_SESSION['CustomerID']); 
  ?>
  <style type="text/css"> 
    .panel-body img{
      width: 100%;
      height: 50%;
    }
    .panel-body img:hover{
      cursor: pointer;
    }
  </style>
<section id="inner-headline">
  <div class="container">
      <div class="row">
          <div class="col-lg-12">
              <h2 class="pageTitle">Profile</h2>
          </div>
      </div>
  </div>
</section>
<div class="container">

    <div class="row">

        <div class="col-sm-3"><!--left col-->
           <div class="panel panel-default">            
            <div class="panel-body"> 
              <div  id="image-container">
                <img title="profile image"  data-target="#myModal"  data-toggle="modal"  src="<?php echo web_root.'customer/'.$customer->Customer_Photo; ?>">  
              </div>
             </div>
          <ul class="list-group">
       
         
            <li class="list-group-item text-muted">Profile</li> 
            <li class="list-group-item text-right"><span class="pull-left"><strong>Real Name</strong></span> 
             <?php echo $customer->CustomerName; ?> 
             </li>
            
          </ul>  
          <div class="box box-solid">  
            <div class="box-body no-padding">
              <ul class="nav nav-pills nav-stacked"> 
                <li class="<?php echo ($view=='orders' || $view=='') ? 'active': '';?>"><a href="<?php echo web_root.'customer/index.php?view=orders'; ?>"><i class="fa fa-list"></i> Orders
                   </a></li>
                    <li class="<?php echo ($view=='wishlist') ? 'active': '';?>"><a href="<?php echo web_root.'customer/index.php?view=wishlist'; ?>"><i class="fa fa-list"></i> Wish List
                   </a></li>
                  <li class="<?php echo ($view=='accounts') ? 'active': '';?>"><a href="<?php echo web_root.'customer/index.php?view=accounts'; ?>"><i class="fa fa-user"></i> Accounts </a></li>
        
              </ul>
            </div>
            <!-- /.box-body -->
          </div>
  
          <!-- /.box -->
          </div>
          
        </div> 
        <div class="col-sm-9">
        <?php
        check_message();  
        check_active(); 
            
    switch ($view) {
      case 'message':
        # code...
        require_once("message.php");
        break;
      case 'notification':
        # code...
        require_once("notification.php");
        break;
      case 'orders':
        # code...
        require_once("orders.php");
        break;
      case 'accounts':
        # code...
        require_once("account.php");
        break;
      case 'viewproduct':
        # code...
        require_once("viewproduct.php");
        break;
      case 'wishlist':
        # code...
        require_once("wishlist.php");
        break;
 
      default:
        # code...
        require_once("orders.php");
        break;
    }
?>  
  
        </div><!--/col-sm-9-->
    </div><!--/row-->

  </div><!--/contanier--> 

   <?php  
    unset($_SESSION['appliedjobs']);
    unset($_SESSION['accounts']); 
     ?>
 
         <!-- Modal -->
                    <div class="modal fade" id="myModal" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button class="close" data-dismiss="modal" type=
                                    "button">×</button>

                                    <h4 class="modal-title" id="myModalLabel">Choose Image.</h4>
                                </div>

                                <form action="controller.php?action=photos" enctype="multipart/form-data" method=
                                "post">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <div class="rows">
                                                <div class="col-md-12">
                                                    <div class="rows">
                                                        <div class="col-md-8">
                                                          <input name="MAX_FILE_SIZE" type=
                                                            "hidden" value="1000000"> <input id=
                                                            "photo" name="photo" type=
                                                            "file">
                                                        </div>

                                                        <div class="col-md-4"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button class="btn btn-default" data-dismiss="modal" type=
                                        "button">Close</button> <button  class="btn btn-primary"
                                        name="savephoto" type="submit">Upload Photo</button>
                                    </div>
                                </form>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
