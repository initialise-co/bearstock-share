<?php require 'wp-blog-header.php'; ?>
<?php

	if(is_user_logged_in()){
		if(isset($uid) && isset($file)){
			$dropbox = new Share();
			$meta = $dropbox->get_file($uid, $file);
			if($meta){
				$new = $bloginfo('').$file;
				$fd = fopen($new, 'wb');
				$dropbox->download($meta['path'], $fd);
				fclose($fd);
				
				header('Content-Description: File Transfer');
    			header('Content-Type: application/octet-stream');
    			header('Content-Disposition: attachment; filename='.basename($new));
   				header('Expires: 0');
			    header('Cache-Control: must-revalidate');
			    header('Pragma: public');
			    header('Content-Length: ' . filesize($new));
			    readfile($new);
				exit();
			}else{
				echo 'This is not a file';
			}
				
		}else if(isset($uid)){
			get_template_part('header', 'share');		
			$dropbox = new Share();
			if($dropbox->is_path($uid)){
				$files = $dropbox->getFolderFiles($uid);
				
				if(!empty($files['contents'])){
					$url = $dropbox->create_share($files['path']);
					$url = explode('=', $url);
					$url = $url[0].'=1';
					$folder_size;
					foreach ($files['contents'] as $size){
						$folder_size = $folder_size + $size['bytes'];
					}
				?>
				<p class="share-title">Folder</p>
				<table>
					<thead>
						<tr>
							<td>Name</td>
							<td>Filesize</td>
							<td>Download</td>
						</tr>
					</thead>
					<tbody>
						<td><?php echo $dropbox->get_name($files['path']); ?></td>
						<td><?php echo $dropbox->formatBytes($folder_size); ?></td>
						<td><a href="<?php echo $url ?>">ZIP</a></td>
					</tbody>
				</table>
				<p class="share-title">Files</p>
				<table>
					<thead>
						<tr>
							<td>Name</td>
							<td>Filesize</td>
							<td>Download</td>
						</tr>
					</thead>
					<tbody>
					<?php foreach ($files['contents'] as $file) { ?>
					<tr>
						<?php $file_details = explode('.', $dropbox->get_name($file['path'])); ?>
						<?php $link = $dropbox->create_download($file['path']); ?>
						<?php $link = $link[0].'?dl=1'; ?>
						
						<td><?php echo $file_details[0] ?></td>
						<td><?php echo $dropbox->formatBytes($file['bytes']); ?></td>
						<td><a class="share-download" id="<?php echo $dropbox->get_name($file['path']); ?>" href="<?php echo $link; ?>"><?php echo strtoupper($file_details[count($file_details) - 1]); ?></a></td>
					</tr>	
					<?php } ?>
					</tbody>
				</table>
				<?php }else{ ?>
					<h1 class="share-message">OOPS?!</h1>
					<p>This file is currently not shared</p>
				<?php } ?>
			<?php }else{ ?>
				<h1 class="share-message">OOPS?!</h1>
				<p>This file is currently not shared</p>
			<?php } ?>
		<?php }else{ ?>
			<h1 class="share-message">OOPS?!</h1>
			<p>There is something wrong with your download link</p>
		<?php } 
	}else{ ?>
		<?php get_template_part('header', 'share'); ?>
		<script type="text/javascript">
			window.onload = function () {
				$('.fancybox-login').trigger('click');
			};
			
		</script>
	<?php } ?>
</div>
<script type="text/javascript">

	$('.share-download').on('click', function(e){
		e.preventDefault();

		$.ajax({
			url : '<?php echo bloginfo("url")."/wp-admin/admin-ajax.php"; ?>',
			type : 'post',
			data : { 
				action : 'create_dropbox_share', 
				folder : '<?php echo $dropbox->get_name($files['path']); ?>', 
				file : e.target.id
			}, 
			success : function(data){
				console.log(data);
			}
		}, 'json');
	});

</script>
</body>
</html>