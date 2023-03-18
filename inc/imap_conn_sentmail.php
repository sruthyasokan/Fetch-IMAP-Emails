<?php 
/* gmail connection,with port number 993  to get sent mails*/
$hostname = '{imap.gmail.com:993/ssl}[Gmail]/Sent Mail';
			
/* Your gmail credentials */
$username = 'test@gmail.com';
$password = '*********';//Use App password for login to avoid authentcation problems.

/* Establish a IMAP connection */
$conn = imap_open($hostname,$username,$password,NULL,1) or die('Cannot connect : ' . print_r(imap_errors()));		
?>