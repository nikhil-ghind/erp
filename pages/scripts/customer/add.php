<?php
require_once("../../includes/db.php");
require_once("../../includes/functions.php");
session_start();
$employee_id = $_SESSION["employee_id"];

if(isset($_POST["add_customer"])){
   $customer_name = $_POST["customer_name"];
   $customer_address = $_POST["customer_address"];
   $customer_email = $_POST["customer_email"];
   $customer_number = $_POST["customer_number"];
   $gst_no =$_POST["gst_no"];
   
   $query = "SELECT * FROM customer WHERE customer_contact = $customer_number";
   $resultset = mysqli_query($connection,$query);
   if(mysqli_num_rows($resultset)>0){
      $_SESSION["status"]= CUSTOMER_EXISTS_WARNING;
      echo mysqli_num_rows($resultset);
   header("Location: http://".BASE_SERVER."/erp/pages/add-customer.php");
   exit();
   }
   else{
   $tablename = "customer";
   $columns = "customer_name,customer_address,customer_email,customer_contact,gst_no,created_by";
   $values =" '$customer_name','$customer_address','$customer_email',$customer_number,'$gst_no',$employee_id";
   
   insert($tablename,$columns,$values);
   $_SESSION['status']=CUSTOMER_ADDED_SUCCESS;
   header("Location: http://".BASE_SERVER."/erp/pages/add-customer.php");
      exit();
   }
   
   
}
?>