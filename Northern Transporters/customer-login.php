<!DOCTYPE html>
<?php
     session_start();
     $errors=array();

     //Connect to the database
     $connect = mysqli_connect('localhost', '', '', 'database');

     if(isset($_POST['customer-login'])){
       $username = mysqli_real_escape_string($connect, $_POST['username']);
       $password = mysqli_real_escape_string($connect, $_POST['password_1']);

       IF(empty($username)){
         array_push($errors, "All fields must be FILLED!");
       }
       IF(empty($password)){
         array_push($errors, "All fields must be FILLED!");
       }


       if (count($errors) == 0){
          $password = md5($password); //Encrypt password before comparing it to database (security)
          $sql = "SELECT * FROM customer WHERE username ='$username';";
          $result = mysqli_query($connect, $sql);
          if (mysqli_num_rows($result) == 1){
               while($row = $result->fetch_assoc()){
                 $_SESSION['username'] = $username;
                 header('location:customer-page.php');
               }
          }
          else {
            echo 'ERROR! iNCORRECT CRIDENTIALS!'.mysqli_error($connect);
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

<title>Customer Login | Northern Travellers</title>

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
           <li class="highlight">Customer Login</li>
        </ol>
           <div class="signup-section">
     	   		<div class="col-md-12 col-sm-12 col-xs-12" >
               <div class="details-section">
                 <div class="details-header">CUSTOMER LOGIN</div>
                 <div class="details-form">
                   <form action="" method="post">
                       <label>Username</label><input name="username" placeholder="Username" class="input form-control" type="text">
                       <label>Password</label><input name="password_1" placeholder="password" class="input form-control" type="password">
                       <input name="customer-login" value="LOGIN" class="btn-default btn-submit" type="submit">
                       <span class="alter">Dont have an account?<a href="customer-signup.php"> SIGNUP</a></span>
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
