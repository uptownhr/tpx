<?php
	if($_POST){
		$to = 'example@example.com';/*Put Yuur Email Adress Here*/
		$subject = $_POST['subject'];
		$from_name = $_POST['name'];
		$from_email = $_POST['email'];
		$message = $_POST['message'];
		$header = "From: $from_name <$from_email>";
		mail($to, $subject, $message, $header);
					
				
			
	}
?>