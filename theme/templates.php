<?php
$validate = new Validate();
$validate->pending_products();
?>
<?php
// function of expiration
$sql = "UPDATE `tblstockin` SET ExpiredQty=1,Remaining=0 WHERE `Sold`=0 AND  datediff(date(DateExpire),date(Now())) <= 0 ";
$mydb->setQuery($sql);
$mydb->executeQuery();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>A WEB BASED STORE LOCATOR / <?php echo $title; ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="" />
  <meta name="author" content="http://webthemez.com" />
  <!-- css -->
  <link href="<?php echo web_root; ?>plugins/home-plugins/css/bootstrap.min.css" rel="stylesheet" />
  <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">
  <link href="<?php echo web_root; ?>plugins/home-plugins/css/fancybox/jquery.fancybox.css" rel="stylesheet">
  <link href="<?php echo web_root; ?>plugins/home-plugins/css/flexslider.css" rel="stylesheet" />
  <link href="<?php echo web_root; ?>plugins/home-plugins/css/style.css" rel="stylesheet" />
  <!-- <link rel="stylesheet" href="<?php echo web_root; ?>plugins/dataTables/dataTables.bootstrap.css">  -->
  <link rel="stylesheet" href="<?php echo web_root; ?>plugins/font-awesome/css/font-awesome.min.css">

  <link rel="stylesheet" href="<?php echo web_root; ?>plugins/datatables/jquery.dataTables.min.css">
  <link rel="stylesheet" href="<?php echo web_root; ?>plugins/datatables/jquery.dataTables_themeroller.css">
  <!-- datetime picker CSS -->
  <link href="<?php echo web_root; ?>plugins/datepicker/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
  <link href="<?php echo web_root; ?>plugins/datepicker/datepicker3.css" rel="stylesheet" media="screen">

  <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
  <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  <style type="text/css">
    #content {
      min-height: 400px;
      color: #000;
    }

    .contentbody p {
      font-weight: bold;
    }

    .login a:hover {
      color: #00bcd4;
      text-decoration: none;

    }

    .login a:focus {
      color: #00bcd4;
      text-decoration: none;

    }

    .login a {
      font-size: 14px;
      color: #fff;
      padding: 0px;
    }

    .navbar-header>.search-box {

      width: 100%;
    }

    .search-box {
      padding: 10px 10px;
      position: absolute;
      margin-top: 40px;
    }

    .search-box input {
      height: 40px;
      width: 100%;
    }

    #navbar ul li ul {
      max-height: 300px;
      /* you can change as you need it */
      overflow: auto;
      /* to get scroll */
    }


    #navbar .dropdown-menu {
      background-color: #EFEAEA;
    }

    /* width */
    #navbar ::-webkit-scrollbar {
      width: 5px;
    }

    /* Track */
    #navbar ::-webkit-scrollbar-track {
      background: #f1f1f1;
    }

    /* Handle */
    #navbar ::-webkit-scrollbar-thumb {
      background: #888;
    }

    /* Handle on hover */
    #navbar ::-webkit-scrollbar-thumb:hover {
      background: #555;
    }

    #navbar input[type=text] {
      /* float: right;*/
      padding: 6px;
      /*border: none;*/
      margin-top: 13px;
      font-size: 17px;
      height: 40px;
      border-radius: 25px;
    }

    #navbar #submit {
      /* float: right;*/
      padding: 6px;
      /*border: none;*/
      margin-top: 12.5px;
      /*margin-right: 16px;*/
      padding: 4px;
      font-size: 17px;
      height: 40px;
      width: 50px;
    }

    .body-content {
      /*clear: both;*/
      margin: 130px 0px;
    }

    @media screen and (min-width: 400px) {
      .body-content {
        margin: 85px 0px;
      }
    }

    @media screen and (min-width: 786px) {
      .body-content {
        margin: 130px 0px;
      }
    }

    .dropdown:hover .dropdown-menu {
      display: block;
    }
  </style>


</head>

