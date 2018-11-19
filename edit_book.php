<?php require('includes/connection.inc.php');

$go_on = false;
$book_id='';

function convertToParas($text) {
$text = trim($text);
return '<p>' . preg_replace('/[\r\n]+/', '</p><p>', $text) . '</p>';
}

if(isset($_GET['book_id'])){
	$book_id = $_GET['book_id'];
	$go_on = true;
}else{
	$go_on = false;
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
		
		if(isset($_POST['submit'])){
			require('includes/edit_book.inc.php');	
			
		}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Edit Book (<?php echo $name_of_book; ?>) - Kayz Journal</title>
<link href="style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="includes/main.js">
</script>

</head>

<body onLoad="updateClock(); setInterval('updateClock()', 1000); randomizeQuotes();">
<div id="maincontent">
	<?php require('includes/header.inc.php');?>
    
     <div id="mainbody">
    	<div id="inner_mainbody">
        	
            <div id="titlebar">
            	<p><a href="home.php">Index</a> / Personal Philosophy</p>
            </div>
            
            <div id="mainmenu">
            	<?php require('includes/leftsidemenu.inc.php');?>
                <div id="rightsidemenu">
                	<div id="innerrightsidemenu">
                    <?php if($go_on){ ?>	
                        <h2>Edit book - (<?php echo $name_of_book; ?>)</h2>
                        <form method="post" action="" id="frm1" name="frm1">
                        	<table border="0" width="100%" style="font-style:normal;">
                                <tr>
                                    <td width="30%">
                                        <label for="name">Name of book</label>
                                    </td>
                                    <td  width="50%"> 
                                        <input type="text" value="<?php echo $name_of_book; ?>" id="name_of_book" name="name_of_book"
                                        style="width:80%; height:30px; margin:5px 0 0 0; padding:5px;color:#000; background:inherit; 
                                        border:#000 solid 1px;
                                        font-size:1.0em;font-family:'Microsoft JhengHei',Microsoft JhengHei Light;"/>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td width="30%">
                                        <label for="status">Status</label>
                                    </td>
                                    <td>    
                                        <select id="edit_status" name="edit_status"
                                        style="background:inherit;width:300px;height:35px; border:black 1px solid;
                                        font-family:'Microsoft JhengHei',Microsoft JhengHei Light; font-size:1.0em;padding:5px;color:#000;" 
                                        onfocus="this.style.border='solid #000 1px';">
                                                
                                            <?php 
                                            $sql = 'SELECT * FROM status';
                                            //$stmt = $conn->stmt_init();
                                            $stmt->prepare($sql);
                                            $stmt->bind_result($status_idd, $status_namee);
                                            $stmt->execute();
                                            
                                            while($stmt->fetch()){ ?>
                                                <option value="<?php echo $status_idd; ?>" <?php
                                                    if ($status_name == $status_namee) {
                                                      echo 'selected';
                                                    } ?>><?php echo $status_namee; ?></option>
                                                <?php } ?>
                                            
                                        </select>
                                    </td>    
                                </tr>
                                
                                <tr>
                                    <td width="30%">
                                        <label for="name">Author</label>
                                    </td>
                                    <td  width="50%"> 
                                        <input type="text" value="<?php echo $author; ?>" id="author" name="author"
                                        style="width:80%; height:30px; margin:5px 0 0 0; padding:5px;color:#000; background:inherit; 
                                        border:#000 solid 1px;
                                        font-size:1.0em;font-family:'Microsoft JhengHei',Microsoft JhengHei Light;"/>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td width="30%">
                                        <label for="name">Edition</label>
                                    </td>
                                    <td  width="50%"> 
                                        <input type="text" value="<?php echo $edition; ?>" id="edition" name="edition"
                                        style="width:80%; height:30px; margin:5px 0 0 0; padding:5px;color:#000; background:inherit; 
                                        border:#000 solid 1px;
                                        font-size:1.0em;font-family:'Microsoft JhengHei',Microsoft JhengHei Light;"/>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td width="30%">
                                        <label for="name">Year</label>
                                    </td>
                                    <td  width="50%"> 
                                        <input type="text" value="<?php echo $year; ?>" id="year" name="year"
                                        style="width:80%; height:30px; margin:5px 0 0 0; padding:5px;color:#000; background:inherit; 
                                        border:#000 solid 1px;
                                        font-size:1.0em;font-family:'Microsoft JhengHei',Microsoft JhengHei Light;"/>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td width="30%">
                                        <label for="name">Notes</label>
                                    </td>
                                	<td  width="50%"> 
                                        <textarea id="notes" name="notes"
                                        style="width:80%; height:400px; margin:5px 0 0 0;padding:5px; color:#000; background:inherit; border:
                                        #000 solid 1px;
                                        font-size:1.0em; font-family:'Microsoft JhengHei',Microsoft JhengHei Light;"><?php echo $notes; ?></textarea>
                                    </td>
                                </tr>
                                
                                <tr>
                                	<td>
                                        <input type="submit" name="submit" id="submit" style="padding:5px 20px;background:black;
                                        border:none;color:white;cursor:pointer;font-size:1em;font-family:'Microsoft JhengHei',Microsoft JhengHei 
                                        Light;text-align:center;" onMouseOver="this.style.background='#333'"
                                        onMouseOut="this.style.background='black'" value="Edit">
                                    </td>
                                </tr>
                                 
                                </table>

                        </form>
                        <?php } else{ ?>
                        	<div id="error_msg">
                            	No info available..
                            </div>
						<?php } ?>
                    </div>
                </div>
            </div>
        </div>
     </div>
     
     <?php require('includes/footer.inc.php');?>
     
    
</div>


</body>
</html>