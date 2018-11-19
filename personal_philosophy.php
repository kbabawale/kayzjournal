<?php require('includes/connection.inc.php');
$ref = '';
if(isset($_GET['ref'])){
	$ref = $_GET['ref'];
}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Personal Philosophy - Kayz Journal</title>
<link href="style.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="includes/main.js">
</script>

</head>

<body onLoad="updateClock(); setInterval('updateClock()', 1000); randomizeQuotes();
<?php
if($ref == 'books'){?>
showLibrary();
<?php } 
elseif($ref == 'quotes'){?>
showQuotes();
<?php } 
elseif($ref == 'movies'){?>
showMovies();
<?php }
elseif($ref == 'inspi'){?>
showInspi();
<?php }
elseif($ref == 'places'){?>
showPlaces();
<?php }
elseif($ref == 'activities'){?>
showActi();
<?php } ?>

">
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
                    	
                    </div>
                </div>
            </div>
        </div>
     </div>
     
     <?php require('includes/footer.inc.php');?>
     
   
</div>
</body>
</html>