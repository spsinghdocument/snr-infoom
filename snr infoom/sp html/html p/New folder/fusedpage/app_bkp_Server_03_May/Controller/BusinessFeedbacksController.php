<?php
App::uses('AppController', 'Controller');
/**
 * BusinessBanners Controller
 *
 * @property BusinessBanner $BusinessBanner
 */
class BusinessFeedbacksController extends AppController {
	public $name = 'BusinessFeedbacks';	
	public $helpers = array('Html', 'Form', 'Session', 'Text', 'Image');
	public $components = array('Session', 'Email', 'Auth', 'Location', 'Fp');

	public $wallUrl = '/users/dashboard/';

	//BEFORE FILTER STARTS
	function beforeFilter(){
		parent::beforeFilter();
		if(!empty($this->Auth))
			$this->Auth->allowedActions = array();
	}
	//BEFORE FILTER ENDS

	/*---------------------------- ADMIN SECTION START --------------------------------------*/
	//FUNCTION FOR MANAGING THE FEEDBACKS START
	public function admin_manage($business_id){
		$this->paginate = array('conditions'=>array('BusinessFeedback.business_id'=>$business_id), 'limit'=>PAGING_SIZE, 'order'=>array('BusinessFeedback.id'=>'DESC'));
		$this->set('viewListing', $this->paginate('BusinessFeedback'));
	}
	//FUNCTION FOR MANAGING THE FEEDBACKS END

	public function admin_status_update($id, $newStatus, $business_id){
		if($id != ''){
			$pageCount = $this->BusinessFeedback->find('count', array('conditions'=>array('BusinessFeedback.id'=>$id)));
			if($pageCount > 0){
				$saveData['id'] = $id;
				$saveData['status'] = $newStatus;
				if($newStatus == '1')
					$message = 'Approved';
				else
					$message = 'Disapproved';
				if($this->BusinessFeedback->save($saveData, false))
					$this->Session->setFlash(__('Feedback '.$message.' Successfully!!', true), 'message', array('class'=>'message-green'));
				else
					$this->Session->setFlash(__('No Associated Page Found!!', true), 'message', array('class'=>'message-red'));
			}else
				$this->Session->setFlash(__('No Associated Page Found!!', true), 'message', array('class'=>'message-red'));
		}else
			$this->Session->setFlash(__('No Associated Page Found!!', true), 'message', array('class'=>'message-red'));
		$this->redirect('/admin/business_feedbacks/manage/'.$business_id.'/');
		exit;
	}

	public function admin_view($id){
		$this->layout = 'FancyBox/fancy_box_popup';
		$this->set('businessArr', $this->BusinessFeedback->findById($id));
	}
	/*---------------------------- ADMIN SECTION END ----------------------------------------*/

	/*---------------------------- FRONT SECTION START --------------------------------------*/
	//FUNCTION FOR ADDING THE FEEDBACK START
	/* public function post_feedback(){ //pr($_POST);die;
		$this->layout = 'ajax';
		//add the provided comment

		$set = '';

		$saveData['business_id'] = base64_decode($_POST['business_id']);
		$saveData['user_id'] = $this->Session->read('Auth.User.User.id');
		$saveData['feedback'] = $_POST['feedback'];

		if($this->BusinessFeedback->save($saveData)){

			//fetch the last record
			$set = $saveData;

			/* $feedbackArr = $this->BusinessFeedback->find('all', array('fields'=>array('BusinessFeedback.feedback', 'User.first_name', 'User.city', 'User.gender', 'User.image'), 'conditions'=>array('BusinessFeedback.status'=>'1')));
			$set = $feedbackArr; */
		/* }
		$this->set('set', $set);
	} */

	public function post_feedback(){ //pr($_POST);die;
		$this->layout = 'ajax';

		$rating = '';
	
		//if rating data available, set the rating section
		if($_POST['rating'] != ''){
			Controller::loadModel('Business');
			Controller::loadModel('BusinessRating');

			$new_rating = (int)$_POST['rating'];
			$prev_rating = (int)$_POST['previous_rating'];

			if($prev_rating != 0){
				$newRating = ceil(($new_rating + $prev_rating)/2);
				if($newRating > 5)
					$newRating = 5;
			}else
				$newRating = $new_rating;

			//save the new rating value in business rating table
			$saveBusinessRatingData['business_id'] = $_POST['business_id'];
			$saveBusinessRatingData['user_id'] = $this->Session->read('Auth.User.User.id');
			$saveBusinessRatingData['rating'] = $_POST['rating'];
			$this->BusinessRating->save($saveBusinessRatingData, false);

			// update the overall rating for business
			$saveBusinessData['id'] = $_POST['business_id'];
			$saveBusinessData['rating'] = $newRating;
			$this->Business->save($saveBusinessData, false);
			
			$rating = $_POST['rating'];
		}

		//add the provided comment
		$set = '';
		$saveData['business_id'] = $_POST['business_id'];
		$saveData['user_id'] = $this->Session->read('Auth.User.User.id');
		$saveData['feedback'] = $_POST['feedback'];

		//fetchmembershipPlan start
		$membershipPlan = $this->Fp->fetchBusinessMembershipPlan($_POST['business_id']);
		if($membershipPlan > 1)
			$saveData['status'] = '1';
		else
			$saveData['status'] = '2'; //have to be approved by admin
		//fetchmembershipPlan end

		if($rating != '')
			$saveData['rating'] = $_POST['rating'];

		if($this->BusinessFeedback->save($saveData)){
			$set = $saveData;
		}
		$this->set('set', $set);
		$this->set('rating', $rating);
	}
	//FUNCTION FOR ADDING THE FEEDBACK END

	//FUNCTION FOR POSTING THE ENQUIRY START
	function post_enquiry(){ //pr($_POST);die;
		Controller::loadModel('BusinessEnquiry');
		
		$saveData['business_id'] = $_POST['business_id'];
		$saveData['user_id'] = $this->Session->read('Auth.User.User.id');
		$saveData['subject'] = $_POST['subject'];
		$saveData['message'] = $_POST['message'];
		$saveData['phone'] = $_POST['phone'];

		if($this->BusinessEnquiry->save($saveData))
			echo '1';
		else
			echo '0';
		exit;
	}
	//FUNCTION FOR POSTING THE ENQUIRY END
	/*---------------------------- FRONT SECTION END --------------------------------------*/

}
