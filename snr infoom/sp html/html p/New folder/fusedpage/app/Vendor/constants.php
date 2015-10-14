<?php //pr($_SERVER);die;
	//FOR HTTPS
	$protocol = 'http';
	if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on')
		$protocol = 'https';

	//FOR WEBSITE CONSTANTS START
	define('PAGING_SIZE','20');
	define('SITE_PATH', $protocol.'://'.$_SERVER['HTTP_HOST'].'/fusedpage/');
	define('EMAIL_ADMIN_FROM', 'info@fusedpage.com');
	define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT'].'/fusedpage/');
	define('EMAIL_SIGNATURE', 'Fused Page Team.');
	define('ALLOWED_IMAGE_TYPES', serialize(array('image/jpeg', 'image/pjpeg', 'image/png')));
	define('GOOGLE_MAP_API_KEY', 'AIzaSyAwRX-ElDvyL7oiWafWaomBiGg5jlSPbCA');

	//FOR GEOGRAPHIC LOCATIONS START
	define('IP_LOCATION_API_KEY', 'efd67dca864cbe8b45fb21b7d19916bf471afd1bfcfe0b3e975d1f238d6c7ed3');
	//define('IP_ADDRESS', $_SERVER['REMOTE_ADDR']);
	define('IP_ADDRESS', '125.63.73.82');
	//FOR GEOGRAPHIC LOCATIONS END

	//FOR TWITTER CONSTANTS START 5/28/2013
	define('TWITTER_CONSUMER_KEY', 'ipE13pot4mEerM0INOSYeg');
	define('TWITTER_CONSUMER_SECRET', 'k7DCZicoJajEa6KHsQ9m139LgRpOhBp8gCgTN69zpQ');
	//FOR TWITTER CONSTANTS END 5/28/2013

	//FOR FACEBOOK CONSTANTS START 5/29/2013
	define('FACEBOOK_APP_ID', '393776577405415');
	define('FACEBOOK_APP_SECRET', 'b2054342e6d09c948a56ac84f9cefc71');
	//FOR FACEBOOK CONSTANTS START 5/29/2013

	//FOR CONFIGURING THE SMTP ON LOCAL START
	ini_set('SMTP','mail.seologistics.com');
	ini_set('smtp_port','25');
	ini_set('sendmail_from','arun_chauhan@seologistics.com');
	//FOR CONFIGURING THE SMTP ON LOCAL END

		
	//echo Configure::version();die;
?>