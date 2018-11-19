<?php require('connection.inc.php');

$places_array_id = array(); $places_array = array(); $status_array = array(); $status_array_id = array();
		$sql = "SELECT * FROM places ORDER BY date_created ASC";
		$stmt = $conn->stmt_init();
		$stmt->prepare($sql);
		$stmt->bind_result($places_id, $name_of_place, $name_of_city, $name_of_country, $status_id, $date_created, $date_updated, $notes);
		$ok = $stmt->execute();
		$stmt->store_result();
		$numRows = $stmt->num_rows;
		echo $stmt->error;
		
		if($numRows){ 
			while($stmt->fetch()){ 
				$places_array_id[] = $places_id; 
				$places_array['places_id_'.$places_id] = $places_id;
				$places_array['name_of_place_'.$places_id] = $name_of_place;
				$places_array['name_of_city_'.$places_id] = $name_of_city;
				$places_array['name_of_country_'.$places_id] = $name_of_country;
				$places_array['status_id_'.$places_id] = $status_id;
				$places_array['date_created_'.$places_id] = $date_created;
				$places_array['date_updated_'.$places_id] = $date_updated;
				$places_array['notes_'.$places_id] = $notes;
			}//while
		}//numrows
		
		$stmt->free_result();
		
		//get details of status
		$sql = "SELECT * FROM status";
		$stmt->prepare($sql);
		$stmt->bind_result($status_id, $status_name);
		$ok = $stmt->execute();
		$stmt->store_result();
		$numRows = $stmt->num_rows;
		echo $stmt->error;
		
		if($numRows){ 
			while($stmt->fetch()){ 
				$status_array_id[] = $status_id; 
				$status_array['status_id_'.$status_id] = $status_id;
				$status_array['status_name_'.$status_id] = $status_name;
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
    	<p><span style="font-size:2.5em;">PLACES</span> &nbsp;&nbsp;&nbsp;&nbsp;
        <span style="color:#06F;"><?php  if(count($places_array_id) == 0){
					echo 'No location';	
				}elseif(count($places_array_id) == 1){
					echo count($places_array_id). ' place';	
				}else{
					echo count($places_array_id). ' places';	
				} ?>
        </span>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <a href="add_place.php" id="add_book" style="//border:solid 1px black; text-decoration:none;padding:5px;color:white;background:#006600;"
        onMouseOver="this.style.background='black';this.style.color='white';"
        onMouseOut="this.style.background='#060';this.style.color='#fff';">+Add place</a>
        </p>
    </div>
    
    <div id="leftlib" style="width:30%;float:left;">
    	<?php 
		if(count($places_array_id) == 0){
			echo '<div style="color:#333;text-align:center;padding:10px;//border:1px solid black;width:100%;">No location.</div>';	
		}else{
			//display books as a list
			foreach($places_array_id as $places_array_id1){
			?>
			<ul>
				<a href="#" onclick="showPlaceDetail(<?php echo $places_array_id1; ?>); return false;"><li><?php echo $places_array['name_of_place_'.
				$places_array_id1]; ?></li></a>
			</ul>
		<?php }//foreach
		} ?>
		
    </div>
    
    <div id="rightlib" style="//border:solid 1px black; width:67%; left:32%; float:left; margin:6px 5px;">
    	<div id="innerrightlib" style="//padding:5px;"></div>
    </div>
</div>