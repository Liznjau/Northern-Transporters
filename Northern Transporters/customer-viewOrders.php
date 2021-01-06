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

     //Delet records
     if(isset($_GET['rental_id'])){
       $id = $_GET['rental_id'];

       $sql2= "DELETE FROM `rental` WHERE `rental_id`='$id';";
       $result2=mysqli_query($connect, $sql2);
       if ($result2) {
               echo "<script type='javascript'>alert('Rental order successfully deleted');</script>";
               echo '<script>window.setTimeout(function() {window.location = "customer-viewOrders.php";}, 3000);</script>';
        } else {
             echo 'Sorry! Could not delete rental'.mysqli_error($connect);
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

<title>Add load | Northern Travellers</title>

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
           <li >
             <a class="" href="customer-page.php">
               <i class="icon_house_alt"></i>
               <span>Dashboard</span>
             </a>
           </li>
           <li class="active">
             <a class="" href="customer-viewOrders.php">
               <i class="icon_documents_alt"></i>
               <span>My Orders</span>
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
           <li><a href="customer-page.php">Customer page</a></li>
           <li class="highlight">view Orders</li>
        </ol>

        <section class="panel">
            <header class="panel-heading title1">
              <h2>MY ORDERS</h2>
            </header>

            <table class="table table-striped table-advance table-hover">
             <tbody>
                <tr>
                   <th><i class="icon_key_alt"></i> Rental_id</th>
                   <th><i class="icon_profile"></i> Material</th>
                   <th><i class="icon_profile"></i> Source</th>
                   <th><i class="icon_calendar"></i> Destination</th>
                   <th><i class="icon_phone"></i> Date</th>
                   <th><i class="icon_pin_alt"></i> Amount</th>
                   <th><i class="icon_pin_alt"></i> Approved</th>
                   <th><i class="icon_cogs"></i> Action</th>
                </tr>
                <?php
                    $students= array();
                    $sql= "SELECT * FROM `rental` WHERE customer_username='$username';";
                    $result= mysqli_query($connect, $sql);
                    if (mysqli_num_rows($result) > 0){
                         while($row = $result->fetch_assoc()){
                           echo "
                           <tr>
                              <td>".$row['rental_id']."</td>
                              <td>".$row['type']."</td>
                              <td>".$row['source']."</td>
                              <td>".$row['destination']."</td>
                              <td>".$row['date']."</td>";
                              if($row['amount'] == ''){
                        echo "<td><a href='#' class='btn btn-default'>PENDING</a></td>";
                      }else{
                        echo "<td>".$row['amount']."</td>";
                      }

                              if($row['approved'] == 'no'){
                        echo "<td><a href='#' class='btn btn-default'>PENDING</a></td>";
                               }else{
                                 echo "<td>".$row['approved']."</td>";
                               }
                        echo "
                              <td>
                               <div class='btn-group'>
                                   <a href='#' class='btn btn-danger' data-toggle='modal' data-target='#deleteRental'>DELETE</a>
                               </div>
                               </td>

                               <div class='modal' id='deleteRental' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                                  <div class='modal-dialog' role='document'>
                                    <div class='modal-content'>
                                      <div class='modal-header'>
                                        <h5 class='modal-title' id='exampleModalLabel'>CONFIRMATION!</h5>
                                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                          <span aria-hidden='true'>&times;</span>
                                        </button>
                                      </div>
                                      <div class='modal-body'>
                                        <p>Are you sure you want to delete this order from the system?</p>
                                      </div>
                                      <div class='modal-footer'>
                                          <a href='admin-viewOrders.php?rental_id=".$row['rental_id']."'  class='btn btn-primary'>DELETE</a>
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

           <div class="row">
             <div class="col-md-6">
           </div>

        </section>


      </div>
    </section>

  </section>


  <script src="js/jquery-1.11.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</body>
</html>
