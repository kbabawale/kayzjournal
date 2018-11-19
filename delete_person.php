<?php 
require('includes/connection.inc.php');

if(isset($_GET['inspi_id'])){
	$inspi_id = $_GET['inspi_id'];
}

if(isset($_POST['reset'])){
	header('Location:personal_philosophy.php?ref=inspi');
	exit;
}
if(isset($_POST['submit'])){
	$sql = "DELETE FROM inspiration WHERE inspiration_id ='$inspi_id'";
	$stmt = $conn->stmt_init();
	$stmt->prepare($sql);
	$stmt->execute();
	echo $stmt->error;
	if($stmt->affected_rows > 0){
		$deletesuccess = true;
		header('Location:personal_philosophy.php?ref=inspi');
		exit;
	}else{
			echo 'Cannot delete person now. Try again later.';	
	}

}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Delete person - Kayz Journal</title>
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
                    	<h2 style="color:red;">Confirm deletion</h2>
                        <p style="padding-bottom:30px;">Are you sure you want to delete this person?</p>
                        <div style="padding:20px;">
                            <form method="post">
                            <input type="submit" name="submit" id="submit" style="border:none;text-decoration:none;padding:8px 40px;color:white;
                            background:#060;margin-right:5px;cursor:pointer;" value="Yes"
                                onMouseOver="this.style.background='black';this.style.color='white';"
                                onMouseOut="this.style.background='#060';this.style.color='#fff';" />
                            
                            
                            <input type="submit" id="reset" name="reset" style="border:none;text-decoration:none;padding:8px 40px;
                            color:white;
                            background:#F00;cursor:pointer;" value="No"
                                onMouseOver="this.style.background='black';this.style.color='white';"
                                onMouseOut="this.style.background='#F00';this.style.color='#fff';" />
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
     </div>
     
     <?php require('includes/footer.inc.php');?>
     
   
</div>

</body>
</html>