<?php require('connection.inc.php');

if(isset($_GET['book_id'])){
	$book_id = $_GET['book_id'];
}
 
function convertToParas($text) {
$text = trim($text);
return '<p>' . preg_replace('/[\r\n]+/', '</p><p>', $text) . '</p>';
}
 
		$books_array_id = array(); $books_array = array(); $status_array = array(); $status_array_id = array();
		$sql = "SELECT books_id, name_of_book, status_id, author, edition, year, notes, image_filename, DATE_FORMAT(date_created, '%d %b %Y %H:%i%p') as date_created1, DATE_FORMAT(date_updated, '%d %b %Y %H:%i%p') as date_updated1 FROM books WHERE books_id = '$book_id' ORDER BY date_created ASC";
		$stmt = $conn->stmt_init();
		$stmt->prepare($sql);
		$stmt->bind_result($books_id, $name_of_book, $status_id, $author, $edition, $year, $notes, $image_filename, $date_created, $date_updated);
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
	<h3 style="//border:solid 1px black;"><?php echo $name_of_book; ?></h3>
    
	<?php if($status_id == 1){ ?>
    <div id="status" style="//border:solid 1px black;padding:3px;margin:5px 0px;text-align:center;background:#F00;color:white;width:200px;">
		<?php echo $status_name; ?>
    </div>
    <?php }elseif($status_id == 2){ ?>
    <div id="status" style="//border:solid 1px black;padding:3px;margin:5px 0px;text-align:center;background:#F60;color:white;width:200px;">
		<?php echo $status_name; ?>
    </div>
    <?php }elseif($status_id == 3){ ?>
    <div id="status" style="//border:solid 1px black;padding:3px;margin:5px 0px;text-align:center;background:#FF0;color:white;width:200px;">
		<?php echo $status_name; ?>
    </div>
    <?php }elseif($status_id == 4){ ?>
    <div id="status" style="//border:solid 1px black;padding:3px;margin:5px 0px;text-align:center;background:#0F0;color:white;width:200px;">
		<?php echo $status_name; ?>
    </div>
    <?php } ?>
    
    <table border="0" cellspacing="10">
    <tr>
    	<td><b>Author:</b></td> <td><?php echo $author; ?></td>
    </tr>
    <tr>
    	<td><b>Edition:</b></td> <td><?php echo $edition; ?></td>
    </tr>
    <tr>
    	<td><b>Year:</b></td> <td><?php echo $year; ?></td>
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
	<a href="edit_book.php?book_id=<?php echo $book_id;?>" style="padding:5px;border:1px solid black;color:black;text-decoration:none;margin-right:2px;" 
    onMouseOver="this.style.background='blue';this.style.color='white';"
    onMouseOut="this.style.background='white';this.style.color='black';">Edit</a>
</div>
</td>

<td>
<div id="deletebutton" style="float:left;margin-top:10px;">
	<a href="delete_book.php?book_id=<?php echo $book_id;?>" style="padding:5px;border:1px solid black;color:black;text-decoration:none;" onMouseOver="this.style.background='red';this.style.color='white';"
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