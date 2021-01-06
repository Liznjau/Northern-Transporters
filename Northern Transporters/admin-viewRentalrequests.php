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

     if(isset($_POST['approve'])){
       $amount= mysqli_real_escape_string($connect, $_POST['amount']);
       $customer_id = mysqli_real_escape_string($connect, $_POST['cust_id']);
       $rental_id = mysqli_real_escape_string($connect, $_POST['rental_id']);
       $plate= mysqli_real_escape_string($connect, $_POST['plate']);

       $result4=mysqli_query($connect, "UPDATE `rental` SET `amount` = '$amount', `approved` = 'yes' WHERE `rental`.`rental_id` = '$rental_id';");
       if($result4) {
         $message='Your Application to rent truck '.$plate.' was successful and your charges is Ksh. '.$amount.' . PAYBILL: 450214<br/> Acc name is your username. Click here <a class="btn btn-primary" href="customer-checkout.php?rental='.$rental_id.'&customer='.$customer_id.'&plate='.$plate.' ">PAYMENTS</a> to complete your payments.';
         $result5= mysqli_query($connect, "INSERT INTO `customer messages` (customer_id, message, assess) VALUES('$customer_id', '$message', 'accepted')");
         if($result5){
           echo "The rental order has been approved!";
         }else{

         }
       }
     }

     if(isset($_GET['reject'])){
         $rental_id=$_GET['rental'];
         $result4=mysqli_query($connect, "UPDATE `rental` SET `approved` = 'rejected' WHERE `rental`.`rental_id` = '$rental_id';");
         $message='Your Application to rent truck '.$plate.' has been rejected.';
         $result5= mysqli_query($connect, "INSERT INTO `customer messages` (customer_id, message, assess) VALUES('$customer_id', '$message', 'rejected')");
         if($result5){
           echo "The rental order has been approved!";
         }else{

         }
     }

     //Delet records
     if(isset($_GET['plate'])){
       $id = $_GET['plate'];

       $sql2= "DELETE FROM `rental` WHERE `vehicle_plate`='$id';";
       $result2=mysqli_query($connect, $sql2);
       if ($result2) {
               echo "<script type='javascript'>alert('Customer account successfully deleted');</script>";
        } else {
             echo 'Sorry! Could not delete vehicle'.mysqli_error($connect);
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

<title>Admin Rental requests | Northern Travellers</title>

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
             <a class="" href="customer-page.php">
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
           <li>
             <a class="" href="admin-viewVehicles.php">
               <i class="icon_documents_alt"></i>
               <span>View Vehicles</span>
             </a>
           </li>
           <li class="active">
             <a class="" href="customer-viewLoads.php">
               <i class="icon_documents_alt"></i>
               <span>View Rental requests</span>
             </a>
           </li>
           <li>

         </ul>
        <!-- sidebar menu end-->
      </div>
  </aside>


    <section id="page-banner">
      <div class="container">
        <ol class="breadcrumb" id="breadcrumb">
           <li><i class="fa fa-home"></i><a href="index.php">Home</a></li>
           <li><a href="admin-page.php">Admin page</a></li>
           <li class="highlight">Rental requests</li>
        </ol>

        <div class="row">
                    <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading title1">
                                RENTAL REQUESTS
                            </header>

                            <table class="table table-striped table-advance table-hover">
                             <tbody>
                                <tr>
                                   <th><i class="icon_key_alt"></i>Rental_id</th>
                                   <th><i class="icon_profile"></i> Customer_id</th>
                                   <th><i class="icon_profile"></i> Truck plate</th>
                                   <th><i class="icon_profile"></i> Material</th>
                                   <th><i class="icon_profile"></i> Source</th>
                                   <th><i class="icon_profile"></i> Destination</th>
                                   <th><i class="icon_profile"></i> Date</th>
                                   <th><i class="icon_profile"></i> Approved</th>
                                   <th colspan=3><i class="icon_cogs"></i> Action</th>
                                </tr>
                                <?php
                                    $students= array();
                                    $sql= "SELECT * FROM `rental`;";
                                    $result= mysqli_query($connect, $sql);
                                    if (mysqli_num_rows($result) > 0){
                                         while($row = $result->fetch_assoc()){
                                           echo "
                                           <tr>
                                              <td>".$row['rental_id']."</td>
                                              <td>".$row['customer_id']."</td>
                                              <td>".$row['vehicle_plate']."</td>
                                              <td>".$row['type']."</td>
                                              <td>".$row['source']."</td>
                                              <td>".$row['destination']."</td>
                                              <td>".$row['date']."</td>
                                              <td>".$row['approved']."</td>
                                              <td> ";
                                              if($row['approved']== 'rejected'){
                                                echo "
                                                <td>
                                                 <div class='btn-group'>
                                                     <a href='#' class='btn btn-default'>REJECTED</a>
                                                 </div>
                                                 </td>
                                                 <td>
                                                  <div class='btn-group'>
                                                      <a href='#' class='btn btn-danger' data-toggle='modal' data-target='#delete'>DELETE</a>
                                                  </div>
                                                  </td>
                                                ";
                                              }elseif($row['approved']== 'yes'){
                                                echo "<td>
                                                 <div class='btn-group'>
                                                     <a href='#' class='btn btn-success' '>APPROVED</a>
                                                 </div>
                                                 </td>
                                                 <td>
                                                  <div class='btn-group'>
                                                      <a href='#' class='btn btn-danger' data-toggle='modal' data-target='#delete'>DELETE</a>
                                                  </div>
                                                  </td>
                                                ";
                                              }else{
                                              ?>
                                              <td>
                                               <div class='btn-group'>
                                                   <a href='#' class='btn btn-primary' data-toggle='modal' data-target='#approve'>APPROVE</a>
                                               </div>
                                               </td>
                                               <td>
                                                <div class='btn-group'>
                                                    <a href='admin-viewRentalrequests.php?reject=1&rental=<?php echo $row['rental_id']; ?>' class='btn btn-warning'>REJECT</a>
                                                </div>
                                                </td>
                                               <td>
                                                <div class='btn-group'>
                                                    <a href='#' class='btn btn-danger' data-toggle='modal' data-target='#delete'>DELETE</a>
                                                </div>
                                                </td>

                                                <?php
                                      echo "  <div class='modal' id='approve' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                                                  <div class='modal-dialog' role='document'>
                                                    <div class='modal-content'>
                                                      <div class='modal-header'>
                                                        <h5 class='modal-title' id='exampleModalLabel'>APPROVAL</h5>
                                                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                          <span aria-hidden='true'>&times;</span>
                                                        </button>
                                                      </div>
                                                      <div class='modal-body'>
                                                        <form action='admin-viewRentalRequests.php?approve=1' method='post'>
                                                        <label>AMOUNT CHARGED:</label><input name='amount' placeholder='Amount charged' class='input form-control' type='text'>
                                                        <input name='cust_id' placeholder='Customer id' value='".$row['customer_id']."' class='input form-control' type='hidden'>
                                                        <input name='plate' placeholder='Customer id' value='".$row['vehicle_plate']."' class='input form-control' type='hidden'>
                                                        <input name='rental_id' placeholder='Rental id' value='".$row['rental_id']."' class='input form-control' type='hidden'>
                                                        <input type='submit' name='approve' class='form-control btn btn-primary' value='APPROVE'>
                                                        </form>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>

                                                <div class='modal' id='delete' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                                                   <div class='modal-dialog' role='document'>
                                                     <div class='modal-content'>
                                                       <div class='modal-header'>
                                                         <h5 class='modal-title' id='exampleModalLabel'>CONFIRMATION!</h5>
                                                         <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                                           <span aria-hidden='true'>&times;</span>
                                                         </button>
                                                       </div>
                                                       <div class='modal-body'>
                                                         <p>Are you sure you want to remove this rental order from the system?</p>
                                                       </div>
                                                       <div class='modal-footer'>
                                                           <a href='admin-viewRentalRequests.php?rental_id=".$row['rental_id']."'  class='btn btn-primary'>DELETE</a>
                                                         <button type='button' class='btn btn-secondary' data-dismiss='modal'>NO</button>
                                                       </div>
                                                     </div>
                                                   </div>
                                                 </div>
                                           </tr>
                                           ";
                                         }

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
