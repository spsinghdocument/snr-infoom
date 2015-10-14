<?php
App::uses('AppController', 'Controller');
/**
 * BusinessFeeds Controller
 *
 * @property BusinessFeed $BusinessFeed
 */
class BusinessFeedsController extends AppController {

	public $name = 'BusinessFeeds';	
	public $helpers = array('Html', 'Form', 'Session', 'Text', 'Image');
	public $components = array('Session', 'Email', 'Auth', 'Location', 'Fp', 'SocialMedia');

	public $wallUrl = '/users/dashboard/';

	//BEFORE FILTER STARTS
	function beforeFilter(){
		parent::beforeFilter();
		if(!empty($this->Auth))
			$this->Auth->allowedActions = array('view_feed_content');
	}
	//BEFORE FILTER ENDS

	/*---------------------------- FRONT SECTION START ----------------------------------------*/
	//FUNCTION FOR POSTING THE BUSINESS FEED START
	public function post_feed(){ //pr($_POST);die;
		$this->layout = '';
		
		$fieldNameArr = explode('_', $_POST['post_type']);
		$fieldName = end($fieldNameArr);

		$saveData['business_id'] = $_POST['business_id'];
		$saveData['status'] = '1';

		if($fieldName == 'message')
			$saveData['message'] = trim($_POST['post_content']);
		else
			$saveData[$fieldName] = $_POST['post_content'];
		

		if($this->BusinessFeed->save($saveData)){
			echo 'saved';
		}else{
			echo '<font color="red">Please Try Later!!</font>';
		}
		exit;
	}
	//FUNCTION FOR POSTING THE BUSINESS FEED END

	//FUNCTION FOR OPENING THE CORRESPONDING SECTION START
	public function open_corresponding_field(){ //pr($_POST);die;
		$this->layout = 'ajax';

		$this->set('type', $_POST['type']);
	}
	//FUNCTION FOR OPENING THE CORRESPONDING SECTION END

	//FUNCTON FOR UPLAODING THE IMAGE START
	public function upload_image(){ //pr($_FILES);die;
		$this->layout = 'ajax';
		if($_FILES['image']['name'] != ''){
			$file_name = $this->Fp->uploadFile('../webroot/img/front_end/business/feeds/', $_FILES['image']);
			if($file_name != '')
				$ret = $file_name;
		}

		echo $ret;
		exit;
	}
	//FUNCTON FOR UPLAODING THE IMAGE END

	//FUNCTON FOR UPLAODING THE VIDEO START
	public function upload_video(){ //pr($_FILES);die;
		$this->layout = 'ajax';
		$ret = '';
		if($_FILES['image']['name'] != ''){
			$file_name = $this->Fp->upload_major_videos('../webroot/img/front_end/business/feeds/video/flv/', '../webroot/img/front_end/business/feeds/video/image/', $_FILES['image']);
			if($file_name != '')
				$ret = $file_name;
		}

		echo $ret;
		exit;
	}
	//FUNCTON FOR UPLAODING THE VIDEO END

	//FUNCTION TO VIEW VIDEO IN POP-UP START
	public function view_video($video, $type=null){ //echo $video.', '.$type;die;
		$this->layout = 'ajax';

		$this->set('video', $video);
		$this->set('type', $type);
	}
	//FUNCTION TO VIEW VIDEO IN POP-UP END

