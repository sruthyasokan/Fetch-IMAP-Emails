# Reading-IMAP-Mail-Accounts-and-save-the-data-to-database
Reading IMAP-Mail Accounts and save the following data in a database

Create database and establish the connection. And create table mailinfo to insert the data to the database.
	
	// Create connection
	$dbconn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($dbconn->connect_error) {
	  die("Connection failed: " . $dbconn->connect_error);
	}


The following is the HTML and PHP code to list emails from Gmail account. 

To connect to Gmail, the developer needs the individual’s “username” and “password” to be set in the code. 

    /* gmail connection,with port number 993 */
    $hostname = "{imap.gmail.com:993/imap/ssl}INBOX";
		
    /* gmail connection,with port number 993  to get sent mails*/
    //$hostname = '{imap.gmail.com:993/ssl}[Gmail]/Sent Mail';		
		
    /* Your gmail credentials */
    $username = 'abc@gmail.com';
    $password = '*****'; 
    
    /* use app password to login to avoid authentication problems. Make sure IMAP enabled in Gmail settings. */
		
  
  Establish a IMAP connection
     
     $conn = imap_open($hostname,$username,$password,NULL,1) or die('Cannot connect : ' . print_r(imap_errors()));
      
      

Once connected, the function search for all emails or emails based on certain criteria by using the imap_search() function. 

    $date = date("j F Y");
    $mails = imap_search($conn,'ON "'.$date.'"' ); /* Fetch current date emails */
      

The emails are sorted in a reverse manner so that the latest mails are available on the top using the PHP rsort() function. 
     
     rsort($mails);

This PHP function sorts an array in descending order. 
For every email returned, the subject, from, partial content, and date-time messages are captured. 

    /* Retrieve specific email information*/
    $headers = imap_fetch_overview($conn, $email_number, 0);

    $datee=$headers[0]->date;
    $from=$headers[0]->from;
    $to=$headers[0]->to;
    $subject=$headers[0]->subject;
     
    /* Returns a particular section of the body*/
    $message = imap_fetchbody($conn, $email_number, '1.1');
    $structure = imap_fetchstructure($conn, $email_number); 

The imap_fetchbody() function fetches a particular section of the email body. 
So to get the plain text part of the email, we can use “1.1” option as the third parameter. 
imap_fetchstructure() used to fetch the attachments from the email.


Insert all fetched datas to the database.

