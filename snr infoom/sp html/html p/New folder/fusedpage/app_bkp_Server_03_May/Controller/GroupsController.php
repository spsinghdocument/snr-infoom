<?php
App::uses('AppController', 'Controller');
/**
 * Faqs Controller
 *
 * @property Faq $Faq
 */
class GroupsController extends AppController {
	public $name = 'Groups';	
	public $helpers = array('Html', 'Form', 'Session', 'Text', 'Image');
	public $components = array('Session', 'Cookie', 'Email', 'Auth', 'Fp', 'SocialMedia');

	//BEFORE FILTER STARTS
	/*function beforeFilter(){
		parent::beforeFilter();
		if(!empty($this->Auth)){
			$this->Auth->allowedActions = array('faq', 'fetch_paging_data');
		}
	}*/
	//BEFORE FILTER ENDS

	/*---------------------------- ADMIN SECTION START ----------------------------------------*/
	
	/*---------------------------- ADMIN SECTION END ------------------------------------------*/

	/*---------------------------- FRONT SECTION START ------------------------------------------*/
	function validateGroupOwner($grpId){
		$this->Group->recursive = -1;
		$grpArr = $this->Group->findById($grpId);
		if($grpArr['Group']['user_id'] != $this->Session->read('Auth.User.User.id')){
			$this->redirect('/groups/listings/');
		}
	}

	//FUNCTION FOR ADD GROUP START(SAURABH 5/15/2013)
	public function listings() {
		$user_Id = $this->Session->read('Auth.User.User.id');
		$this->set('viewListing', $this->Group->find('all', array('conditions'=>array('Group.status'=>'1'), 'limit'=>PAGING_SIZE, 'order'=>array('Group.id'=>'DESC'))));
	}
	//FUNCTION FOR ADD GROUP END(SAURABH 5/15/2013)

	//FUNCTION FOR FROUP DETAILS START(SAURABH 5/15/2013)
	public function details($id=null, $alias_name=null){
		if($id != ''){
			$this->Group->unbindModel(array('belongsTo'=>array('User')));
			$grpArr = $this->Group->findById($this->Fp->decrypt($id));
			if(!empty($grpArr)){ //pr($grpArr);die;
				$this->set('grpArr', $grpArr);
			}else
				$this->redirect('/groups/listings/');
		}else
			$this->redirect('/groups/listings/');
	}
	//FUNCTION FOR GROUP DETAILS END(SAURABH 5/15/2013)

	//FUNCTION FOR ADD GROUPS START(SAURABH 5/15/2013)
	public function add_groups() {
		Controller::loadModel('BusinessBanner');
		if(!empty($this->request->data)){ //pr($this->request->data);die;
		$allowed_types = unserialize(ALLOWED_IMAGE_TYPES);
		$continue = 'true';
		$fileName = '';
		//upload the image
			if($this->request->data['Group']['image']['name'] != ''){
				if(in_array($this->request->data['Group']['image']['type'], $allowed_types)){
					$fileName = $this->Fp->uploadFile('../webroot/img/front_end/groups/', $this->request->data['Group']['image']);
					if($fileName != '')
						$this->request->data['Group']['image'] = $fileName;
				}else{
					$this->Session->setFlash(__('Please Upload only *.gif, *.jpg, *.png image only!', true), 'message', array('class'=>'message-red'));
					$continue = 'false';
				}
			}else
				$this->request->data['Group']['image'] = '';

				if($continue == 'true'){
					$this->request->data['Group']['user_id'] = $this->Session->read('Auth.User.User.id');
					$this->request->data['Group']['alias_name'] = $this->Fp->parseParameterNew($this->request->data['Group']['title']);
				if($this->Group->save($this->request->data)){
					if($fileName != ''){
						$last_id = $this->Group->id;
						$saveData['BusinessBanner']['banner'] = $fileName;
						$saveData['BusinessBanner']['group_id'] = $last_id;
						$this->BusinessBanner->save($saveData);
					}

					$this->Session->setFlash(__('Group Added Successfully!!', true), 'message', array('class'=>'message-green'));
					$this->redirect('/groups/listings/');
				}else
					$this->Session->setFlash(__('Please Correct Following Errors!!', true), 'message', array('class'=>'message-red'));
				}
		}
	}
	//FUNCTION FOR ADD GROUPS END(SAURABH 5/15/2013)

