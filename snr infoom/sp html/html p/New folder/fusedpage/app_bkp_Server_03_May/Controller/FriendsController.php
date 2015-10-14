<?php
App::uses('AppController', 'Controller');
/**
 * Businesses Controller
 *
 * @property Business $Business
 */
class FriendsController extends AppController {
	public $name = 'Friends';	
	public $helpers = array('Html', 'Form', 'Session', 'Text', 'Image');
	public $components = array('Session', 'Email', 'Auth', 'Location', 'Fp');

	public $wallUrl = '/users/dashboard/';

	//BEFORE FILTER STARTS
	function beforeFilter(){
		parent::beforeFilter();
		if(!empty($this->Auth))
			$this->Auth->allowedActions = array('search_friend', 'sent_request');
	}
	//BEFORE FILTER ENDS

	/*---------------------------- ADMIN SECTION START ----------------------------------------*/
	
	/*---------------------------- ADMIN SECTION END ----------------------------------------*/

	/*---------------------------- FRONT END SECTION START ----------------------------------------*/

	//FUNCTION FOR LIST USRE FRIENDS START(SAURABH 5/2/2013)
	function listings(){
		$user_id = $this->Session->read('Auth.User.User.id');

		$conditions["Friend.request_sent"] = $user_id;
		$conditions["Friend.request_received"] = $user_id;
		
		$this->set('viewListing', $this->Friend->find('all', array('conditions'=>array('Friend.friendship_status'=>'1', "OR"=>$conditions), 'limit'=>PAGING_SIZE, 'order'=>array('Friend.id'=>'DESC'))));

		/*$this->set('viewListing', $this->Friend->find('all', array('conditions'=>array('Friend.request_sent'=>$user_id, 'Friend.friendship_status <>'=>'2'), 'limit'=>PAGING_SIZE, 'order'=>array('Friend.id'=>'DESC'))));*/
	}
	//FUNCTION FOR LIST USER FRIENDS END(SAURABH 5/2/2013)

	//FUNCTION FOR SEND FRIEND REQUEST START(SAURABH 5/3/2013)
	function received_requests(){
		$user_id = $this->Session->read('Auth.User.User.id');
		$this->set('viewListing', $this->Friend->find('all', array('conditions'=>array('Friend.request_received'=>$user_id, 'Friend.friendship_status'=>'0'), 'limit'=>PAGING_SIZE, 'order'=>array('Friend.id'=>'DESC'))));
	}
	//FUNCTION FOR SEND FRIEND REQUEST END(SAURABH 5/3/2013)

	//FUNCTION FOR FRIEND LISTING AFTER SEARCH START(SAURABH 5/3/2013)
	function search_friend(){
		Controller::loadModel('User');
		$this->layout = 'ajax';
		$keyword = trim($_POST['keyword']);
		$userlistArr = $this->User->find('all', array('conditions'=>array('User.id <>'=>$this->Session->read('Auth.User.User.id'), 'User.status'=>'1', 'OR'=>array(
			'User.first_name LIKE'=>"%".$keyword."%",
			'User.last_name LIKE'=>"%".$keyword."%",
			'CONCAT(User.first_name, " ", User.last_name) LIKE'=>"%".$keyword."%",
			'User.email LIKE'=>"%".$keyword."%",
			)), 'limit'=>PAGING_SIZE, 'order'=>array('User.id'=>'DESC')));
		if(!empty($userlistArr)){
			$this->set('viewListing', $userlistArr);
		}
		
	}
	//FUNCTION FOR FRIEND LISTING AFTER SEARCH END(SAURABH 5/3/2013)

	//FUNCTION FOR AUTOSUGGATION DATE START(SAURABH 5/3/2013)
	function auto_data(){
		Controller::loadModel('User');
		$this->layout = 'ajax';
		$searchkey = trim($_POST['searchkey']);
		$return = '';
		$searchArr = $this->User->find('all', array('conditions'=>array('User.id <>'=>$this->Session->read('Auth.User.User.id'), 'User.status'=>'1', 'OR'=>array(
			'User.first_name LIKE'=>"%".$searchkey."%",
			'User.last_name LIKE'=>"%".$searchkey."%",
			'CONCAT(User.first_name, " ", User.last_name) LIKE'=>"%".$searchkey."%",
			'User.email LIKE'=>"%".$searchkey."%",
			))));
		$this->set('searchArr', $searchArr);
		if(!empty($searchArr)){
			$return = $searchArr;
		}
		return $return;
	}
	//FUNCTION FOR AUTOSUGGATION DATA END(SAURABH 5/3/2013)

