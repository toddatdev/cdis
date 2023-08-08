<!doctype html>
<title>Site Maintenance</title>
<style>
    body { text-align: center; padding: 150px; }
    h1 { font-size: 50px; }
    body { font: 20px Helvetica, sans-serif; color: #333; }
    article { display: block; text-align: left; width: 650px; margin: 0 auto; }
    a { color: #dc8100; text-decoration: none; }
    a:hover { color: #333; text-decoration: none; }
</style>

<article>
    <h1>We&rsquo;ll be back soon!</h1>
    <div>
        <p>Sorry for the inconvenience but we&rsquo;re performing some maintenance at the moment. If you need to you can always <a href="mailto:#">contact us</a>, otherwise we&rsquo;ll be back online shortly!</p>
        <p>&mdash; The Team</p>
    </div>
</article>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Conservation District Information System">
    <meta name="author" content="RealTechs">
    <link rel="shortcut icon" href="assets2/ico/favicon.png">
    <title>U.S. Conservation District</title>
    <!-- Bootstrap Core CSS -->
    <link href="assets2/bootstrap/css/bootstrap.css" rel="stylesheet">
    <!-- Plugins CSS -->
    <link href="assets2/UItoTop/css/ui.totop.css" rel="stylesheet">
    <link href="assets2/prettyPhoto/css/prettyPhoto.css" rel="stylesheet">
    <!-- REVOLUTION BANNER CSS SETTINGS -->
    <link rel="stylesheet" type="text/css" href="assets2/rs-plugin/css/settings.css" media="screen" />
    <!-- Font Awesome  -->
    <link href="assets2/font-awesome-4.0.1/css/font-awesome.min.css" rel="stylesheet">
    <!-- Custom Stylesheet For This Template -->
    <link href="assets2/css/stylesheet.css" rel="stylesheet">
    <link href="assets2/css/normalize.css" rel="stylesheet">
    <link href="assets2/css/skins.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic|Montserrat:400,700' rel='stylesheet' type='text/css'>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="assets2/js/html5shiv.js"></script>
    <script src="assets2/js/respond.min.js"></script>
    <![endif]-->
</head>
<body><!--[if IE]> body { zoom: 125%; } <![endif]-->
<div id="utter-wrapper" class="color-skin-1">
    <header id="header" class="header" data-spy="affix" data-offset-top="10">
        <nav class="navbar navbar-default" role="navigation">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <a href="index.html">
                    <table class="navbar-brand" width="100%" border="0" cellpadding="2px">
                        <tbody>
                        <tr>
                            <td width="11%"><img src="assets2/img/CDISLogo1.png" class="img-responsive2" alt="CDIS Logo"/></td>
                            <td><span>Conservation District Information System</span><span style="color:#0378C1;font-size:14px; font-style:italic; line-height:9px;"><br>Preserving and Protecting Natural Resources</span></td>
                        </tr>
                        </tbody>
                    </table>
                </a>
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->

                <!-- *********************************************************
                    UNCOMMENT BELOW THIS LINE TO BRING NAVBAR BACK
                ************************************************************-->
                <!-- <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <ul class="nav navbar-nav">
                        <li class="dropdown">
                            <a href="index.html" class="dropdown-toggle">Home</a>
                        </li>

                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Contact</a>
                            <ul class="dropdown-menu">
                                <li><a href="#">General Contact Form</a></li>
                                <li><a href="#">MCCD Forms Submission</a></li>
                                <li><a href="#">MCCD Plans Submission</a></li>
                            </ul>
                        </li>
                        <li class="dropdown active">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Login</a>
                            <ul class="dropdown-menu">
                                <li><a href="#">Site Owner</a></li>
                                <li><a href="#">Contractor</a></li>
                                <li><a href="CDISLogin.html">CDIS Users</a></li>
                            </ul>
                        </li>
                    </ul>

                </div> -->

                <!-- *********************************************************
                    UNCOMMENT ABOVE THIS LINE TO BRING NAVBAR BACK
                ************************************************************-->

                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container -->
        </nav>
        <!-- /.navbar -->
    </header>
    <!-- /#header -->
    <div id="index-1" class="main-wrapper">
        <section id="action-box" class="pad-25">
            <div class="container">
                <div>&nbsp;</div>
                <div>&nbsp;</div>
                <div class="row" align="center">
                    <div class="col-md-3">&nbsp;</div>
                    <div class="col-md-6">
                        <div class="action-box" style="background-color:#E0ECFD;">
                            <h4><center>CDIS Login</center></h4>
                            <div>&nbsp;</div>
                            <div>&nbsp;</div>
                            <form id="MCCDLogin" name="MCCDLogin" action="#" method="POST">
                                <div class="row">
                                    <div class="col-md-3">&nbsp;</div>
                                    <div class="col-md-6">
                                        <label>User Name *</label>
                                        <input id="username" name="username" class="form-control" data-msg-required="Please enter your User Name." placeholder="UserName (required)" type="text">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">&nbsp;</div>
                                    <div class="col-md-6">
                                        <label>Password *</label>
                                        <input id="password" name="password" class="form-control" data-msg-required="Please enter your Password." placeholder="Password (required)" type="password">
                                    </div>
                                </div>
                                <div class="row" id="error">
                                    <div class="col-md-3">&nbsp;</div>
                                    <div class="col-md-6">
                                        <div>
                                            <strong style="color:#F00" id="errormsg1"></strong>
                                        </div>
                                    </div>
                                </div>
                                <div>&nbsp;</div>
                                <div class="row">
                                    <div class="col-md-3">&nbsp;</div>
                                    <div class="col-md-6" align="center">
                                        <input type="button" id="login" name="login" value="Login" class="btn btn-flat flat-color btn-rounded" data-loading-text="Loading...">
                                    </div>
                                </div>
                                <div>&nbsp;</div>
                                <div>* = REQUIRED</div>
                            </form>
                        </div>
                    </div>
                    <!-- /.action-box -->
                </div>
                <p>&nbsp;</p>
            </div>
            <!-- /.container -->
        </section>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
    </div>
    <!-- /.main-wrapper -->
    <footer id="footer-1" class="footer">
        <div class="container">
            <div class="row">
                <!-- **************************************************
                COMMENTED OUT FROM HERE
                ************************************************** -->

                <!-- <div class="col-md-3">
                    <div class="widget about-us">
                        <div class="footer-brand">Conservation District <span>Information System</span></div>
                        <p>To protect and improve the quality of life of the residents and surrounding communities by providing, in cooperation with others, timely and efficient service, education, and technical guidance, for the wise use of our soil, water, and related resources.</p>
                    </div>

                    <div class="widget stay-connected">
                        <div class="subpage-title">
                            <h5>Stay Connected</h5>
                        </div>
                        <ul class="social-links">
                            <li><a class="facebook" href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a class="google-plus" href="#"><i class="fa fa-google-plus"></i></a></li>
                            <li><a class="twitter" href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a class="pinterest" href="#"><i class="fa fa-pinterest"></i></a></li>
                            <li><a class="rss" href="#"><i class="fa fa-rss"></i></a></li>
                        </ul>
                    </div>
                </div> -->

                <!-- **************************************************
TO HERE
************************************************** -->
                <!-- /.col-md-3 -->
                <!-- **************************************************
COMMENTED OUT FROM HERE
************************************************** -->
                <!--   <div class="col-md-3">
                      <div class="widget popular-posts">
                          <div class="subpage-title">
                              <h5>Popular Posts</h5>
                          </div>
                          <ul class="recent-posts">
                              <li>
                                  <img src="assets2/img/blog/recent-posts/dozer1.jpg" alt="Post Image">
                                  <h5>
                                      <a href="#">Proper Site Planning for Land Clearing</a>
                                      <small>Posted July 20, 2014</small>
                                  </h5>
                              </li>
                              <li>
                                  <img src="assets2/img/blog/recent-posts/basin2.jpg" alt="Post Image">
                                  <h5>
                                      <a href="#">Rentention Basin Contrsuction Basics</a>
                                      <small>Posted July 15, 2014</small>
                                  </h5>
                              </li>
                              <li>
                                  <img src="assets2/img/blog/recent-posts/siltfence1.jpg" alt="Post Image">
                                  <h5>
                                      <a href="#">Types of Silt Fence Based on Control Issue</a>
                                      <small>Posted July 10, 2014</small>
                                  </h5>
                              </li>
                          </ul>
                      </div> -->
                <!-- **************************************************
              TO HERE
              ************************************************** -->
                <!-- /.popular-posts -->
            </div>
            <!-- /.col-md-3 -->
            <div class="col-md-3">
                <div class="widget tagcloud">


                    <!-- **************************************************
                    COMMENTED OUT FROM HERE
                    ************************************************** -->

                    <!-- <div class="subpage-title">
                        <h5>Some Tags</h5>
                    </div>
                    <ul class="tagcloud-list">
                        <li><a href="#">conservation</a></li>
                        <li><a href="#">district</a></li>
                        <li><a href="#">information</a></li>
                        <li><a href="#">system</a></li>
                        <li><a href="#">erosion</a> </li>
                        <li><a href="#">water</a></li>
                        <li><a href="#">soil</a></li>
                        <li><a href="#">trees</a></li>
                        <li><a href="#">environment</a></li>
                        <li><a href="#">resources</a></li>
                        <li><a href="#">site plans</a></li>
                        <li><a href="#">PA DEP</a></li>
                        <li><a href="#">codes &amp; laws</a></li>
                        <li><a href="#">enforcement</a></li>
                    </ul>
                </div> -->



                    <!-- **************************************************
TO HERE
************************************************** -->
                    <!-- /.tagcloud -->
                </div>
                <!-- /.col-md-3 -->

                <!-- **************************************************
                COMMENTED OUT FROM HERE
                ************************************************** -->
                <!-- <div class="col-md-3">
                    <div class="widget about-us">
                        <div class="subpage-title">
                            <h5>Contact Information</h5>
                        </div>
                            <p class="fa fa-map-marker"><strong><font style="font-size:14px; color:#2C3E50; font-family:Open Sans,sans-serif;"> 123 main Street<br>&nbsp;&nbsp;&nbsp;&nbsp;Everywhere, US</font></strong></p>
                            <p class="fa fa-phone"><strong><font style="font-size:14px; color:#2C3E50; font-family:Open Sans,sans-serif;"> Phone: (212) 555-4000</font></strong></p>
                            <p class="fa fa-phone"><strong><font style="font-size:14px; color:#2C3E50; font-family:Open Sans,sans-serif;"> FAX: (212) 555-5000</font></strong></p>
                            <p class="fa fa-envelope"><strong><font style="font-size:14px; color:#2C3E50; font-family:Open Sans,sans-serif;"> Email:</font></strong>&nbsp;<a href="#"><span class="btn btn-success btn-sm">WEBMAIL</span></a></p>
                    </div> -->

                <!-- **************************************************
TO HERE
************************************************** -->
                <!-- /.about-us -->
            </div>
        </div>
        <!-- /.row -->
</div>
<!-- /.container -->
</footer>
<!-- /#footer-1 -->
<footer id="footer-2" class="footer">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-6 footer-info-wrapper">
                <span>© RealTechs 2014. All Rights Reserved.</span>
            </div>
            <!-- /.footer-info-wrapper -->
            <div class="col-xs-12 col-sm-6 footer-links-wrapper">
                <ul class="list-inline">
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms Of Service</a></li>
                    <li><a href="#">Disclaimer</a></li>
                </ul>
            </div>
            <!-- /.footer-links-wrapper -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container -->
</footer>
</div>
<!-- /#utter-wrapper -->
<!-- Bootstrap JS & Others JavaScript Plugins
    ================================================== -->
<!-- Placed At The End Of The Document So Page Loads Faster -->
<script src="assets2/js/jquery-2.0.3.min.js"></script>
<script src="assets2/js/jquery-migrate-1.2.1.min.js"></script>
<script src="assets2/bootstrap/js/bootstrap.min.js"></script>
<script src="assets2/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>
<script src="assets2/UItoTop/js/easing.js"></script>
<script src="assets2/UItoTop/js/jquery.ui.totop.min.js"></script>
<script src="assets2/isotope-site/jquery.isotope.min.js"></script>
<script src="assets2/FitVids.js/jquery.fitvids.js"></script>
<script src="assets2/js/login.js"></script>

</body>
</html>
</html>
