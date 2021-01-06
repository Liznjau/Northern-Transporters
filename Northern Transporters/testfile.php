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

       //Upload profile pic
       $file = mysqli_real_escape_string($connect, $_POST['profilep']);
       
       $fileExt = explode('.', $fileName);
       $fileActualExt= strtolower(end($fileExt));
       $allowed= array('jpg', 'jpeg', 'png', 'pdf');
       if(in_array($fileActualExt, $allowed)){
         if($fileError === 0){
           if($fileSize < 10000000){
             $fileNameNew= uniqid('', true).".".$fileActualExt;
             $file_destination = 'images/';
             echo $fileActualExt."  FileExt";
             move_uploaded_file($fileTmpName, $file_destination.$fileName);
             //echo "success profile pic";

           }else{
             array_push($errors, "File is too large!");
             echo 'Sorry! File is too large!'.mysqli_error($connect);
             exit();
           }
         }else{
           array_push($errors, "There was an error uploading your file!");
           echo 'Sorry! There was an error uploading your file!'.mysqli_error($connect);
           exit();
         }
       }else{
         array_push($errors, "You cannot upload files of this type!");
         echo 'Sorry! Could not upload file of this type!'.mysqli_error($connect);
         exit();
       }

       IF(empty($plate)){
         array_push($errors, "All fields must be FILLED!");
         echo 'All fields must be FILLED';
         exit();
       }

       //check if user with same username exists in db
       $sql = "SELECT * FROM vehicle WHERE vehicle_plate ='$plate';";
       $result = mysqli_query($con, $sql);
       if (mysqli_num_rows($result) == 1){
         array_push($errors, "User already exists");
         echo 'Sorry! Vehicle already exists!'.mysqli_error($connect);
         exit();
       }

       if (count($errors) == 0){
         $sql2= "INSERT INTO `vehicle` (`vehicle_plate`, `vehicle_model`, `vehicle_profile`, `vehicle_location`) VALUES ('$plate', '$model', '$profile', '$location');";
         $result2= mysqli_query($con, $sql2);
         if($result2){
           echo '<script type="text/javascript">Vehicle was successfully added!</script>;';
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
           <li><a href="allLorries.php" class="smoothScroll">VEHICLES</a></li>
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


  <form action="admin-viewVehicles.php" method="post">
    <label>Vehicle plate</label><input name="plate" placeholder="Vehicle plate" class="input form-control" type="text">
    <label>Vehicle profile</label><input name="profilep" placeholder="Profile" class="input form-control" type="file">
    <label>Vehicle model</label><input name="model" placeholder="Vehicle model" class="input form-control" type="text">
    <label>Vehicle location</label><input name="location" placeholder="Vehicle location" class="input form-control" type="text">
    <input name="add-vehicle" value="ADD VEHICLE" class="btn-default btn-submit" type="submit">
  </form>


  </div>
  </section>


  <script src="js/jquery-1.11.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</body>
</html>
