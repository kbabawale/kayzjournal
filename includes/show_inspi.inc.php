<?php require('connection.inc.php');

$inspiration_array_id = array(); $inspiration_array = array(); 
		$sql = "SELECT * FROM inspiration ORDER BY date_created ASC";
		$stmt = $conn->stmt_init();
		$stmt->prepare($sql);
		$stmt->bind_result($inspiration_id, $name_of_person, $profession, $image_filename, $notes, $date_created, $date_updated);
		$ok = $stmt->execute();
		$stmt->store_result();
		$numRows = $stmt->num_rows;
		echo $stmt->error;
		
		if($numRows){ 
			while($stmt->fetch()){ 
				$inspiration_array_id[] = $inspiration_id; 
				$inspiration_array['inspiration_id_'.$inspiration_id] = $inspiration_id;
				$inspiration_array['name_of_person_'.$inspiration_id] = $name_of_person;
				$inspiration_array['profession_'.$inspiration_id] = $profession;
				$inspiration_array['image_filename_'.$inspiration_id] = $image_filename;
				$inspiration_array['notes_'.$inspiration_id] = $notes;
				$inspiration_array['date_created_'.$inspiration_id] = $date_created;
				$inspiration_array['date_updated_'.$inspiration_id] = $date_updated;
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
    	<p><span style="font-size:2.5em;">INSPIRATION</span> &nbsp;&nbsp;&nbsp;&nbsp;
        <span style="color:#06F;"><?php  if(count($inspiration_array_id) == 0){
					echo 'Nobody';	
				}elseif(count($inspiration_array_id) == 1){
					echo count($inspiration_array_id). ' person';	
				}else{
					echo count($inspiration_array_id). ' people';	
				} ?>
        </span>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <a href="add_inspiration.php" id="add_book" style="//border:solid 1px black; text-decoration:none;padding:5px;color:white;background:#006600;"
        onMouseOver="this.style.background='black';this.style.color='white';"
        onMouseOut="this.style.background='#060';this.style.color='#fff';">+Add person</a>
        </p>
    </div>
    
    <div id="leftlib" style="width:30%;float:left;">
    	<?php 
		if(count($inspiration_array_id) == 0){
			echo '<div style="color:#333;text-align:center;padding:10px;//border:1px solid black;width:100%;">Nobody.</div>';	
		}else{
			//display books as a list
			foreach($inspiration_array_id as $inspiration_array_id1){
			?>
			<ul>
				<a href="#" onclick="showInspirationDetail(<?php echo $inspiration_array_id1; ?>); return false;"><li><?php echo $inspiration_array['name_of_person_'.
				$inspiration_array_id1]; ?></li></a>
			</ul>
		<?php }//foreach
		} ?>
		
    </div>
    
    <div id="rightlib" style="//border:solid 1px black; width:67%; left:32%; float:left; margin:6px 5px;">
    	<div id="innerrightlib" style="//padding:5px;"></div>
    </div>
</div>