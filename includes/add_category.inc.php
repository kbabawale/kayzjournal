<?php 
require('connection.inc.php');

//list expected fields
	$expected = array('catt');
	
	//set required fields
	$required = array('catt');

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
			
		$catt = trim($catt);
			
		//prepare SQL statement
		$sql = 'INSERT INTO category (category_name) VALUES (?)';
			
			$stmt = $conn->stmt_init();
			$stmt->prepare($sql);
			$stmt->bind_param('s', $catt);
			$stmt->execute();
			$err = $stmt->error;
			
			if($stmt->affected_rows){ 
				//header('Location:add_article.php');
				$stmt->free_result();
				//exit;	
			}elseif($err){
				echo $err;
			}
			
		}
}

?>