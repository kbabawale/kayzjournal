<?php require('includes/connection.inc.php'); 
$missing = ''; $errors = '';
if(isset($_POST['submit'])){
	//list expected fields
	$expected = array('title','category','article_text');
	
	//set required fields
	$required = array('title','category');

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
			
		$title = trim($title);
		$category = trim($category);
		$article_text = trim($article_text);
			
		//prepare SQL statement
		$sql = 'INSERT INTO articles (article_title, category_id, article_text, date_created) VALUES (?,?,?,NOW())';
			
			//require_once('includes/connection.inc.php');

			$stmt = $conn->stmt_init();
			$stmt->prepare($sql);
			$stmt->bind_param('sis', $title, $category, $article_text);
			$stmt->execute();
			$err = $stmt->error;
			
			if($stmt->affected_rows == 1){
				header('Location:journals.php?ref=articles');
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
<title>Add article - Kayz Journal</title>
<link href="style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="includes/main.js">
</script>
</head>

<body onLoad="updateClock(); setInterval('updateClock()', 1000); randomizeQuotes(); iFrameOn();">
<div id="maincontent">
	<?php require('includes/header.inc.php');?>
    
     <div id="mainbody">
    	<div id="inner_mainbody">
        	
            <div id="titlebar">
            	<p><a href="home.php">Index</a> / Journals</p>
            </div>
            
            <div id="mainmenu">
            	<?php require('includes/leftsidemenu_journals.inc.php');?>
                <div id="rightsidemenu">
                	<div id="innerrightsidemenu">
                    	<h2>Add article
                        <span style="font-size:.35em;color:#0066CC;">Make sure to have your category created before inputing any field</span></h2>
                        
                        <form method="post" action="" id="frm1" name="frm1">
                        	<table border="0" width="100%" style="font-style:normal;">
                                <tr>
                                    <td width="30%">
                                        <label for="name">Title</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td  width="50%"> 
                                        <input type="text" id="title" name="title"
                                        <?php if($missing || $errors) {echo 'value="'. htmlentities($_POST['title'], ENT_COMPAT, 'UTF-8') 
										.'"';} ?>
                                        style="width:80%; height:30px; margin:5px 0 0 0; padding:5px;color:#000; background:inherit; 
                                        border:#000 solid 1px;
                                        font-size:1.0em;font-family:'Microsoft JhengHei',Microsoft JhengHei Light;"/>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td width="30%">
                                        <label for="status">Select category <i>(optional)</i></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>    
                                        <select id="category" name="category"
                                        style="background:inherit;width:300px;height:35px; border:black 1px solid;
                                        font-family:'Microsoft JhengHei',Microsoft JhengHei Light; font-size:1.0em;padding:5px;color:#000;" 
                                        onfocus="this.style.border='solid #000 1px';">
                                        	<option value="">Select one</option>
                                             <?php 
                                            $sql = 'SELECT * FROM category';
                                            $stmt = $conn->stmt_init();
                                            $stmt->prepare($sql);
                                            $stmt->bind_result($category_idd, $category_namee);
                                            $stmt->execute();
                                            
                                            while($stmt->fetch()){ ?>
                                                <option value="<?php echo $category_idd; ?>"><?php echo $category_namee; ?></option>
                                                <?php } ?>
                                        </select>
                                        &nbsp; <a href="javascript:void(0);" id="new_category"
                                        style="text-decoration:none;color:#093;" 
                                        onClick="document.getElementById('category_div').style.display='block';">or add new category</a>
                                    </td>    
                                </tr>
                                
                                <tr>
                                    <td width="20%">
                                        <label for="name">Article Text</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td  width="80%">
                                    	<textarea id="article_text" name="article_text"
                                        style="width:80%; height:400px; margin:5px 0 0 0;padding:5px; color:#000; background:inherit; border:
                                        #000 solid 1px;
                                        font-size:1.0em; font-family:'Microsoft JhengHei',Microsoft JhengHei Light;"><?php if($missing || $errors) {echo htmlentities($_POST['article_text'], ENT_COMPAT, 'UTF-8'); } ?></textarea>
                                        
                                    </td>
                                </tr> 
                                
                                <tr>
                                	<td>
                                       	<input type="submit" name="submit" id="submit" style="padding:5px 20px;background:black;
                                        border:none;color:white;cursor:pointer;font-size:1em;font-family:'Microsoft JhengHei',Microsoft JhengHei 
                                        Light;text-align:center;" onMouseOver="this.style.background='#333'"
                                        onMouseOut="this.style.background='black'" value="Add Article">
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
     
     <div id="category_div" style="display:none;position:fixed; top:50%; left:50%; transform:translate(-50%,-50%); //border-radius:5px; 
     padding:5px;background:#ccc;//opacity:0.75;width:300px;height:150px;box-shadow:2px 2px 5px #000; /*left, top, blur size, blur color */">
     	<h3 style="padding:3px;">Add new Category</h3>
        <hr />
        <table border="0">
        	<tr>
            	<td><input type="text" name="catt" id="catt" style="width:250px;height:30px;font-size:1em;font-weight:normal;"></td>
            </tr>
            
            <tr>
            	<table cellspacing="5">
					<tr>
                        <td><a href="javascript:void(0);" style="background:green;color:white;padding:5px;text-decoration:none;"
                        onClick="addCategory();">Create</a></td>
                        <td><a href="javascript:void(0);" style="background:red;color:white;padding:5px;text-decoration:none;" 
                        onClick="document.getElementById('category_div').style.display='none';">Cancel</a></td>
                    </tr>
                    <tr>
                    	<td><div id="catterr" style="display:none;">Error</div></td>
                    </tr>
                </table>
            </tr>
        </table>
     </div>
    
</div>

</body>
</html>