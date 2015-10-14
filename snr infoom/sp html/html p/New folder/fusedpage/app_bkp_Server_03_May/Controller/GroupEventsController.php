<?php
App::uses('AppController', 'Controller');
/**
 * BusinessDeals Controller
 *
 * @property BusinessDeal $BusinessDeal
 */
class GroupEventsController extends AppController {
	public $name = 'GroupEvents';	
	public $helpers = array('Html', 'Form', 'Session', 'Text', 'Image');
	public $components = array('Session', 'Email', 'Auth', 'Location', 'Fp');

	public $wallUrl = '/users/dashboard/';

	//BEFORE FILTER STARTS
	function beforeFilter(){
		parent::beforeFilter();
		if(!empty($this->Auth))
			$this->Auth->allowedActions = array('*');
	}
	//BEFORE FILTER ENDS

	/*---------------------------- FRONT SECTION START ----------------------------------------*/

	//FUNCTION FOR FETCHING THE DEALS FOR LISTING START
	public function fetch_group_events(){ //pr($_POST);die;
		$this->layout = 'ajax';

		$ret = '';
		//$this->GroupEvent->recursive = -1;

		
		$businessDealsArr = $this->GroupEvent->find('all', array('conditions'=>array('GroupEvent.group_id'=>$_POST['group_id'], 'GroupEvent.status'=>'1')));


		if(!empty($businessDealsArr))
			$ret = $businessDealsArr; //pr($ret);die;
		$this->set('dealsArr', $ret);
	}
	//FUNCTION FOR FETCHING THE DEALS FOR LISTING END

	//FUNCTION FOR FETCHING THE ADD EVENT FORM START
	public function fetch_add_events_form(){ //pr($_POST); die;
		$this->layout = 'ajax';
	}
	//FUNCTION FOR FETCHING THE ADD EVENTS FORM END

	//FUNCTION FOR ADDING A EVENT START
	public function add_events_data(){ //pr($_POST);die;
		$this->layout = 'ajax';

		$saveData['group_id'] = $_POST['group_id'];
		$saveData['user_id'] = $this->Session->read('Auth.User.User.id');
		$saveData['title'] = $_POST['GroupEventTitle'];
		$saveData['description'] = $_POST['GroupEventDescription'];
		$saveData['start_date'] = $_POST['GroupEventStartDate'];
		$saveData['status'] ='1';
		if($this->GroupEvent->save($saveData)){
			echo 'saved';
		}else{
			echo '<font color="red">Please Try Later</font>';
		}
		exit;
	}
	//FUNCTION FOR ADDING A EVENT END

	//FUNCTION FOR EDITING A EVENT START
	public function fetch_edit_events_form(){ //pr($_POST);die;
		$this->layout = 'ajax';
		
		
		$businessArr = $this->GroupEvent->find('first', array('conditions'=>array('GroupEvent.id'=>$_POST['id'], 'GroupEvent.user_id'=>$this->Session->read('Auth.User.User.id'))));
		if(!empty($businessArr))
			$this->set('businessArr', $businessArr);
		else{
			echo '<font color="red">Invalid Selection!!</font>';
			die;
		}		
	}
	//FUNCTION FOR EDITING A EVENT END

	//FUNCTION FOR EDITING A EVENT START
	public function edit_events_data(){ //pr($_POST);die;
		$this->layout = 'ajax';

		$saveData['id'] = $_POST['GroupEventId'];
		$saveData['title'] = $_POST['GroupEventTitle'];
		
		$saveData['description'] = $_POST['GroupEventDescription'];
		
		$saveData['start_date'] = $_POST['GroupEventStartDate'];
		
		$saveData['status'] ='1'; //pr($saveData);die;

		if($this->GroupEvent->save($saveData)){
			echo 'saved';
		}else{
			echo '<font color="red">Please Try Later</font>';
		}
		exit;
	}
	//FUNCTION FOR EDITING A EVENT END

