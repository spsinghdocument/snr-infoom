<?php
App::uses('AppController', 'Controller');
/**
 * BusinessSubscribers Controller
 *
 * @property BusinessSubscriber $BusinessSubscriber
 */
class GroupSubscribersController extends AppController {
	public $name = 'GroupSubscribers';	
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
	public function subscribe_group(){ //pr($_POST);die;
		$this->layout = 'ajax';

		Controller::loadModel('Group');

		$this->GroupSubscriber->recursive = -1;
		$subscribeArr = $this->GroupSubscriber->find('first', array('conditions'=>array('GroupSubscriber.group_id'=>$_POST['group_id'], 'GroupSubscriber.user_id'=>$this->Session->read('Auth.User.User.id'), 'GroupSubscriber.status'=>'1')));

		/*$this->Favorite->recursive = -1;
		$favoriteArr = $this->Favorite->find('first', array('conditions'=>array('Favorite.business_id'=>$_POST['business_id'], 'Favorite.user_id'=>$this->Session->read('Auth.User.User.id'), 'Favorite.status'=>'1')));*/


		if($_POST['type'] == 'subscribe'){ //subscribe business
			if(empty($subscribeArr)){
				$saveData['group_id'] = $_POST['group_id'];
				$saveData['user_id'] = $this->Session->read('Auth.User.User.id');
				$saveData['status'] = '1';
				if($this->GroupSubscriber->save($saveData)){
					$groupArr = $this->Group->find('first', array('conditions'=>array('Group.id'=>$_POST['group_id'])));
					$subscribeGroup = $groupArr['Group']['subscribe_users'];
					$saveGroupData['id'] = $_POST['group_id'];
					$saveGroupData['subscribe_users'] = $subscribeGroup+1;
					$this->Group->save($saveGroupData);

					$ret = 'subscribed';

					//add to favorite list as well
					/*if(empty($favoriteArr)){
						$saveFavData['user_id'] = $this->Session->read('Auth.User.User.id');
						$saveFavData['business_id'] = $_POST['business_id'];
						$saveFavData['status'] = '1';
						$this->Favorite->save($saveFavData);
					}*/
				}else
					$ret = 'Please Try Later!!';
			}else
				$ret = 'Group Already Subscribed!!';
		}else{ //unsubscribe business
			if(!empty($subscribeArr)){
				if($this->GroupSubscriber->delete($subscribeArr['GroupSubscriber']['id'])){
					$groupArr = $this->Group->find('first', array('conditions'=>array('Group.id'=>$_POST['group_id'])));
					$subscribeGroup = $groupArr['Group']['subscribe_users'];
					$saveGroupData['id'] = $_POST['group_id'];
					$saveGroupData['subscribe_users'] = $subscribeGroup-1;
					$this->Group->save($saveGroupData);

					$ret = 'unsubscribed';

					//remove from the favorite list
					/*if(!empty($favoriteArr)){
						$this->Favorite->delete($favoriteArr['Favorite']['id']);
					}*/
				}else
					$ret = 'Please Try Later!!';
			}else
				$ret = 'No Subscribed Group Found!!';
		}
		
		

		$this->set('ret', $ret);
		$this->set('post', $_POST);
	}
	//FUNCTION FOR SUBSCRIBE THE BUSINESS END
	/*---------------------------- FRONT SECTION END ----------------------------------------*/

}
