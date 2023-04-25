<?php include "inc/db.php"; ?>
<?php include("inc/imap_conn_inbox.php");?>
<?php 
/* Search current date emails from gmail inbox*/
$date = date("j F Y");
$mails = imap_search($conn,'ON "'.$date.'"' ); 

/* loop through each email id mails are available. */
if ($mails) {
	

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

			//email body if no attachment
			$msg = imap_fetchbody($conn, $email_number, "1");
            $finalMessage2=substr(quoted_printable_decode($msg), 0, 150); 
			
			
			/* Gmail MAILS header information */	
			$datee=$headers[0]->date;
			$from=$headers[0]->from;
			$to=$headers[0]->to;
			$subject=$headers[0]->subject;
			
			
			$datee=$headers[0]->date;
			$subject=$headers[0]->subject;
			
			$header = imap_headerinfo($conn, $email_number);
            $fromaddress = $header->from[0]->mailbox . "@" . $header->from[0]->host;
            $toaddress = $header->to[0]->mailbox . "@" . $header->to[0]->host;
			 
			$domain = substr($fromaddress, strpos($fromaddress, '@') + 1);
			$toaddressdomain = substr($toaddress, strpos($toaddress, '@') + 1);
				
				
			//check in databse if the email exists or not. 
			$sql = "SELECT * FROM adminclient where mail = '$fromaddress' ";
			
			
			$result = $dbconn->query($sql);
			if ($result->num_rows == 0) {
				
					//check in databse if the domain exists or not.
					$sql10 = "SELECT * FROM adminclient where mail LIKE '%$domain%' ";
					
					$result10 = $dbconn->query($sql10);
					if ($result10->num_rows > 0) {
						$row10 = $result10->fetch_assoc();
						$kundennummer=$row10["kundennummer"];
						$adminid="";
							
					}else{
						$kundennummer="";
						$adminid="";
					}
			}else{
				
				$result10 = $dbconn->query($sql);
				$row10 = $result10->fetch_assoc();
				$kundennummer=$row10["kundennummer"];
				$adminid=$row10["id"];
			}
			
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
						
						
						if($attachmentall<>''){
							$message=$finalMessage1;
						}else{
							$message=$finalMessage2;
						}
						
						
						//insert datas to database.
						$sql = "INSERT INTO mailinfo(mailinfo_id,adminid,kundennummer,mailtype, fromaddress, toaddress,subject,content,filename,date)VALUES('0','$adminid','$kundennummer','Inbox', '$fromaddress', '$toaddress', '$subject', '$message','$attachmentall','$datee')";

						if ($dbconn->query($sql) === TRUE) {
						// echo "New record created successfully";
						} else {
							echo "Error: " . $sql . "<br>" . $dbconn->error;
						}
								
						$attachmentall='';
						
			
				
		}// End foreach
				
	}//endif
	?>
	<?php
	$curdate = date("j M Y");
	$sql10 = "SELECT * FROM mailinfo where date LIKE '%$curdate%' and mailtype='Inbox'";
	$result10 = $dbconn->query($sql10);
	if ($result10->num_rows > 0) { ?><br>
	<table class="table table-bordered" >
	<tr>
		<th colspan=7> Inbox Emails </th>
	</tr>
	<tr>
		<th> Date Time </th>
		<th> Kundennummer </th>
		<th> Admin ID </th>
		<th> From </th>
		<th> To </th>
		<th> Subject </th>
		<th> Content </th>
		<th> Filename </th>
	</tr>
	<?php
	while($row10 = $result10->fetch_assoc()){
	$kundennummer=$row10["kundennummer"];
	$adminid=$row10["adminid"];
	$fromaddress=$row10["fromaddress"];
	$toaddress=$row10["toaddress"];
	$subject=$row10["subject"];
	$content=$row10["content"];
	$filename=$row10["filename"];
	$date=$row10["date"];
	?>
	<tr>
		<td><?php echo $date;?></td>
		<td><?php echo $kundennummer;?></td>
		<td><?php echo $adminid;?></td>
		<td><?php echo $fromaddress;?></td>
		<td><?php echo $toaddress;?></td>
		<td><?php echo $subject;?></td>
		<td><?php echo $content;?></td>
		<td><?php echo $filename;?></td>
	</tr>
	<?php } ?>
	</table>
	<?php } ?>

<?php	
/* imap connection is closed */
imap_close($conn);
?>
