<?php require('connection.inc.php');

$movies_array_id = array(); $movies_array = array(); $status_array = array(); $status_array_id = array();
		$sql = "SELECT * FROM movies ORDER BY date_created ASC";
		$stmt = $conn->stmt_init();
		$stmt->prepare($sql);
		$stmt->bind_result($movies_id, $name_of_movie, $year, $genre, $status_id, $image_filename, $notes, $date_created, $date_updated);
		$ok = $stmt->execute();
		$stmt->store_result();
		$numRows = $stmt->num_rows;
		echo $stmt->error;
		
		if($numRows){ 
			while($stmt->fetch()){ 
				$movies_array_id[] = $movies_id; 
				$movies_array['movies_id_'.$movies_id] = $movies_id;
				$movies_array['name_of_movie_'.$movies_id] = $name_of_movie;
				$movies_array['year_'.$movies_id] = $year;
				$movies_array['genre_'.$movies_id] = $genre;
				$movies_array['status_id_'.$movies_id] = $status_id;
				$movies_array['image_filename_'.$movies_id] = $image_filename;
				$movies_array['notes_'.$movies_id] = $notes;
				$movies_array['date_created_'.$movies_id] = $date_created;
				$movies_array['date_updated_'.$movies_id] = $date_updated;
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
    	<p><span style="font-size:2.5em;">MOVIES</span> &nbsp;&nbsp;&nbsp;&nbsp;
        <span style="color:#06F;"><?php  if(count($movies_array_id) == 0){
					echo 'No movies';	
				}elseif(count($movies_array_id) == 1){
					echo count($movies_array_id). ' movie';	
				}else{
					echo count($movies_array_id). ' movies';	
				} ?>
        </span>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <a href="add_movie.php" id="add_book" style="//border:solid 1px black; text-decoration:none;padding:5px;color:white;background:#006600;"
        onMouseOver="this.style.background='black';this.style.color='white';"
        onMouseOut="this.style.background='#060';this.style.color='#fff';">+Add movie</a>
        </p>
    </div>
    
    <div id="leftlib" style="width:30%;float:left;">
    	<?php 
		if(count($movies_array_id) == 0){
			echo '<div style="color:#333;text-align:center;padding:10px;//border:1px solid black;width:100%;">No movies.</div>';	
		}else{
			//display books as a list
			foreach($movies_array_id as $movies_array_id1){
			?>
			<ul>
				<a href="#" onclick="showMovieDetail(<?php echo $movies_array_id1; ?>); return false;"><li><?php echo $movies_array['name_of_movie_'.
				$movies_array_id1]; ?></li></a>
			</ul>
		<?php }//foreach
		} ?>
		
    </div>
    
    <div id="rightlib" style="//border:solid 1px black; width:67%; left:32%; float:left; margin:6px 5px;">
    	<div id="innerrightlib" style="//padding:5px;"></div>
    </div>
</div>