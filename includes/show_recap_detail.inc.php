<?php require('connection.inc.php');

if(isset($_GET['recap_id'])){
	$recap_id = $_GET['recap_id'];
}
 
function convertToParas($text) {
$text = trim($text);
return '<p>' . preg_replace('/[\r\n]+/', '</p><p>', $text) . '</p>';
}
 
		$sql = "SELECT recap_id, recap_text_english, recap_text_french, DATE_FORMAT(date_created, '%d %b %Y %H:%i%p') as date_created, DATE_FORMAT(date_updated, '%d %b %Y %H:%i%p') as date_updated FROM daily_recap_english WHERE recap_id = '$recap_id' ORDER BY date_created DESC";
		$stmt = $conn->stmt_init();
		$stmt->prepare($sql);
		$stmt->bind_result($recap_id, $recap_text_english, $recap_text_french, $date_created, $date_updated);
		$ok = $stmt->execute();
		echo $stmt->error;
		$stmt->fetch();		
		$stmt->free_result();
		
?>
<script type="text/javascript" src="main.js"></script>

<div id="notes1" style="padding-top:10px;//border:solid 1px black;//clear:both;">
    <h3 style="border-bottom:1px solid black;">English version</h3>
    <div id="notes_details" style="padding:5px;color:black;">
    	<?php
			if(empty($recap_text_english)){echo '<i>No entry</i>';}
			else{
				echo convertToParas($recap_text_english);
			} 
		?>
    </div>
</div>

<div id="notes1" style="padding-top:10px;//border:solid 1px black;//clear:both;">
    <h3 style="border-bottom:1px solid black;">French version</h3>
    <div id="notes_details" style="padding:5px;color:black;">
    	<?php
			if(empty($recap_text_french)){echo '<i>No entry</i>';}
			else{
				echo convertToParas($recap_text_french);
			} 
		?>
    </div>
</div>
<div id="details" style="float:left;//border:solid 1px black;padding:5px;">
	
    <table border="0" cellspacing="10">
   	<tr>
    	<td><b>Date added:</b></td> <td><?php echo $date_created; ?></td>
    </tr>
    <tr>
    	<td><b>Last modified:</b></td> <td><?php echo $date_updated; ?></td>
    </tr>
    </table>
    
</div>

<table border="0">
<tr>
<td>
<div id="editbutton" style="float:left;margin-top:10px;">
	<a href="edit_recap.php?recap_id=<?php echo $recap_id;?>" style="padding:5px;border:1px solid black;color:black;text-decoration:none;margin-right:2px;" 
    onMouseOver="this.style.background='blue';this.style.color='white';"
    onMouseOut="this.style.background='white';this.style.color='black';">Edit</a>
</div>
</td>

<td>
<div id="deletebutton" style="float:left;margin-top:10px;">
	<a href="delete_recap.php?recap_id=<?php echo $recap_id;?>" style="padding:5px;border:1px solid black;color:black;text-decoration:none;" onMouseOver="this.style.background='red';this.style.color='white';"
    onMouseOut="this.style.background='white';this.style.color='black';">Delete</a>
</div>

</td>
</tr>
</table>

