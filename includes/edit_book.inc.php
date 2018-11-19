<?php 
require('connection.inc.php');
$expected = array('name_of_book','edit_status','author','edition','year','notes');
$required = array();
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
		
		$name_of_book = trim($name_of_book);
		$edit_status = trim($edit_status);
		$author = trim($author);
		$edition = trim($edition);
		$year = trim($year);
		$notes = trim(ucfirst($notes));
		
			$sql = 'UPDATE books SET name_of_book = ?, status_id = ?, author = ?, edition = ?, year = ?, notes = ? WHERE books_id = ?';
			$stmt = $conn->stmt_init();
			$stmt->prepare($sql);
			$stmt->bind_param('sissisi', $name_of_book, $edit_status, $author, $edition, $year, $notes, $book_id);
			$stmt->execute();
			$err = $stmt->error;
			//$stmt->free_result();
			
			
			if(!$err){
				header('Location:http://127.0.0.1/kayzjournal/personal_philosophy.php?ref=books');
				exit;
			}
			
	}
}

/*
if($errors){
				echo '<p style="font-size:1.2em;color:#ff9;">
				Errors occured in the process. Please ensure that you provide your details in the correct format</p>';	
			}

*/
?>