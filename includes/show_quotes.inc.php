<?php 
require('connection.inc.php');

$quotes_array_id = array(); $quotes_array = array(); 
		$sql = "SELECT * FROM quotes";
		$stmt = $conn->stmt_init();
		$stmt->prepare($sql);
		$stmt->bind_result($quote_id, $quote_details, $date_created, $date_updated, $quoter);
		$ok = $stmt->execute();
		$stmt->store_result();
		$numRows = $stmt->num_rows;
		echo $stmt->error;
		
		if($numRows){ 
			while($stmt->fetch()){ 
				$quotes_array_id[] = $quote_id; 
				$quotes_array['quote_id_'.$quote_id] = $quote_id;
				$quotes_array['quote_details_'.$quote_id] = $quote_details;
				$quotes_array['date_created_'.$quote_id] = $date_created;
				$quotes_array['date_updated_'.$quote_id] = $date_updated;
				$quotes_array['quoter_'.$quote_id] = $quoter;
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
    	<p><span style="font-size:2.5em;">QUOTES</span> &nbsp;&nbsp;&nbsp;&nbsp;
        <span style="color:#06F;"><?php  if(count($quotes_array_id) == 0){
					echo 'No quotes';	
				}elseif(count($quotes_array_id) == 1){
					echo count($quotes_array_id). ' quote';	
				}else{
					echo count($quotes_array_id). ' quotes';	
				} ?>
        </span>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <a href="add_quote.php" id="add_quote" style="//border:solid 1px black; text-decoration:none;padding:5px;color:white;background:#006600;"
        onMouseOver="this.style.background='black';this.style.color='white';"
        onMouseOut="this.style.background='#060';this.style.color='#fff';">+Add quote</a>
        </p>
</div>

<div id="mainquote">
	<?php 
		if(count($quotes_array_id) == 0){
			echo '<div style="color:#333;text-align:center;padding:10px;//border:1px solid black;width:100%;">No quotes.</div>';	
		}else{
			//display books as a list
			foreach($quotes_array_id as $quotes_array_id1){
			?>
			<ul>
				<li>
					<div>                	
                        <p><?php echo $quotes_array['quote_details_'.$quotes_array_id1]; ?></p>
                    </div>
                    <div>
                        <?php if($quotes_array['quoter_'.$quotes_array_id1]){ ?>
                            <span style="font-size:.8em;//border:1px solid black;//float:left;">
                            <?php echo $quotes_array['quoter_'.$quotes_array_id1]; ?>
                            </span>	
                        <?php }?>
                     </div>
                     
                     <div>
                        <table border="0">
                        <tr>
                        <td>
                        <div id="editbutton" style="float:left;margin-top:10px;">
                            <a href="edit_quote.php?quote_id=<?php echo $quotes_array['quote_id_'.$quotes_array_id1]; ?>" 
                            style="padding:5px;border:1px solid black;color:black;text-decoration:none;margin-right:2px;" 
                            onMouseOver="this.style.background='blue';this.style.color='white';"
                            onMouseOut="this.style.background='white';this.style.color='black';">Edit</a>
                        </div>
                        </td>
                        
                        <td>
                        <div id="deletebutton" style="float:left;margin-top:10px;">
                            <a href="delete_quote.php?quote_id=<?php echo $quotes_array['quote_id_'.$quotes_array_id1]; ?>" 
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