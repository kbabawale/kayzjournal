<?php require('includes/connection.inc.php'); 
$missing = ''; $errors = '';
if(isset($_POST['submit'])){
	//list expected fields
	$expected = array('name_of_place','edit_status','name_of_city','name_of_country');
	
	//set required fields
	$required = array('name_of_place');

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
			
		//prepare SQL statement
		$sql = 'INSERT INTO places (name_of_place, name_of_city, name_of_country, status_id, date_created) VALUES (?,?,?,?,NOW())';
			
			//require_once('includes/connection.inc.php');

			$stmt = $conn->stmt_init();
			$stmt->prepare($sql);
			$stmt->bind_param('sssi', $name_of_place, $name_of_city, $name_of_country, $edit_status);
			$stmt->execute();
			$err = $stmt->error;
			
			if($stmt->affected_rows == 1){
				header('Location:personal_philosophy.php?ref=places');
				exit;	
			}elseif($err){
			}
			
		}
}

}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Add new place - Kayz Journal</title>
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
                    	<h2>Add new place</h2>
                        
                        <form method="post" action="" id="frm1" name="frm1">
                        	<table border="0" width="100%" style="font-style:normal;">
                                <tr>
                                    <td width="30%">
                                        <label for="name">Name of place</label>
                                    </td>
                                    <td  width="50%"> 
                                        <input type="text" id="name_of_place" name="name_of_place"
                                        <?php if($missing || $errors) {echo 'value="'. htmlentities($_POST['name_of_place'], ENT_COMPAT, 'UTF-8') 
										.'"';} ?>
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
                                        	<option value="5">Visited</option>
                                            <option value="6">Not visited</option>
                                        </select>
                                    </td>    
                                </tr>
                                
                                <tr>
                                    <td width="30%">
                                        <label for="name">Name of City</label>
                                    </td>
                                    <td  width="50%"> 
                                        <input type="text" id="name_of_city" name="name_of_city"
                                        <?php if($missing || $errors) {echo 'value="'. htmlentities($_POST['name_of_city'], ENT_COMPAT, 'UTF-8') 
										.'"';} ?>
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
                                        <input type="text" id="name_of_country" name="name_of_country"
                                        <?php if($missing || $errors) {echo 'value="'. htmlentities($_POST['name_of_country'], ENT_COMPAT, 'UTF-8') 
										.'"';} ?>
                                        style="width:80%; height:30px; margin:5px 0 0 0; padding:5px;color:#000; background:inherit; 
                                        border:#000 solid 1px;
                                        font-size:1.0em;font-family:'Microsoft JhengHei',Microsoft JhengHei Light;"/>
                                    </td>
                                </tr>
                                
                                <tr>
                                	<td>
                                        <input type="submit" name="submit" id="submit" style="padding:5px 20px;background:black;
                                        border:none;color:white;cursor:pointer;font-size:1em;font-family:'Microsoft JhengHei',Microsoft JhengHei 
                                        Light;text-align:center;" onMouseOver="this.style.background='#333'"
                                        onMouseOut="this.style.background='black'" value="Add Book">
                                    </td>
                                </tr>
                                 
                                </table>

                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
     </div>
     
     <?php require('includes/footer.inc.php');?>
     
    
</div>

</body>
</html>