	//FUNCTION FOR SAVING THE FEEDS SECTION START
	public function save_feeds_data(){ //pr($_POST);die;
		$this->layout = 'ajax';

		$saveData['business_id'] = $_POST['business_id'];
		$saveData['image'] = $_POST['image'];

		$fileName = '';
		if($_POST['video'] != ''){
			$videoExpArr = explode('.', $_POST['video']);
			$fileExt = array_pop($videoExpArr);
			$fileName = str_replace('.'.$fileExt, '', $_POST['video']);
		}

		$saveData['video'] = $fileName;
		$saveData['link'] = $_POST['link'];
		$saveData['message'] = trim($_POST['message']);
		$saveData['status'] = '1';
		$saveData['marketting'] = $_POST['marketting'];
		$saveData['image_caption'] = $_POST['image_caption'];
		$saveData['video_caption'] = $_POST['video_caption'];
		$saveData['link_caption'] = $_POST['link_caption'];

		//for youtube vimeo
		if($_POST['youtube_link'] != ''){
			$saveData['youtube_link'] = $_POST['youtube_link'];
			$saveData['youtube_type'] = $_POST['yotube_type'];
		} //pr($saveData);die;

		if($this->BusinessFeed->save($saveData)){
			$id = $this->BusinessFeed->id;

			//SHARE ON SOCIAL MEDIAS START
			$socialExp = explode(',', $_POST['social_medias']);
			foreach($socialExp as $social){
				if($social != ''){
					switch($social){
						case 'google': 
							$this->SocialMedia->postContentOnGoogle();
							break;
						case 'twitter': 
							$this->SocialMedia->postContentOnTwitter($saveData, $id, $this->Session->read('Auth.User.User.twitter_oauth_token'), $this->Session->read('Auth.User.User.twitter_oauth_verifier')); 
							break;
						case 'facebook': 
							$this->SocialMedia->postContentOnFacebook($saveData, $id, $this->Session->read('Auth.User.User.facebook_oauth_token')); 
							break;
					}
				}
			}
			//SHARE ON SOCIAL MEDIAS END

			echo 'saved*'.$id;
		}else
			echo 'error*<font color="red">Please Try Later!!</font>';
		exit;
	}
	//FUNCTION FOR SAVING THE FEEDS SECTION END

	//FUNCTION FOR VIEWING THE CONTENT IN POP-UP STRAT
	public function view_content($type, $id){
		$this->layout = 'FrontEnd/Pop_up/default';

		//$this->BusinessFeed->recursive = -1;
		$businessArr = $this->BusinessFeed->findById($this->Fp->decrypt($id));
		$this->set('businessArr', $businessArr);
		$this->set('type', $type);
	}
	//FUNCTION FOR VIEWING THE CONTENT IN POP-UP END

	//FUNCTION FOR DELETING THE FEEDS START
	public function delete_feeds_data(){ //pr($_POST);die;
		$this->layout = 'ajax';

		$this->BusinessFeed->recursive = -1;
		$feedArr = $this->BusinessFeed->findById($_POST['feed_id']);

		//validate loggedIn User is the owner of the corresponding business
		$user_id = $this->Fp->fetchCorrespondingBusinessUser_id($feedArr['BusinessFeed']['business_id']);
		if($user_id == $this->Session->read('Auth.User.User.id')){
			//delete the feed details start
			//1.DELETE THE IMAGE
			if($feedArr['BusinessFeed']['image'] != ''){
				$imageRealPath = '../webroot/img/front_end/business/feeds/'.$feedArr['BusinessFeed']['image'];
				if(is_file($imageRealPath))
					unlink($imageRealPath);
			}

			//2.DELETE THE VIDEO START
			if($feedArr['BusinessFeed']['video'] != ''){
				//a. delete the video file start
				$videoRealUrl = '../webroot/img/front_end/business/feeds/video/flv/'.$feedArr['BusinessFeed']['video'].'.flv';
				if(is_file($videoRealUrl))
					unlink($videoRealUrl);

				//b. delete the video image start
				$videoImageRealPath = '../webroot/img/front_end/business/feeds/video/image/'.$feedArr['BusinessFeed']['video'].'.jpg';
				if(is_file($videoImageRealPath))
					unlink($videoImageRealPath);
			}

			if($this->BusinessFeed->delete($feedArr['BusinessFeed']['id'])){
				echo 'deleted';
			}else{
				echo '<font color="red">Please Try Later!!</font>';
			}
			//delete the feed details end
		}else{
			echo '<font color="red">Invalid Business!!</font>';
		}
		exit;
	}
	//FUNCTION FOR DELETING THE FEEDS START

