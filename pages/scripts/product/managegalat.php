<?php
require_once("../../includes/db.php");


$query = "SELECT product.image_extension, product.product_id,product.product_name,product.eoq,product_sale_rate.rate_of_sale,product.additional_specification,GROUP_CONCAT(DISTINCT supplier.supplier_name,', ') as supplier_name,category.category_name,product.deleted FROM category,product,supplier,product_supplier,product_sale_rate WHERE product.category_id = category.category_id AND product.product_id=product_supplier.product_id AND product_supplier.supplier_id = supplier.supplier_id AND product.product_id = product_sale_rate.product_id GROUP BY product.product_id HAVING product.deleted=0";

if(isset($_POST["search"]["value"])){
    $query .= " AND (product.product_name like '%".$_POST["search"]["value"]."%' OR category.category_name like '%".$_POST['search']['value']."%' OR supplier_name like '%".$_POST['search']['value']."%' )"; 
}
if(isset($_POST["order"])){
    $query .= " ORDER BY ".$columns[$_POST['order']['0']['column']]." ".$_POST['order']['0']['dir'];
}
else{
    $query .= " ORDER BY ".$columns[0]." ASC";
}
echo $query;

$query1 = "";

if($_POST["length"]!=-1){
    $query1 = ' LIMIT '.$_POST['start'].','.$_POST['length'];
}

$number_filtered_row = mysqli_num_rows(mysqli_query($connection,$query));

$result = mysqli_query($connection,$query . $query1);

$data = array();
while($row = mysqli_fetch_assoc($result)){
    $sub_array = array();
//    //Instead of this we can use rendering features 
//   $sub_array[] = "<img height='75px' class='img-responsive' src='http://localhost/erp/assets/products/images/".$row['product_id'].".".$row['image_extension']."'>";
   $sub_array[] = $row["product_id"].".".$row["image_extension"];
    $sub_array[] = $row["product_name"];
    $sub_array[] = $row["eoq"];
    $sub_array[] = $row["rate_of_sale"];
    $sub_array[] = $row["additional_specification"];
    $sub_array[] = $row["supplier_name"];
    $sub_array[] = $row["category_name"];
    $sub_array[] = "<button class='edit fa fa-pencil btn blue' id='".$row['product_id']."' data-toggle='modal' data-target='#editModal'></button>";
    $sub_array[] = "<button class='delete fa fa-trash btn red' id='".$row['product_id']."' data-toggle='modal' data-target='#deleteModal'></button>";
    
    
    $data[] = $sub_array;
    
    
}
function get_all_data($connection){
    $query = "SELECT * FROM category,gst WHERE category.hsn_code = gst.hsn_code";
    return(mysqli_num_rows(mysqli_query($connection,$query)));
}
$output = array(
    "draw" => intval($_POST["draw"]),
    "recordsTotal" => get_all_data($connection),
    "recordsFiltered" => $number_filtered_row,
    "data" => $data,
);

echo json_encode($output); //sends in json format






?>