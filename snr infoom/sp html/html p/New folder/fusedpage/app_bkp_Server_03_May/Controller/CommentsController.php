<?php
App::uses('AppController', 'Controller');
/**
 * Businesses Controller
 *
 * @property Business $Business
 */
class CommentsController extends AppController {
	public $name = 'Comments';	
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
	public function admin_manage($id){
		$this->paginate = array('conditions'=>array('Comment.feed_id'=>$id), 'limit'=>PAGING_SIZE, 'order'=>array('Comment.id'=>'DESC'));
		$this->set('viewListing', $this->paginate('Comment'));
	}

	public function admin_status_update($id, $newStatus, $feed_id){
		if($id != ''){
			$pageCount = $this->Comment->find('count', array('conditions'=>array('Comment.id'=>$id)));
			if($pageCount > 0){
				$saveData['id'] = $id;
				$saveData['status'] = $newStatus;
				if($newStatus == '1')
					$message = 'Approved';
				else
					$message = 'Disapproved';
				if($this->Comment->save($saveData, false))
					$this->Session->setFlash(__('Comment '.$message.' Successfully!!', true), 'message', array('class'=>'message-green'));
				else
					$this->Session->setFlash(__('No Associated Page Found!!', true), 'message', array('class'=>'message-red'));
			}else
				$this->Session->setFlash(__('No Associated Page Found!!', true), 'message', array('class'=>'message-red'));
		}else
			$this->Session->setFlash(__('No Associated Page Found!!', true), 'message', array('class'=>'message-red'));
		$this->redirect('/admin/comments/manage/'.$feed_id.'/');
		exit;
	}
	/*---------------------------- ADMIN SECTION END ----------------------------------------*/

	/*---------------------------- FRONT END SECTION START ----------------------------------------*/
	//FUNCTION FOR SAVE BUSINESS COMMENT START(SAURABH 5/9/2013)
	function saveComment(){
		$this->layout = 'ajax';
		$user_id = $_POST['user_id'];
		$feeds_id = $_POST['business_feeds_id'];
		$comment = $_POST['comment'];
		$membership_id = $_POST['membershipPlan'];

		$saveData['user_id'] = $user_id;
		$saveData['feed_id'] = $feeds_id;
		$saveData['comment'] = $comment;
		if($membership_id != 1){
			$saveData['status'] = 1;
		} else {
			$saveData['status'] = 2;
		}

		$this->Comment->save($saveData);

		$this->set('comment', $comment);

		$last_id = $this->Comment->id;
		$commentArr = $this->Comment->find('first', array('conditions'=>array('Comment.id'=>$last_id, 'Comment.status'=>'1')));
		$this->set('commentArr', $commentArr);
		if(!empty($commentArr)){
		$userr_id = $commentArr['Comment']['user_id'];
		$this->set('userr_id', $userr_id);
		}	
		$this->set('last_id', $last_id);
	}
	//FUNCTION FOR SAVE BUSINESS COMMENT END(SAURABH 5/9/2013)

	//FUNCTION FOR DELETE USER COMMENT START(SAURABH 5/9/2013)
	function delete_comment_data(){
		$this->layout = 'ajax';
		$comment_id = $_POST['comment_id'];

		if($this->Comment->delete($comment_id)){
			echo 'deleted';
		}
		exit;
	}
	//FUNCTION FOR DELETE USER COMMENT END(SAURABH 5/9/2013)
	/*---------------------------- FRONT END SECTION END ----------------------------------------*/



}