	//FUNCTION FOR FETCHING THE CORRESPONDING FEED DATA START
	function fetch_corresponding_feeds_data(){ //pr($_POST);die;
		$this->layout = 'ajax';

		//$this->BusinessFeed->recursive = -1;
		$this->set('feed', $this->BusinessFeed->findById($_POST['id']));
	}
	//FUNCTION FOR FETCHING THE CORRESPONDING FEED DATA END
	/*---------------------------- FRONT SECTION END ----------------------------------------*/



	//FUNCTION FOR TESTING THE FFMPEG START
	public function test_mpeg(){
		$ffmpeg = '';
		$ffmpeg = trim(shell_exec('which ffmpeg')); 
		if($ffmpeg == '')
			echo 'FFMPEG NOT CONFIGURED';
		else
			echo $ffmpeg;
		die;
	}
	//FUNCTION FOR TESTING THE FFMPEG END

	//FUNCTION FOR MAKING AN IMAGE OF A VIDEO FILE START
	public function snap_from_video(){
		$input = '../webroot/img/front_end/business/feeds/video/flv/iHGaXSZdMHXHeCQ.flv';
		$output = '../webroot/img/front_end/business/feeds/video/flv/iHGaXSZdMHXHeCQ.jpg';
		if(is_file($input)){
			$shellCommand = "ffmpeg -i ".$input." -an -ss 00:00:05 -r 1 -vframes 1 -f mjpeg -y ".$output;
			$convert_image = exec($shellCommand);

			//check for the presence of flv file whether created or not
			$return = 'false';
			if(is_file($output))
				$return = 'true';
		}else
			$return = 'Input File Not Found!!';
		
		echo $return;
		die;
	}
	//FUNCTION FOR MAKING AN IMAGE OF A VIDEO FILE END


	//FUNCTION FOR SAVING THE USER FEEDS SECTION START(SAURABH 5/6/2013)
	 public function save_user_feeds_data(){ //pr($_POST);die;
	  $this->layout = 'ajax';
	 
	  $saveData['user_id'] = $_POST['user_id'];
	  $saveData['image'] = $_POST['image'];
	  $saveData['visibility'] = $_POST['visibility'];
	 
	  $fileName = '';
	  if($_POST['video'] != ''){
	   $videoExpArr = explode('.', $_POST['video']);
	   $fileExt = array_pop($videoExpArr);
	   $fileName = str_replace('.'.$fileExt, '', $_POST['video']);
	  }
	 
	  $saveData['video'] = $fileName;
	  $saveData['link'] = $_POST['link'];
	  $saveData['message'] = trim($_POST['message']);
	  $saveData['status'] = '1';
	  $saveData['image_caption'] = $_POST['image_caption'];
	  $saveData['video_caption'] = $_POST['video_caption'];
	  $saveData['link_caption'] = $_POST['link_caption'];

	  //for youtube vimeo
		if($_POST['youtube_link'] != ''){
			$saveData['youtube_link'] = $_POST['youtube_link'];
			$saveData['youtube_type'] = $_POST['yotube_type'];
		} //pr($saveData);die;
	 
	  if($this->BusinessFeed->save($saveData)){
	   $id = $this->BusinessFeed->id;

		//SHARE ON SOCIAL MEDIAS START
		$socialExp = explode(',', $_POST['social_medias']);
		foreach($socialExp as $social){
			if($social != ''){
				switch($social){
					case 'google': 
						$this->SocialMedia->postContentOnGoogle();
						break;
					case 'twitter': 
						$this->SocialMedia->postContentOnTwitter($saveData, $id, $this->Session->read('Auth.User.User.twitter_oauth_token'), $this->Session->read('Auth.User.User.twitter_oauth_verifier')); 
						break;
					case 'facebook': 
						$this->SocialMedia->postContentOnFacebook($saveData, $id, $this->Session->read('Auth.User.User.facebook_oauth_token')); 
						break;
				}
			}
		}
		//SHARE ON SOCIAL MEDIAS END

	   echo 'saved*'.$id;
	  }else
	   echo 'error*<font color="red">Please Try Later!!</font>';
	  exit;
	 }
	 //FUNCTION FOR SAVING THE USER FEEDS SECTION END(SAURABH 5/6/2013)



