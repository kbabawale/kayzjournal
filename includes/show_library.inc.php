<?php require('connection.inc.php');

$books_array_id = array(); $books_array = array(); $status_array = array(); $status_array_id = array();
		$sql = "SELECT * FROM books ORDER BY date_created ASC";
		$stmt = $conn->stmt_init();
		$stmt->prepare($sql);
		$stmt->bind_result($books_id, $name_of_book, $status_id, $author, $edition, $year, $notes, $image_filename, $date_created, $date_updated);
		$ok = $stmt->execute();
		$stmt->store_result();
		$numRows = $stmt->num_rows;
		echo $stmt->error;
		
		if($numRows){ 
			while($stmt->fetch()){ 
				$books_array_id[] = $books_id; 
				$books_array['books_id_'.$books_id] = $books_id;
				$books_array['name_of_book_'.$books_id] = $name_of_book;
				$books_array['status_id_'.$books_id] = $status_id;
				$books_array['author_'.$books_id] = $author;
				$books_array['edition_'.$books_id] = $edition;
				$books_array['year_'.$books_id] = $year;
				$books_array['notes_'.$books_id] = $notes;
				$books_array['image_filename_'.$books_id] = $image_filename;
				$books_array['date_created_'.$books_id] = $date_created;
				$books_array['date_updated_'.$books_id] = $date_updated;
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
    	<p><span style="font-size:2.5em;">LIBRARY</span> &nbsp;&nbsp;&nbsp;&nbsp;
        <span style="color:#06F;"><?php  if(count($books_array_id) == 0){
					echo 'No books';	
				}elseif(count($books_array_id) == 1){
					echo count($books_array_id). ' book';	
				}else{
					echo count($books_array_id). ' books';	
				} ?>
        </span>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <a href="add_book.php" id="add_book" style="//border:solid 1px black; text-decoration:none;padding:5px;color:white;background:#006600;"
        onMouseOver="this.style.background='black';this.style.color='white';"
        onMouseOut="this.style.background='#060';this.style.color='#fff';">+Add book to library</a>
        </p>
    </div>
    
    <div id="leftlib" style="width:30%;float:left;">
    	<?php 
		if(count($books_array_id) == 0){
			echo '<div style="color:#333;text-align:center;padding:10px;//border:1px solid black;width:100%;">No books.</div>';	
		}else{
			//display books as a list
			foreach($books_array_id as $books_array_id1){
			?>
			<ul>
				<a href="#" onclick="showBookDetail(<?php echo $books_array_id1; ?>); return false;"><li><?php echo $books_array['name_of_book_'.
				$books_array_id1]; ?></li></a>
			</ul>
		<?php }//foreach
		} ?>
		
    </div>
    
    <div id="rightlib" style="//border:solid 1px black; width:67%; left:32%; float:left; margin:6px 5px;">
    	<div id="innerrightlib" style="//padding:5px;"></div>
    </div>
</div>