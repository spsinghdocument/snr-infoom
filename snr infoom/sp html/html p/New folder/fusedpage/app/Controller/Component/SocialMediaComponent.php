<?php
App::uses('twitteroauth', 'Vendor/twitter/twitter/lib/twitteroauth');
App::uses('tmhUtilities', 'Vendor/twitter/twitter/lib/secret');

App::uses('Component', 'Controller');
class SocialMediaComponent extends Component{
	public $components = array('Session', 'Cookie', 'Auth', 'Fp');

	/*-----------------------------------  TWITTER SECTION START -----------------------------------------------*/
	public function postContentOnTwitter($content, $id, $user_token, $user_secret){
		//$link = SITE_PATH.'business_feeds/view_feed_content/'.$this->Fp->encrypt($id);
		$link = SITE_PATH.'feeds/'.$this->Fp->encrypt($id);
		$status_update = $content['message'].' '.$link;
		include_once('../Vendor/twitter/twitter/lib/twitteroauth.php');
		include_once('../Vendor/twitter/twitter/lib/secret.php');

		$connection = new TwitterOAuth(TWITTER_CONSUMER_KEY, TWITTER_CONSUMER_SECRET, $user_token, $user_secret);
		$connection->post('statuses/update', array('status'=>$status_update));
	}

	public function postDirectContentOnTwitter($content, $user_token, $user_secret){
		$status_update = $content;
		include_once('../Vendor/twitter/twitter/lib/twitteroauth.php');
		include_once('../Vendor/twitter/twitter/lib/secret.php');

		$connectionNew = new TwitterOAuth(TWITTER_CONSUMER_KEY, TWITTER_CONSUMER_SECRET, $user_token, $user_secret);
		$connectionNew->post('statuses/update', array('status'=>$status_update));
	}
	/*-----------------------------------  TWITTER SECTION END -----------------------------------------------*/

	/*-----------------------------------  FACEBOOK SECTION START ---------------------------------------------*/
	public function postContentOnFacebook($content, $id, $user_token){
		//$link = SITE_PATH.'business_feeds/view_feed_content/'.$this->Fp->encrypt($id);
		$link = SITE_PATH.'feeds/'.$this->Fp->encrypt($id);
		$status_update = $content['message'].' '.$link;

		include_once('../Vendor/facebook/facebook-auth/facebook.php');
		$facebook = new Facebook(array(
			'appId'  => FACEBOOK_APP_ID,
			'secret' => FACEBOOK_APP_SECRET,
			'cookie' => true
		));

		$post =  array(
			'access_token' => $user_token,
			'message' => $status_update
		);
		
		$uid = '';
		$res = $facebook->api('/'.$uid.'feed', 'POST', $post);
	}

	public function postDirectContentOnFacebook($content, $user_token){
		$status_update = $content;

		include_once('../Vendor/facebook/facebook-auth/facebook.php');
		$facebook = new Facebook(array(
			'appId'  => FACEBOOK_APP_ID,
			'secret' => FACEBOOK_APP_SECRET,
			'cookie' => true
		));

		$post =  array(
			'access_token' => $user_token,
			'message' => $status_update
		);
		
		$uid = '';
		$res = $facebook->api('/'.$uid.'feed', 'POST', $post);
	}
	/*-----------------------------------  FACEBOOK SECTION END -----------------------------------------------*/

	/*-----------------------------------  GOOGLE PLUS SECTION START ---------------------------------------------*/
	public function postContentOnGoogle(){
		return '';
	}
	/*-----------------------------------  GOOGLE PLUS SECTION END   ---------------------------------------------*/
}
?>