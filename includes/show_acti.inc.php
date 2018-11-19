<?php 
require('connection.inc.php');

$acti_array_id = array(); $acti_array = array(); 
		$sql = "SELECT * FROM activities";
		$stmt = $conn->stmt_init();
		$stmt->prepare($sql);
		$stmt->bind_result($acti_id, $name_of_activity, $notes, $date_created, $date_updated);
		$ok = $stmt->execute();
		$stmt->store_result();
		$numRows = $stmt->num_rows;
		echo $stmt->error;
		
		if($numRows){ 
			while($stmt->fetch()){ 
				$acti_array_id[] = $acti_id; 
				$acti_array['acti_id_'.$acti_id] = $acti_id;
				$acti_array['name_of_activity_'.$acti_id] = $name_of_activity;
				$acti_array['notes_'.$acti_id] = $notes;
				$acti_array['date_created_'.$acti_id] = $date_created;
				$acti_array['date_updated_'.$acti_id] = $date_updated;
			}//while
		}//numrows
		
		$stmt->free_result();
		
?>
<script type="text/javascript" src="main.js"></script>

<style type="text/css">
li{
	list-style-type:none;
	padding:10px 5px;
	//background:black;
	margin:5px 0px;
	text-align:center;
	border-bottom:1px solid black;
}
a{
	text-decoration:none;
	color:white;
}
li:hover{
	//background:#333333;
	//color:white;
}

</style>


<div id="toplib" style="width:100%; color:#000; border-bottom:2px solid black; padding-bottom:10px;">
    	<p><span style="font-size:2.5em;">ACTIVITIES</span> &nbsp;&nbsp;&nbsp;&nbsp;
        <span style="color:#06F;"><?php  if(count($acti_array_id) == 0){
					echo 'No activities';	
				}elseif(count($acti_array_id) == 1){
					echo count($acti_array_id). ' activity';	
				}else{
					echo count($acti_array_id). ' activities';	
				} ?>
        </span>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <a href="add_acti.php" id="add_quote" style="//border:solid 1px black; text-decoration:none;padding:5px;color:white;background:#006600;"
        onMouseOver="this.style.background='black';this.style.color='white';"
        onMouseOut="this.style.background='#060';this.style.color='#fff';">+Add activity</a>
        </p>
</div>

<div id="mainquote">
	<?php 
		if(count($acti_array_id) == 0){
			echo '<div style="color:#333;text-align:center;padding:10px;//border:1px solid black;width:100%;">No activities.</div>';	
		}else{
			//display books as a list
			foreach($acti_array_id as $acti_array_id1){
			?>
			<ul>
				<li>
					<div>                	
                        <p><?php echo $acti_array['name_of_activity_'.$acti_array_id1]; ?></p>
                    </div>
                     
                    <div>
                        <table border="0">
                        <tr>
                        <td>
                        <div id="editbutton" style="float:left;margin-top:10px;">
                            <a href="edit_acti.php?acti_id=<?php echo $acti_array['acti_id_'.$acti_array_id1]; ?>" 
                            style="padding:5px;border:1px solid black;color:black;text-decoration:none;margin-right:2px;" 
                            onMouseOver="this.style.background='blue';this.style.color='white';"
                            onMouseOut="this.style.background='white';this.style.color='black';">Edit</a>
                        </div>
                        </td>
                        
                        <td>
                        <div id="deletebutton" style="float:left;margin-top:10px;">
                            <a href="delete_acti.php?acti_id=<?php echo $acti_array['acti_id_'.$acti_array_id1]; ?>" 
                            style="padding:5px;border:1px solid black;color:black;text-decoration:none;" 
                            onMouseOver="this.style.background='red';this.style.color='white';"
                            onMouseOut="this.style.background='white';this.style.color='black';">Delete</a>
                        </div>
                        
                        </td>
                        </tr>
                        </table>
                        </div>
                     
                </li>
			</ul>
		<?php }//foreach
		} ?>
        
        

</div>