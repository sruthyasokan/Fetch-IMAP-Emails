<?php include "inc/db.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>List Emails using PHP and IMAP</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script>
	function getEmails()
	{  		
		if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
		} else { // code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function() {
		
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		// alert(xmlhttp.responseText);
		document.getElementById("inbox").innerHTML=xmlhttp.responseText;
		}
		}										  
		xmlhttp.open("GET","fetchmail_inbox.php",true);
		//window.location.href = "fetchmail_inbox.php";
		xmlhttp.send();
	}
	
	
	function getsentEmails()
	{   		
		if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
		} else { // code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function() {
		
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
		// alert(xmlhttp.responseText);
		document.getElementById("sentmail").innerHTML=xmlhttp.responseText;
		}
		}										  
		xmlhttp.open("GET","fetchmail_sent.php",true);
		//window.location.href = "fetchmail_sent.php";
		xmlhttp.send();
	}
  </script>
</head>

<body>
	<div class="container">  	
		<div class="row"> 
			<h3><br>List Emails using PHP and IMAP</h3> 
			<button class="btn active" onclick="getEmails()"><i class="fa fa-bars"></i>Click to get emails</button>
			<button class="btn active" onclick="getsentEmails()"><i class="fa fa-bars"></i>Click to get Sent emails</button>
			
		</div>	
	
		<!-----------------------Fetches the emails from inbox----------------------------------->
		<div class="row" id="inbox" >
		
		</div>
		<!-----------------------Fetches the emails from inbox----------------------------------->
		
		
		<!-----------------------Fetches the emails from Sent----------------------------------->
		<div class="row" id="sentmail" >
		
		</div>
	    <!-----------------------Fetches the emails from Sent----------------------------------->
	
	</div>
</body>
</html>