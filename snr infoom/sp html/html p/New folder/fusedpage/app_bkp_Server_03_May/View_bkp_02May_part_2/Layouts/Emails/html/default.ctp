<html>
<head>
<title>Fused Page</title>
</head>
<body>
<!-- Main Container Start -->
<div align="left" style="width:600px;">
	<!-- Website Logo Start -->
	<div style="border:2px solid #502D7F; width:650px; margin:0 0 0 30px; border-bottom:none;" align="left"><a href="<?php echo SITE_PATH;?>"><img src="<?php echo SITE_PATH.'img/front_end/logo.png'; ?>" border="0" alt="" /></a></div>
	<!-- Website Logo End -->

	<!-- Email Body Start -->
	<div style="margin:0 0 0 30px; width:650px; border:2px solid #502D7F;">

	<?php echo $content_for_layout;?>

	<span style="font-size:10px; float:right; font-family:Arial,Helvetica,sans-serif;">Please don't reply to this email as this is an autogenerated email.</span>
	</div>
	<!-- Email Body End -->
</div>
<!-- Main Container End -->
</body>
</html>