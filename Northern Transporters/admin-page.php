<!DOCTYPE html>
<?php
     session_start();
     $errors=array();

     if(!isset($_SESSION['admin-name'])){
       header('location:admin-login.php');
     }

     //Connect to the database
     $connect = mysqli_connect('localhost', 'root', '5987', 'database');

     $username= $_SESSION['admin-name'];

     $customers= array();
     $vehicles= array();
     $rentals= array();

     $sql = "SELECT * FROM customer";
     $result = mysqli_query($connect, $sql);
     if (mysqli_num_rows($result) > 0){
          while($row = $result->fetch_assoc()){
            array_push($customers, "This is a customer");
          }
        }
        $customer_no= (count($customers));

        $sql2 = "SELECT * FROM vehicle";
        $result2 = mysqli_query($connect, $sql2);
        if (mysqli_num_rows($result2) > 0){
             while($row = $result2->fetch_assoc()){
               array_push($vehicles, "This is a vehicle");
             }
           }
           $vehicles_no= (count($vehicles));

           $sql3 = "SELECT * FROM rental";
           $result3 = mysqli_query($connect, $sql3);
           if (mysqli_num_rows($result3) > 0){
                while($row = $result3->fetch_assoc()){
                  array_push($rentals, "This is a rental");
                }
              }
              $rentals_no= (count($rentals));

 ?>


<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta property="og:title" content="Vide" />
<meta name="keywords" content="" />

<title>Customer Login | Northern Travellers</title>

<link rel="icon" href="images/job3.jpg" type="image/x-icon">
<link rel="shortcut icon" href="images/logo icon.png">
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/font-awesome.min.css">
<link rel="stylesheet" href="css/layout.css">
</head>
<body>
  <section id="banner2">
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
           <li><a href="allVehicles.php" class="smoothScroll">VEHICLES</a></li>
           <li>
               <a href="admin-page.php?logout-admin='1'"><span class="highlight"><?php echo $username; ?></span> (Log Out)</a>
               <?php
                    if(isset($_GET['logout-admin'])){
                      unset($_SESSION['admin-name']);
                      session_destroy();
                      header('location:admin-login.php');
                    }
               ?>
           </li>
         </ul>
       </div>
      </div>
    </div>
  </nav>

  <aside>
      <div id="sidebar" class="nav-collapse " tabindex="5000" style="overflow: hidden; outline: none;">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu">
           <li class="active">
             <a class="" href="student-page.php">
               <i class="icon_house_alt"></i>
               <span>Dashboard</span>
             </a>
           </li>
           <li>
             <a class="" href="admin-viewCustomers.php">
               <i class="icon_profile"></i>
               <span>View customers</span>
             </a>
           </li>
           <li >
             <a class="" href="admin-viewVehicles.php">
               <i class="icon_documents_alt"></i>
               <span>View Vehicles</span>
             </a>
           </li>
           <li>
             <a class="" href="admin-viewRentalrequests.php">
               <i class="icon_documents_alt"></i>
               <span>View rental requests</span>
             </a>
           </li>

         </ul>
        <!-- sidebar menu end-->
      </div>
  </aside>


    <section id="page-banner">
      <div class="container">
        <ol class="breadcrumb" id="breadcrumb">
           <li><i class="fa fa-home"></i><a href="index.php">Home</a></li>
           <li class="highlight">Customer page</li>
        </ol>

        <div class="row">
  				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
  					<div class="info-box blue-bg">
  						<i class="fa fa-user"></i>
  						<div class="count"><?php echo $customer_no; ?></div>
  						<div class="title">Customers</div>
  					</div><!--/.info-box-->
  				</div><!--/.col-->

  				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
  					<div class="info-box brown-bg">
  						<i class="icon_map_alt"></i>
              <div class="count"><?php echo $vehicles_no; ?></div>
                <div class="title">Vehicles</div>
  					</div><!--/.info-box-->
  				</div><!--/.col-->

  				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
  					<div class="info-box dark-bg">
  						<i class="fa fa-photo"></i>
              <div class="count"><?php echo $rentals_no; ?></div>
                <div class="title">Rent requests</div>
  					</div><!--/.info-box-->
  				</div><!--/.col-->

  			</div><!--/.row-->


      </div>
    </section>

  </section>


  <script src="js/jquery-1.11.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</body>
</html>
