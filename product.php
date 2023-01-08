   <style type="text/css">
     .stretch img {
       width: 100%;
       height: 250px;
     }

     #watermark {
       position: absolute;
       bottom: 5px;
       opacity: 0.5;
       z-index: 00;
       color: white;
       top: 0
     }

     .info-blocks {
       /*border : 1px solid #ddd;*/
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

     .info-blocks-in {
       background-color: #fff;

     }

     .info-blocks:hover {

       background-color: #fff;
       /*border: .5px #ddd solid;*/
       cursor: pointer;
       box-shadow:
         0 0 1px 1px #ddd,
         /* middle magenta */
         0 0 1px 1px #000;
       /* outer cyan */
     }

     .info-blocks-in #pricein {
       font-weight: bold;
       padding: 2px;
       font-size: 30px;
       color: #f04e5d
     }

     #side-bar {
       border: 1px solid #ddd;
     }

     #side-bar ul li a {
       text-decoration: none;
       color: #000;
       font-size: 13px;
     }

     #side-bar ul li {
       list-style: square;
       padding: 0px 3px;
     }

     #side-bar ul li a:hover {
       color: #00bcd4;
     }
   </style>
   <section id="content" class="container">
     <div class="row">
       <div class="col-lg-3">
         <div id="side-bar">
           <p style="border-bottom:1px solid #ddd;padding: 5px;font-weight: bold;"> Categories </p>
           <ul>
             <?php
              $search = isset($_GET['search']) ? $_GET['search'] : "";


              $sql = "SELECT * FROM `tblproduct` p, `tblcategory` c WHERE p.`CategoryID`=c.`CategoryID` GROUP BY c.`CategoryID`";
              $mydb->setQuery($sql);
              $cur = $mydb->loadResultList();

              foreach ($cur as $result) {
                # code...

                if (isset($_GET['search'])) {
                  # code...
                  if ($result->CategoryID == $search) {
                    # code...
                    $viewresult = '<li> <a  style="color:#00bcd4"  href="' . web_root . 'index.php?q=product&search=' . $result->CategoryID . '">' . $result->Categories . '</a></li>';
                  } else {
                    $viewresult = '<li><a href="' . web_root . 'index.php?q=product&search=' . $result->CategoryID . '">' . $result->Categories . '</a></li>';
                  }
                } else {
                  $viewresult = '<li><a href="' . web_root . 'index.php?q=product&search=' . $result->CategoryID . '">' . $result->Categories . '</a></li>';
                }

                echo $viewresult;
              }

              ?>
           </ul>
         </div>
       </div>
       <div class="col-lg-9">


         <?php
          if ($search != "") {
            $sql = "SELECT * FROM `tblcategory` WHERE CategoryID = " . $search;
            $mydb->setQuery($sql);
            $title = $mydb->loadSingleResult();

            echo '<p style="border-bottom:1px solid #ddd">' . $title->Categories . '</p>';

            $sql = "SELECT *,SUM(`Remaining`) as qty FROM  `tblstockin` s,`tblproduct` p, `tblcategory` c WHERE p.`CategoryID`=c.`CategoryID`  AND s.`ProductID`=p.`ProductID` AND c.CategoryID = '{$search}' GROUP BY s.`ProductID`";
          } else {
            echo '<p style="border-bottom:1px solid #ddd">Products</p>';
            $sql = "SELECT *,SUM(`Remaining`) as qty FROM  `tblstockin` s,`tblproduct` p, `tblcategory` c WHERE p.`CategoryID`=c.`CategoryID`  AND s.`ProductID`=p.`ProductID` GROUP BY s.`ProductID`";
          }

          // function of expiration
          // $sql = "UPDATE `tblstockin` SET ExpiredQty=1,Remaining=0 WHERE `Sold`=0 AND  datediff(date(DateExpire),date(Now())) <= 0 ";
          // $mydb->setQuery($sql);
          // $mydb->executeQuery(); 




          $mydb->setQuery($sql);
          $p = $mydb->loadResultList();


          foreach ($p as $product) {
            # code...

            $expiry_date = $product->DateExpire;
            $today = date('d-m-Y', time());
            $exp = date('d-m-Y', strtotime($expiry_date));
            $expDate =  date_create($exp);
            $todayDate = date_create($today);
            $diff =  date_diff($todayDate, $expDate);
            if ($diff->format("%R%a") > 0) {

              $expStatus =  "active";
            } else {
              $expStatus =  "Expired";
            }

          ?>

           <div class="col-sm-3 info-blocks">
             <a href="index.php?q=products&id=<?php echo $product->ProductID; ?>" title="<?php echo $product->ProductName; ?> <?php echo $product->Description; ?> <?php echo $product->Categories; ?>">
               <div class="stretch">
                 <img src="<?php echo web_root . 'admin/products/' . $product->Image1 ?>">
               </div>

             </a>
             <a href="index.php?q=products&id=<?php echo $product->ProductID; ?>" title="<?php echo $product->ProductName; ?> <?php echo $product->Description; ?> <?php echo $product->Categories; ?>">
               <div class="info-blocks-in">
                 <p> <?php echo $product->ProductName; ?> </p>
                 <p><?php echo $product->Description; ?> <?php echo $product->Categories; ?> </p> <br />
                 <p id="pricein">&#8369 <?php echo number_format($product->Price, 2); ?></p>
               </div>
               <?php if ($product->qty <= 0 || $expStatus != 'active') {   ?>
                 <div id="watermark">
                   <img src="<?php echo web_root; ?>dist/img/soldout.png">
                 </div>
               <?php } ?>
             </a>
           </div>
         <?php } ?>
       </div>
     </div>
   </section>


   <?php
    # include 'test.php';
    ?>