	//FUNCTION FOR DELETING A BUSINESS DEAL START
	public function delete_event(){ //pr($_POST);die;
		$this->layout = 'ajax';

		//$this->BusinessDeal->recursive = -1;
		$offerArr = $this->GroupEvent->findById($_POST['id']);
		if(!empty($offerArr)){
			//delete the image
			/*if($offerArr['BusinessDeal']['image'] != ''){
				$imagePath = '../webroot/img/front_end/business/deals/'.$offerArr['BusinessDeal']['image'];
				if(is_file($imagePath))
					unlink($imagePath);
			}*/

			//delete the record
			if($this->GroupEvent->delete($_POST['id']))
				echo 'deleted';
			else
				echo '';
		}else
			echo '';
		exit;
	}
	//FUNCTION FOR DELETING A BUSINESS DEAL START



	//FUNCTION FOR SAVE EVENT COMMENTS START(SAURABH 5/13/2013)
	function saveComment(){
		Controller::loadModel('EventComment');
		$this->layout = 'ajax';
		$user_id = $_POST['user_id'];
		$event_id = $_POST['event_id'];
		$comment = $_POST['comment'];

		$saveData['user_id'] = $user_id;
		$saveData['event_id'] = $event_id;
		$saveData['comment'] = $comment;
		$saveData['status'] = '1';
		$this->EventComment->save($saveData);

		$this->set('comment', $comment);

		$last_id = $this->EventComment->id;
		$commentArr = $this->EventComment->find('first', array('EventComment.id'=>$last_id));
		$this->set('commentArr', $commentArr);
		$userr_id = $commentArr['EventComment']['user_id'];
		$this->set('userr_id', $userr_id);
		$this->set('last_id', $last_id);
	}
	//FUNCTION FOR SAVE EVENT COMMENTS END(SAURABH 5/13/2013)

	//FUNCTION FOR DELETE EVENT COMMENT START(SAURABH 5/9/2013)
	function delete_event_comment(){
		Controller::loadModel('EventComment'); 
		$this->layout = 'ajax';
		$comment_id = $_POST['comment_id'];

		if($this->EventComment->delete($comment_id)){
			echo 'deleted';
		}
		exit;
	}
	//FUNCTION FOR DELETE EVENT COMMENT END(SAURABH 5/9/2013)


	//FUNCTION FOR ADD RECOMMENDE FOR EVENT START(SAURABH 5/10/2013)
	function add_recommended(){
		Controller::loadModel('EventRecommended');
		$this->layout = 'ajax';
		$saveData['event_id'] = $_POST['event_id'];
		$saveData['user_id'] = $_POST['user_id'];
		$saveData['status'] = '1';

		$this->EventRecommended->save($saveData);

		$last_id = $this->EventRecommended->id;
		$recArr = $this->EventRecommended->find('first', array('conditions'=>array('EventRecommended.id'=>$last_id)));
		$event_id = $recArr['EventRecommended']['event_id'];
			
			$CountRecommended = $this->EventRecommended->find('count', array('conditions'=>array('EventRecommended.event_id'=>$event_id, 'EventRecommended.status'=>'1')));
			$this->set('CountRecommended', $CountRecommended);
	
		
	}
	//FUNCTION FOR ADD RECOMMENDED FOR EVENT END (SAURABH 5/10/2013)

	//FUNCTION FOR FETCH USER IMAGE FOR EVENT START(SAURABh 5/10/2013)
	function fetch_user_image(){
		Controller::loadModel('EventRecommended');
		$this->layout = 'ajax';
		$event_id = $_POST['event_id'];
		$user_id = $_POST['user_id'];

		$userImage = $this->EventRecommended->find('first', array('conditions'=>array('EventRecommended.event_id'=>$event_id, 'EventRecommended.user_id'=>$user_id)));
		$this->set('userImage', $userImage);
	}
	//FUNCTION FOR FETCH USER IMAGE FOR EVENT START(SAURABh 5/10/2013)
	/*---------------------------- FRONT SECTION END ----------------------------------------*/


}
