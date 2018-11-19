<?php require('includes/connection.inc.php');

$go_on = false;
$recap_id='';

function convertToParas($text) {
$text = trim($text);
return '<p>' . preg_replace('/[\r\n]+/', '</p><p>', $text) . '</p>';
}

if(isset($_GET['recap_id'])){
	$recap_id = $_GET['recap_id'];
	$go_on = true;
}else{
	$go_on = false;
}

		$sql = "SELECT recap_id, recap_text_english, recap_text_french, DATE_FORMAT(date_created, '%d %b %Y %H:%i%p') as date_created, DATE_FORMAT(date_updated, '%d %b %Y %H:%i%p') as date_updated FROM daily_recap_english WHERE recap_id = '$recap_id' ORDER BY date_created DESC";
		$stmt = $conn->stmt_init();
		$stmt->prepare($sql);
		$stmt->bind_result($recap_id, $english, $french, $date_created, $date_updated);
		$ok = $stmt->execute();
		echo $stmt->error;
		$stmt->fetch();		
		$stmt->free_result();
		
if(isset($_POST['submit'])){
	
$expected = array('english', 'french');
$required = array('english');
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
		
		$english = trim($english);
		$french = trim($french);
		
			$sql = 'UPDATE daily_recap_english SET recap_text_english = ?, recap_text_french = ? WHERE recap_id = ?';
			$stmt = $conn->stmt_init();
			$stmt->prepare($sql);
			$stmt->bind_param('ssi', $english, $french, $recap_id);
			$stmt->execute();
			$err = $stmt->error;
			//$stmt->free_result();
			
			
			if(!$err){
				header('Location:http://127.0.0.1/kayzjournal/journals.php?ref=recap');
				exit;
			}
			
	}
}
		
}//isset

?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Edit recap - Kayz Journal</title>
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
            	<p><a href="home.php">Index</a> / Journal</p>
            </div>
            
            <div id="mainmenu">
            	<?php require('includes/leftsidemenu_journals.inc.php');?>
                <div id="rightsidemenu">
                	<div id="innerrightsidemenu">
                    <?php if($go_on){ ?>	
                        <h2>Edit Recap</h2>
                        <form method="post" action="" id="frm1" name="frm1">
                        	<table border="0" width="100%" style="font-style:normal;">
                               <tr>
                                    <td width="20%">
                                        <label for="name">English entry</label>
                                    </td>
                               </tr>
                               <tr>
                                    <td  width="80%"> 
                                        <textarea id="english" name="english"
                                        style="width:80%; height:300px; margin:5px 0 0 0;padding:5px; color:#000; background:inherit; border:
                                        #000 solid 1px;
                                        font-size:1.0em; font-family:'Microsoft JhengHei',Microsoft JhengHei Light;"><?php echo $english; ?></textarea>
                                    </td>
                                </tr>
                                
                                <tr>
                                	<td>&nbsp;</td>
                                </tr>
                                
                                <tr>
                                    <td width="20%">
                                        <label for="name">French entry</label>
                                    </td>
                               	</tr>
                                <tr>
                                    <td  width="80%"> 
                                        <textarea id="french" name="french"
                                        style="width:80%; height:300px; margin:5px 0 0 0;padding:5px; color:#000; background:inherit; border:
                                        #000 solid 1px;
                                        font-size:1.0em; font-family:'Microsoft JhengHei',Microsoft JhengHei Light;"><?php echo $french; ?></textarea>
                                    </td>
                                </tr>
                                
                                <tr>
                                	<td>
                                        <input type="submit" name="submit" id="submit" style="padding:5px 20px;background:black;
                                        border:none;color:white;cursor:pointer;font-size:1em;font-family:'Microsoft JhengHei',Microsoft JhengHei 
                                        Light;text-align:center;" onMouseOver="this.style.background='#333'"
                                        onMouseOut="this.style.background='black'" value="Edit recap">
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