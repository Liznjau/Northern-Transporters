<!DOCTYPE html>
<?php
     session_start();

     //Connect to the database
     $connect = mysqli_connect('localhost', '', '', 'database');

?>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta property="og:title" content="Vide" />
<meta name="keywords" content="" />

<title>All vehicles Transporters</title>

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
           <li><a href="index.php" class="smoothScroll">HOME</a></li>
           <li><a href="allVehicles.php" class="smoothScroll"><span class="highlight">VEHICLES</span></a></li>

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

  <section id="login-banner">
    <div class="container">
      <ol class="breadcrumb" id="breadcrumb">
         <li><i class="fa fa-home"></i><a href="index.php">Home</a></li>
         <li class="highlight">All trucks</li>
      </ol>

      <section class="panel">
          <header class="panel-heading title1">
              AVAILABLE TRUCKS
          </header>
          <div class="row">
            <?php
            $query = "SELECT * FROM vehicle WHERE status=1";
            $result = mysqli_query($connect, $query);
            $i=1;
             while($truck=mysqli_fetch_assoc($result)){
               ?>
            <div class="col-md-4 ">
              <div class="intro-wrap"><img src="images/img<?php echo $i; ?>.jpg" class="img-responsive" alt="Embodied Enlightenment"></a>
                 <div class="caption">
                    <h4>Model: <?php echo $truck['vehicle_model']; ?></h4>
                    <p style="text-align:center;"><span style="font-size:20px;">ID: <?php echo $truck['vehicle_plate']; ?></span></p>

                    <a href='customerAddLoad.php?plate=<?php echo $truck['vehicle_plate']; ?>'  class='form-control btn-default btn-submit'>RENT TRUCK</a>
               </div>
              </div>
            </div>

            <?php $i++; } ?>

          </div>

      </section>


    </div>
  </section>


  </section>





  <script src="js/jquery-1.11.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</body>
</html>
