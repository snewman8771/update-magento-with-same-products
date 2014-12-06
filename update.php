<?php
   require('connect.php');
  //Get IP Address from Database
  $get_ip = "select * from ipaddress";
  $get_ip_result = mysqli_query($mysqli, $get_ip);
  if(count(mysqli_fetch_assoc($get_ip_result) > 0)) {

 
  
  
    while($result_ip = mysqli_fetch_assoc($get_ip_result)){
	$ip = $result_ip['ip'];
	$user = $result_ip['username'];
	$password = $result_ip['password1'];
	$database = $result_ip['databasename'];
	
	$sql = "select * from  catalog_product_entity";
	$query = mysqli_query($mysqli, $sql);
	while($row3 = mysqli_fetch_assoc($query)){
	$sku = $row3['sku'];
	 
	 //create connection to parent database
	  $parent_sql = "select * from catalog_product_entity where sku = '$sku'";
	  $parent_query = mysqli_query($mysqli, $parent_sql);
	 //create connection to child database
	  $put_ip = new mysqli($ip, $user, $password, $database);
	  $child_sql = "select * from catalog_product_entity where sku = '$sku'";
	  $child_query = mysqli_query($put_ip, $child_sql);
	  //compare the two quantities 
	   while($row1 = mysqli_fetch_array($child_query) and $row2 = mysqli_fetch_array($parent_query)){
	   echo "<br>";
	 
	   
	   if($row1['sku'] == $row2['sku']){

	   $stock1 = $row1['entity_id'];
	   $stock2 = $row2['entity_id'];
	   
	     //parent if parent stock is equal query
		 $stock1_equal = "select * from cataloginventory_stock_item where product_id =" . $stock1;
		 $stock1_equal_query = mysqli_query($mysqli, $stock1_equal);
		 //check if child stock is equal query
		 $stock2_equal = "select * from cataloginventory_stock_item where product_id =" . $stock2;
		 $stock2_equal_query = mysqli_query($put_ip, $stock2_equal);
		   //run both queries through to check if stock is the same
		   while($row4 = mysqli_fetch_assoc($stock1_equal_query) and $row5 = mysqli_fetch_assoc($stock2_equal_query)){
		     
			 if($row4['qty'] == $row5['qty'] ){
			 echo "quanties are the same for item with SKU" . $row1['sku'];
			 
			 }
		     if($row4['qty'] > $row5['qty']){
			 $update_stock1 = "update cataloginventory_stock_item set qty = '$row5[qty]' where item_id = '$stock2'";
			 $update_stock2 = "update cataloginventory_stock_status set qty = '$row5[qty]' where product_id = '$stock2'";
			
			 
			
			   if(mysqli_query($mysqli,$update_stock1)){
			   echo "success";
			   }
			   if( mysqli_query($mysqli,$update_stock2)){
			   echo "success";
			   }
			    else{
			 echo "fail";
			 }
			 }
		     if($row4['qty'] < $row5['qty']){
			  $update_stock4 = "update cataloginventory_stock_item set qty = '$row4[qty]' where item_id = '$stock2'";
			  $update_stock5 = "update cataloginventory_stock_status set qty = '$row4[qty]' where product_id = '$stock2'";
			 
			    if(mysqli_query($put_ip, $update_stock4) and mysqli_query($put_ip, $update_stock5)){
			    echo "success";
			   }
			    else{
			 echo "fail";
			 }
			 }
		   
		 
	   
	   
	   }
	   //if quanty
	
	 
	 
	
	}
  
  }
  }
}
}
?>