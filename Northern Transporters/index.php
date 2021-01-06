<!DOCTYPE html>
<?php
     session_start();

?>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta property="og:title" content="Vide" />
<meta name="keywords" content="" />

<title>Welcome to Transporters</title>

<link rel="icon" href="images/" type="image/x-icon">
<link rel="shortcut icon" href="images/logo icon.png">
<link rel="stylesheet" href="css/bootstrap.min.css">
<link href="css/elegant-icons-style.css" rel="stylesheet" />
<link rel="stylesheet" href="css/font-awesome.min.css">
<link rel="stylesheet" href="css/layout.css">
</head>
<body>
  <section id="banner">
  <nav>
    <div class="navbar-default">
      <div class="container">
        <div class="navbar-header">
          <button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
             <span class="icon icon-bar"></span>
             <span class="icon icon-bar"></span>
             <span class="icon icon-bar"></span>
          </button>
          <h2><span class="highlight">Northern </span> Transporters</h2>
        </div>
        <div class="collapse navbar-collapse">
         <ul class="nav navbar-nav navbar-right">
           <li><a href="index.php" class="smoothScroll"><span class="highlight">HOME</span></a></li>
           <li><a href="allVehicles.php" class="smoothScroll">VEHICLES</a></li>

           <?php if(isset($_SESSION['username'])){ ?>
             <li class="dropdown"><a data-toggle="dropdown" class="dropdown-toggle" href="#">
                  <span class="profile-ava"><img alt="" src="server/profile-images/<?php echo $_SESSION['profile']; ?>"></span>
                  <span class="username"><?php
                       echo $_SESSION['username'];
                   ?></span>
                  <b class="caret"></b>
                </a>
                <ul class="dropdown-menu extended logout">
                  <div class="log-arrow-up"></div>
                    <li class="eborder-top">
                      <a href="customer-page.php"><i class="icon_profile"></i> My Profile</a>
                    </li>
                    <li>
                        <a href="index.php?logout-customer='1'"><i class="icon_key_alt"></i> Log Out</a>
                        <?php
                             if(isset($_GET['logout-customer'])){
                               unset($_SESSION['username']);
                               session_destroy();
                               header('location:customer-login.php');
                             }
                        ?>
                    </li>
                </ul>
            </li>
          <?php } elseif(isset($_SESSION['admin-name'])){ ?>
           <li class="dropdown"><a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <span class="username"><?php
                     echo "ADMIN:". $_SESSION['admin-name'];
                 ?></span>
                <b class="caret"></b>
              </a>
              <ul class="dropdown-menu extended logout">
                <div class="log-arrow-up"></div>
                  <li class="eborder-top">
                    <a href="admin-page.php"><i class="icon_profile"></i> My Profile</a>
                  </li>
                  <li>
                      <a href="index.php?logout-admin='1'" name='logout-admin'><i class="icon_key_alt"></i> Log Out</a>
                      <?php
                           if(isset($_GET['logout-admin'])){
                             unset($_SESSION['admin-name']);
                             session_destroy();
                             header('location:admin-login.php');
                           }
                      ?>
                  </li>
              </ul>
          </li>
          <?php }else{ ?>
           <li><a href="customer-login.php" class="smoothScroll">CUSTOMER</a></li>
           <li><a href="admin-login.php" class="smoothScroll">ADMIN</a></li>
         <?php } ?>
         </ul>
       </div>
      </div>
    </div>
  </nav>


      <div class="row">
          <div class="banner-caption">
    				 <h2 >We offer the most affordable and convinient transportations of heavy cargos</h2>
    			</div>

        <div class="logBox">
            <a href="customer-login.php">Customer login</a>
        </div>
      </div>
  </section>

  <section id="service">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
           <h1>Cargo stransportations</h1>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
           <h1>Affordable</h1>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
           <h1>Convinient</h1>
        </div>
      </div>
    </div>
  </section>




  <script src="js/jquery-1.11.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</body>
</html>
