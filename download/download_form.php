<?php
	require '../../../../wp-blog-header.php';
	global $current_user;

	get_currentuserinfo();

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Enquire</title>
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<link rel="stylesheet" href="../css/bootstrap.css" />  
		<style>
			html, body {
				padding: 0;
				margin: 0;
			}
			body {
				font-family: 'PT Sans', sans-serif;
			}
			img {
				max-width: 450px;
				max-height: 300px;
				margin-bottom: 10px;
			}
			.well {min-height:120px;}
		</style>
		<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
	</head>
	<body>
		<div class="well"  style="margin-bottom: 0;">

<?php if (!is_user_logged_in()) : ?>
	<div style="height: 90px;margin-bottom: 0;">
		<h3>Please register to download the file</h3>
		<a class="btn" href="register.php">REGISTER NOW</a> or <a href="login.php">login</a>
	</div>
<?php else: ?>
	<form id="form1" name="form1" method="post" class="form-horizontal" action="<?php echo site_url(); ?>/wp-content/themes/symplebearstock/download/download_image.php" parsley-validate>
		<fieldset>
			<!--<legend>Download: <?php echo $_REQUEST['id']; ?></legend>
			<div class="control-group">
				<div class="enquire_img"><img src="<?php echo $_REQUEST['img']; ?>" /></div>
				<hr />
			</div>-->
			

			<!--<div class="control-group">
				<label class="control-label">Contact Name</label>
				<div class="controls">
					<input type="text" name="contact_name" id="contact_name" value="<?php echo get_user_meta($current_user->data->ID, 'first_name', true) . ' ' . get_user_meta($current_user->data->ID, 'last_name', true) ?>" required />
				</div>
			</div>-->

			<div class="control-group">
				<label class="control-label">Email Address</label>
				<div class="controls">
					<input type="text" name="email" id="email" value="<?php echo $current_user->data->user_email ?>" required parsley-type="email" />
				</div>
			</div>
			<input readonly type="hidden" name="download_id" id="download_reference" value="<?php echo $_REQUEST['id']; ?>" required />
			<input readonly type="hidden" name="image_reference" id="image_reference" value="<?php echo $_REQUEST['img_ref']; ?>" required />
			<div class="controls">
				<input class="btn" type="submit" name="submit" id="submit" value="Send" />
				<!--<span id="raw-info" style="margin-left:10px; font-style:italic;">RAW files available upon request</span>-->
			</div>
		</fieldset>
	</form>
<?php endif; ?>
		</div>
		<script src="../js/jquery-1.8.1.min.js"></script>
		<script src="../js/jquery.mousewheel-3.0.6.pack.js"></script>
		<script src="../js/jquery.fancybox.js"></script>

<!-- MISSING		
js/functions.js
-->

	<script src="../js/parsley.js"></script>
	</body>
</html>