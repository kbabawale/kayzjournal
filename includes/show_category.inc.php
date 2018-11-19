<?php require('connection.inc.php');

		$category_array = array(); $category_array_id = array();
		//get details of status
		$sql = "SELECT * FROM category";
		$stmt = $conn->stmt_init();
		$stmt->prepare($sql);
		$stmt->bind_result($category_id, $category_name);
		$ok = $stmt->execute();
		$stmt->store_result();
		$numRows = $stmt->num_rows;
		echo $stmt->error;
		
		if($numRows){ 
			while($stmt->fetch()){ 
				$category_array_id[] = $category_id; 
				$category_array['category_id_'.$category_id] = $category_id;
				$category_array['category_name_'.$category_id] = $category_name;
			}//while
		}//numrows
		$stmt->free_result();
		
		
?>

<style type="text/css">
#leftlib li{
	list-style-type:none;
	padding:10px 5px;
	background:black;
	margin:5px 0px;
	text-align:center;
}
#leftlib a{
	text-decoration:none;
	color:white;
}
#leftlib li:hover{
	background:#333333;
	color:white;
}

</style>
<script type="text/javascript" src="main.js"></script>
<div id="mainlibrary">
	<div id="toplib" style="width:100%; color:#000; border-bottom:2px solid black; padding-bottom:10px;">
    	<p><span style="font-size:2.5em;">CATEGORY</span> &nbsp;&nbsp;&nbsp;&nbsp;
        <span style="color:#06F;"><?php  if(count($category_array_id) == 0){
					echo 'No categories';	
				}elseif(count($category_array_id) == 1){
					echo count($category_array_id). ' category';	
				}else{
					echo count($category_array_id). ' categories';	
				} ?>
        </span>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <a href="javascript:void(0);" style="//border:solid 1px black; text-decoration:none;padding:5px;color:white;background:#006600;"
        onMouseOver="this.style.background='black';this.style.color='white';"
        onMouseOut="this.style.background='#060';this.style.color='#fff';" onClick="document.getElementById('category_div').style.display='block';">+Add category</a>
        </p>
    </div>
    
    <div id="" style="width:80%;//float:left;">
    	<?php 
		if(count($category_array_id) == 0){
			echo '<div style="color:#333;text-align:center;padding:10px;//border:1px solid black;width:100%;">No categories.</div>';	
		}else{
			//display books as a list
			foreach($category_array_id as $category_array_id1){
			?>
				<div style="border-bottom:1px solid black;float:left;color:black;font-size:1em;padding:15px;width:100%;">
					<div style="float:left;"><?php echo $category_array['category_name_'.$category_array_id1]; ?></div>
                    
                    <div id="editbutton" style="float:left;margin-left:20px;">
                        <a href="javascript:void(0);" style="padding:5px;border:1px solid black;color:black;			
                        text-decoration:none;margin-right:2px;" 
                        onMouseOver="this.style.background='blue';this.style.color='white';"
                        onMouseOut="this.style.background='white';this.style.color='black';"
                        onClick="loadeditCat('<?php echo $category_array['category_name_'.$category_array_id1]; ?>');
                        document.getElementById('edit_id').value = '<?php echo $category_array['category_id_'.$category_array_id1]; ?>';">Edit</a>
                        <input type="hidden" id="edit_id" value="">
                    </div>
                    <div id="deletebutton" style="float:left;margin-left:20px;">
                        <a href="javascript:void(0);" style="padding:5px;border:1px solid black;color:black;			
                        text-decoration:none;margin-right:2px;" 
                        onMouseOver="this.style.background='red';this.style.color='white';"
                        onMouseOut="this.style.background='white';this.style.color='black';"
                        onClick="document.getElementById('edit_id').value = '<?php echo $category_array['category_id_'.$category_array_id1]; ?>';
                        deleteCategory();">Delete</a>
                    </div>

                </div>
		<?php }//foreach
		} ?>
		
    </div>
    
    
</div>


<div id="category_div" style="display:none;position:fixed; top:50%; left:50%; transform:translate(-50%,-50%); //border-radius:5px; 
     padding:5px;background:#ccc;//opacity:0.75;width:300px;height:150px;box-shadow:2px 2px 5px #000; /*left, top, blur size, blur color */">
     	<h3 style="padding:3px;">Add new Category</h3>
        <hr />
        <table border="0">
        	<tr>
            	<td><input type="text" name="catt" id="catt" style="width:250px;height:30px;font-size:1em;font-weight:normal;"></td>
            </tr>
            
            <tr>
            	<table cellspacing="5">
					<tr>
                        <td><a href="javascript:void(0);" style="background:green;color:white;padding:5px;text-decoration:none;"
                        onClick="addCategory();">Create</a></td>
                        <td><a href="javascript:void(0);" style="background:red;color:white;padding:5px;text-decoration:none;" 
                        onClick="document.getElementById('category_div').style.display='none';">Cancel</a></td>
                    </tr>
                    <tr>
                    	<td><div id="catterr" style="display:none;">Error</div></td>
                    </tr>
                </table>
            </tr>
        </table>
     </div>
     
     
     <div id="category_edit" style="display:none;position:fixed; top:50%; left:50%; transform:translate(-50%,-50%); //border-radius:5px; 
     padding:5px;background:#ccc;//opacity:0.75;width:300px;height:150px;box-shadow:2px 2px 5px #000; /*left, top, blur size, blur color */">
     	<h3 style="padding:3px;">Edit Category</h3>
        <hr />
        <table border="0">
        	<tr>
            	<td><input type="text" name="editcatt" id="editcatt" style="width:250px;height:30px;font-size:1em;font-weight:normal;"></td>
            </tr>
            
            <tr>
            	<table cellspacing="5">
					<tr>
                        <td><a href="javascript:void(0);" style="background:green;color:white;padding:5px;text-decoration:none;"
                        onClick="editCategory();">Edit</a></td>
                        <td><a href="javascript:void(0);" style="background:red;color:white;padding:5px;text-decoration:none;" 
                        onClick="document.getElementById('category_edit').style.display='none';">Cancel</a></td>
                    </tr>
                    <tr>
                    	<td><div id="catterr" style="display:none;">Error</div></td>
                    </tr>
                </table>
            </tr>
        </table>
     </div>