	//FUNCTION FOR EDITING A GROUP START
	public function edit($id=null, $alias_name=null){
		if(!empty($this->request->data)){ //pr($this->request->data);die;
			$allowed_types = unserialize(ALLOWED_IMAGE_TYPES);
			$continue = 'true';
		
			//upload the image, if uploaded
			if($this->request->data['Group']['image']['name'] != ''){
				if(in_array($this->request->data['Group']['image']['type'], $allowed_types)){
					$fileName = $this->Fp->uploadFile('../webroot/img/front_end/groups/', $this->request->data['Group']['image']);
					if($fileName != '')
						$this->request->data['Group']['image'] = $fileName;

					//delete the old image
					if($this->request->data['Group']['old_banner'] != ''){
						$bannerRealPath = '../webroot/img/front_end/groups/'.$this->request->data['Group']['old_banner'];
						if(is_file($bannerRealPath))
							unlink($bannerRealPath);
					}

					//update the info in banners table
					Controller::loadModel('BusinessBanner');
					$saveData['id'] = $this->request->data['Group']['banner_id'];
					$saveData['banner'] = $fileName;
					$this->BusinessBanner->save($saveData, false);
				}else{
					$this->Session->setFlash(__('Please Upload only *.gif, *.jpg, *.png image only!', true), 'message', array('class'=>'message-red'));
					$continue = 'false';
				}
			}else{
				$this->request->data['Group']['image'] = $this->request->data['Group']['old_banner'];
			}

			//save the other data
			if($continue == 'true'){
				$this->request->data['Group']['alias_name'] = $this->Fp->parseParameterNew($this->request->data['Group']['title']); 
				if($this->Group->save($this->request->data, false))
					$this->redirect('/groups/listings/');
				else
					$this->Session->setFlash(__('Please Try Later!!', true), 'message', array('class'=>'message-red'));
			}
		}

		if($id != ''){
			$id = $this->Fp->decrypt($id);
			$this->validateGroupOwner($id); //validate group owner

			$this->Group->recursive = 1;
			$this->Group->unbindModel(array('belongsTo'=>array('User'), 'hasMany'=>array('GroupGallery')));
			$grpArr = $this->Group->findById($id);
			if(!empty($grpArr)){ //pr($grpArr);die;
				$this->data = $grpArr;
			}else
				$this->redirect('/groups/listings/');
		}else
			$this->redirect('/groups/listings/');
	}
	//FUNCTION FOR EDITING A GROUP END

	//AJAX FUNCTION FOR POSTING THE ABOUT US CONTENT START
	public function post_about_us_content(){ 
		$this->layout = 'ajax';

		$message = trim($_POST['aboutUsMessage']);
		$groupId = $_POST['group_id'];

		$groupArr = $this->Group->find('first', array('conditions'=>array('Group.id'=>$groupId)));

		if($groupArr['Group']['user_id'] == $this->Session->read('Auth.User.User.id')){
			$saveData['Group']['id'] = $groupId;
			$saveData['Group']['description'] = $message;
			if($this->Group->save($saveData)){
				echo 'saved';
			}else
				echo '<font color="red">Please Try Later!!</font>';
		}else
			echo '<font color="red">Invalid Groups!!</font>';
		exit;
	}
	//AJAX FUNCTION FOR POSTING THE ABOUT US CONTENT END

	//FUNCTION FOR ADD GROUP RECOMMENDED START(SAURABH 5/18/2013)
	function add_group_recommend(){ //pr($_POST); die;
		$this->layout = 'ajax';

		Controller::loadModel('GroupRecommend');
		$saveData['group_id'] = $_POST['group_id'];
		$saveData['user_id'] = $_POST['user_id'];
		$saveData['status'] = '1';

		$this->GroupRecommend->save($saveData);
	}
	//FUNCTIONF OR ADD GROUP RECOMMENDED END(SAUURABH 5/18/2013)


	/* FOR GROUP COMMENT AREA START */

	//FUNCTON FOR UPLAODING THE IMAGE START
	public function upload_image(){ //pr($_FILES);die;
		$this->layout = 'ajax';
		if($_FILES['image']['name'] != ''){
			$file_name = $this->Fp->uploadFile('../webroot/img/front_end/groups/recents/', $_FILES['image']);
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
			$file_name = $this->Fp->upload_major_videos('../webroot/img/front_end/groups/recents/video/flv/', '../webroot/img/front_end/groups/recents/video/image/', $_FILES['image']);
			if($file_name != '')
				$ret = $file_name;
		}

		echo $ret;
		exit;
	}
	//FUNCTON FOR UPLAODING THE VIDEO END

