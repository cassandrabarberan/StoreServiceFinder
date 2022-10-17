<style type="text/css">
  .stretch img{
    width: 100%;
    height: 200px;
  }
  .slides > li > img {
    width: 100%;
    height: 480px;
  }
  #item > img{
    width: 100%;
    height: 4%;
  }
 

  #items  img{
    width: 100%;
    height:200px;
  }
  #watermark { position: absolute; bottom:5px;   opacity:0.5; z-index:00; color:white;  top: 0  } 
.info-blocks { 
  /*margin: 0px;*/
  padding: 5px; 
}
  .info-blocks-in p {
    display: inline-block;
    max-width: 100%;
    height: 1.5em;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap; 
    color: #000;
    padding: 0px;
    margin: 0px;
  }

   .info-blocks-in #pricein {
    font-weight: bold;padding: 2px;font-size: 30px;color: #f04e5d
   }
  .info-blocks:hover{

    background-color: #fff;
      /*border: .5px #ddd solid;*/
      cursor: pointer;
     box-shadow: 
        0 0 1px 1px #ddd, /* middle magenta */
        0 0 1px 1px #000; /* outer cyan */
  }

</style>
  <section id="banner">
   
  <!-- Slider -->
       <?php include 'slides.php';?>
  <!-- end slider -->
 
  </section> 
  <section id="call-to-action-2"  style="background-color:#06d5f0; padding:0px;" >
    <div class="container">
      <div class="row">
        <div class="col-md-10 col-sm-9" >
          <h3 style="color: #ffffff">Your Store Finder</h3>
          <p style="color: #ffffff">Your Ways.</p>
        </div>
       <!--  <div class="col-md-2 col-sm-3">
          <a href="#" class="btn btn-primary">Read More</a>
        </div> -->
      </div>
    </div>
  </section>
  <!-- <section style="background-color: #eee">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="section-title text-center">
            <h2 >Product Categories</h2>  
          </div>
        </div>
      </div>
     <div class="row">
        <div class="col-md-12 ">
          < ?php 
            $sql = "SELECT * FROM `tblproduct` p, `tblcategory` c WHERE p.`CategoryID`=c.`CategoryID` GROUP BY c.`CategoryID` ";
            $mydb->setQuery($sql);
            $cur = $mydb->loadResultList();

            foreach ($cur as $result) {
             ?>
             <a href="index.php?q=category&search=< ?php echo $result->CategoryID;?>" title="< ?php echo $result->Categories;?>">
                <div class="col-sm-2 info-blocks" style="min-height: 340px;padding: 0px;border: 1px solid #ddd;background-color: #fff;"> 
                          <div class="stretch">  
                              <img src="< ?php echo web_root.'admin/products/'. $result->Image1 ?>">
                             < !--  <div id="myCarousels< ?php echo $result->ProductID; ?>" class="carousel slide" data-ride="carousel">
                                  
 
                                  <div class="carousel-inner">
                                    <div id="items" class="item  active">
                                    <img src=" < ?php echo web_root.'admin/products/'. $result->Image1 ?>" >
                                    </div>

                                    <div id="items" class="item ">
                                    <img src=" < ?php echo web_root.'admin/products/'. $result->Image2 ?>" >
                                    </div>
                                  
                                    <div id="items" class="item ">
                                    <img src=" < ?php echo web_root.'admin/products/'. $result->Image3 ?>" >
                                    </div>
                                  </div> 
                                  <a class="left carousel-control" href="#myCarousels< ?php echo $result->ProductID; ?>" data-slide="prev">
                                    <span class="glyphicon glyphicon-chevron-left"></span>
                                    <span class="sr-only">Previous</span>
                                  </a>
                                  <a class="right carousel-control" href="#myCarousels< ?php echo $result->ProductID; ?>" data-slide="next">
                                    <span class="glyphicon glyphicon-chevron-right"></span>
                                    <span class="sr-only">Next</span>
                                  </a>
                                </div>  
                          < /div>

                < d iv class="info-blocks-in" style="background-color: #fff">
                    < label>< ?php echo $result->Categories;?></ label> 
                < /div>
            < /div>
          < /a>
           <  ?php }

          ?>
        < /div>
      < /div> -->
 
    </div>
  </section>    
  <section id="content" style="background-color: #fff; padding-top:0px;">
   <div class="container"> 
 
 <div class="row">
      <div class="col-md-12">
        <div class="aligncenter"><h2 class="aligncenter">Products</h2><!-- Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolores quae porro consequatur aliquam, incidunt eius magni provident, doloribus omnis minus ovident, doloribus omnis minus temporibus perferendis nesciunt.. --></div>
        <br/>
      </div>
    </div>

    <?php 
 
 // function of expiration
    // $sql = "UPDATE `tblstockin` SET ExpiredQty=1,Remaining=0 WHERE `Sold`=0 AND  datediff(date(DateExpire),date(Now())) <= 0 ";
    // $mydb->setQuery($sql);
    // $mydb->executeQuery(); 
 
 

      $sql = "SELECT * FROM `tblproduct` p, `tblcategory` c WHERE p.`CategoryID`=c.`CategoryID` GROUP BY ProductName";
      $mydb->setQuery($sql);
      $p = $mydb->loadResultList();


      foreach ($p as $product ) {
        # code...
    
    ?>
           <a  href="index.php?q=products&id=<?php echo $product->ProductID;?>" title="<?php echo $product->ProductName;?> <?php echo $product->Description;?> <?php echo $product->Categories;?>">
            <div class="col-sm-3 info-blocks" style="border: 1px solid #ddd; padding: 0px;"> 
                        <div class="stretch" >  
                           <img src="<?php echo web_root.'admin/products/'. $product->Image1 ?>">
                         
                          </div> 

          </a>
             <a  href="index.php?q=products&id=<?php echo $product->ProductID;?>" title="<?php echo $product->ProductName;?> <?php echo $product->Description;?> <?php echo $product->Categories;?>">
                <div class="info-blocks-in">
                    <p> <?php echo $product->ProductName;?>  </p>
                    <p><?php echo $product->Description;?> <?php echo $product->Categories;?> </p>  <br/>
                    <p id="pricein">&#8369 <?php echo number_format($product->Price,2);?></p>
                </div>
                
                </div> 
             </a>

    <?php } ?> 
      </div>
  


  </section>
  
  
  <section id="content-3-10" class="content-block data-section nopad content-3-10" style="margin-top:20px;">
