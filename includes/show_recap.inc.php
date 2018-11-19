<?php require('connection.inc.php');

$recap_array_id = array(); $recap_array = array(); 
		$sql = "SELECT recap_id, recap_text_english, recap_text_french, DATE_FORMAT(date_created, '%d %b %Y %H:%i%p') as date_created, date_updated FROM daily_recap_english ORDER BY date_created DESC";
		$stmt = $conn->stmt_init();
		$stmt->prepare($sql);
		$stmt->bind_result($recap_id, $recap_text_english, $recap_text_french, $date_created, $date_updated);
		$ok = $stmt->execute();
		$stmt->store_result();
		$numRows = $stmt->num_rows;
		echo $stmt->error;
		
		if($numRows){ 
			while($stmt->fetch()){ 
				$recap_array_id[] = $recap_id; 
				$recap_array['recap_id_'.$recap_id] = $recap_id;
				$recap_array['recap_text_english_'.$recap_id] = $recap_text_english;
				$recap_array['recap_text_french_'.$recap_id] = $recap_text_french;
				$recap_array['date_created_'.$recap_id] = $date_created;
				$recap_array['date_updated_'.$recap_id] = $date_updated;
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
    	<p><span style="font-size:2.5em;">DAILY RECAP</span> &nbsp;&nbsp;&nbsp;&nbsp;
        <span style="color:#06F;"><?php  if(count($recap_array_id) == 0){
					echo 'No entries';	
				}elseif(count($recap_array_id) == 1){
					echo count($recap_array_id). ' entry';	
				}else{
					echo count($recap_array_id). ' entries';	
				} ?>
        </span>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <a href="add_recap.php" id="add_book" style="//border:solid 1px black; text-decoration:none;padding:5px;color:white;background:#006600;"
        onMouseOver="this.style.background='black';this.style.color='white';"
        onMouseOut="this.style.background='#060';this.style.color='#fff';">+Add entry</a>
        </p>
    </div>
    
    <div id="leftlib" style="width:30%;float:left;">
    	<?php 
		if(count($recap_array_id) == 0){
			echo '<div style="color:#333;text-align:center;padding:10px;//border:1px solid black;width:100%;">No entries.</div>';	
		}else{
			//display books as a list
			foreach($recap_array_id as $recap_array_id1){
			?>
			<ul>
				<a href="#" onclick="showRecapDetail(<?php echo $recap_array_id1; ?>); return false;"><li><?php echo $recap_array['date_created_'.
				$recap_array_id1]; ?></li></a>
			</ul>
		<?php }//foreach
		} ?>
		
    </div>
    
    <div id="rightlib" style="//border:solid 1px black; width:67%; left:32%; float:left; margin:6px 5px;">
    	<div id="innerrightlib" style="//padding:5px;"></div>
    </div>
</div>