<?php

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	require '../../../../wp-blog-header.php';
	require 'PHPMailer/PHPMailerAutoload.php';

	
	$to = $_POST['email'];
	$subject = "Bear Stock Image Download: " . $_POST['image_reference']; 

	$image = get_attached_file(get_post_thumbnail_id($_POST['download_id']));
	$enquire_image = wp_get_attachment_image_src( get_post_thumbnail_id( $_POST['download_id'] ), 'medium' ); 
	
	

	// Mail Settings
	$mail = new PHPMailer;
	$mail->isSMTP();
	$mail->Host = 'homie.mail.dreamhost.com'; // Specify main and backup SMTP servers
	$mail->SMTPAuth = true;                              
	$mail->Username = "downloads@bearstock.com";                 
	$mail->Password = "removed"; //password removed                         
	$mail->SMTPSecure = 'ssl';                           
	$mail->Port = 465;                                   
	$mail->From = 'downloads@bearstock.com';
	$mail->FromName = 'Bear Stock';
	$mail->addAddress($to);

	$mail->addAttachment($image);
	$mail->Subject = $subject;
	$mail->Body = 'Please find the your requested download file attached';

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>Enquire</title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" href="../css/bootstrap.css" />  
<style>
	body {
		padding: 5px;
		font-family: 'PT Sans', sans-serif;
	}

</style>
<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
</head>

<body>

<div class="well">
	<?php if($sent || $send || $mail->send()){ ?>
	<p>Thanks for your request. Sit tight and you'll receive the file to your supplied email address shortly. 
<br/><br/><strong>Download facility is for layout & presentation purposes only. License fee applies to all other usages.</strong>
<br>
<br>
<a class="btn btn-success fancybox" data-fancybox-type="iframe" href="<?php bloginfo('template_url'); ?>/enquire_form.php?id=<?php echo $_POST['image_reference']; ?>&img=<?php echo $enquire_image[0]; ?>">LICENCE ENQUIRE</a>
<br/><br/>If you require anything further please email <a href="mailto:info@bearstock.com">info@bearstock.com</a> 
<br/>or call + 61 (0) 412 569366</p>

		<?php 

			date_default_timezone_set('Australia/Sydney');
			$subject = "Bear Stock Image Download - user: ".$_POST['email']." downloaded file: ".$_POST['image_reference']." at: ".date('Y-m-d H:i:s');
			$body = "Bear Stock Image Download \n\nUser: ".$_POST['email']."\nDownloaded file: ".$_POST['image_reference']."\nAt: ".date('Y-m-d H:i:s');;
			$to = "downloads@bearstock.com";

			$mail = new PHPMailer;
			$mail->isSMTP();
			$mail->Host = 'homie.mail.dreamhost.com'; // Specify main and backup SMTP servers
			$mail->SMTPAuth = true;                              
			$mail->Username = "downloads@bearstock.com";                 
			$mail->Password = "removed"; //password removed                         
			$mail->SMTPSecure = 'ssl';                           
			$mail->Port = 465;                                   
			$mail->From = 'downloads@bearstock.com';
			$mail->FromName = 'Bear Stock';
			$mail->addAddress($to);

			$mail->Subject = $subject;
			$mail->Body = $body;

			$mail->send();

		?>
		
	<?php }else{ ?>
	<p>Your request cannont be processed at this time please email <a href="mailto:info@bearstock.com">info@bearstock.com</a> 
		<br/>or call + 61 (0) 412 569366 for assistance</p>
		<?php $mail->ErrorInfo; ?>
	<?php } ?>

</div>
	</body>
</html>