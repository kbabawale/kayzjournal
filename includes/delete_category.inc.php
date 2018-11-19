<?php 
require('connection.inc.php');

if(isset($_GET['cat_id'])){
	$cat_id = $_GET['cat_id'];
}

	$sql = "DELETE FROM category WHERE category_id ='$cat_id'";
	$stmt = $conn->stmt_init();
	$stmt->prepare($sql);
	$stmt->execute();
	echo $stmt->error;
	if($stmt->affected_rows > 0){
		//$deletesuccess = true;
		//header('Location:journals.php?ref=articles');
		//exit;
	}else{
			//echo 'Cannot delete article now. Try again later.';	
	}
?>