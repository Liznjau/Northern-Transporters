<!DOCTYPE html>
<?php
     session_start();
     $errors=array();

     if(!isset($_SESSION['username'])){
       header('location:customer-login.php');
     }

     //Connect to the database
     $connect = mysqli_connect('localhost', 'root', '5987', 'database');

     $username= $_SESSION['username'];
     $rental_id=$_GET['rental'];
     $customer_id=$_GET['customer'];
     $plate=$_GET['plate'];


          if(isset($_POST['submit-check'])){
            $pay_type = mysqli_real_escape_string($connect, $_POST['pay_type']);


            $qresult= mysqli_query($connect, "UPDATE `vehicle` SET `status` = '0' WHERE `vehicle`.`vehicle_plate` = '$plate'");
            if($qresult){
              //echo $pay_type;
               $_SESSION['paysuccess']= "The truck you rented will be delivered as soon as you finish the payments! Thank you for using our services<br/> Rental id:".$rental_id."<br/>Truck plate:".$plate;
               header('location:process.php?rental='.$rental.'&plate='.$plate.'');
            }
          }

 ?>


<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta property="og:title" content="Vide" />
<meta name="keywords" content="" />

<title>Customer Checkout | Northern Travellers</title>

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
               <a href="customer-page.php?logout-customer='1'"><span class="highlight"><?php echo $username; ?></span> (Log Out)</a>
               <?php
                    if(isset($_GET['logout-customer'])){
                      unset($_SESSION['username']);
                      session_destroy();
                      header('location:customer-login.php');
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
             <a class="" href="customer-viewOrders.php">
               <i class="icon_documents_alt"></i>
               <span>My Orders</span>
             </a>
           </li>
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
           <li class="highlight">Checkout</li>
        </ol>

        <section class="panel">
          <div class="panel panel-default feedback-c">
                <div class="panel-heading">
                  <div class="pull-left">PAYMENT</div>
                  <div class="clearfix"></div>
                </div>
                <div class="panel-body">
                  <form method="post" action="" class="form-horizontal">
                        <div class="form-group">
                            <label for="card_type" class="col-lg-2 control-label">Type</label>
                            <div class="col-lg-10">
                              	<select class="form-control" name="pay_type">
                                  	<option value="MPESA">MPESA</option>
                                    <option value="CASH">CASH</option>
                              	</select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-10 col-lg-offset-2">
                              	<button type="reset" class="btn btn-default">Cancel</button>
                              	<button type="submit" name="submit-check" class="btn btn-primary">RENT</button>
                            </div>
                        </div>
                    </form>
                	<p class="lead">Please press rent to confirm your booking, or cancel.</p>

                </div>
              </div>

        </section>


      </div>
    </section>

  </section>


  <script src="js/jquery-1.11.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</body>
</html>