<div id="myCarousel" class="carousel slide" data-ride="carousel"> 
    <!-- Wrapper for slides -->
    <div class="carousel-inner">
      <div  id="item" class="item active"> 
        <img src="<?php echo web_root; ?>plugins/home-plugins/img/slides/drug.png" alt="Los Angeles" style="height: 350px;" >
      </div>

    
    
     <?php 
          $sql ="SELECT * FROM tblproduct";
          $mydb->setQuery($sql);
          $res = $mydb->loadResultList();

          foreach ($res as $row) {
          echo '<div id="item"  class="item">
                <img src="admin/products/'.$row->Image1.'" alt="'.$row->ProductName.'" style="height: 350px;"  >
              </div>';
            
          }
      ?>
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>
</section>
  
  <div class="about home-about">
<div class="container">
  <div class="row">
      <div class="col-md-12">
        <div class="aligncenter"><h2 class="aligncenter">Store</h2><!-- Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolores quae porro consequatur aliquam, incidunt eius magni provident, doloribus omnis minus ovident, doloribus omnis minus temporibus perferendis nesciunt.. --></div>
        <br/>
      </div>
    </div>

    <?php 
     $sql = "SELECT * FROM `tblstore` s, `tblusers` u WHERE StoreID=UserID";
      $mydb->setQuery($sql);
      $comp = $mydb->loadResultList();


      foreach ($comp as $company ) {
        # code...
    
    ?>
            <div class="col-sm-4 info-blocks" style="min-height: 400px;">
              <!--   <i class="icon-info-blocks fa fa-building-o"></i> -->
               <a href="<?php echo web_root.'index.php?q=map&search='.$company->StoreID.'&lat='.$company->lat.'&lng='.$company->lng.'&address='.$company->StoreAddress;?>">
              <div class="stretch">
                <?php if($company->PicLoc!='') { ?>
                   <img src="<?php echo web_root.'admin/user/'.$company->PicLoc;?>">
                <?php }else{ ?>
                    <img src="<?php echo web_root.'dist/img/storetempimage.jpg';?>"> 
                <?php } ?>

                 </div>
            
               </a>
                <div class="info-blocks-in">
                    <h3>   <a href="<?php echo web_root.'index.php?q=map&search='.$company->StoreID.'&lat='.$company->lat.'&lng='.$company->lng.'&address='.$company->StoreAddress;?>"><?php echo $company->StoreName;?></a></h3>
                    <!-- <p><?php echo $company->COMPANYMISSION;?></p> -->
                    <p><i class="fa fa-map-marker"></i> <?php echo $company->StoreAddress;?></p>
                    <p><i class="fa fa-phone"></i> <?php echo $company->ContactNo;?></p>
                </div>
            </div>

    <?php } ?> 
  </div>
    </div>