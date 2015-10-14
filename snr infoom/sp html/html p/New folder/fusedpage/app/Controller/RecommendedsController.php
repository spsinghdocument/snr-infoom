<?php
App::uses('AppController', 'Controller');
/**
 * Businesses Controller
 *
 * @property Business $Business
 */
class RecommendedsController extends AppController {
	public $name = 'Recommendeds';	
	public $helpers = array('Html', 'Form', 'Session', 'Text', 'Image');
	public $components = array('Session', 'Email', 'Auth', 'Location', 'Fp');

	public $wallUrl = '/users/dashboard/';

	//BEFORE FILTER STARTS
	/*function beforeFilter(){
		parent::beforeFilter();
		if(!empty($this->Auth))
			$this->Auth->allowedActions = array('search_friend', 'sent_request');
	}*/
	//BEFORE FILTER ENDS

	/*---------------------------- ADMIN SECTION START ----------------------------------------*/
	
	/*---------------------------- ADMIN SECTION END ----------------------------------------*/

	/*---------------------------- FRONT END SECTION START ----------------------------------------*/

	//FUNCTION FOR ADD RECOMMENDE START(SAURABH 5/10/2013)
	function add_recommended(){
		$this->layout = 'ajax';
		$saveData['feed_id'] = $_POST['recommended_id'];
		$saveData['user_id'] = $_POST['user_id'];
		if(!empty($_POST['business_id'])){
			$saveData['business_id'] = $_POST['business_id'];
		}
		$saveData['status'] = '1';

		$this->Recommended->save($saveData);

		$last_id = $this->Recommended->id;
		$recArr = $this->Recommended->find('first', array('conditions'=>array('Recommended.id'=>$last_id)));
		$feed_id = $recArr['Recommended']['feed_id'];
			
		$CountRecommended = $this->Recommended->find('count', array('conditions'=>array('Recommended.feed_id'=>$feed_id, 'Recommended.status'=>'1')));
		$this->set('CountRecommended', $CountRecommended);

		$this->addFeedsInBusinessFeeds($_POST['recommended_id'], 'Feed');



		//post recommen
		//pr($recArr);die;
		/*----- POSTING ON SOCIAL MEDIA START  -------*/
		$id = $last_id;
		$content['message'] = $this->Session->read('Auth.User.User.first_name').' has recommended the feed on fusedpage ';

		//1. FACEBOOK
		if(($this->Session->read('Auth.User.User.social_facebook') == '1') && ($this->Session->read('Auth.User.User.social_post_recommends') == '1')){
			if($this->Session->read('Auth.User.User.facebook_oauth_token') != ''){
				$this->SocialMedia->postContentOnFacebook($content, $id, $this->Session->read('Auth.User.User.facebook_oauth_token')); 
			}
		}

		//2. TWITTER
		if(($this->Session->read('Auth.User.User.social_twitter') == '1') && ($this->Session->read('Auth.User.User.social_post_recommends') == '1')){
			if($this->Session->read('Auth.User.User.twitter_oauth_token') != ''){
				$this->SocialMedia->postContentOnTwitter($content, $id, $this->Session->read('Auth.User.User.twitter_oauth_token'), $this->Session->read('Auth.User.User.twitter_oauth_verifier')); 
			}
		}
		/*----- POSTING ON SOCIAL MEDIA END   -------*/
	}
	//FUNCTION FOR ADD RECOMMENDED END (SAURABH 5/10/2013)

	//FUNCTION FOR FETCH USER IMAGE START(SAURABh 5/10/2013)
	function fetch_user_image(){
		$this->layout = 'ajax';
		$feed_id = $_POST['feed_id'];
		$user_id = $_POST['user_id'];

		$userImage = $this->Recommended->find('first', array('conditions'=>array('Recommended.feed_id'=>$feed_id, 'Recommended.user_id'=>$user_id)));
		$this->set('userImage', $userImage);
	}
	//FUNCTION FOR FETCH USER IMAGE START(SAURABh 5/10/2013)

	//FUNCTION FOR RECOMMENDING/ UNRECOMMENDING A COMMENT START
	public function comment_recommend(){ //pr($_POST);die;
		$this->layout = 'ajax';

		$this->set('post', $_POST);

		if($_POST['type'] == 'recommend'){
			$saveData['feed_id'] = $_POST['feed_id'];
			$saveData['user_id'] = $this->Session->read('Auth.User.User.id');
			$saveData['comment_id'] = $_POST['comment_id'];
			$saveData['status'] = '1';
			$this->Recommended->save($saveData, false);

			$this->addFeedsInBusinessFeeds($_POST['feed_id'], 'Comment');
		}else{
			$con = array('Recommended.feed_id'=>$_POST['feed_id'], 'Recommended.user_id'=>$this->Session->read('Auth.User.User.id'), 'Recommended.comment_id'=>$_POST['comment_id']);
			$this->Recommended->deleteAll($con);
		}
	}
	//FUNCTION FOR RECOMMENDING/ UNRECOMMENDING A COMMENT END
	
	/*---------------------------- FRONT END SECTION END ----------------------------------------*/



}
