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

     //Delet records
     if(isset($_GET['cust_id'])){
       $id = $_GET['cust_id'];

       $sql2= "DELETE FROM `customer` WHERE `customer_id`='$id';";
       $result2=mysqli_query($connect, $sql2);
       if ($result2) {
               echo "<script type='javascript'>alert('Customer account successfully deleted');</script>";
        } else {
             echo 'Sorry! Could not delete customer'.mysqli_error($connect);
             exit();
       }
     }

 ?>


<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta property="og:title" content="Vide" />
<meta name="keywords" content="" />

<title>Admin View Customers | Northern Travellers</title>

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
           <li>
             <a class="" href="student-page.php">
               <i class="icon_house_alt"></i>
               <span>Dashboard</span>
             </a>
           </li>
           <li class="active">
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
               <span>View Rental requests</span>
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
           <li><a href="admin-page.php">Admin page</a></li>
           <li class="highlight">View customers</li>
        </ol>

        <div class="row">
                    <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading title1">
                                CUSTOMERS
                            </header>

                            <table class="table table-striped table-advance table-hover">
                             <tbody>
                                <tr>
                                   <th><i class="icon_key_alt"></i> Customer_id</th>
                                   <th><i class="icon_profile"></i> Full Name</th>
                                   <th><i class="icon_profile"></i> Username</th>
                                   <th><i class="icon_calendar"></i> Email</th>
                                   <th><i class="icon_phone"></i> Phone</th>
                                   <th><i class="icon_pin_alt"></i> Location</th>
                                   <th><i class="icon_cogs"></i> Action</th>
                                </tr>
                                <?php
                                    $students= array();
                                    $sql= "SELECT * FROM `customer`;";
                                    $result= mysqli_query($connect, $sql);
                                    if (mysqli_num_rows($result) > 0){
                                         while($row = $result->fetch_assoc()){
                                           echo "
                                           <tr>
                                              <td>".$row['customer_id']."</td>
                                              <td>".$row['customer_name']."</td>
                                              <td>".$row['username']."</td>
                                              <td>".$row['customer_email']."</td>
                                              <td>".$row['customer_contact']."</td>
                                              <td>".$row['customer_location']."</td>
                                              <td>
                                               <div class='btn-group'>
                                                   <a href='#' class='btn btn-danger' data-toggle='modal' data-target='#deleteStude'>DELETE</a>
                                               </div>
                                               </td>

                                               <div class='modal' id='deleteStude' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                                                  <div class='modal-dialog' role='document'>
                                                    <div class='modal-content'>
                                                      <div class='modal-header'>
                                                        <h5 class='modal-title' id='exampleModalLabel'>CONFIRMATION!</h5>
                                                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                          <span aria-hidden='true'>&times;</span>
                                                        </button>
                                                      </div>
                                                      <div class='modal-body'>
                                                        <p>Are you sure you want to remove ".$row['username']." from the system?</p>
                                                      </div>
                                                      <div class='modal-footer'>
                                                          <a href='admin-viewCustomers.php?cust_id=".$row['customer_id']."'  class='btn btn-primary'>DELETE</a>
                                                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>NO</button>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                           </tr>
                                           ";

                                         }
                                       }else{
                                         echo "<tr><td align='center' colspan='8' class='alert alert-block alert-danger fade in'>No records available yet!</td></tr>";
                                       }


                                ?>

                             </tbody>
                          </table>
                        </section>
                    </div>
                </div>

  </div>
  </section>


  <script src="js/jquery-1.11.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</body>
</html>
