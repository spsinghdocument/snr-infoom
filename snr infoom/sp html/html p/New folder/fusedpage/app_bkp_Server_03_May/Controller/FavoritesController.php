<?php
App::uses('AppController', 'Controller');
/**
 * Businesses Controller
 *
 * @property Business $Business
 */
class FavoritesController extends AppController {
	public $name = 'Favorites';	
	public $helpers = array('Html', 'Form', 'Session', 'Text', 'Image');
	public $components = array('Session', 'Email', 'Auth', 'Location', 'Fp');

	public $wallUrl = '/users/dashboard/';

	//BEFORE FILTER STARTS
	function beforeFilter(){
		parent::beforeFilter();
		if(!empty($this->Auth))
			$this->Auth->allowedActions = array('add_to_favorite');
	}
	//BEFORE FILTER ENDS

	/*---------------------------- ADMIN SECTION START ----------------------------------------*/
	
	/*---------------------------- ADMIN SECTION END ----------------------------------------*/

	/*---------------------------- FRONT END SECTION START ----------------------------------------*/
	//FUNCTION FOR ADD TO FAVORITE START(SAURABH)
	function add_to_favorite(){
		$this->layout = 'ajax';
		$business_Id = $_POST['business_id'];
	    $user_Id = $this->Session->read('Auth.User.User.id');
		
		$return = '';
		$saveData['Favorite']['user_id'] = $user_Id;
		$saveData['Favorite']['business_id'] = $business_Id;
		$saveData['Favorite']['status'] = '1';

		$this->Favorite->save($saveData);
		echo $return ='<span style="color:green; font-weight:bold;">'."Add To Favorite Added Successfully!!".'</span>';
		exit;
	}
	//FUNCTION FOR ADD TO FAVORITE END(SAURABH)

	//FUNCTION FOR LIST ALL USER FAVORITES BUSINESS START(SAURABH 5/2/2013)
	function listings(){
		$ret = '';
		$user_Id = $this->Session->read('Auth.User.User.id');
		//$this->Business->unbindModel(array('belongsTo'=>array('User', 'Sub-Category')));

		$this->set('viewListing', $this->Favorite->find('all', array('conditions'=>array('Favorite.user_id'=>$user_Id), 'limit'=>PAGING_SIZE, 'order'=>array('Favorite.id'=>'DESC'))));
	}
	//FUNCTION FOR LIST ALL USER FAVORITES BUSINESS END(SAURABH 5/2/2013)
	
	/*******************  Function to add business End ***************************/

	//FUNCTION FOR DELETING FAVORITE BUSINESS START(SAURABH 5/3/2013)
	public function favorite_delete($id=null){
		if($id != ''){
			$this->Favorite->recursive = -1;
			$favoriteArr = $this->Favorite->findById($id);
			if(!empty($favoriteArr)){
				//delete the record
				if($this->Favorite->delete($id)){
					//remove from the subscriber list
					Controller::loadModel('BusinessSubscriber');
					$this->BusinessSubscriber->recursive = -1;
					$subsArr = $this->BusinessSubscriber->find('first', array('fields'=>array('BusinessSubscriber.id'), 'conditions'=>array('BusinessSubscriber.business_id'=>$favoriteArr['Favorite']['business_id'], 'BusinessSubscriber.user_id'=>$this->Session->read('Auth.User.User.id'), 'BusinessSubscriber.status'=>'1')));
					if(!empty($subsArr))
						$this->BusinessSubscriber->delete($subsArr['BusinessSubscriber']['id']);
					$this->Session->setFlash(__('Business Removed Successfully!!', true), 'message', array('class'=>'message-green'));
				}else
					$this->Session->setFlash(__('Please Try Later!!', true), 'message', array('class'=>'message-red'));
				$this->redirect('/favorites/listings/');
			}
		}
		exit;
	}
	//FUNCTION FOR DELETING A FAVORITE BUSINESS END(SAURABH 5/3/2013)
 
	
	/*---------------------------- FRONT END SECTION END ----------------------------------------*/



}