	//FUNCTION FOR SEND FRIEND REQUEST START(SAURABH 5/3/2013)
	function sent_request(){
		$this->layout = 'ajax';
		$user_id = $this->Session->read('Auth.User.User.id');
		$sent_request = $_POST['sent_request'];

		$return = '';
		$saveData['request_sent'] = $user_id;
		$saveData['request_received'] = $sent_request;
		$saveData['friendship_status'] = '0';
		$this->Friend->save($saveData);
		echo $return ='<span>'."Request Sent!!".'</span>';
		exit;
	}
	//FUNCTION FOR SEND FRIEND REQUEST END(SAURABH 5/3/2013)

	//FUNCTION FOR ACCEPT FRIEND REQUEST START(SAURABH 5/3/2013)
	function accept_request(){
		$this->layout = 'ajax';
		$id = $_POST['id'];

		$return = '';
		$saveData['id'] = $id;
		$saveData['friendship_status'] = '1';
		$this->Friend->save($saveData);
		//echo $return ='<span>'."Friend Requested!!".'</span>';
		exit;
	}
	//FUNCTION FOR ACCEPT FRIEND REQUEST END(SAURABH 5/3/2013)

	//FUNCTION FOR DENY FRIEND REQUEST START(SAURABH 5/3/2013)
	function deny_friend(){
		$this->layout = 'ajax';
		$id = $_POST['id'];

		$return = '';
		$saveData['id'] = $id;
		$saveData['friendship_status'] = '2';
		$this->Friend->save($saveData);
		//echo $return ='<span>'."Friend Requested!!".'</span>';
		exit;
	}
	//FUNCTION FOR DENY FRIEND REQUEST END(SAURABH 5/3/2013)

	//FUNCTION FOR UN-FRIEND REQUEST START(SAURABH 5/3/2013)
	function unfriend(){
		$this->layout = 'ajax';
		$id = $_POST['id'];
		
		$this->Friend->delete($id);
	}
	//FUNCTION FOR UN-FRIEND REQUEST END(SAURABH 5/3/2013)
	
	/*******************  Function to add business End ***************************/

	//FUNCTION FOR FETCH USER FRIEND FEED START(SAURABH 5/8/2013)
	function fetch_user_friends_feed(){
		$this->layout = 'ajax';
		App::import('Model', 'BusinessFeed');
		$this->BusinessFeed = new BusinessFeed();
		$user_id = $this->Session->read('Auth.User.User.id');

		//$friendsArr = $this->Friend->find('all', array('fields'=>array('Friend.request_received'), 'conditions'=>array('Friend.request_sent'=>$user_id,'Friend.friendship_status'=>'1')));

		$friendsArr = $this->Friend->find('all', array('fields'=>array('Friend.request_sent','Friend.request_received'), 'conditions'=>array('OR'=>array('Friend.request_sent'=>$user_id, 'Friend.request_received'=>$user_id), 'Friend.friendship_status'=>'1')));
		
		if(!empty($friendsArr)){
		$request_sent = '';
		$request_received = '';
		foreach($friendsArr as $friendArr){
			$request_sent[] = $friendArr['Friend']['request_sent'];
			$request_received[] = $friendArr['Friend']['request_received'];
		} 
			$friend_id = array_merge($request_sent, $request_received);
			$business_user_id = array_unique($friend_id);

			$feedsArr = $this->BusinessFeed->find('all', array('conditions'=>array('BusinessFeed.user_id'=>$business_user_id, 'BusinessFeed.user_id <>'=>$user_id, 'BusinessFeed.status'=>'1'), 'limit'=>PAGING_SIZE, 'order'=>array('BusinessFeed.id'=>'DESC')));
			$this->set('feedsArr', $feedsArr);
		}
	}
	//FUNCTION FOR FETCH USER FRIEND FEED END(SAURABH 5/8/2013)

	
	/*---------------------------- FRONT END SECTION END ----------------------------------------*/



}
