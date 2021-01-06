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

     if(isset($_GET['plate'])){
       $plate=$_GET['plate'];
     }

     if(isset($_POST['add-load'])){
       $material = mysqli_real_escape_string($connect, $_POST['material']);
       $source = mysqli_real_escape_string($connect, $_POST['source']);
       $destination = mysqli_real_escape_string($connect, $_POST['destination']);
       $plate = mysqli_real_escape_string($connect, $_POST['plate']);

       IF(empty($material) || empty($source) || empty($destination)){
         array_push($errors, "All fields must be FILLED!");
         echo 'All fields must be FILLED';
         exit();
       }

       $sql = "SELECT * FROM customer WHERE username ='$username';";
       $result = mysqli_query($connect, $sql);
       while($row=mysqli_fetch_assoc($result)){
         if (count($errors) == 0){
           $customer_id= $row['customer_id'];
                $result4= mysqli_query($connect, "INSERT INTO `rental` (`customer_id`, `customer_username`, `vehicle_plate`, `type`, `source`, `destination`, `status`, `approved`) VALUES ('$customer_id', '$username', '$plate', '$material', '$source', '$destination', '1', 'no');");
                if($result4){
                  echo '<script type="text/javascript">Your application has been successfully sent to rent Truck with plate '.$plate.';</script>';
                  $_SESSION['success']="Your application has been successfully sent to rent Truck with plate ".$plate."";
                }else{
                  echo "SORRY! Could not apply for renting the truck";
                    exit();
                }
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
           <li>
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
           <li class="highlight">Add Load</li>
        </ol>

        <section class="panel">
            <header class="panel-heading title1">
              <h2>ADD LOADS</h2>
            </header>

            <form method="POST" class="" style="margin:10px auto;width:40%;">
              <?php if(isset($_SESSION['success'])){ ?><p class="alert alert-success"><?php  echo $_SESSION['success']; ?></p><?php unset($_SESSION['success']); }?>
              <label>Load Type</label><select name="material" class="form-control input" placeholder="Load Type" required="">
                <option value="cargo">Cargo</option>
                <option value="funiture">Funiture</option>
                <option value="metalwork">Metal Work</option>
                <option value="supplys">Supplys</option>
                <option value="Agricultural">Agricultural</option>
              </select>
              <label>From:</label><input name="source" placeholder="Source" class="input form-control" type="text">
              <input name="plate"  value="<?php echo $plate; ?>" class="input form-control" type="hidden">
              <label>Destination</label><input name="destination" placeholder="Destination" class="input form-control" type="text">
              <input type="submit" name="add-load"  class='form-control btn-default btn-submit' value="ADD LOAD">
           </form>

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