<body>
  <div id="wrapper" class="home-page">

    <!-- start header -->
    <header>
      <div id="topbar" class="topbar navbar-fixed-top " style="padding: 0px;border-bottom: 3px solid #00bcd4; ">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <!-- <p class="pull-left hidden-xs"><i class="fa fa-phone"></i>Tel No. (+001) 123-456-789</p> -->
              <div class="pull-right login">
                <?php

                if (isset($_SESSION['gcCart'])) {
                  # code...
                  $count_cart = count($_SESSION['gcCart']);
                } else {
                  $count_cart = 0;
                }


                echo '<a title="View Notification(s)" href="' . web_root . 'index.php?q=cart"> <i class="fa fa-shopping-cart"></i> <span class="loadnotif label label-success">' . $count_cart . '</span></a> | ';



                if (isset($_SESSION['CustomerID'])) {


                  $customer = new Customer();
                  $cus  = $customer->single_customer($_SESSION['CustomerID']);

                  $sql = "SELECT count(*) as 'COUNT' FROM `tblstockout` WHERE `HView`=1 AND `CustomerID`='{$_SESSION['CustomerID']}'";
                  $mydb->setQuery($sql);
                  $showMsg = $mydb->loadSingleResult();
                  $msg = isset($showMsg->COUNT) ? $showMsg->COUNT : 0;



                  $sql = "SELECT SUM(`Remaining`) as Remain FROM `tblstockin` p,`tblwishlist` w WHERE p.`ProductID`=w.`ProductID` AND `CustomerID`='" . $_SESSION['CustomerID'] . "' GROUP BY p.`ProductID`";
                  $mydb->setQuery($sql);
                  $cur = $mydb->executeQuery();
                  $maxrow = $mydb->num_rows($cur);
                  if ($maxrow > 0) {
                    # code...
                    $res = $mydb->loadSingleResult();

                    if ($res->Remain > 0) {
                      # code...
                      $maxrow = $maxrow;
                    }
                  } else {
                    $maxrow = 0;
                  }


                  echo '<a title="View Message(s)" href="' . web_root . 'customer/index.php?view=notification"> <i class="fa fa-bell-o"></i> <span class="label label-success">' . ($msg + $maxrow) . '</span></a> | <a title="View Profile" href="' . web_root . 'customer/"> <i class="fa fa-user"></i> Hello, ' . $cus->CustomerName . ' </a> | <a href="' . web_root . 'logout.php">  <i class="fa fa-sign-out"> </i>Logout</a> ';
                } else { ?>
                  <p class="login"><a href="index.php?q=register/store"> <i class="fa fa-building-o"></i> Register Store </a></p> |
                  <p class="login"><a href="index.php?q=register/customer"> <i class="fa fa-users"></i> Register Customer </a></p>
                  |
                  <p class="login"><a data-target="#myModal" data-toggle="modal" href=""> <i class="fa fa-lock"></i> Login </a></p>

                <?php } ?>
              </div>
            </div>
          </div>
        </div>
        <div id="navbar" class="navbar navbar-default navbar-static-top">
          <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <!-- <a class="navbar-brand" href="<?php echo web_root; ?>index.php">Multi Store<img src="<?php echo web_root; ?>plugins/home-plugins/img/logo.png" alt="logo"/></a> -->

              <!-- <a class="navbar-brand" href= ""><font size= "02.05">A Web Based Store locator</font></a>  -->
            </div>
            <div class="navbar-collapse collapse ">
              <ul class="nav navbar-nav">
                <li class="<?php echo !isset($_GET['q']) ? 'active' : '' ?>"><a href="<?php echo web_root; ?>index.php">Home</a></li>
                <li class="<?php if (isset($_GET['q'])) {
                              if ($_GET['q'] == 'product') {
                                echo 'active';
                              } else {
                                echo '';
                              }
                            }  ?>"><a href="<?php echo web_root; ?>index.php?q=product">Products</a></li>

                <li class="<?php if (isset($_GET['q'])) {
                              if ($_GET['q'] == 'company') {
                                echo 'active';
                              } else {
                                echo '';
                              }
                            }  ?>"><a href="<?php echo web_root; ?>index.php?q=company">Store</a></li>
                <li class="<?php if (isset($_GET['q'])) {
                              if ($_GET['q'] == 'nearstore') {
                                echo 'active';
                              } else {
                                echo '';
                              }
                            }  ?>"><a href="<?php echo web_root; ?>index.php?q=nearstore"><i class="fa fa-search"></i> Store Near You</a></li>
                <li class="<?php if (isset($_GET['q'])) {
                              if ($_GET['q'] == 'map') {
                                echo 'active';
                              } else {
                                echo '';
                              }
                            } ?>"><a href="<?php echo web_root; ?>index.php?q=map">Map</a></li>
                <li class="<?php if (isset($_GET['q'])) {
                              if ($_GET['q'] == 'About') {
                                echo 'active';
                              } else {
                                echo '';
                              }
                            }  ?>"><a href="<?php echo web_root; ?>index.php?q=About">About Us</a></li>
                <li class="<?php if (isset($_GET['q'])) {
                              if ($_GET['q'] == 'Contact') {
                                echo 'active';
                              } else {
                                echo '';
                              }
                            }  ?>"><a href="<?php echo web_root; ?>index.php?q=Contact">Contact</a></li>
                <?php
                $rq = isset($_GET['q']) ?  $_GET['q'] : "";

                if ($rq != 'advancesearch' && $rq != 'search/store' && $rq != 'search/category') { ?>

                  <form autocomplete="off" method="POST" action="<?php echo web_root; ?>index.php?q=result&searchfor=advancesearch" style="padding: 0px 20px 0px 5px;">
                    <div class="input-group autocomplete">
                      <input type="text" name="SEARCH" id="tags" class="form-control" placeholder="Search">
                      <div class="input-group-btn">
                        <button type="submit" name="submit" id="submit" class="btn btn-default btn-xs">
                          <span class="glyphicon glyphicon-search"></span>
                        </button>
                      </div>
                    </div>
                  </form>
                <?php } ?>
              </ul>
            </div>
          </div>
        </div>

      </div>
    </header>
    <!-- end header -->
    <div class="body-content">
      <?php
      if (!isset($_SESSION['CustomerID'])) {
        include("login.php");
      }
      ?>
      <?php

      if (isset($_GET['q'])) {
        # code...
        // echo '<div  style="background-color:#00bcd4;height:40px;"  >
        //     <div class="container">
        //         <div class="row">
        //             <div class="col-lg-12">
        //                 <p style="padding:10px 0px;font-size:25px;color:#fff;font-weight:bold" >'.$title.'</p>
        //             </div>
        //         </div>
        //     </div>
        //     </div>';
      }


      require_once($content);

      ?>
    </div>
    <footer>
      <div class="container">
        <div class="row">
          <div class="col-md-4 col-sm-4">
            <div class="widget">
              <h5 class="widgetheading">Our Contact</h5>
              <address>
                <strong>Store Locator Finder</strong><br>

                Zamboanga City
              </address>
              <p>
                <i class="icon-phone"></i> 09936324530---(DITO)<br>
                <i class="icon-phone"></i> 09936324531---(DITO)<br>
                <i class="icon-envelope-alt"></i> spoted1999@gmail.com
              </p>
            </div>
          </div>
          <div class="col-md-4 col-sm-4">
            <div class="widget">
              <h5 class="widgetheading">Quick Links</h5>
              <ul class="link-list">
                <li><a href="<?php echo web_root; ?>index.php?q=company">Store</a></li>
                <li><a href="<?php echo web_root; ?>index.php?q=map">Map</a></li>
                <li><a href="<?php echo web_root; ?>index.php?q=About">About Us</a></li>
                <li><a href="<?php echo web_root; ?>index.php?q=Contact">Contact</a></li>
              </ul>
            </div>
          </div>
          <!--       <div class="col-md-4 col-sm-4">
        <div class="widget">
          <h5 class="widgetheading">Latest posts</h5>
          <ul class="link-list">
            <?php
            $sql = "SELECT * FROM `tblcompany` c,`tbljob` j WHERE c.`COMPANYID`=j.`COMPANYID`   ORDER BY DATEPOSTED DESC LIMIT 3";
            $mydb->setQuery($sql);
            $cur = $mydb->loadResultList();


            foreach ($cur as $result) {
              echo ' <li><a href="' . web_root . 'index.php?q=viewjob&search=' . $result->JOBID . '">' . $result->COMPANYNAME . '/ ' . $result->OCCUPATIONTITLE . '</a></li>';
            }
            ?> 
          </ul>
        </div>
      </div> -->
          <div class="col-md-4 col-sm-4">
            <div class="widget">
              <h5 class="widgetheading">Search</h5>
              <ul class="link-list">
                <li><a href="<?php echo web_root; ?>index.php?q=advancesearch">Advance Search</a></li>
                <li><a href="<?php echo web_root; ?>index.php?q=search/store">Filter By Store</a></li>
                <li><a href="<?php echo web_root; ?>index.php?q=search/category">Filter By Category</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div id="sub-footer">
        <div class="container">
          <div class="row">
            <div class="col-lg-6">
              <div class="copyright">
                <p>
                  <span>&copy; spoted1999@gmail.com 2022 All right reserved.
                </p>
              </div>
            </div>
            <div class="col-lg-6">
              <ul class="social-network">
                <li><a href="#" data-placement="top" title="Facebook"><i class="fa fa-facebook"></i></a></li>
                <li><a href="#" data-placement="top" title="Twitter"><i class="fa fa-twitter"></i></a></li>
                <li><a href="#" data-placement="top" title="Linkedin"><i class="fa fa-linkedin"></i></a></li>
                <li><a href="#" data-placement="top" title="Pinterest"><i class="fa fa-pinterest"></i></a></li>
                <li><a href="#" data-placement="top" title="Google plus"><i class="fa fa-google-plus"></i></a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </footer>
  </div>
  <a href="#" class="scrollup"><i class="fa fa-angle-up active"></i></a>
  <!-- javascript
    ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <script src="<?php echo web_root; ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
  <!-- <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script> -->
  <script src="<?php echo web_root; ?>plugins/home-plugins/js/jquery.easing.1.3.js"></script>
  <script src="<?php echo web_root; ?>plugins/home-plugins/js/bootstrap.min.js"></script>

  <script src="<?php echo web_root; ?>plugins/datatables/jquery.dataTables.min.js"></script>

  <script type="text/javascript" src="<?php echo web_root; ?>plugins/datepicker/bootstrap-datepicker.js" charset="UTF-8"></script>
  <script type="text/javascript" src="<?php echo web_root; ?>plugins/datepicker/bootstrap-datetimepicker.js" charset="UTF-8"></script>
  <script type="text/javascript" src="<?php echo web_root; ?>plugins/datepicker/locales/bootstrap-datetimepicker.uk.js" charset="UTF-8"></script>

  <script type="text/javascript" language="javascript" src="<?php echo web_root; ?>plugins/input-mask/jquery.inputmask.js"></script>
  <script type="text/javascript" language="javascript" src="<?php echo web_root; ?>plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
  <script type="text/javascript" language="javascript" src="<?php echo web_root; ?>plugins/input-mask/jquery.inputmask.extensions.js"></script>

  <script src="<?php echo web_root; ?>plugins/home-plugins/js/jquery.fancybox.pack.js"></script>
  <script src="<?php echo web_root; ?>plugins/home-plugins/js/jquery.fancybox-media.js"></script>
  <script src="<?php echo web_root; ?>plugins/home-plugins/js/jquery.flexslider.js"></script>
  <script src="<?php echo web_root; ?>plugins/home-plugins/js/animate.js"></script>


  <!-- Vendor Scripts -->
  <script src="<?php echo web_root; ?>plugins/home-plugins/js/modernizr.custom.js"></script>
  <script src="<?php echo web_root; ?>plugins/home-plugins/js/jquery.isotope.min.js"></script>
  <script src="<?php echo web_root; ?>plugins/home-plugins/js/jquery.magnific-popup.min.js"></script>
  <script src="<?php echo web_root; ?>plugins/home-plugins/js/animate.js"></script>
  <script src="<?php echo web_root; ?>plugins/home-plugins/js/custom.js"></script>




  <!-- <script src="<?php echo web_root; ?>plugins/paralax/paralax.js"></script>  -->

  <script type="text/javascript">
    $('input.ContactNo').on('keyup', function() {
      limitText(this, 11)
    });

    function limitText(field, maxChar) {
      var ref = $(field),
        val = ref.val();
      if (val.length >= maxChar) {
        ref.val(function() {
          console.log(val.substr(0, maxChar))
          return val.substr(0, maxChar);
        });
      }
    }


    // Restricts input for the set of matched elements to the given inputFilter function.
    (function($) {
      $.fn.inputFilter = function(inputFilter) {
        return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
          if (inputFilter(this.value)) {
            this.oldValue = this.value;
            this.oldSelectionStart = this.selectionStart;
            this.oldSelectionEnd = this.selectionEnd;
          } else if (this.hasOwnProperty("oldValue")) {
            this.value = this.oldValue;
            this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
          } else {
            this.value = "";
          }
        });
      };
    }(jQuery));

    $(document).ready(function() {
      $("#ContactNo").inputFilter(function(value) {
        return /^\d*$/.test(value); // Allow digits only, using a RegExp
      });
    });
  </script>

  <script type="text/javascript">
    function personalInfo() {

      if (document.personal.condition.checked == false) {
        alert('please agree the term and condition');
        return false;
      }

    }

    $("#QTY").focus(function() {
      $(this).select();
    });
    $("#QTY").focusout(function() {

      if ($(this).val("")) {
        $(this).val(1);
      }

    })

    $("#QTY").keyup(function() {
      // alert("sad")
      var inpQTY = $(this).val();
      var rqty = $("#RQTY").val();
      // alert(rqty); 
      if (inpQTY > rqty) {
        $("#QTY").val(rqty);
      }

    });


    $(function() {
      $("#dash-table").DataTable();
      $('#dash-table2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false
      });
    });

    $("#storeID_rating").click(function() {
      var id = $(this).data('id');
      // alert(id)
      $(".modal-body #storeid").val(id);
    });


    $("#btnlogin").click(function() {
      var username = document.getElementById("user_email");
      var pass = document.getElementById("user_pass");

      // alert(username.value)
      // alert(pass.value)
      if (username.value == "" && pass.value == "") {
        $('#loginerrormessage').fadeOut();
        $('#loginerrormessage').fadeIn();
        $('#loginerrormessage').css({
          "background": "red",
          "color": "#fff",
          "padding": "5px;"
        });
        $("#loginerrormessage").html("Invalid Username and Password!");
        //  $("#loginerrormessage").css(function(){ 
        //   "background-color" : "red";
        // });
      } else {

        $.ajax({ //create an ajax request to load_page.php
          type: "POST",
          url: "process.php?action=login",
          dataType: "text", //expect html to be returned  
          data: {
            USERNAME: username.value,
            PASS: pass.value
          },
          success: function(data) {
            // alert(data);
            $('#loginerrormessage').fadeOut();
            $('#loginerrormessage').fadeIn();
            $('#loginerrormessage').css({
              "background": "red",
              "color": "#fff",
              "padding": "5px;"
            });
            $('#loginerrormessage').html(data);
          }
        });
      }
    });

    $("#btnlogin_cart").click(function() {
      var username = document.getElementById("user_email_cart");
      var pass = document.getElementById("user_pass_cart");

      // alert(username.value)
      // alert(pass.value)
      if (username.value == "" && pass.value == "") {
        $('#loginerrormessage_cart').fadeOut();
        $('#loginerrormessage_cart').fadeIn();
        $('#loginerrormessage_cart').css({
          "background": "red",
          "color": "#fff",
          "padding": "5px;"
        });
        $("#loginerrormessage_cart").html("Invalid Username and Password!");
        //  $("#loginerrormessage_cart").css(function(){ 
        //   "background-color" : "red";
        // });
      } else {

        $.ajax({ //create an ajax request to load_page.php
          type: "POST",
          url: "process.php?action=login_cart",
          dataType: "text", //expect html to be returned  
          data: {
            USERNAME: username.value,
            PASS: pass.value
          },
          success: function(data) {
            // alert(data);
            $('#loginerrormessage_cart').fadeOut();
            $('#loginerrormessage_cart').fadeIn();
            $('#loginerrormessage_cart').css({
              "background": "red",
              "color": "#fff",
              "padding": "5px;"
            });
            $('#loginerrormessage_cart').html(data);
          }
        });
      }
    });


    $("#btnLoginRating").click(function() {
      var username = document.getElementById("user_email_rating");
      var pass = document.getElementById("user_pass_rating");
      var storeid = document.getElementById("storeid");

      // alert(username.value)
      // alert(pass.value)
      if (username.value == "" && pass.value == "") {
        $('#loginerrormessage_rating').fadeOut();
        $('#loginerrormessage_rating').fadeIn();
        $('#loginerrormessage_rating').css({
          "background": "red",
          "color": "#fff",
          "padding": "5px;"
        });
        $("#loginerrormessage_rating").html("Invalid Username and Password!");
        //  $("#loginerrormessage_rating").css(function(){ 
        //   "background-color" : "red";
        // });
      } else {

        $.ajax({ //create an ajax request to load_page.php
          type: "POST",
          url: "process.php?action=loginRating",
          dataType: "text", //expect html to be returned  
          data: {
            USERNAME: username.value,
            PASS: pass.value,
            StoreID: storeid.value
          },
          success: function(data) {
            // alert(data);
            $('#loginerrormessage_rating').fadeOut();
            $('#loginerrormessage_rating').fadeIn();
            $('#loginerrormessage_rating').css({
              "background": "red",
              "color": "#fff",
              "padding": "5px;"
            });
            $('#loginerrormessage_rating').html(data);
          }
        });
      }
    });

    $('input[data-mask]').each(function() {
      var input = $(this);
      input.setMask(input.data('mask'));
    });


    $('#BIRTHDATE').inputmask({
      mask: "2/1/y",
      placeholder: "mm/dd/yyyy",
      alias: "date",
      hourFormat: "24"
    });
    $('#HIREDDATE').inputmask({
      mask: "2/1/y",
      placeholder: "mm/dd/yyyy",
      alias: "date",
      hourFormat: "24"
    });

    $('.date_picker').datetimepicker({
      format: 'mm/dd/yyyy',
      startDate: '01/01/1950',
      language: 'en',
      weekStart: 1,
      todayBtn: 1,
      autoclose: 1,
      todayHighlight: 1,
      startView: 2,
      minView: 2,
      forceParse: 0

    });

    $(function() {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.open("GET", "loadcart.php", false);
      xmlhttp.send(null);
      // $('#loaddata').hide();   
      // $('#loaddata').fadeIn(); 
      $('#loaddata').html(xmlhttp.responseText);
    });
  </script>

  <link href="<?php echo web_root; ?>plugins/autocomplete/jquery.auto-complete.css" rel="stylesheet" media="screen">
  <script src="<?php echo web_root; ?>plugins/autocomplete/jquery.auto-complete.min.js"></script>

  <?php
  $sql = "Select * From tblproduct p, tblcategory c Where p.CategoryID=c.CategoryID GROUP BY ProductName";
  $mydb->setQuery($sql);
  $cur = $mydb->loadResultList();
  foreach ($cur as $result) {
    # code...
    $products[] = $result->ProductName;
    $products[] = $result->Categories;

    //$products[]
  }

  ?>

  <script>
    var availableTags = <?php echo json_encode($products) ?>;

    $("#tags").autoComplete({
      minChars: 1,
      source: function(term, suggest) {
        term = term.toLowerCase();
        var choices = availableTags;
        var matches = [];
        for (i = 0; i < choices.length; i++)
          if (~choices[i].toLowerCase().indexOf(term)) matches.push(choices[i]);
        suggest(matches);
      }
    });

    function popitup(url, windowName) {
      newwindow = window.open(url, windowName, 'height=500,width=500');
      if (window.focus) {
        newwindow.focus()
      }
      return false;
    }
  </script>



</body>

</html>