<?php
/**
 * Sidebar Files Template
 *
 * @package GetSimple
 */
 
$path = (isset($_GET['path'])) ? $_GET['path'] : "";
?>
<ul class="snav">
	<li id="sb_upload" ><a href="upload.php" <?php check_menu('upload');  ?>><?php i18n('FILE_MANAGEMENT');?></a></li>
	<?php if(isset($_GET['i']) && $_GET['i'] != '') { ?><li id="sb_image" ><a href="#" class="current"><?php i18n('IMG_CONTROl_PANEL');?></a></li><?php } ?>
	
	<?php exec_action("files-sidebar"); ?>

<?php if (!getDef('GSNOUPLOADIFY',true)) { ?>	
	<li class="upload" id="sb_uploadify" >
		<div id="uploadify"></div>
	<?php 
	
	// create Uploadify uploader
	$debug = isDebug() ? 'true' : 'false';
	$fileSizeLimit = toBytes(ini_get('upload_max_filesize'))/1024;
	echo "
	<script type=\"text/javascript\">
	jQuery(document).ready(function() {
		if(jQuery().uploadify) {
		$('#uploadify').uploadify({
			'debug'			: ". $debug . ",
			'buttonText'	: '". i18n_r('UPLOADIFY_BUTTON') ."',
			'buttonCursor'	: 'pointer',
			'uploader'		: 'upload-uploadify.php',
			'swf'			: 'template/js/uploadify/uploadify.swf',
			'multi'			: true,
			'auto'			: true,
			'height'		: '25',
			'width'			: '100%',
			'requeueErrors'	: false,
			'fileSizeLimit'	: '".$fileSizeLimit."', // expects input in kb
			'cancelImage'	: 'template/images/cancel.png',
			'checkExisting'	: 'uploadify-check-exists.php?path=".$path."',
			'postData'		: {
			'sessionHash' : '". $SESSIONHASH ."',
			'path' : '". $path ."'
			},
			onUploadProgress: function() {
				$('#loader').show();
			},
			onUploadComplete: function() {
				$('#loader').fadeOut(500);
				$('#maincontent').load(location.href+' #maincontent > *');
			},
			onSelectError: function(file,errorCode,errorMsg) {
				notifyError('<strong>Uploadify:</strong> ' + file.name + ' <br/>Error ' + errorCode +':'+errorMsg).popit().removeit();
			},
			onUploadSuccess: function(file,data,response) {	
				if(data != 1){
					notifyError('<strong>Uploadify:</strong>' + data + ' ('+file.name+')').popit().removeit();
					jQuery('#' + file.id).addClass('uploadifyError');
					jQuery('#' + file.id).find('.uploadifyProgressBar').css('width','1px');
					jQuery('#' + file.id).find('.data').html(' - ' + 'Failed');					
				}	 
			},				
			onUploadError: function(file,errorCode,errorMsg, errorString) {
				notifyError('<strong>Uploadify:</strong> ' + errorMsg).popit().removeit();
			}
		});
		}
	});
	</script>";
	 ?>
	</li>
	<li style="float:right;" id="sb_filesize" ><small><?php i18n('MAX_FILE_SIZE'); ?>: <strong><?php echo (toBytes(ini_get('upload_max_filesize'))/1024)/1024; ?>MB</strong></small></li>

<?php } ?>
	</ul>


<?php 
# show normal upload form if Uploadify is turned off 
if (getDef('GSNOUPLOADIFY',true)) { ?>
	<form class="uploadform" action="upload.php?path=<?php echo $path; ?>" method="post" enctype="multipart/form-data">
		<p>
			<label for="file" class="custom-file-upload">
				<input onchange="myFunction()" type="file" name="file[]" id="file" style="width:120px;" multiple />
				<span style="display:none"><?php i18n('SELECT_UPLOADIFY'); ?></span>
			</label>
		</p>
		<p id="demo"></p>
  
		<script>
			function myFunction(){
				var x = document.getElementById("file");
				var txt = "";
				if ('files' in x) {
					if (x.files.length == 0) {
						txt = "Select one or more files.";
					} else {
						for (var i = 0; i < x.files.length; i++) {
							txt += "<p style='margin:0 0 8px 20px;'><strong>" + (i+1) + ". </strong> ";
							var file = x.files[i];
							if ('name' in file) {
								txt += " " + file.name + "</p>";
							}
						}
					}
				} 
				else {
					if (x.value == "") {
						txt += "Select one or more files.";
					} else {
						txt += "The files property is not supported by your browser!";
						txt  += "<br>The path of the selected file: " + x.value; // If the browser does not support the files property, it will return the path of the selected file instead. 
					}
				}
				document.getElementById("demo").innerHTML = txt;
			}
		</script>
		<input type="hidden" name="hash" id="hash" value="<?php echo $SESSIONHASH; ?>" />
		<input type="submit" class="submit" name="submit" value="<?php i18n('UPLOAD'); ?>" />
	</form>
<?php } else { ?>

	<!-- show normal upload form if javascript is turned off -->
	<noscript>
		<form class="uploadform" action="upload.php?path=<?php echo $path; ?>" method="post" enctype="multipart/form-data">
			<p><input type="file" name="file[]" id="file" style="width:220px;" multiple /></p>
			<input type="hidden" name="hash" id="hash" value="<?php echo $SESSIONHASH; ?>" />
			<input type="submit" class="submit" name="submit" value="<?php i18n('UPLOAD'); ?>" />
		</form>
	</noscript>

<?php } ?>