<?php
App::uses('AppController', 'Controller');
/**
 * BusinessSubscribers Controller
 *
 * @property BusinessSubscriber $BusinessSubscriber
 */
class BusinessSubscribersController extends AppController {
	public $name = 'BusinessSubscribers';	
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
	//FUNCTION FOR SUBSCRIBE THE BUSINESS START
	public function subscribe_business(){ //pr($_POST);die;
		$this->layout = 'ajax';

		Controller::loadModel('Favorite');

		$this->BusinessSubscriber->recursive = -1;
		$subscribeArr = $this->BusinessSubscriber->find('first', array('conditions'=>array('BusinessSubscriber.business_id'=>$_POST['business_id'], 'BusinessSubscriber.user_id'=>$this->Session->read('Auth.User.User.id'), 'BusinessSubscriber.status'=>'1')));

		$this->Favorite->recursive = -1;
		$favoriteArr = $this->Favorite->find('first', array('conditions'=>array('Favorite.business_id'=>$_POST['business_id'], 'Favorite.user_id'=>$this->Session->read('Auth.User.User.id'), 'Favorite.status'=>'1')));


		if($_POST['type'] == 'subscribe'){ //subscribe business
			if(empty($subscribeArr)){
				$saveData['business_id'] = $_POST['business_id'];
				$saveData['user_id'] = $this->Session->read('Auth.User.User.id');
				$saveData['status'] = '1';
				if($this->BusinessSubscriber->save($saveData)){
					$ret = 'subscribed';

					//add to favorite list as well
					if(empty($favoriteArr)){
						$saveFavData['user_id'] = $this->Session->read('Auth.User.User.id');
						$saveFavData['business_id'] = $_POST['business_id'];
						$saveFavData['status'] = '1';
						$this->Favorite->save($saveFavData);
					}
				}else
					$ret = 'Please Try Later!!';
			}else
				$ret = 'Business Already Subscribed!!';
		}else{ //unsubscribe business
			if(!empty($subscribeArr)){
				if($this->BusinessSubscriber->delete($subscribeArr['BusinessSubscriber']['id'])){
					$ret = 'unsubscribed';

					//remove from the favorite list
					if(!empty($favoriteArr)){
						$this->Favorite->delete($favoriteArr['Favorite']['id']);
					}
				}else
					$ret = 'Please Try Later!!';
			}else
				$ret = 'No Subscribed Business Found!!';
		}
		
		

		$this->set('ret', $ret);
		$this->set('post', $_POST);
	}
	//FUNCTION FOR SUBSCRIBE THE BUSINESS END
	/*---------------------------- FRONT SECTION END ----------------------------------------*/

}
