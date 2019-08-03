<?php
require_once("../../includes/db.php");
require_once("../../includes/functions.php");
session_start();
$employee_id = $_SESSION["employee_id"];

if(isset($_POST["add_supplier"])){
   $supplier_name = $_POST["supplier_name"];
   $supplier_address = $_POST["supplier_address"];
   $supplier_email = $_POST["supplier_email"];
   $supplier_number = $_POST["supplier_number"];
   $gst_no =$_POST["gst_no"];
   
   $query = "SELECT * FROM supplier WHERE supplier_contact = $supplier_number";
   $resultset = mysqli_query($connection,$query);
   if(mysqli_num_rows($resultset)>0){
      $_SESSION["status"]= SUPPLIER_EXISTS_WARNING;
      echo mysqli_num_rows($resultset);
   header("Location: http://".BASE_SERVER."/erp/pages/add-supplier.php");
   exit();
   }
   else{
   $tablename = "supplier";
   $columns = "supplier_name,supplier_address,supplier_email,supplier_contact,gst_no,created_by";
   $values =" '$supplier_name','$supplier_address','$supplier_email',$supplier_number,'$gst_no',$employee_id";
   
   insert($tablename,$columns,$values);
   $_SESSION['status']=SUPPLIER_ADDED_SUCCESS;
   header("Location: http://".BASE_SERVER."/erp/pages/add-supplier.php");
      exit();
   }
   
   
}
?>