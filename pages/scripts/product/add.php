<?php
   require_once("../../includes/db.php");
   require_once("../../includes/functions.php");
   session_start();
/********************************************************************************************************************************************                                 CODE TO UPLOAD THE IMGE                                                                                     ******************************************************************************************************************************************/
//
//   $image_name = $_FILES["product_image"]["name"];
//   $image_size = $_FILES["product_image"]["size"];
//   $temp_name = $_FILES["product_image"]["tmp_name"];
//   $image_type = $_FILES["product_image"]["type"];
//
//   $file_extension = strtolower(end(explode(".",$image_name)));
//   
//   echo "Image name : $image_name";
//   echo "<br> Image size : $image_size";
//echo "<br> Image name : $temp_name";
//echo "<br> Image type : $image_type";
//echo " <br>  File extensions : $file_extension";
//
//$valid_extensions = array("jpeg","jpg","png");
//
//if(in_array($file_extension,$valid_extensions) == false){
//   $error_msg[] = "Image is not valid,invalid file extension"; 
//}
//
//if($image_size>2097152){
//   $error_msg[] = "Image is larger than input expected limit is 2MB";
//}
//
//if(empty($error_msg)){
//   move_uploaded_file($temp_name,"../../../assets/products/images/".$image_name);
//   echo "File uploaded successfully";
//}
//else{
//   print_r($error_msg);
//}


/********************************************************************************************************************************************                               END OF  CODE TO UPLOAD THE IMGE                                                                                  *******************************************************************************************************************************************/
   $employee_id = $_SESSION["employee_id"];
   //Checking whether file was uploaded or not
   if(isset($_POST["add_product"])){
      
      if(isset($_FILES["product_image"])){
         //yes the file was uploaded so we are initialising all the required variables
            $image_name = $_FILES["product_image"]["name"];
            $image_size = $_FILES["product_image"]["size"];
            $temp_name = $_FILES["product_image"]["tmp_name"];
            $file_type = $_FILES["product_image"]["type"];
            $file_extension = strtolower(end(explode(".",$image_name)));
      }
      $product_name = $_POST['product_name'];
      $rate_of_sale = $_POST["rate_of_sale"];
      $additional_specification = $_POST["additional_specification"];
      $category_id = $_POST["category_id"];
      $eoq = $_POST["eoq"];
      $suppliers =$_POST["supplier_id"];
      
      $tablename = "product";
      $columns ="product_name,image_extension,additional_specification,category_id,eoq,created_by";
      $values ="'$product_name','$file_extension','$additional_specification',$category_id,$eoq,'$employee_id'";
      $result = insert($tablename,$columns,$values);
      //product hahs been added
      
      
      //getting the last id that was inserted in the DB...
      $product_id = mysqli_insert_id($connection);
            //this function returns the last inserted value ka id
            //same kaam can be done using MAX quwry from database
      $tablename = "product_sale_rate";
      $columns = "product_id,rate_of_sale,wef,created_by";
      $values = "$product_id,$rate_of_sale,now(),$employee_id";
      $result = insert($tablename,$columns,$values);
      
      $tablename = "product_supplier";
      $columns = "product_id,supplier_id";
      foreach($suppliers as $supplier_id){
         $values ="$product_id,$supplier_id";
         $result = insert($tablename,$columns,$values);
      }
      
      if(isset($_FILES["product_image"])){
      move_uploaded_file($temp_name,IMG_PTH.$product_id.".".$file_extension);
      }
      echo "ADDED";
         
   }
?>