	//FUNCTION FOR SHOWING THE DATA PUBLICALLY START
	public function view_feed_content(){
		$this->layout = 'FrontEnd/Pop_up/default';
		$feed_id = $this->params['id'];
		if($feed_id != ''){
			//$this->BusinessFeed->unbindModel(array('belongsTo'=>array('Business', 'GroupUser', 'Group')));
			$businessArr = $this->BusinessFeed->findById($this->Fp->decrypt($feed_id));
			if(!empty($businessArr))
				$this->set('businessArr', $businessArr);
			else
				$this->redirect(SITE_PATH);
		}else
			$this->redirect(SITE_PATH);
	}
	//FUNCTION FOR SHOWING THE DATA PUBLICALLY END

	//FUNCTION FOR VALIDATING THE MARKETTING FEEDS START 6/5/2013
	public function validate_marketting_feeds(){ //pr($_POST);die;
		$this->layout = 'ajax';

		$business_id = $_POST['busines_id'];
		$business_plan = $_POST['business_plan'];

		Controller::loadModel('PurchasedMembership');
		Controller::loadModel('Membership');
		$this->PurchasedMembership = new PurchasedMembership();
		$this->Membership = new Membership();

		$available = 'no';

		//find the total provided feeds
		$this->Membership->recursive = -1;
		$availableFiedsArr = $this->Membership->find('first', array('fields'=>array('Membership.advertising_feeds'), 'conditions'=>array('Membership.id'=>$business_plan)));
		$availableFieds = $availableFiedsArr['Membership']['advertising_feeds'];

		//fetch the date of purchase of membership plan
		$this->PurchasedMembership->recursive = -1;
		$purchasedDateArr = $this->PurchasedMembership->find('first', array('conditions'=>array('PurchasedMembership.business_id'=>$business_id, 'PurchasedMembership.membership_id'=>$business_plan), 'order'=>array('PurchasedMembership.id'=>'DESC'), 'limit'=>1));
		$purchasedDate = date('Y-m-d', strtotime($purchasedDateArr['PurchasedMembership']['purchased_on']));

		//fetch the total Used marketting feeds
		Controller::loadModel('BusinessFeed');
		$this->BusinessFeed = new BusinessFeed();

		$usedFeeds = $this->BusinessFeed->find('count', array('conditions'=>array('BusinessFeed.business_id'=>$business_id, 'BusinessFeed.marketting'=>'1', 'DATE(BusinessFeed.created) >='=>$purchasedDate)));

		//check for used feeds & calculate availability
		if($availableFieds > $usedFeeds)
			$available = 'yes';
		echo $available;
		exit;
	}
	//FUNCTION FOR VALIDATING THE MARKETTING FEEDS END 6/5/2013



	/*------------------------------  ADMIN SECTION START --------------------------------*/
	public function admin_manage($business_id){
		$this->paginate = array('conditions'=>array('BusinessFeed.business_id'=>$business_id), 'limit'=>PAGING_SIZE, 'order'=>array('BusinessFeed.id'=>'DESC'));
		$this->set('viewListing', $this->paginate('BusinessFeed'));
	}

	public function admin_view($id){
		$this->layout = 'FancyBox/fancy_box_popup';
		$this->set('businessArr', $this->BusinessFeed->findById($id));
	}
	/*------------------------------  ADMIN SECTION END --------------------------------*/
 






}
