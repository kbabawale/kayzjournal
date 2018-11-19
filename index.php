<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
<title>Kayz Journal</title>
</head>

<body>
<div id="middiv">
	<div id="logo1"><h2 style="text-align:center;font-weight:normal;font-size:3.5em;padding:40px;color:#000;">KAYZ JOURNAL</h2></div>
    <div id="login" style="text-align:center;background:#006666;width:100%;height:150px;">
    	<div id="innerlogin" style="padding:40px;">
            <form id="form1" action="" method="post">
                <input type="password" name="pwd" id="pwd" 
                style="width:200px;height:40px;padding:0px 10px;border:#fff solid 1px;border-radius:15px;color:#fff;font-size:20px;
                background:inherit;" />
                
                <a href="javascript:void(0);" name="submit" id="submit" onClick="if(document.getElementById('pwd').value == 'kayz'){
                location.href = 'home.php';}"
                style="border:1px solid #fff;border-radius:15px;color:#fff;font-size:20px;
                background:inherit;padding:07px;text-decoration:none;">Enter</a>
            </form>
        </div>
    </div>
</div>


</body>
</html>