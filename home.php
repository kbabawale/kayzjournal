<?php require('includes/connection.inc.php');
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Home - Kayz Journal</title>
<link href="style.css" rel="stylesheet" type="text/css">

<script type="text/javascript" src="includes/main.js">
</script>
</head>

<body onLoad="updateClock(); setInterval('updateClock()', 1000); randomizeQuotes();">

<div id="maincontent">
	<?php require('includes/header.inc.php'); ?>
        
    <div id="mainbody">
    	<div id="inner_mainbody">
        	<div id="titlebar">
            	<p><a href="home.php">Index</a> /</p>
            </div>
            
            <div id="tabs">
            	<div id="innertabs">
                    <a href="personal_philosophy.php"><div id="tab1" title="Personal philosophy"><p>Personal Philosophy</p></div></a>
                    <a href="journals.php"><div id="tab2" title="Journals"><p>Journals</p></div></a>
                    <!--<a href="commitments.php"><div id="tab3" title="Commitments"><p>Commitments</p></div></a>
                    <a href="people.php"><div id="tab4" title="People"><p>People</p></div></a>
                    <a href="others.php"><div id="tab5" title="Others"><p>Others</p></div></a>-->
                </div>
            </div>
        </div>
    </div>
    
<?php include('includes/footer.inc.php'); ?>
</div>

</body>
</html>