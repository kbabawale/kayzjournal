<?php require('connection.inc.php');

$articles_array_id = array(); $articles_array = array(); $category_array = array(); $category_array_id = array();
		$sql = "SELECT articles_id, article_title, category_id, article_text, DATE_FORMAT(date_created, '%d %b %Y %H:%i%p') as date_created, date_updated FROM articles ORDER BY date_created DESC";
		$stmt = $conn->stmt_init();
		$stmt->prepare($sql);
		$stmt->bind_result($articles_id, $article_title, $category_id, $article_text, $date_created, $date_updated);
		$ok = $stmt->execute();
		$stmt->store_result();
		$numRows = $stmt->num_rows;
		echo $stmt->error;
		
		if($numRows){ 
			while($stmt->fetch()){ 
				$articles_array_id[] = $articles_id; 
				$articles_array['articles_id_'.$articles_id] = $articles_id;
				$articles_array['articles_title_'.$articles_id] = $article_title;
				$articles_array['category_id_'.$articles_id] = $category_id;
				$articles_array['articles_text_'.$articles_id] = $article_text;
				$articles_array['date_created_'.$articles_id] = $date_created;
				$articles_array['date_updated_'.$articles_id] = $date_updated;
			}//while
		}//numrows
		
		$stmt->free_result();
		
		//get details of status
		$sql = "SELECT * FROM category";
		$stmt->prepare($sql);
		$stmt->bind_result($category_id, $category_name);
		$ok = $stmt->execute();
		$stmt->store_result();
		$numRows = $stmt->num_rows;
		echo $stmt->error;
		
		if($numRows){ 
			while($stmt->fetch()){ 
				$category_array_id[] = $category_id; 
				$category_array['category_id_'.$category_id] = $category_id;
				$category_array['category_name_'.$category_id] = $category_name;
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
    	<p><span style="font-size:2.5em;">ARTICLES</span> &nbsp;&nbsp;&nbsp;&nbsp;
        <span style="color:#06F;"><?php  if(count($articles_array_id) == 0){
					echo 'No articles';	
				}elseif(count($articles_array_id) == 1){
					echo count($articles_array_id). ' article';	
				}else{
					echo count($articles_array_id). ' articles';	
				} ?>
        </span>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <a href="add_article.php" id="add_book" style="//border:solid 1px black; text-decoration:none;padding:5px;color:white;background:#006600;"
        onMouseOver="this.style.background='black';this.style.color='white';"
        onMouseOut="this.style.background='#060';this.style.color='#fff';">+Add article</a>
        </p>
    </div>
    
    <div id="leftlib" style="width:30%;float:left;">
    	<?php 
		if(count($articles_array_id) == 0){
			echo '<div style="color:#333;text-align:center;padding:10px;//border:1px solid black;width:100%;">No articles.</div>';	
		}else{
			//display books as a list
			foreach($articles_array_id as $articles_array_id1){
			?>
			<ul>
				<a href="#" onclick="showArticlesDetail(<?php echo $articles_array_id1; ?>); return false;"><li>
				<span style="float:inherit;"><?php echo $articles_array['articles_title_'.$articles_array_id1]; ?></span><br />
				<span style="float:inherit;background:#0066CC;padding:0 5px;"><?php echo $category_array['category_name_'.$articles_array['category_id_'.$articles_array_id1]]; ?></span></li></a>
			</ul>
		<?php }//foreach
		} ?>
		
    </div>
    
    <div id="rightlib" style="//border:solid 1px black; width:67%; left:32%; float:left; margin:6px 5px;">
    	<div id="innerrightlib" style="//padding:5px;"></div>
    </div>
</div>