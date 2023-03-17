<?php 
$servername = "sg2nlmysql11plsk.secureserver.net:3306";
$username = "testdbmailuser";
$password = "el3q8Q_3";
$dbname = "testdbmail";

// Create connection
$dbconn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($dbconn->connect_error) {
  die("Connection failed: " . $dbconn->connect_error);
}

?>
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
		document.getElementById('dataDivID').style.display = "block";
	}
  </script>
</head>
<body>

<div class="container">
  	
	<div class="row"> 
	<h3><br>List Emails using PHP and IMAP</h3> 
	<button class="btn active" onclick="getEmails()"><i class="fa fa-bars"></i>Click to get emails</button>
	</div>
	
	<div class="row" id="dataDivID" style="display:none;"> 
    <br><?php
		
			/* gmail connection,with port number 993 */
			$hostname = "{imap.gmail.com:993/imap/ssl}INBOX";
			
			/* gmail connection,with port number 993  to get sent mails*/
			//$hostname = '{imap.gmail.com:993/ssl}[Gmail]/Sent Mail';
			
			/* Your gmail credentials */
			$username = 'entwicklerin1@gmail.com';
			$password = 'hbcatgopxgddvgwd';

			/* Establish a IMAP connection */
			$conn = imap_open($hostname,$username,$password,NULL,1) or die('Cannot connect : ' . print_r(imap_errors()));




			/* Search emails from gmail inbox*/
			//$mails = imap_search($conn, 'SUBJECT "Comment"');
			$date = date("j F Y");
			$mails = imap_search($conn,'ON "'.$date.'"' ); 
			/* loop through each email id mails are available. */
			if ($mails) {

				/* Mail output variable starts*/
				$mailOutput = '';$attachmentall='';
				$mailOutput.= '<table class="table table-bordered" >
				<tr>
				<th> Date Time </th>
				<th> From </th>
				<th> To </th>
				<th> Subject </th>
				<th> Content </th>
				<th> Filename </th>
				</tr>';

				/* rsort is used to display the latest emails on top */
				rsort($mails);

				/* For each email */
				foreach ($mails as $email_number) {

					/* Retrieve specific email information*/
					$headers = imap_fetch_overview($conn, $email_number, 0);

					/* Returns a particular section of the body*/
					$message = imap_fetchbody($conn, $email_number, '1.1');
					$subMessage = substr($message, 0, 150);
					//$finalMessage = trim(quoted_printable_decode($subMessage));
					$finalMessage = $subMessage;

					$mailOutput.= '';
					
					$datee=$headers[0]->date;
					$from=$headers[0]->from;
					$to=$headers[0]->to;
					$subject=$headers[0]->subject;
					
					/* Gmail MAILS header information */
					$mailOutput.= '<td>'.$headers[0]->date . '</td>';
					$mailOutput.= '<td>'.$headers[0]->from . '</td>';					
					$mailOutput.= '<td>'.$headers[0]->to  . '</td>';					
					$mailOutput.= '<td>'.$headers[0]->subject.'</td> ';
					
					$datee=$headers[0]->date;
					$from=$headers[0]->from;
					$to=$headers[0]->to;
					$subject=$headers[0]->subject;
					
					
					$structure = imap_fetchstructure($conn, $email_number); 
					$finalMessage1=utf8_encode($finalMessage);
					
					//fetch attachment names
					$attachments = [];

					foreach ($structure->parts as $part) {
								$is_attachment = (isset($part->disposition) && $part->disposition == 'ATTACHMENT');

								if ($part->ifdparameters) {
									foreach ($part->dparameters as $object) {
										if (strtolower($object->attribute) == 'filename') {
											$is_attachment = true;
											$filename = $object->value;
											break;
										}
									}
								}

								if ($part->ifparameters) {
									foreach ($part->parameters as $object) {
										if (strtolower($object->attribute) == 'name') {
											$is_attachment = true;
											$name = $object->value;
											break;
										}
									}
								}

								if (!$is_attachment) {
									continue;
								}
								
								$attachment = imap_fetchbody($conn, $email_number, $email_number+1);

								if ($part->encoding == 3) {
									$attachment = base64_decode($attachment);
								} elseif ($part->encoding == 4) {
									$attachment = quoted_printable_decode($attachment);
								}

								$attachments[] = [
									'is_attachment' => $is_attachment,
									'filename' => isset($filename) ? $filename : '',
									'name' => isset($name) ? $name : '',
									'attachment' => isset($attachment) ? $attachment : ''
								];
						}


						/* iterate through each attachment and save it */
							$folder = "maildocs";
							if (!is_dir($folder)) {
									 mkdir($folder);
								}

							foreach ($attachments as $attachment) {

								if (!empty($attachment['name'])) {
									$filename = $attachment['name'];
								} elseif (!empty($attachment['filename'])) {
									$filename = $attachment['filename'];
								} else {
									$filename = time().'.dat';
								}

								$destination = './'.$folder.'/'.$email_number.'-'.$filename;
								$attachmentall.=$filename." ";
								//file_put_contents($destination, $attachment['attachment']);
							}
							
					
					/* Mail body is returned */
					$mailOutput.= '<td>' .$finalMessage1 . '</td>';
					$mailOutput.= '<td>'.$attachmentall.'</td>
					
					</tr></div>';
					
					//insert datas to database.
					$sql = "INSERT INTO mailinfo(id,mailtype, adr_sender, adr_recipient,subject,content,filename,date)
					VALUES ('0', 'Inbox', '$from', '$to', '$subject', '$finalMessage1','$attachmentall','$datee')";

					if ($dbconn->query($sql) === TRUE) {
					 // echo "New record created successfully";
					} else {
					  echo "Error: " . $sql . "<br>" . $dbconn->error;
					}
					
					$attachmentall='';
					
				}// End foreach
				
				$mailOutput.= '</table>';
				echo $mailOutput;
									
			}//endif

			/* imap connection is closed */
			imap_close($conn);
			?>
</div>
</body>
</html>
