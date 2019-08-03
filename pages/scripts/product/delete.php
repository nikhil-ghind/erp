<?php
   require_once("../../includes/functions.php");
   session_start();
   $employee_id=$_SESSION["employee_id"];
   if(isset($_POST["deleteBtn"])){
      $product_id = $_POST['product_id'];
      $tableName = "product";
      $primaryTableColumn = "product_id";
      deleteRecord($tableName,$primaryTableColumn,$product_id,$employee_id);
      $tableName = 'product_sale_rate';
      deleteRecord($tableName,$primaryTableColumn,$product_id,$employee_id);
      echo "deleted successfully";
      
   }
?>