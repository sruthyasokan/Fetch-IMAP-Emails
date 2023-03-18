<?php 
/* gmail connection,with port number 993 */
$hostname = "{imap.gmail.com:993/imap/ssl}INBOX";
			
/* Your gmail credentials */
$username = 'entwicklerin1@gmail.com';
$password = 'hbcatgopxgddvgwd';//Use App password for login to avoid authentcation problems.

/* Establish a IMAP connection */
$conn = imap_open($hostname,$username,$password,NULL,1) or die('Cannot connect : ' . print_r(imap_errors()));		
?>