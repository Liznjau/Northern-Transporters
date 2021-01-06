<?php
//Connect to the database
$con = mysqli_connect('localhost', 'root', '5987', 'database');

//Delet records
$id = $_GET['cust_id'];

$sql2= "DELETE FROM `customers` WHERE `customer_id`='$id';";
$result2=mysqli_query($con, $sql2);
if ($result2) {
        header('location:company-viewApplications.php?success="1"');
      } else {
  echo 'Sorry! Could not delete customer'.mysqli_error($conn);
}
?>
