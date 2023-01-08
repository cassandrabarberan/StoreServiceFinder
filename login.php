  
     <!-- Modal -->
          <div class="modal fade" id="myModal" tabindex="-1">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button class="close" data-dismiss="modal" type=
                  "button">×</button>

                  <h4 class="modal-title" id="myModalLabel">Login</h4>
                </div>

                <!-- <form action="process.php?action=login" enctype="multipart/form-data" method="post"> -->
                  <div class="modal-body hold-transition login-page">
                    <div id="loginerrormessage"></div>
                    <div class="login-box"> 
                        <div class="login-box-body" style="border: solid 1px #ddd;padding: 35px;min-height: 350px;"> 
                            <div class="form-group has-feedback">
                              <input type="text" class="form-control" placeholder="Username" name="user_email" id="user_email">
                              <span class="fa fa-user form-control-feedback" style="margin-top: -22px;"></span>
                            </div>
                            <div class="form-group has-feedback">
                              <input type="password" class="form-control" placeholder="Password" name="user_pass" id="user_pass">
                              <span class="fa fa-lock form-control-feedback" style="margin-top: -22px;"></span>
                            </div>
                            <div class="row">
                              <div class="col-xs-8">
                             <!--    <div class="checkbox icheck">
                                  <label>
                                    <input type="checkbox"> Remember Me
                                  </label>
                                </div> -->
                              </div> 
                              <div class="col-xs-4">
                                
                              </div> 
                            </div>
                          
                           <a href="forgotpassword.php">Forgot Passsword</a><br> 
                          <a href="<?php echo web_root; ?>index.php?q=register/customer" class="text-center">Register New Customer</a>

                        </div>
                        <!-- /.login-box-body -->
                      </div>
                  </div>

                  <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal">Close</button> <button class="btn btn-primary"
                    name="btnlogin" id="btnlogin"  >Login</button>
                  </div>
                <!-- </form> -->
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
          </div><!-- /.modal --> 


            <!-- Modal -->
          <div class="modal fade" id="myModalcart_login" tabindex="-1">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button class="close" data-dismiss="modal" type=
                  "button">×</button>

                  <h4 class="modal-title" id="myModalLabel">Login</h4>
                </div>

                <!-- <form action="process.php?action=login" enctype="multipart/form-data" method="post"> -->
                  <div class="modal-body hold-transition login-page">
                    <div id="loginerrormessage_cart"></div>
                    
                    <div class="login-box"> 
                        <div class="login-box-body" style="border: solid 1px #ddd;padding: 35px;min-height: 350px;"> 
                            <div class="form-group has-feedback">
                              <input type="text" class="form-control" placeholder="Username" name="user_email" id="user_email_cart">
                              <span class="fa fa-user form-control-feedback" style="margin-top: -22px;"></span>
                            </div>
                            <div class="form-group has-feedback">
                              <input type="password" class="form-control" placeholder="Password" name="user_pass" id="user_pass_cart">
                              <span class="fa fa-lock form-control-feedback" style="margin-top: -22px;"></span>
                            </div>
                            <div class="row">
                              <div class="col-xs-8">
                                <div class="checkbox icheck">
                                  <label>
                                    <input type="checkbox"> Remember Me
                                  </label>
                                </div>
                              </div>
                              <!-- /.col -->
                              <div class="col-xs-4">
                                
                              </div>
                              <!-- /.col -->
                            </div>
                          
                          <a href="<?php echo web_root; ?>forgotpassword.php">Forgot Passsword</a><br>
                          <a href="<?php echo web_root; ?>index.php?q=register/customer" class="text-center">Register New Customer</a>
                        </div>
                        <!-- /.login-box-body -->
                      </div>
                  </div>

                  <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal">Close</button> <button class="btn btn-primary"
                    name="btnlogin_cart" id="btnlogin_cart"  >Login</button>
                  </div>

                <!-- </form> -->
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
          </div><!-- /.modal --> 


            <div class="modal fade" id="myModal_Rating" tabindex="-1">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button class="close" data-dismiss="modal" type=
                  "button">×</button>

                  <h4 class="modal-title" id="myModalLabel">Login</h4>
                </div>

                <!-- <form action="process.php?action=login" enctype="multipart/form-data" method="post"> -->
                  <div class="modal-body hold-transition login-page">
                    <div id="loginerrormessage_rating"></div>
                    <div class="login-box"> 
                        <div class="login-box-body" style="border: solid 1px #ddd;padding: 35px;min-height: 350px;"> 
                            <div class="form-group has-feedback">
                              <input type="hidden" id="storeid">
                              <input type="text" class="form-control" placeholder="Username" name="user_email" id="user_email_rating">
                              <span class="fa fa-user form-control-feedback" style="margin-top: -22px;"></span>
                            </div>
                            <div class="form-group has-feedback">
                              <input type="password" class="form-control" placeholder="Password" name="user_pass" id="user_pass_rating">
                              <span class="fa fa-lock form-control-feedback" style="margin-top: -22px;"></span>
                            </div>
                            <div class="row">
                              <div class="col-xs-8">
                                <div class="checkbox icheck">
                                  <label>
                                    <input type="checkbox"> Remember Me
                                  </label>
                                </div>
                              </div>
                              <!-- /.col -->
                              <div class="col-xs-4">
                                
                              </div>
                              <!-- /.col -->
                            </div>
                          
                          <a href="#">Forgot Passsword</a><br>
                          <a href="<?php echo web_root; ?>index.php?q=register/customer" class="text-center">Register New Customer</a>

                        </div>
                        <!-- /.login-box-body -->
                      </div>
                  </div>

                  <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal">Close</button> <button class="btn btn-primary"
                    name="btnLoginRating" id="btnLoginRating"  >Login</button>
                  </div>
                <!-- </form> -->
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
          </div><!-- /.modal --> 

            <div class="modal fade" id="myModal_SendMessage" tabindex="-1">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button class="close" data-dismiss="modal" type=
                  "button">×</button>

                  <h4 class="modal-title" id="myModalLabel">Login</h4>
                </div>

                <!-- <form action="process.php?action=login" enctype="multipart/form-data" method="post"> -->
                  <div class="modal-body hold-transition login-page">
                    <div id="loginerrormessage_message"></div>
                    <div class="login-box"> 
                        <div class="login-box-body" style="border: solid 1px #ddd;padding: 35px;min-height: 350px;"> 
                            <div class="form-group has-feedback">
                              <input type="hidden" id="storeid">
                              <input type="text" class="form-control" placeholder="Username" name="user_email" id="user_email_message">
                              <span class="fa fa-user form-control-feedback" style="margin-top: -22px;"></span>
                            </div>
                            <div class="form-group has-feedback">
                              <input type="password" class="form-control" placeholder="Password" name="user_pass" id="user_pass_message">
                              <span class="fa fa-lock form-control-feedback" style="margin-top: -22px;"></span>
                            </div>
                            <div class="row">
                              <div class="col-xs-8">
                                <div class="checkbox icheck">
                                  <label>
                                    <input type="checkbox"> Remember Me
                                  </label>
                                </div>
                              </div>
                              <!-- /.col -->
                              <div class="col-xs-4">
                                
                              </div>
                              <!-- /.col -->
                            </div>
                          
                          <a href="#">Forgot Passsword</a><br>
                          <a href="<?php echo web_root; ?>index.php?q=register/customer" class="text-center">Register New Customer</a>

                        </div>
                        <!-- /.login-box-body -->
                      </div>
                  </div>

                  <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal">Close</button> <button class="btn btn-primary"
                    name="btnLoginMessage" id="btnLoginMessage"  >Login</button>
                  </div>
                <!-- </form> -->
              </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
          </div><!-- /.modal --> 