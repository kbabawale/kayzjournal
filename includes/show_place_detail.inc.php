<?php require('connection.inc.php');

if(isset($_GET['place_id'])){
	$place_id = $_GET['place_id'];
}
 
function convertToParas($text) {
$text = trim($text);
return '<p>' . preg_replace('/[\r\n]+/', '</p><p>', $text) . '</p>';
}
 
		$place_array_id = array(); $place_array = array();  $status_array = array(); $status_array_id = array();
		$sql = "SELECT places_id, name_of_place, name_of_city, name_of_country, status_id, DATE_FORMAT(date_created, '%d %b %Y %H:%i%p') as date_created, DATE_FORMAT(date_updated, '%d %b %Y %H:%i%p') as date_updated, notes FROM places WHERE places_id = '$place_id' ORDER BY date_created ASC";
		$stmt = $conn->stmt_init();
		$stmt->prepare($sql);
		$stmt->bind_result($places_id, $name_of_place, $name_of_city, $name_of_country, $status_id, $date_created, $date_updated, $notes);
		$ok = $stmt->execute();
		echo $stmt->error;
		$stmt->fetch();		
		$stmt->free_result();
		
		//get details of status
		$sql = "SELECT status_name FROM status WHERE status_id = '$status_id'";
		$stmt->prepare($sql);
		$stmt->bind_result($status_name);
		$ok = $stmt->execute();
		echo $stmt->error;
		$stmt->fetch();		
		$stmt->free_result();
		
?>
<script type="text/javascript" src="main.js"></script>

<div id="bookimage" style="background:black;width:200px;height:200px;float:left;">
	<img src="" />
</div>

<div id="details" style="float:left;//border:solid 1px black;padding:5px;">
	<h3 style="//border:solid 1px black;"><?php echo $name_of_place; ?></h3>
    
	<?php if($status_id == 5){ ?>
    <div id="status" style="//border:solid 1px black;padding:3px;margin:5px 0px;text-align:center;background:#0F0;color:white;width:200px;">
		<?php echo $status_name; ?>
    </div>
    <?php }elseif($status_id == 6){ ?>
    <div id="status" style="//border:solid 1px black;padding:3px;margin:5px 0px;text-align:center;background:#F00;color:white;width:200px;">
		<?php echo $status_name; ?>
    </div>
    <?php } ?>
    
    <table border="0" cellspacing="10">
   	<tr>
    	<td><b>Name of City:</b></td> <td><?php echo $name_of_city; ?></td>
    </tr>
    <tr>
    	<td><b>Name of Country:</b></td> <td><?php echo $name_of_country; ?></td>
    </tr>
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
	<a href="edit_place.php?place_id=<?php echo $place_id;?>" style="padding:5px;border:1px solid black;color:black;text-decoration:none;margin-right:2px;" 
    onMouseOver="this.style.background='blue';this.style.color='white';"
    onMouseOut="this.style.background='white';this.style.color='black';">Edit</a>
</div>
</td>

<td>
<div id="deletebutton" style="float:left;margin-top:10px;">
	<a href="delete_place.php?place_id=<?php echo $place_id;?>" style="padding:5px;border:1px solid black;color:black;text-decoration:none;" onMouseOver="this.style.background='red';this.style.color='white';"
    onMouseOut="this.style.background='white';this.style.color='black';">Delete</a>
</div>

</td>
</tr>
</table>

<div id="notes" style="padding-top:10px;//border:solid 1px black;clear:both;">
    <h3 style="border-bottom:1px solid black;">Notes</h3>
    <div id="notes_details" style="padding:5px;color:black;">
    	<?php
			if(empty($notes)){echo '<i>No notes</i>';}
			else{
				echo convertToParas($notes);
			} 
		?>
    </div>
</div>