<!DOCTYPE html>
<?php
     session_start();
     $errors=array();

     //Connect to the database
     $connect = mysqli_connect('localhost', 'root', '5987', 'database');

     if(isset($_POST['customer-signup'])){
       $name = mysqli_real_escape_string($connect, $_POST['name']);
       $username= mysqli_real_escape_string($connect, $_POST['username']);
       $location = mysqli_real_escape_string($connect, $_POST['location']);
       $email = mysqli_real_escape_string($connect, $_POST['email']);
       $phone = mysqli_real_escape_string($connect, $_POST['contact']);
       $password_1 = mysqli_real_escape_string($connect, $_POST['password_1']);
       $password_2 = mysqli_real_escape_string($connect, $_POST['password_2']);


       //Check if passwords match
       if($password_1 !== $password_2){
         array_push($errors, "Passwords do not match");
         echo 'ERROR! Passwords do not match!'.mysqli_error($connect);
       }

       //check if user with same username exists in db
       $sql = "SELECT * FROM customer WHERE username ='$username';";
       $result = mysqli_query($connect, $sql);
       if (mysqli_num_rows($result) == 1){
         array_push($errors, "User already exists");
         echo 'Customer with that username already exists!'.mysqli_error($connect);
       }

       if (count($errors) == 0){
          $password = md5($password_1); //Encrypt password before comparing it to database (security)
          $sql2= "INSERT INTO `customer` (`customer_name`, `username`, `customer_contact`, `customer_email`, `customer_location`, `password`) VALUES ('$name', '$username', '$phone', '$email', '$location', '$password');";
          $result1= mysqli_query($connect, $sql2);
          if($result1){
                 $_SESSION['username'] = $username;
                 header('location:customer-page.php');

          }
          else{
          echo 'ERROR! Could not create account!'.mysqli_error($connect);
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

<title>Customer Signup | Northern Travellers</title>

<link rel="icon" href="images/job3.jpg" type="image/x-icon">
<link rel="shortcut icon" href="images/logo icon.png">
<link rel="stylesheet" href="css/bootstrap.min.css">
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
           <li><a href="allVehicles.php" class="smoothScroll">VEHICLES</a></li>
           <li><a href="customer-login.php" class="smoothScroll"><span class="highlight">CUSTOMER</span></a></li>
           <li><a href="admin-login.php" class="smoothScroll">ADMIN</a></li>
         </ul>
       </div>
      </div>
    </div>
  </nav>


    <section id="login-banner">
      <div class="container">
        <ol class="breadcrumb" id="breadcrumb">
           <li><i class="fa fa-home"></i><a href="index.php">Home</a></li>
           <li class="highlight">Customer Signup</li>
        </ol>
           <div class="signup-section">
     	   		<div class="col-md-12 col-sm-12 col-xs-12" >
               <div class="details-section">
                 <div class="details-header">CUSTOMER SIGNUP</div>
                 <div class="details-form">
                   <form action="" method="post">
                       <label>Full name</label><input name="name" placeholder="Full name" class="input form-control" type="text">
                       <label>Username</label><input name="username" placeholder="Username" class="input form-control" type="text">
                       <label>Contact</label><input name="contact" placeholder="Contact" class="input form-control" type="text">
                       <label>Email</label><input name="email" placeholder="Email" class="input form-control" type="text">
                       <label>Location</label><input name="location" placeholder="Location" class="input form-control" type="text">
                       <label>Password</label><input name="password_1" placeholder="password" class="input form-control" type="password">
                       <label>Confirm Password</label><input name="password_2" placeholder="Confirm password" class="input form-control" type="password">
                       <input name="customer-signup" value="SIGNUP" class="btn-default btn-submit" type="submit">
                       <span class="alter">Already have an account?<a href="customer-login.php"> LOGIN</a></span>
                     </form>
                 </div>
               </div>
             </div>
           </div>

      </div>
    </section>

  </section>


  <script src="js/jquery-1.11.1.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</body>
</html>
