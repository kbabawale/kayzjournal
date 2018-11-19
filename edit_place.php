<?php require('includes/connection.inc.php');

$go_on = false;
$place_id='';

function convertToParas($text) {
$text = trim($text);
return '<p>' . preg_replace('/[\r\n]+/', '</p><p>', $text) . '</p>';
}

if(isset($_GET['place_id'])){
	$place_id = $_GET['place_id'];
	$go_on = true;
}else{
	$go_on = false;
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
		
		if(isset($_POST['submit'])){
			$expected = array('name_of_place','edit_status','name_of_city','name_of_country','notes');
			$required = array('name_of_place');
			$errors = '';
			$victory = false;
			$missing = array();
			
			//assume nothing is suspect
			$suspect = false;
			//create a pattern to locate suspect phrase
			$pattern = '/Content-Type:|Bcc:|Cc:/i';
			
			//function to check for suspect phrases
			function isSuspect($val, $pattern, &$suspect){
				//if the variable is an array, loop through each element
				//and pass it recursively back to the same function
				if(is_array($val)){
					foreach($val as $item){
						isSuspect($item, $pattern, $suspect);
					}
				} else{
					//if one of the suspect phrases is found, set Boolean to true
					if(preg_match($pattern, $val)){
						$suspect = true;
					}
				}
			}
			
			//check the POST array and any subarrays for suspect content
			isSuspect($_POST, $pattern, $suspect);
			
			if(!$suspect){
				foreach ($_POST as $key => $value) {
					// assign to temporary variable and strip whitespace if not an array
					$temp = is_array($value) ? $value : trim($value);
					// if empty and required, add to $missing array
					if (empty($temp) && in_array($key, $required)) {
						$missing[] = $key;
						} elseif (in_array($key, $expected)) {
						// otherwise, assign to a variable of the same name as $key
						${$key} = $temp;
						}
					}
				}		
			
				
			//go ahead only if not suspect and all required fields are okay
			if(!$suspect && !$missing){
				
				if(!$errors){
					
					$name_of_place = trim($name_of_place);
					$edit_status = trim($edit_status);
					$name_of_city = trim($name_of_city);
					$name_of_country = trim($name_of_country);
					$notes = trim($notes);
					
						$sql = 'UPDATE places SET name_of_place = ?, name_of_city = ?, name_of_country = ?, status_id = ?, notes = ? WHERE places_id = ?';
						$stmt = $conn->stmt_init();
						$stmt->prepare($sql);
						$stmt->bind_param('sssisi', $name_of_place, $name_of_city, $name_of_country, $edit_status, $notes, $place_id);
						$stmt->execute();
						$err = $stmt->error;
						//$stmt->free_result();
						
						
						if(!$err){
							header('Location:http://127.0.0.1/kayzjournal/personal_philosophy.php?ref=places');
							exit;
						}
						
				}
			}
		} //isset
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Edit Place (<?php echo $name_of_place; ?>) - Kayz Journal</title>
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
                        <h2>Edit place - (<?php echo $name_of_place; ?>)</h2>
                        <form method="post" action="" id="frm1" name="frm1">
                        	<table border="0" width="100%" style="font-style:normal;">
                                <tr>
                                    <td width="30%">
                                        <label for="name">Name of place</label>
                                    </td>
                                    <td  width="50%"> 
                                        <input type="text" value="<?php echo $name_of_place; ?>" id="name_of_place" name="name_of_place"
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
                                            ?>
                                        </select>
                                    </td>    
                                </tr>
                                
                                <tr>
                                    <td width="30%">
                                        <label for="name">Name of City</label>
                                    </td>
                                    <td  width="50%"> 
                                        <input type="text" value="<?php echo $name_of_city; ?>" id="name_of_city" name="name_of_city"
                                        style="width:80%; height:30px; margin:5px 0 0 0; padding:5px;color:#000; background:inherit; 
                                        border:#000 solid 1px;
                                        font-size:1.0em;font-family:'Microsoft JhengHei',Microsoft JhengHei Light;"/>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td width="30%">
                                        <label for="name">Name of Country</label>
                                    </td>
                                    <td  width="50%"> 
                                        <input type="text" value="<?php echo $name_of_country; ?>" id="name_of_country" name="name_of_country"
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
                                        style="width:80%; height:100px; margin:5px 0 0 0;padding:5px; color:#000; background:inherit; border:
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