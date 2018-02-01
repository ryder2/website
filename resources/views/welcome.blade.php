<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>

    <!-- Basic Page Needs
    ================================================== -->
    <meta charset="utf-8">
    <!--[if IE]><meta http-equiv="x-ua-compatible" content="IE=9" /><![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Road Mecs</title>
    
    <!-- Favicons
    ================================================== -->
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" href="img/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="img/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="img/apple-touch-icon-114x114.png">

    <!-- Bootstrap -->
    <link rel="stylesheet" type="text/css"  href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome/css/font-awesome.css">

    <!-- Slider
    ================================================== -->
    <link href="css/owl.carousel.css" rel="stylesheet" media="screen">
    <link href="css/owl.theme.css" rel="stylesheet" media="screen">

    <!-- Stylesheet
    ================================================== -->
    <link rel="stylesheet" type="text/css"  href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/responsive.css">

    <script type="text/javascript" src="js/modernizr.custom.js"></script>
</head>
<body>
    <!-- Navigation
    ==========================================-->
    <nav id="tf-menu" class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="{{ url('/') }}">Road Mecs</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#tf-home" class="page-scroll">Home</a></li>
        <li><a href="#tf-about" class="page-scroll">About Us</a></li>
        <li><a href="#tf-services" class="page-scroll">Services</a></li>
        <li><a href="#tf-clients" class="page-scroll">Affiliates</a></li>
        <li><a href="#tf-works" class="page-scroll">Book Online</a></li>
        <li><a href="#tf-contact" class="page-scroll">Contact Us</a></li>
        @if (Auth::guest())
        <li><a href="{{ route('login') }}">Login</a></li>
        <li><a href="{{ route('register') }}">Register</a></li>
        @else
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                {{ Auth::user()->name }} <span class="caret"></span>
            </a>

            <ul class="dropdown-menu" role="menu">
                <li>
                    @if(Auth::user()->approuved && Auth::user()->mecano)
                    <a href="{{ url('/home') }}">
                        @endif
                        @if(!Auth::user()->approuved && Auth::user()->mecano)
                        <a href="{{ url('/myprofile') }}">
                            @endif
                            @if(!Auth::user()->mecano)
                            <a href="{{ url('/myoffers') }}">
                                @endif
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            Logout
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </ul>
            </li>
            @endif
        </ul>
    </div><!-- /.navbar-collapse -->
</div><!-- /.container-fluid -->
</nav>

    <!-- Home Page
    ==========================================-->
    <div id="tf-home" class="text-center">
        <div class="overlay">
            <div class="content">
                <h1>Welcome on <strong><span class="color">Road Mecs</span></strong></h1>
                <p class="lead">Taking roadside assistance to <strong>another level</strong> with <strong>extraordinary people</strong></p>
            </br></br>
            <button type="getapp" class="btn tf-btn btn-default1" onclick="window.location.href='https://laravel.dev/login'">Register or Login to get started</button>
        </br>
        <a href="#tf-about" class="fa fa-angle-down page-scroll"></a>
    </div>
</div>
</div>

    <!-- About Us Page
    ==========================================-->
    <div id="tf-about">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <img src="img/coffee.jpg" class="img-responsive">
                </div>
                <div class="col-md-6">
                    <div class="about-text">
                        <div class="section-title">
                            <h4>About us</h4>
                            <h2>Some words <strong>about us</strong></h2>
                            <hr>
                            <div class="clearfix"></div>
                        </div>
                        <p class="intro">Contacting us when needing assistance will grant you knowledge to make your next move. While in need of a particular part, technician, shop or repair, contacting RoadMecs will permit you to find a low cost and quick solution for your car issues. </br></br>
                            Cars are a convenient, necessary or work tool for those in need of a quick or absolute way of transport. Here at RoadMecs with understand the market and availability hours of shops. While the demand is increasing, RoadMecs will find quick solutions and lowest costs for your car problems to be solved.</p>
                            <ul class="about-list">
                                <li>
                                    <span class="fa fa-dot-circle-o"></span>
                                    <strong>Mission</strong> - <em>We deliver uniqueness and quality</em>
                                </li>
                                <li>
                                    <span class="fa fa-dot-circle-o"></span>
                                    <strong>Skills</strong> - <em>Delivering fast and excellent results</em>
                                </li>
                                <li>
                                    <span class="fa fa-dot-circle-o"></span>
                                    <strong>Clients</strong> - <em>Satisfied clients thanks to our experience</em>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <!-- Services Section
    ==========================================-->
    <div id="tf-services" class="text-center">
        <div class="container">
            <div class="section-title center">
                <h2>Take a look at <strong>our services</strong></h2>
                <div class="line">
                    <hr>
                </div>
                <div class="clearfix"></div>
                <small><em>Here at RoadMecs, we engage ourselves at finding the closest technician available in your area. We can also advise you free of charge and find a solution to your car problems from finding the cheapest parts to the closest garage near you.</em></small>
            </div>
            <div class="space"></div>
            <div class="row">
                <div class="col-md-3 col-sm-6 service">
                    <i class="fa fa-graduation-cap"></i>
                    <h4><strong>Dedicated Technicien</strong></h4>
                    <p>You can choose from a large number of technician applying on your offer.</p>
                </div>

                <div class="col-md-3 col-sm-6 service">
                    <i class="fa fa-car"></i>
                    <h4><strong>Car Checks</strong></h4>
                    <p>Free advising by phone while browsing the list of available technicians for a fee, you will always find someone available to assist you with your car issues.</p>
                </div>

                <div class="col-md-3 col-sm-6 service">
                    <i class="fa fa-dashboard"></i>
                    <h4><strong>Oil & Brake Checks</strong></h4>
                    <p>With you lifestyle, not having much time to have a maintenance check on your car? No problem. We have the solution for you. Just reach a technician close to you, able to reach your location and help you with your needs.</p>
                </div>
                
                <div class="col-md-3 col-sm-6 service">
                    <i class="fa fa-road"></i>
                    <h4><strong>Breakdown Service</strong></h4>
                    <p>Many car issues can be fixed where the problem occurred. While in a place permitted by law, a technician can reach you location and repair the issue on the spot.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 col-sm-6 service">
                    <i class="fa fa-database"></i>
                    <h4><strong>Tire Change</strong></h4>
                    <p>Avoiding distant appointments and leaving your car for the day? We will engage ourselves to send you a technician to your location and have your tires changed or repaired without leaving the comfort of your house.</p>
                </div>
                
                <div class="col-md-3 col-sm-6 service">
                    <i class="fa fa-flash"></i>
                    <h4><strong>Battery Change</strong></h4>
                    <p>While cold seasons approach, or battery life ends without warning, available technicians can assist you with diagnosing the charge system and replacing the battery on the spot.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Clients Section
    ==========================================-->
    <div id="tf-clients" class="text-center">
        <div class="overlay">
            <div class="container">

                <div class="section-title center">
                    <h2>Associate only with <strong>quality</strong> providers</h2>
                    <div class="line">
                        <hr>
                    </div>
                </div>
                <div id="clients" class="owl-carousel owl-theme">
                    <div class="item">
                        Put image here
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Portfolio Section
    ==========================================-->
    <div id="tf-works">
        <div class="container"> <!-- Container -->
            <div class="section-title text-center center">
                <h2>Book online <strong>now</strong></h2>
                <div class="line">
                    <hr>
                </div>
                <div class="clearfix"></div>
                <small><em>Anywhere you are, anywhere you go. Connect with a professionnal advisor and a mechanic near you for assistance with your car issues.</em></small>
            </div>
            <div class="space"></div>

            <div class="categories">
                
                <ul class="cat">
                    <li class="pull-left"><h4>Filter by Type:</h4></li>
                    <li class="pull-right">
                        <ol class="type">
                            <li><a href="#" data-filter="*" class="active">All</a></li>
                            <li><a href="#" data-filter=".tires">Tire Change</a></li>
                            <li><a href="#" data-filter=".oilbrake">Oil & Brake Check</a></li>
                            <li><a href="#" data-filter=".battery" >Battery Change</a></li>
                            <li><a href="#" data-filter=".brakedown" >Brake Down Service</a></li>
                            <li><a href="#" data-filter=".services" >Services</a></li>
                        </ol>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>

            <div id="lightbox" class="row">

                <div class="col-sm-6 col-md-3 col-lg-3 tires">
                    <div class="portfolio-item">
                        <div class="hover-bg">
                            <a href="{{ url('/addoffer') }}">
                                <div class="hover-text">
                                    <h4>Tire Change</h4>
                                    <small>Mounted Tires</small>
                                    <div class="clearfix"></div>
                                    <i class="fa fa-plus"></i>
                                </div>
                                <img src="img/portfolio/01.jpg" class="img-responsive" alt="...">
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-3 col-lg-3 tires">
                    <div class="portfolio-item">
                        <div class="hover-bg">
                            <a href="{{ url('/addoffer') }}">
                                <div class="hover-text">
                                    <h4>Tire Change</h4>
                                    <small>Unmounted Tires</small>
                                    <div class="clearfix"></div>
                                    <i class="fa fa-plus"></i>
                                </div>
                                <img src="img/portfolio/02.jpg" class="img-responsive" alt="...">
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-3 col-lg-3 oilbrake">
                    <div class="portfolio-item">
                        <div class="hover-bg">
                            <a href="{{ url('/addoffer') }}">
                                <div class="hover-text">
                                    <h4>Oil Change</h4>
                                    <small>Synthetic/Regular</small>
                                    <div class="clearfix"></div>
                                    <i class="fa fa-plus"></i>
                                </div>
                                <img src="img/portfolio/03.jpg" class="img-responsive" alt="...">
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-3 col-lg-3 oilbrake">
                    <div class="portfolio-item">
                        <div class="hover-bg">
                            <a href="{{ url('/addoffer') }}">
                                <div class="hover-text">
                                    <h4>Brake Check/Change</h4>
                                    <small>Discs/Drums</small>
                                    <div class="clearfix"></div>
                                    <i class="fa fa-plus"></i>
                                </div>
                                <img src="img/portfolio/04.jpg" class="img-responsive" alt="...">
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-3 col-lg-3 battery">
                    <div class="portfolio-item">
                        <div class="hover-bg">
                            <a href="{{ url('/addoffer') }}">
                                <div class="hover-text">
                                    <h4>Battery</h4>
                                    <small>Change/Test</small>
                                    <div class="clearfix"></div>
                                    <i class="fa fa-plus"></i>
                                </div>
                                <img src="img/portfolio/05.jpg" class="img-responsive" alt="...">
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-3 col-lg-3 brakedown">
                    <div class="portfolio-item">
                        <div class="hover-bg">
                            <a href="{{ url('/addoffer') }}">
                                <div class="hover-text">
                                    <h4>Towing</h4>
                                    <small>4x4/Regular</small>
                                    <div class="clearfix"></div>
                                    <i class="fa fa-plus"></i>
                                </div>
                                <img src="img/portfolio/06.jpg" class="img-responsive" alt="...">
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-3 col-lg-3 brakedown battery">
                    <div class="portfolio-item">
                        <div class="hover-bg">
                            <a href="{{ url('/addoffer') }}">
                                <div class="hover-text">
                                    <h4>Battery Boost</h4>
                                    <small>Jumper Cable/Battery Pack</small>
                                    <div class="clearfix"></div>
                                    <i class="fa fa-plus"></i>
                                </div>
                                <img src="img/portfolio/07.jpg" class="img-responsive" alt="...">
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6 col-md-3 col-lg-3 services">
                    <div class="portfolio-item">
                        <div class="hover-bg">
                            <a href="{{ url('/addoffer') }}">
                                <div class="hover-text">
                                    <h4>Light Change</h4>
                                    <small>Brake/Headlight/Flasher/...</small>
                                    <div class="clearfix"></div>
                                    <i class="fa fa-plus"></i>
                                </div>
                                <img src="img/portfolio/08.jpg" class="img-responsive" alt="...">
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Contact Section
    ==========================================-->
    <div id="tf-contact" class="text-center">
        <div class="container">

            <div class="row">
                <div class="col-md-8 col-md-offset-2">

                    <div class="section-title center">
                        <h2>Feel free to <strong>contact us</strong></h2>
                        <div class="line">
                            <hr>
                        </div>
                        <div class="clearfix"></div>
                        <small><em>The quality of our service is important to us. Do not hesitate to contact us for any comments or suggestions</em></small>            
                    </div>

                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email address</label>
                                    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Message</label>
                            <textarea class="form-control" rows="3"></textarea>
                        </div>
                        
                        <button type="submit" class="btn tf-btn btn-default">Submit</button>
                    </form>

                </div>
            </div>

        </div>
    </div>

    
    <nav id="footer">
        <div class="container">
            <div class="pull-left fnav">
                <ul class="footer-social">
                    <li><i class="fa fa-phone"></i>&nbsp;&nbsp;CALL US : 1-514-555-1234 or Follow us on social media to be aware of all news.</li>
                </ul>
            </div>
            <div class="pull-right fnav">
                <ul class="footer-social">
                    <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="#"><i class="fa fa-dribbble"></i></a></li>
                    <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                    <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                </ul>
            </div>
        </div>
    </nav>


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script type="text/javascript" src="js/jquery.1.11.1.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script type="text/javascript" src="js/bootstrap.js"></script>
    <script type="text/javascript" src="js/SmoothScroll.js"></script>
    <script type="text/javascript" src="js/jquery.isotope.js"></script>

    <script src="js/owl.carousel.js"></script>

    <!-- Javascripts
    ================================================== -->
    <script type="text/javascript" src="js/main.js"></script>
</body>


</html>
