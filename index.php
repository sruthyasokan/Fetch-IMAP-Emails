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
	function getEmails() {
		document.getElementById('inbox').style.display = "block";
		document.getElementById('sentmail').style.display = "none";
	}
	
	function getsentEmails() {
		document.getElementById('sentmail').style.display = "block";
		document.getElementById('inbox').style.display = "none";
		
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
		<div class="row" id="inbox" style="display:none;"> <br>
			<?php include("inc/imap_conn_inbox.php");?>
			<?php include("fetchmail.php");?>
		</div>
		<!-----------------------Fetches the emails from inbox----------------------------------->
		
		
		<!-----------------------Fetches the emails from Sent----------------------------------->
		<div class="row" id="sentmail" style="display:none;"><br> 
			<?php include("inc/imap_conn_sentmail.php");?>
			<?php include("fetchmail.php");?>
		</div>
	    <!-----------------------Fetches the emails from Sent----------------------------------->
	
	</div>
</body>
</html>