<?php
   require_once($_SERVER["DOCUMENT_ROOT"]."/erp/pages/includes/functions.php");
//include_once("../../includes/functions.php");
   //This is providing warnings
      //This was the work around because it was giving error in the relative path..
            //This error was only for this file.
      //THis can be done in the way using ajax call of the select2..
function getAllSupplierForSelect(){
   global $connection;
   $query ="SELECT * FROM supplier WHERE deleted = 0";
   $result = mysqli_query($connection,$query);
   while($row = mysqli_fetch_assoc($result)){
      $supplier_id = $row["supplier_id"];
      $supplier_name =$row["supplier_name"];
      echo "<option value='$supplier_id'>$supplier_name</option>";
   }
}
?>