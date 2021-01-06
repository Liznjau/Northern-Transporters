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
           <li class="highlight">Customer page</li>
        </ol>

        <section class="panel">
          <div class="panel panel-default feedback-c">
                <div class="panel-heading">
                  <div class="pull-left">FEEDBACKS</div>
                  <div class="clearfix"></div>
                </div>
                <div class="panel-body">
                  <?php
                  $sql3= "SELECT `customer_id` FROM `customer` WHERE `username`='$username';";
                  $result3= mysqli_query($connect, $sql3);
                  while($col = $result3->fetch_assoc()){
                    $customer_id= $col['customer_id'];

                    $sql= "SELECT * FROM `customer messages` WHERE `customer_id`='$customer_id';";
                    $result= mysqli_query($connect, $sql);
                    if(mysqli_num_rows($result) > 0){
                      while($row = $result->fetch_assoc()){
                        $message= $row['message'];
                        $assess= $row['assess'];
                          if($assess == 'accepted'){
                            echo "
                            <div class='alert alert-success company-feedback' role='alert'>
                              <div class='feedback-body'>
                                <h3>ADMIN</h3>
                                <p>".$row['message']."</p>
                              </div>
                              <div class='clearfix'></div>
                              <span class='message-time'>".$row['time']."</span>
                            </div>
                            ";
                          }elseif($assess == 'rejected'){
                            echo "
                            <div class='alert alert-danger company-feedback' role='alert'>
                              <div class='feedback-body'>
                                <h3>ADMIN</h3>
                                <p>".$row['message']."</p>
                              </div>
                              <div class='clearfix'></div>
                              <span class='message-time'>".$row['time']."</span>
                            </div>
                            ";
                          }else{
                            echo "
                            <div class='alert alert-warning company-feedback' role='alert'>
                              <div class='feedback-body'>
                                <h3>ADMIN </h3>
                                <p>".$row['message']."</p>

                              </div>
                              <div class='clearfix'></div>
                              <span class='message-time'>".$row['time']."</span>

                            </div>
                            ";
                        }
                      }

                    }else{
                       echo "<p class='alert alert-block alert-danger fade in'>You have no messages yet!</p>";
                    }

                  }

                  ?>


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
