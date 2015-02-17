<?php
include_once './includes/db_connect.php'
?>
<!DOCTYPE HTML>
<html>
    <head>

        <!-- Favicon Kini -->
        <link rel="apple-touch-icon" sizes="57x57" href="images/favicons/apple-touch-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="images/favicons/apple-touch-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="images/favicons/apple-touch-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="images/favicons/apple-touch-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="images/favicons/apple-touch-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="images/favicons/apple-touch-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="images/favicons/apple-touch-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="images/favicons/apple-touch-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="images/favicons/apple-touch-icon-180x180.png">
        <link rel="icon" type="image/png" href="images/favicons/favicon-32x32.png" sizes="32x32">
        <link rel="icon" type="image/png" href="images/favicons/android-chrome-192x192.png" sizes="192x192">
        <link rel="icon" type="image/png" href="images/favicons/favicon-96x96.png" sizes="96x96">
        <link rel="icon" type="image/png" href="images/favicons/favicon-16x16.png" sizes="16x16">
        <link rel="manifest" href="images/favicons/manifest.json">
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="msapplication-TileImage" content="images/favicons/mstile-144x144.png">
        <meta name="theme-color" content="#ffffff">

        <!-- End of Favicon Kini -->
        <title>Login</title>
        <script type="text/javascript" src="http://ajax.googleapis.com/
        ajax/libs/jquery/1.5/jquery.min.js"></script>
        <script type="application/javascript">
            $(document).ready(function()
            {
                
            $(".tab").click(function()
            {
                var X=$(this).attr('id');
             
            if(X=='evaluate')
            {
                $("#login").removeClass('select');
                $("#evaluate").addClass('select');
                $("#loginbox").slideUp();
                $("#evalbox").slideDown();
            }
            else
            {
                $("#evaluate").removeClass('select');
                $("#login").addClass('select');
                $("#evalbox").slideUp();
                $("#loginbox").slideDown();
            }
             
            });

            });
        </script>
        <!-- Bootstrap -->
        <link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
        <link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
       <![endif]-->
        <link href="css/style.css" rel="stylesheet" type="text/css" media="all" />
        <!-- start plugins -->
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script type="text/javascript" src="js/bootstrap.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <!-- start slider -->
        <link href="css/slider.css" rel="stylesheet" type="text/css" media="all" />
        <link href="css/style.custom.css" rel='stylesheet' type='text/css' />
        <script type="text/javascript" src="js/modernizr.custom.28468.js"></script>
        <!-- //Owl Carousel Assets -->
        <!--font-Awesome-->
        <link rel="stylesheet" href="fonts/css/font-awesome.min.css">
        <!--font-Awesome-->
    </head>
    <body>
        <div class="header_bg">
            <div class="container">
                <div class="row header">
                    <div class="logo navbar-left">
                        <h1><a href="index.html">Faculty Course Evaluation</a></h1>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row h_menu">
                <nav class="navbar navbar-default navbar-left" role="navigation">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav">
                        </ul>
                    </div><!-- /.navbar-collapse -->
                    <!-- start soc_icons -->
                </nav>
            </div>
        </div>
        <div class="container" style="margin-top: 30px">
        
            <div class="main row">
                <div class="col-xs-4 images_1_of_4 bg1 text-center"></div>      
                <div class="col-xs-4 text-center border loginbox">
                    <div id="tabbox">
                        <a href="#" id="evaluate" class="tab evaluate">Evaluate</a>
                        <a href="#" id="login" class="tab select">Login</a>
                        </div>
                        <div id="panel">
                        <div id="loginbox"><form method="post" action="includes/login.php" class="para"><br /><br />
                                                <input type="text" name="email" placeholder=" Email" class="round down"><BR><BR>
                                                <input type="password" name="password" placeholder=" Password" class="round">
                                                <p></p>
                                                <button class="black-btn">LOG IN</button>
                                            </form>
                                            <div class="error">
                                                <?php
                                                    if (isset($_SESSION['errl'])) {
                                                    $err = $_SESSION['errl'];                            
                                                    echo "<h5>Sorry, $err</h5>";
                                                    unset($_SESSION['errl']); // Destroys the err session variable
                                                    }
                                                ?>
                    </div>
                </div>
                        <div id="evalbox"><form method="post" name="" class="para" action="includes/evaluate.php">
                                                <p></p>
                                                <br /><br />
                                                <input type="text" name='key_value' placeholder=" Access Key" class="round" required pattern=".{5,5}" title="Exactly 5 characters" maxlength='5'><br>
                                                <br><br><p></p>
                                                <button class="black-btn">EVALUATE</button>
                                            </form>
                                            <div class="error">
                                                <?php
                                                    if (isset($_SESSION['erre'])) {
                                                    $err = $_SESSION['erre'];                            
                                                    echo "<h5>Sorry, $err</h5>";
                                                    unset($_SESSION['erre']); // Destroys the err session variable
                                                    }
                                                ?>
                                                
                                            </div></div>
                        </div>
                    <!--<form method="post" name="" class="para" action="includes/evaluate.php">
                        <p></p>
                        <input type="text" name='key_value' placeholder=" Access Key" class="round" required pattern=".{5,5}" title="Exactly 5 characters" maxlength='5'><br>
                        <br><br><p></p>
                        <button class="fa-btn btn-1 btn-1e">EVALUATE</button>
                    </form>
                    <div class="error">
                        <?php
                            if (isset($_SESSION['erre'])) {
                            $err = $_SESSION['erre'];                            
                            echo "<h5>Sorry, $err</h5>";
                            unset($_SESSION['erre']); // Destroys the err session variable
                            }
                        ?>
                        
                    </div>
                </div>
                <div class="col-md-6 text-center"></div>	
                <div class="col-md-3 text-center border">
                    <form method="post" action="includes/login.php" class="para">
                        <input type="text" name="email" placeholder=" Email" class="round"><BR><BR>
                        <input type="password" name="password" placeholder=" Password" class="round">
                        <p></p>
                        <button class="fa-btn btn-1 btn-1e">LOG IN</button>
                    </form>
                    <div class="error">
                        <?php
                            if (isset($_SESSION['errl'])) {
                            $err = $_SESSION['errl'];                            
                            echo "<h5>Sorry, $err</h5>";
                            unset($_SESSION['errl']); // Destroys the err session variable
                            }
                        ?>
                        -->
                    </div>
                </div>	
                <div class="col-md-6 text-center"></div>	
            </div>
            
        </div>

    <FOOTER>
        <div class="footer_bg"><!-- start footer -->
            <div class="container">
                <div class="row  footer">
                    <div class="copy text-center">
                        <p class="link"><span>&#169; All rights reserved | Design by&nbsp;<a href="thankyou.php#fceteam"> The FCE Team</a></span></p>
                    </div>
                </div>
            </div>
        </div>
    </FOOTER>
</body>
</html>