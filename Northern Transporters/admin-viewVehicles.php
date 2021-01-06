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
     if(isset($_GET['plate'])){
       $id = $_GET['plate'];

       $sql2= "DELETE FROM `vehicle` WHERE `vehicle_plate`='$id';";
       $result2=mysqli_query($connect, $sql2);
       if ($result2) {
               echo "<script type='javascript'>alert('Customer account successfully deleted');</script>";
        } else {
             echo 'Sorry! Could not delete vehicle'.mysqli_error($connect);
             exit();
       }
     }


     if(isset($_POST['add-vehicle'])){
       $plate = mysqli_real_escape_string($connect, $_POST['plate']);
       $model = mysqli_real_escape_string($connect, $_POST['model']);
       $location = mysqli_real_escape_string($connect, $_POST['location']);


       IF(empty($plate)){
         array_push($errors, "All fields must be FILLED!");
         echo 'All fields must be FILLED';
         exit();
       }

       //check if user with same username exists in db
       $sql = "SELECT * FROM vehicle WHERE vehicle_plate ='$plate';";
       $result = mysqli_query($connect, $sql);
       if (mysqli_num_rows($result) == 1){
         array_push($errors, "User already exists");
         echo 'Sorry! Vehicle already exists!'.mysqli_error($connect);
         exit();
       }

       if (count($errors) == 0){
         $sql2= "INSERT INTO `vehicle` (`vehicle_plate`, `vehicle_model`, `vehicle_location`, `status`) VALUES ('$plate', '$model', '$location', '1');";
         $result2= mysqli_query($connect, $sql2);
         if($result2){
           echo '<script type="text/javascript">Vehicle was successfully added!</script>';
         }else{
           echo 'Sorry! there was an error in adding the vehicle! '.mysqli_error($connect);
           exit();
         }
       }
     }

 ?>


<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta property="og:title" content="Vide" />
<meta name="keywords" content="" />

<title>Admin View Vehicles | Northern Travellers</title>

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
           <li>
             <a class="" href="admin-viewCustomers.php">
               <i class="icon_profile"></i>
               <span>View customers</span>
             </a>
           </li>
           <li class="active">
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
           <li class="highlight">View vehicles</li>
        </ol>

        <div class="row">
                    <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading title1">
                                VEHICLES
                            </header>

                            <table class="table table-striped table-advance table-hover">
                             <tbody>
                                <tr>
                                   <th><i class="icon_key_alt"></i>Vehicle plate</th>
                                   <th><i class="icon_profile"></i> Vehicle model</th>
                                   <th><i class="icon_profile"></i> Vehicle location</th>
                                   <th><i class="icon_cogs"></i> Action</th>
                                </tr>
                                <?php
                                    $students= array();
                                    $sql= "SELECT * FROM `vehicle`;";
                                    $result= mysqli_query($connect, $sql);
                                    if (mysqli_num_rows($result) > 0){
                                         while($row = $result->fetch_assoc()){
                                           echo "
                                           <tr>
                                              <td>".$row['vehicle_plate']."</td>
                                              <td>".$row['vehicle_model']."</td>
                                              <td>".$row['vehicle_location']."</td>
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
                                                        <p>Are you sure you want to remove this vehicle from the system?</p>
                                                      </div>
                                                      <div class='modal-footer'>
                                                          <a href='admin-viewVehicles.php?plate=".$row['vehicle_plate']."'  class='btn btn-primary'>DELETE</a>
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

                                <tr>
                                   <td><a href='#' class='btn btn-primary' data-toggle='modal' data-target='#addVehicle'>ADD VEHICLE</a></td>
                                   <div class='modal' id='addVehicle' tabindex='-1' role='dialog' aria-labelledby='exampleModalLabel' aria-hidden='true'>
                                      <div class='modal-dialog' role='document'>
                                        <div class='modal-content'>
                                          <div class='modal-header'>
                                            <h5 class='modal-title' id='exampleModalLabel'>ADD VEHICLE</h5>
                                            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                              <span aria-hidden='true'>&times;</span>
                                            </button>
                                          </div>
                                          <div class='modal-body'>
                                            <form action="" method="post">
                                              <label>Vehicle plate</label><input name="plate" placeholder="Vehicle plate" class="input form-control" type="text">
                                              <label>Vehicle model</label><input name="model" placeholder="Vehicle model" class="input form-control" type="text">
                                              <label>Vehicle location</label><input name="location" placeholder="Vehicle location" class="input form-control" type="text">
                                              <input name="add-vehicle" value="ADD VEHICLE" class="btn-default btn-submit" type="submit">
                                            </form>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                               </tr>
                                </tr>
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