	//FUNCTION FOR SAVING THE USER FEEDS SECTION START(SAURABH 5/6/2013)
	 public function save_group_recents_data(){ //pr($_POST);die;
	  $this->layout = 'ajax';
	  Controller::loadModel('BusinessFeed');
	  $saveData['group_user_id'] = $_POST['group_user_id'];
	  $saveData['group_id'] = $_POST['group_id'];
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

	 //FUNCTION FOR FETCHING THE CORRESPONDING FEED DATA START
	function fetch_corresponding_recents_data(){
		$this->layout = 'ajax';
		Controller::loadModel('BusinessFeed');
		//$this->BusinessFeed->recursive = -1;
		//$this->set('feed', $this->BusinessFeed->findById($_POST['id']));
		
		$feed = $this->BusinessFeed->find('first', array('conditions'=>array('BusinessFeed.id'=>$_POST['id'])));
		$this->set('feed', $feed);
	}
	//FUNCTION FOR FETCHING THE CORRESPONDING FEED DATA END


	//FUNCTION FOR DELETING THE FEEDS START
	public function delete_feeds_data(){ //pr($_POST);die;
		$this->layout = 'ajax';
		Controller::loadModel('BusinessFeed');

		$this->BusinessFeed->recursive = -1;
		$feedArr = $this->BusinessFeed->findById($_POST['feed_id']);

		//validate loggedIn User is the owner of the corresponding business
		//$user_id = $this->Fp->fetchCorrespondingBusinessUser_id($feedArr['BusinessFeed']['group_id']);
		if($feedArr['BusinessFeed']['group_user_id'] == $this->Session->read('Auth.User.User.id')){
			//delete the feed details start
			//1.DELETE THE IMAGE
			if($feedArr['BusinessFeed']['image'] != ''){
				$imageRealPath = '../webroot/img/front_end/groups/recents/'.$feedArr['BusinessFeed']['image'];
				if(is_file($imageRealPath))
					unlink($imageRealPath);
			}

			//2.DELETE THE VIDEO START
			if($feedArr['BusinessFeed']['video'] != ''){
				//a. delete the video file start
				$videoRealUrl = '../webroot/img/front_end/groups/recents/video/flv/'.$feedArr['BusinessFeed']['video'].'.flv';
				if(is_file($videoRealUrl))
					unlink($videoRealUrl);

				//b. delete the video image start
				$videoImageRealPath = '../webroot/img/front_end/groups/recents/video/image/'.$feedArr['BusinessFeed']['video'].'.jpg';
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

	/* FOR GROUP COMMENT AREA END */



	/* FOR COMMENT AND RECOMMENDED START */
	
	//FUNCTION FOR SAVE GROUP COMMENTS START(SAURABH 5/13/2013)
	function saveComment(){
		Controller::loadModel('GroupComment');
		$this->layout = 'ajax';
		$user_id = $_POST['user_id'];
		$group_id = $_POST['group_recents_id'];
		$group_feed_id = $_POST['group_feed_id'];
		$comment = $_POST['comment'];

		$saveData['user_id'] = $user_id;
		$saveData['group_id'] = $group_id;
		$saveData['feed_id'] = $group_feed_id;
		$saveData['comment'] = $comment;
		$saveData['status'] = '1';
		$this->GroupComment->save($saveData);

		$this->set('comment', $comment);

		$last_id = $this->GroupComment->id;
		$commentArr = $this->GroupComment->find('first', array('GroupComment.id'=>$last_id));
		$this->set('commentArr', $commentArr);
		$userr_id = $commentArr['GroupComment']['user_id'];
		$this->set('userr_id', $userr_id);
		$this->set('last_id', $last_id);
		//$this->set('group_feed_id', $group_feed_id);
	}
	//FUNCTION FOR SAVE GROUP COMMENTS END(SAURABH 5/13/2013)

	//FUNCTION FOR DELETE GROUP COMMENT START(SAURABH 5/9/2013)
	function delete_group_comment(){
		Controller::loadModel('GroupComment'); 
		$this->layout = 'ajax';
		$comment_id = $_POST['comment_id'];

		if($this->GroupComment->delete($comment_id)){
			echo 'deleted';
		}
		exit;
	}
	//FUNCTION FOR DELETE GROUP COMMENT END(SAURABH 5/9/2013)

	/* FOR COMMENT AND RECOMMENDED END */

	/*---------------------------- FRONT SECTION END --------------------------------------------*/

}

?>
