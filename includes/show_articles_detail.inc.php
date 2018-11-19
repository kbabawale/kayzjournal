<?php require('connection.inc.php');

if(isset($_GET['articles_id'])){
	$articles_id = $_GET['articles_id'];
}
 
function convertToParas($text) {
$text = trim($text);
return '<p>' . preg_replace('/[\r\n]+/', '</p><p>', $text) . '</p>';
}
 
 		$sql = "SELECT articles_id, article_title, category_id, article_text, DATE_FORMAT(date_created, '%d %b %Y %H:%i%p') as date_created, 
		date_updated FROM articles WHERE articles_id = '$articles_id' ORDER BY date_created DESC";
		$stmt = $conn->stmt_init();
		$stmt->prepare($sql);
		$stmt->bind_result($articles_id, $article_title, $category_id, $article_text, $date_created, $date_updated);
		$ok = $stmt->execute();
		echo $stmt->error;
		$stmt->fetch();		
		$stmt->free_result();
		
		//get details of status
		$sql = "SELECT category_name FROM category WHERE category_id = '$category_id'";
		$stmt->prepare($sql);
		$stmt->bind_result($category_name);
		$ok = $stmt->execute();
		echo $stmt->error;
		$stmt->fetch();		
		$stmt->free_result();		
?>
<script type="text/javascript" src="main.js"></script>

<div id="details" style="float:left;//border:solid 1px black;padding:5px;">
	<h3 style="//border:solid 1px black;"><?php echo $article_title; ?></h3>
    
	
    
		<?php 
		if($category_id != ''){ ?>
			<div id="status" style="//border:solid 1px black;padding:3px;margin:5px 0px;text-align:center;background:#00F;color:white;width:200px;">
        	<?php echo $category_name; ?>		
			</div>
	<?php	}
		?>
    
    
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
	<a href="edit_article.php?articles_id=<?php echo $articles_id;?>" style="padding:5px;border:1px solid black;color:black;text-decoration:none;margin-right:2px;" 
    onMouseOver="this.style.background='blue';this.style.color='white';"
    onMouseOut="this.style.background='white';this.style.color='black';">Edit</a>
</div>
</td>

<td>
<div id="deletebutton" style="float:left;margin-top:10px;">
	<a href="delete_article.php?articles_id=<?php echo $articles_id;?>" style="padding:5px;border:1px solid black;color:black;text-decoration:none;" onMouseOver="this.style.background='red';this.style.color='white';"
    onMouseOut="this.style.background='white';this.style.color='black';">Delete</a>
</div>

</td>
</tr>
</table>

<div id="notes" style="padding-top:10px;//border:solid 1px black;clear:both;">
    <h3 style="border-bottom:1px solid black;">Notes</h3>
    <div id="notes_details" style="padding:5px;color:black;">
    	<?php
			if(empty($article_text)){echo '<i>No notes</i>';}
			else{
				echo convertToParas($article_text);
			} 
		?>
    </div>
</div>