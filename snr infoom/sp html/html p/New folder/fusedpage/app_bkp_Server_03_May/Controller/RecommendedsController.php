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
		$saveData['status'] = '1';

		$this->Recommended->save($saveData);

		$last_id = $this->Recommended->id;
		$recArr = $this->Recommended->find('first', array('conditions'=>array('Recommended.id'=>$last_id)));
		$feed_id = $recArr['Recommended']['feed_id'];
			
			$CountRecommended = $this->Recommended->find('count', array('conditions'=>array('Recommended.feed_id'=>$feed_id, 'Recommended.status'=>'1')));
			$this->set('CountRecommended', $CountRecommended);
	
		
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
	
	/*---------------------------- FRONT END SECTION END ----------------------------------------*/



}
