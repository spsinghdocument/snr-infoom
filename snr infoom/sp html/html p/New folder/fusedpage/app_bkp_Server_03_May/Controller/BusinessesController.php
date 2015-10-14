<?php
App::uses('AppController', 'Controller');
/**
 * Businesses Controller
 *
 * @property Business $Business
 */
class BusinessesController extends AppController {
	public $name = 'Businesses';	
	public $helpers = array('Html', 'Form', 'Session', 'Text', 'Image');
	public $components = array('Session', 'Email', 'Auth', 'Location', 'Fp');

	public $wallUrl = '/users/dashboard/';

	//BEFORE FILTER STARTS
	function beforeFilter(){
		parent::beforeFilter();
		if(!empty($this->Auth))
			$this->Auth->allowedActions = array('fetch_business_listing_data', 'membership_plans', 'fetchLastLongs','main_header_search', 'category_search', 'details', 'fetch_all_category', 'fetch_popular_category', 'fetch_all_city', 'fetch_popular_city');
	}
	//BEFORE FILTER ENDS

	/*---------------------------- ADMIN SECTION START ----------------------------------------*/
	//FUNCTION TO ADD THE BUSINESS START
	public function admin_add(){
		if(!empty($this->request->data)){ //pr($this->request->data);die;
			$allowed_types = unserialize(ALLOWED_IMAGE_TYPES);
			$continue = 'true';
			$logoName = '';

			//upload the image
			if($this->request->data['Business']['image']['name'] != ''){
				if(in_array($this->request->data['Business']['image']['type'], $allowed_types)){
					$fileName = $this->Fp->uploadFile('../webroot/img/front_end/business/', $this->request->data['Business']['image']);
					if($fileName != '')
						$this->request->data['Business']['image'] = $fileName;
				}else{
					$this->Session->setFlash(__('Please Upload only *.gif, *.jpg, *.png image only!', true), 'message', array('class'=>'message-red'));
					$continue = 'false';
				}
			}else
				$this->request->data['Business']['image'] = '';

			//upload the other data
			if($continue == 'true'){
				$this->request->data['Business']['alias_name'] = $this->Fp->parseParameterNew($this->request->data['Business']['title']);
				if($this->Business->save($this->request->data)){
					$this->Session->setFlash(__('Business Added Successfully!!', true), 'message', array('class'=>'message-green'));
					$this->redirect('/admin/businesses/manage/');
				}else
					$this->Session->setFlash(__('Please Correct Following Errors!!', true), 'message', array('class'=>'message-red'));
			}

		}
	}
	//FUNCTION TO ADD THE BUSINESS END

	//FUNCTION TO MANAGE THE BUSINESS START
	public function admin_manage(){
		$this->paginate = array('limit'=>PAGING_SIZE, 'order'=>array('Business.id'=>'DESC'));
		$this->set('viewListing', $this->paginate('Business'));
	}
	//FUNCTION TO MANAGE THE BUSINESS END

	//FUNCTION FOR MANAGING THE CATEGORIES START
	public function admin_status_update($id, $newStatus){
		if($id != ''){
			$pageCount = $this->Business->find('count', array('conditions'=>array('Business.id'=>$id)));
			if($pageCount > 0){
				$saveData['id'] = $id;
				$saveData['status'] = $newStatus;
				if($newStatus == '1')
					$message = 'Activated';
				else
					$message = 'Deactivated';
				if($this->Business->save($saveData, false))
					$this->Session->setFlash(__('Business '.$message.' Successfully!!', true), 'message', array('class'=>'message-green'));
				else
					$this->Session->setFlash(__('No Associated Page Found!!', true), 'message', array('class'=>'message-red'));
			}else
				$this->Session->setFlash(__('No Associated Page Found!!', true), 'message', array('class'=>'message-red'));
		}else
			$this->Session->setFlash(__('No Associated Page Found!!', true), 'message', array('class'=>'message-red'));
		$this->redirect('/admin/businesses/manage/');
		exit;
	}
	//FUNCTION FOR MANAGING THE CATEGORIES END

	//FUNCTION FOR ADMIN VIEW START
	public function admin_view($id){
		$this->layout = 'FancyBox/fancy_box_popup';
		$this->set('businessArr', $this->Business->findById($id));
	}
	//FUNCTION FOR ADMIN VIEW END

	//FUNCTION FOR EDITING A BUSINESS START
	public function admin_edit($id=null) {
		if(!empty($this->request->data)){ //pr($this->request->data);die;
			$allowed_types = unserialize(ALLOWED_IMAGE_TYPES);
			$continue = 'true';
			$logoName = '';

			//upload the new file
			if($this->request->data['Business']['image']['name'] != ''){
				if(in_array($this->request->data['Business']['image']['type'], $allowed_types)){
					$fileName = $this->Fp->uploadFile('../webroot/img/front_end/business/', $this->request->data['Business']['image']);
					if($fileName != ''){
						//delete the old file start
						if($this->request->data['Business']['old_image'] != ''){
							$realImagePath = '../webroot/img/front_end/business/'.$this->request->data['Business']['old_image'];
							if(is_file($realImagePath))
								unlink($realImagePath);
						}
						//delete the old file end
						$this->request->data['Business']['image'] = $fileName;
					}
				}else{
					$this->Session->setFlash(__('Please Upload only *.gif, *.jpg, *.png image only!', true), 'message', array('class'=>'message-red'));
					$continue = 'false';
				}
			}else
				$this->request->data['Business']['image'] = $this->request->data['Business']['old_image'];

			if($continue == 'true'){
				$this->request->data['Business']['alias_name'] = $this->Fp->parseParameterNew($this->request->data['Business']['title']);
				if($this->Business->save($this->request->data)){
					$this->Session->setFlash(__('Business Added Successfully!!', true), 'message', array('class'=>'message-green'));
					$this->redirect('/admin/businesses/manage/');
				}else
					$this->Session->setFlash(__('Please Correct Following Errors!!', true), 'message', array('class'=>'message-red'));
			}
		}


		if($id != ''){
			$businessArr = $this->Business->findById($id);
			if(!empty($businessArr))
				$this->data = $businessArr;
			else
				$this->redirect('/admin/businesses/manage/');
		}else
			$this->redirect('/admin/businesses/manage/');
	}
	//FUNCTION FOR EDITING A BUSINESS END

	//FUNCTION FOR DELETING A FUNCTION START
	public function admin_delete($id=null){
		if($id != ''){
			$this->Business->recursive = -1;
			$businessArr = $this->Business->findById($id);
			if(!empty($businessArr)){
				//delete the image
				if($businessArr['Business']['image'] != ''){
					$imageRealPath = '../webroot/img/front_end/business/'.$businessArr['Business']['image'];
					if(is_file($imageRealPath))
						unlink($imageRealPath);
				}

				//delete the record
				if($this->Business->delete($id))
					$this->Session->setFlash(__('Business Deleted Successfully!!', true), 'message', array('class'=>'message-green'));
				else
					$this->Session->setFlash(__('Please Try Later!!', true), 'message', array('class'=>'message-red'));
				$this->redirect('/admin/businesses/manage/');
			}else{
				$this->Session->setFlash(__('No Associated Business Found!!', true), 'message', array('class'=>'message-red'));
				$this->redirect('/admin/businesses/manage/');
			}
		}else{
			$this->Session->setFlash(__('No Associated Business Found!!', true), 'message', array('class'=>'message-red'));
			$this->redirect('/admin/businesses/manage/');
		}





		/*if($id != ''){
			if($this->Business->delete($id))
				$this->Session->setFlash(__('Business Deleted Successfully!!', true), 'message', array('class'=>'message-green'));
			else
				$this->Session->setFlash(__('Please Try Later!!', true), 'message', array('class'=>'message-red'));
			$this->redirect('/admin/businesses/manage/');
		}else{
			$this->Session->setFlash(__('No Associated Business Found!!', true), 'message', array('class'=>'message-red'));
			$this->redirect('/admin/businesses/manage/');
		} */
		exit;
	}
	//FUNCTION FOR DELETING A FUNCTION END
	/*---------------------------- ADMIN SECTION END ----------------------------------------*/

	/*---------------------------- FRONT END SECTION START ----------------------------------------*/

	//FUNCTION FOR AUTOSUGGATION DATE START(SAURABH 5/3/2013)
	function auto_data(){
		Controller::loadModel('User');
		$this->layout = 'ajax';
		$searchkey = trim($_POST['searchkey']);
		$return = '';
		$this->Business->recursive = -1;
		$searchArr = $this->Business->find('all', array('fields'=>array('Business.id', 'Business.title'), 'conditions'=>array('Business.status'=>'1', 'Business.title LIKE'=>"%".$searchkey."%"
			), 'order'=>array('Business.title'=>'ASC')));
		$this->set('searchArr', $searchArr);
		if(!empty($searchArr)){
			$return = $searchArr;
		}
		return $return;
	}
	//FUNCTION FOR AUTOSUGGATION DATA END(SAURABH 5/3/2013)

	//FUNCTION FOR AUTOSUGGATION DATE START(SAURABH 5/3/2013)
	function auto_city_data(){
		//Controller::loadModel('User');
		$this->layout = 'ajax';
		$citykey = trim($_POST['citykey']);
		$return = '';
		$this->Business->recursive = -1;
		$cityArr = $this->Business->find('all', array('fields'=>array('Business.id', 'Business.city'), 'conditions'=>array('Business.status'=>'1', 'Business.city LIKE'=>"%".$citykey."%"
			), 'order'=>array('Business.city'=>'ASC')));
		$this->set('cityArr', $cityArr);
		if(!empty($cityArr)){
			$return = $cityArr;
		}
		return $return;
	}
	//FUNCTION FOR AUTOSUGGATION DATA END(SAURABH 5/3/2013)

	//FUNCTION FOR AUTOSUGGATION DATE START(SAURABH 5/3/2013)
	function auto_business_data(){
		//Controller::loadModel('User');
		$this->layout = 'ajax';
		$businesskey = trim($_POST['businesskey']);
		$return = '';
		$this->Business->recursive = -1;
		$businessArr = $this->Business->find('all', array('fields'=>array('Business.id', 'Business.title'), 'conditions'=>array('Business.status'=>'1', 'Business.title LIKE'=>"%".$businesskey."%"
			), 'order'=>array('Business.title'=>'ASC')));
		$this->set('businessArr', $businessArr);
		if(!empty($businessArr)){
			$return = $businessArr;
		}
		return $return;
	}
	//FUNCTION FOR AUTOSUGGATION DATA END(SAURABH 5/3/2013)

	//FUNCTION FOR SEARCH BUSINESS START(SAURABh 5/17/2013)
	public function search(){
		if(!empty($this->request->data)){ 
			if(($this->request->data['Business']['keyword']!='')||($this->request->data['Business']['city']!='')){

		   $codition=array();
		   $keyword=$this->request->data['Business']['keyword'];
		   $city=$this->request->data['Business']['city'];
		  /* $cityname = $this->Business->find('first', array('conditions'=>array('Business.id'=>$city)));
				if(!empty($cityname)){
					$city_name = $cityname['Business']['city'];
				} else {
					$city_name = '';
				} */

		   $condition=array("Business.title LIKE"=>'%'.$keyword.'%', "Business.city LIKE"=>'%'.$city.'%');
				$cond = array();
				   foreach($condition as $key=>$value){
					if($value!=''){     
					 $cond[$key] = $value;     
					}
				   }
				   $conditions=array('AND'=>$cond);  //pr($conditions); die; 
				   $searchArr = $this->Business->find('all', array('conditions'=>array($conditions)));
					$this->set('searchArr', $searchArr);
				  }
				}	
			}
	//FUNCTION FOR SEARCH BUSINESS END(SAURABH 5/17/2013


	//FUNCTION FOR SEARCH BUSINESS START(SAURABh 5/17/2013)
	public function business_search(){ 
		$this->layout = 'ajax';
		if(!empty($_POST)){ 
			$searchkeyword = $_POST['searchkeyword'];

		   if($searchkeyword!=''){
		   $codition=array();
		   $keyword=$searchkeyword;
		  
		   $condition=array("Business.title LIKE"=>'%'.$keyword.'%');
				$cond = array();
				   foreach($condition as $key=>$value){
					if($value!=''){     
					 $cond[$key] = $value;     
					}
				   }
				   $conditions=array('AND'=>$cond);  //pr($conditions); die; 
				   $searchArr = $this->Business->find('all', array('conditions'=>array($conditions)));
					$this->set('searchArr', $searchArr);
				  }
				}	
			}
	//FUNCTION FOR SEARCH BUSINESS END(SAURABH 5/17/2013



	//FUNCTION FOR LISTING THE BUSINESS START
	public function listings(){
		$ret = '';
		$user_Id = $this->Session->read('Auth.User.User.id');
		$this->Business->unbindModel(array('belongsTo'=>array('User', 'Sub-Category')));

		$this->set('viewListing', $this->Business->find('all', array('conditions'=>array('OR'=>array('Business.user_id'=>'', 'Business.user_id <>'=>$user_Id),'Business.status'=>'1'), 'limit'=>PAGING_SIZE, 'order'=>array('Business.id'=>'DESC'))));		
	}
	//FUNCTION FOR LISTING THE BUSINESS END

	//FUNCTION FOR LISTING THE BUSINESS START
	public function business_listings(){
		$ret = '';
		$user_Id = $this->Session->read('Auth.User.User.id');
		$this->Business->unbindModel(array('belongsTo'=>array('User', 'Sub-Category')));

		$this->set('viewListing', $this->Business->find('all', array('conditions'=>array('OR'=>array('Business.user_id'=>'', 'Business.user_id <>'=>$user_Id),'Business.status'=>'1'), 'limit'=>PAGING_SIZE, 'order'=>array('Business.id'=>'DESC'))));		
	}
	//FUNCTION FOR LISTING THE BUSINESS END

	//FUNCTION FOR LISTING THE BUSINESS START
	public function my_business(){
		$ret = '';
		$user_Id = $this->Session->read('Auth.User.User.id');
		$this->Business->unbindModel(array('belongsTo'=>array('User', 'Sub-Category')));

		$this->set('viewListing', $this->Business->find('all', array('conditions'=>array('Business.status'=>'1', 'Business.user_id'=>$user_Id), 'limit'=>PAGING_SIZE, 'order'=>array('Business.id'=>'DESC'))));		
	}
	//FUNCTION FOR LISTING THE BUSINESS END

	//AJAX FUNCTION FOR FETCHING THE DATA FOR PAGINATION START
	public function fetch_business_listing_data(){ //pr($_POST);die;
		$this->layout = 'ajax';

		$this->Business->unbindModel(array('belongsTo'=>array('User', 'Sub-Category')));
		$this->set('viewListing', $this->Fp->set_scroll_pagination_data('Business', $_POST['last_viewed_page'], PAGING_SIZE, array('Business.status'=>'1'), array('Business.id'=>'DESC')));
	}
	//AJAX FUNCTION FOR FETCHING THE DATA FOR PAGINATION END

	//FUNCTION FOR BUSINESS DETAILS START
	public function details($id=null, $title=null){
	$this->layout = 'FrontEnd/Inner/default';
		if($id != '' && $title != ''){
			//INCREMENT THE COUNT OF THE BUSINESS STRAT
			$this->Fp->incrementField('Business', 'views', '+',$this->Fp->decrypt($id));
			//INCREMENT THE COUNT OF THE BUSINESS END

			//ADD THE VIEWING USER DETAILS IN THE TABLE START 6/1/2013
			if($this->Session->read('Auth.User.User.id') != ''){
				Controller::loadModel('BusinessView');
				$saveUserData['business_id'] = $this->Fp->decrypt($id);
				$saveUserData['user_id'] = $this->Session->read('Auth.User.User.id');
				$this->BusinessView->save($saveUserData);
			}
			//ADD THE VIEWING USER DETAILS IN THE TABLE END 6/1/2013

			$this->Business->unbindModel(array('hasMany'=>array('BusinessFeedback')));
			$businessArr = $this->Business->find('first', array('conditions'=>array('Business.id'=>$this->Fp->decrypt($id), 'Business.alias_name'=>$title, 'Business.status'=>'1'))); //pr($businessArr);die;
			if(!empty($businessArr))
				$this->set('businessArr', $businessArr);
			else
				$this->redirect('/businesses/listings/');
		}else
			$this->redirect('/businesses/listings/');
	}
	//FUNCTION FOR BUSINESS DETAILS END

	//FUNCTION FOR RATING THE BUSINESS START
	public function rate_business(){ //pr($_POST);die;
		Controller::loadModel('BusinessRating');
		$this->layout = 'ajax';

		$new_rating = (int)$_POST['rating'];
		$prev_rating = (int)$_POST['overall_rating'];

		if($prev_rating != 0){
			$newRating = ceil(($new_rating + $prev_rating)/2);
			if($newRating > 5)
				$newRating = 5;
		}else
			$newRating = $new_rating;

		//save the new rating value in business rating table
		$saveData['business_id'] = $_POST['business_id'];
		$saveData['user_id'] = $this->Session->read('Auth.User.User.id');
		$saveData['rating'] = $new_rating;
		if($this->BusinessRating->save($saveData, false)){
			// update the overall rating for business
			$saveBusinessData['id'] = $_POST['business_id'];
			$saveBusinessData['rating'] = $newRating;
			if($this->Business->save($saveBusinessData)){
				$this->set('new_rating', $new_rating);
			}else{
				echo '0';
				die;
			}
		}else{
			echo '0';
			die;
		}
	}
	//FUNCTION FOR RATING THE BUSINESS END

	//FUNCTION TO SET THE BUSINESS OVERALLL SETTING START
	public function set_overallrating(){ //pr($_POST);die;
		$this->layout = 'ajax';

		$this->Business->unbindModel(array('belongsTo'=>array('Category', 'Sub-Category', 'User'), 'hasMany'=>array('BusinessBanner', 'BusinessFeedback')));
		$businessArr = $this->Business->find('first', array('fields'=>array('Business.rating'), 'conditions'=>array('Business.id'=>$_POST['business_id'])));
		$this->set('new_rating', $businessArr['Business']['rating']);
	}
	//FUNCTION TO SET THE BUSINESS OVERALLL SETTING END

	//FUNCTION FOR CLAIMING THE BUSINESS START
	public function claim_business(){ //pr($_POST);die;
		$openBusinessCount = $this->Business->find('count', array('conditions'=>array('Business.id'=>$_POST['business_id'], 'Business.user_id'=>'')));
		if($openBusinessCount == 1){
			$saveData['id'] = $_POST['business_id'];
			$saveData['user_id'] = $this->Session->read('Auth.User.User.id');
			$saveData['status'] = '2'; //claimed but not approved by admin
			pr($saveData);die;
		}else{
			echo '<font color="red">Business Already Claimed!</font>';
			exit;
		}




	exit;
	}
	//FUNCTION FOR CLAIMING THE BUSINESS END

	//FUNCTION FOR UPGRADING THE BUSINESS START
	public function membership_plans($business_id){
		
		//validate the user/ business start
		if($this->Fp->validateBusinessMembership(base64_decode($business_id)) != '')
			$this->redirect('/');
		//validate the user/ business end

		Controller::loadModel('Membership');

		$membershipArr = $this->Membership->find('all', array('conditions'=>array('Membership.status'=>'1'), 'order'=>array('Membership.id'=>'ASC')));
		$this->set('membershipArr', $membershipArr); //pr($membershipArr);die;
	}
	//FUNCTION FOR CLAIMING THE BUSINES END

	//AJAX FUNCTION FOR POSTING THE ABOUT US CONTENT START
	public function post_about_us_content(){ //pr($_POST);die;
		$this->layout = 'ajax';

		$message = trim($_POST['aboutUsMessage']);
		$businessId = $_POST['business_id'];

		$this->Business->recursive = -1;
		$businessArr = $this->Business->findById($businessId);

		if($businessArr['Business']['user_id'] == $this->Session->read('Auth.User.User.id')){
			$saveData['Business']['id'] = $businessId;
			$saveData['Business']['about_us'] = $message;
			if($this->Business->save($saveData)){
				echo 'saved';
			}else
				echo '<font color="red">Please Try Later!!</font>';
		}else
			echo '<font color="red">Invalid Business!!</font>';
		exit;
	}
	//AJAX FUNCTION FOR POSTING THE ABOUT US CONTENT END

	/*********************************************************
	*  Function to add business
	*
	**********************************************************/
	public function add_business(){
		if(!empty($this->request->data)){ //pr($this->request->data);
			$allowed_types = unserialize(ALLOWED_IMAGE_TYPES);
			$banners = array();
			$banners = $this->request->data['Business']['banners'];
			$Banners = array();
			foreach($banners as $temp){
				if(!in_array($temp['type'],$allowed_types)){
					$this->Session->setFlash(__('Invalid images!!!, Please Upload valid images', true), 'message', array('class'=>'message-red'));
					$this->redirect('/businesses/add_business/');
				}
			}
			foreach($banners as $temp){
				$image = $this->Fp->uploadFile('../webroot/img/front_end/business/banners/', $temp);
				array_push($Banners,$image);				
			}
			$this->request->data['Business']['banner'] = $Banners[0];
			$this->request->data['Business']['user_id'] = $this->Session->read('Auth.User.User.id');
			$this->request->data['Business']['status'] = '1';
			$this->Business->save($this->request->data);
			$id= $this->Business->id;
			foreach($Banners as $tempImage){
			$this->Business->BusinessBanner->create();
				$Banner['BusinessBanner']['banner'] = $tempImage;
				$Banner['BusinessBanner']['status'] = 0;
				$Banner['BusinessBanner']['business_id'] = $id;				
 				$this->Business->BusinessBanner->save($Banner);
			}
			
			$this->Session->setFlash(__('Your business has been added successfully, will be displayed after being approved by administrator', true), 'message', array('class'=>'message-green'));
			$this->redirect(array('controller'=>'businesses','action'=>'listings'));
			
		}
		$category = $this->Business->Category->find('list');
		$this->set('categories',$category);
	}
	/*******************  Function to add business End ***************************/

	/*********************************************************
	*  Function to add business
	*
	**********************************************************/
	public function edit_business($id=null){
		if(!empty($this->request->data)){ //pr($this->request->data);

			//fetch the business mambership plan start
			$membershipPlan = $this->Fp->fetchBusinessMembershipPlan($this->request->data['Business']['id']);
			//fetch the business mambership plan end
			$banners = array();
			$banners = $this->request->data['Business']['banners'];
			$Banners = array();
			foreach($banners as $temp){

				$image = $this->Fp->uploadFile('../webroot/img/front_end/business/banners/', $temp);
				array_push($Banners,$image);				
			}
			$this->request->data['Business']['banner'] = $Banners[0];
			$this->request->data['Business']['user_id'] = $this->Session->read('Auth.User.User.id');

			//Conditions for membership plans start
			if($membershipPlan > 1){
				$this->request->data['Business']['status'] = '1';
				$msg = 'Business Updated Successfully!!';
			}else{
				$this->request->data['Business']['status'] = '2';
				$msg = 'Administrator would approve the content!!';
			}
			//Conditions for membership plans end

			$this->Business->save($this->request->data);
			$id= $this->Business->id;
			foreach($Banners as $tempImage){
			$this->Business->BusinessBanner->create();
				$Banner['BusinessBanner']['banner'] = $tempImage;
				$Banner['BusinessBanner']['status'] = '1';
				$Banner['BusinessBanner']['business_id'] = $id;				
 				$this->Business->BusinessBanner->save($Banner);
			}
			
			$this->Session->setFlash(__($msg, true), 'message', array('class'=>'message-green'));
			//$this->redirect(array('controller'=>'businesses','action'=>'listings'));
			$this->redirect(SITE_PATH);			
		}
		if($id!=null){
			$this->data=$this->Business->findById($id);
			
		}
		$category = $this->Business->Category->find('list');
		$this->set('categories',$category);
		
	}
	/*******************  Function to add business End ***************************/


	//Ajax function for fetching the lats & longs start
	function fetchLastLongs(){
		$googleURL='http://maps.google.com/maps/api/geocode/json?address=';
		$geocode=file_get_contents($googleURL.urlencode($_POST['address']).'&sensor=false');
		$output= json_decode($geocode);
		echo $output->results[0]->geometry->location->lat.', '.$output->results[0]->geometry->location->lng;
		exit;
	}
	//Ajax function for fetching the lats & longs end

	//FUNCTION FOR FETCH USER BUSINESS FILTRING DATA ON DASHBOARD START(SAURABH 5/8/2013)
	function fetch_user_business(){
		$this->layout = 'ajax';
		Controller::loadModel('BusinessSubscriber');
		Controller::loadModel('BusinessFeed');
		$user_id = $this->Session->read('Auth.User.User.id');

		//$friendsArr = $this->BusinessSubscriber->find('all', array('fields'=>array('BusinessSubscriber.business_id'), array('conditions'=>array('BusinessSubscriber.status'=>'1', 'BusinessSubscriber.user_id'=>$user_id))));

		$friendsArr = $this->BusinessSubscriber->find('all', array('conditions'=>array('BusinessSubscriber.user_id'=>$user_id)));
		
		if(!empty($friendsArr)){
		$business_id = '';
		foreach($friendsArr as $friendArr){
			$business_id[] = $friendArr['BusinessSubscriber']['business_id'];
		} 

		$feedsArr = $this->BusinessFeed->find('all', array('conditions'=>array('BusinessFeed.business_id'=>$business_id, 'BusinessFeed.status'=>'1'), 'limit'=>PAGING_SIZE, 'order'=>array('BusinessFeed.modified'=>'DESC')));
		$this->set('feedsArr', $feedsArr);
		}
	}
	//FUNCTION FOR FETCH USER BUSINESS FILTRING DATA ON DASHBOARD END(SAURABH 5/8/2013)


	//FUNCTION FOR FETCH BUSINESS BY SEARCH START (SAURABH 5/23/2013)
	function main_header_search(){
		$this->layout = 'ajax';
		$type = $_POST['type'];
		$keyword = $_POST['keyword'];
		$key = $_POST['key'];
		$loc = $_POST['loc'];

		if($type == 'location'){
			$businessArr = $this->Business->find('all', array('conditions'=>array('Business.city'=>$keyword, 'Business.status'=>'1')));
		}

		if($type == 'category'){
			$businessArr = $this->Business->find('all', array('conditions'=>array('Business.category_id'=>$keyword, 'Business.status'=>'1')));
		}

		if($type == 'normal'){
			if($key != ''){
				$businessArr = $this->Business->find('all', array('conditions'=>array('Business.title LIKE'=>'%'.$key.'%', 'Business.status'=>'1')));
			}
			if($loc != ''){
				$businessArr = $this->Business->find('all', array('conditions'=>array('Business.city LIKE'=>'%'.$loc.'%', 'Business.status'=>'1')));
			}
			if($key != '' && $loc != ''){
				$businessArr = $this->Business->find('all', array('conditions'=>array('Business.title LIKE'=>'%'.$key.'%', 'Business.city LIKE'=>'%'.$loc.'%', 'Business.status'=>'1')));
			}
		}
		$this->set('businessArr', $businessArr);
	}
	//FUNCTION FOR FETCH BUSINESS BY SEARCH END(SAURABh 5/23/2013)

	//FUNCTION FOR FETCH BUSINESS BY CATEGORY START(SAURABh 5/23/2013)
	function category_search(){
		$this->layout = 'ajax';
		$cat_id = $_POST['cat_id'];
		$businessArr = $this->Business->find('all', array('conditions'=>array('Business.category_id'=>$cat_id, 'Business.status'=>'1')));
		$this->set('businessArr', $businessArr);
	}
	//FUNCTION FOR FETCH BUSINESS BY CATEGORY END(SAURABH 5/23/2013)



	//FUNCTION FOR FETCH ALL CATEGORY FOR HEADER SEARCH START(SAURABH 5/31/2013)
	function fetch_all_category(){
		$this->layout = 'ajax';
		Controller::loadModel('Category');
		$categoryArr = $this->Category->find('all', array('conditions'=>array('Category.parent_id'=>'0', 'Category.status'=>'1')));
		$this->set('categoryArr', $categoryArr);
	}
	//FUNCTION FOR FETCH ALL CATEGORY FOR HEADER SEARCH END (SAURABH 5/31/2013)

	//FUNCTION FOR FETCH ALL CATEGORY FOR HEADER SEARCH START(SAURABH 5/31/2013)
	function fetch_popular_category(){
		$this->layout = 'ajax';
		Controller::loadModel('Business');
		Controller::loadModel('Category');
		$query = "select count(category_id) as category, category_id from fp_businesses group by category_id order by category DESC";
		$busicategoryArr = $this->Business->query($query);
		foreach($busicategoryArr as $category){
			$cat_id[] = $category['fp_businesses']['category_id'];
		}
		$categoryArr = $this->Category->find('all', array('conditions'=>array('Category.id'=>$cat_id, 'Category.parent_id'=>'0', 'Category.status'=>'1')));
		$this->set('categoryArr', $categoryArr);
	}
	//FUNCTION FOR FETCH ALL CATEGORY FOR HEADER SEARCH END (SAURABH 5/31/2013)


	//FUNCTION FOR FETCH ALL CITY FOR HEADER SEARCH START(SAURABH 5/31/2013)
	function fetch_all_city(){
		$this->layout = 'ajax';
		Controller::loadModel('Business');
		$locationArr = $this->Business->find('all', array('fields'=>array('Business.id', 'Business.city'), 'conditions'=>array('Business.status'=>'1')));
		$this->set('locationArr', $locationArr);
	}
	//FUNCTION FOR FETCH ALL CITY FOR HEADER SEARCH END (SAURABH 5/31/2013)

	//FUNCTION FOR FETCH ALL POPULAR CITY FOR HEADER SEARCH START(SAURABH 5/31/2013)
	function fetch_popular_city(){
		$this->layout = 'ajax';
		Controller::loadModel('Business');
		$query = "select count(city) as cityCount, city from fp_businesses group by city order by cityCount DESC";
		$locationArr = $this->Business->query($query);
		/*$locationArr = $this->Business->find('count', array('fields'=>array('Business.cityCount', 'Business.city'), 'conditions'=>array('Business.status'=>'1'), 'group'=>'Business.city', 'order'=>array('Business.cityCount'=>'DESC')));*/
		$this->set('locationArr', $locationArr);
	}
	//FUNCTION FOR FETCH ALL CATEGORY FOR HEADER SEARCH END (SAURABH 5/31/2013)
	
	
	/*---------------------------- FRONT END SECTION END ----------------------------------------*/



	/*------------------------ BUSINESS SUPPORT SECTION START ------------------------*/
	public function post_business_enquiry(){ //pr($_POST);die;
		$this->layout = 'ajax';

		Controller::loadModel('SupportEmail');
		$saveData['user_id'] = $this->Session->read('Auth.User.User.id');
		$saveData['business_id'] = $_POST['business_id'];
		$saveData['membership_id'] = $_POST['business_plan'];
		$saveData['enquiry'] = $_POST['enquiry'];
		$saveData['status'] = '1';
		if($this->SupportEmail->save($saveData))
			echo '<font color="green">Enquiry Posted Successfully!!</font>';
		else
			echo '<font color="red">Please Try Later!!</font>';
		exit;
	}


	/*--------------- ADMIN SECTION START --------------*/
	//FUNCTION FOR MANAGING THE SUPPORT CONTACT START
	public function admin_contact_manage() {
		Controller::loadModel('SupportContact');

		if(!empty($this->request->data)){ //pr($this->request->data);die;
			if($this->SupportContact->save($this->request->data)){
				$this->Session->setFlash(__('Support Contact updated Successfully!!', true), 'message', array('class'=>'message-green'));
				$this->redirect('/admin/businesses/contact_manage/');
			}else
				$this->Session->setFlash(__('Please Try Later!!', true), 'message', array('class'=>'message-green'));
		}

		//fetch the contact detail
		$this->data = $this->SupportContact->findById('1');
	}
	//FUNCTION FOR MANAGING THE SUPPORT CONTACT END

	//FUNCTION FOR LISTING ALL SUPPORT EMAILS START
	public function admin_support_emails(){
		Controller::loadModel('SupportEmail');

		$this->SupportEmail->unbindModel(array('belongsTo'=>array('Membership')));
		$this->paginate = array('limit'=>PAGING_SIZE, 'order'=>array('SupportEmail.id'=>'DESC'));
		$this->set('viewListing', $this->paginate('SupportEmail'));
	}
	//FUNCTION FOR LISTING ALL SUPPORT EMAILS END

	//FUNCTION FOR VIEWING THE SUPPORT ENQUIRY START
	public function admin_view_support_enquiry($id){
		Controller::loadModel('SupportEmail');

		$saveData['id'] = $id;
		$saveData['view'] = '1';
		$this->SupportEmail->save($saveData);

		$this->layout = 'FancyBox/fancy_box_popup';
		$this->set('businessArr', $this->SupportEmail->findById($id));
	}
	//FUNCTION FOR VIEWING THE SUPPORT ENQUIRY END

	//FUNCTION FOR DELETING THE ENQUIRY START
	public function admin_delete_support_enquiry($id){
		Controller::loadModel('SupportEmail');

		$businessArr = $this->SupportEmail->findById($id);
		if(!empty($businessArr)){
			//delete the record
			if($this->SupportEmail->delete($id))
				$this->Session->setFlash(__('Enquiry Deleted Successfully!!', true), 'message', array('class'=>'message-green'));
			else
				$this->Session->setFlash(__('Please Try Later!!', true), 'message', array('class'=>'message-red'));
			$this->redirect('/admin/businesses/support_emails/');
		}else{
			$this->Session->setFlash(__('No Associated Business Found!!', true), 'message', array('class'=>'message-red'));
			$this->redirect('/admin/businesses/support_emails/');
		}
	}
	//FUNCTION FOR DELETING THE ENQUIRY END
	/*--------------- ADMIN SECTION END --------------*/

	//FUNCTION FOR VIEWING ALL THE USERS WHO VIEWED THE BUSINESS START
	public function viewed_business($id){
		$this->layout = 'FancyBox/fancy_box_popup';
		Controller::loadModel('BusinessView');
		
		$this->BusinessView->unbindModel(array('belongsTo'=>array('Business')));
		$viewArr = $this->BusinessView->find('all', array('conditions'=>array('BusinessView.business_id'=>$id), 'limit'=>PAGING_SIZE, 'order'=>array('BusinessView.id'=>'DESC'), 'group'=>'BusinessView.user_id')); //pr($viewArr);die;
		$this->set('viewArr', $viewArr);
	}
	//FUNCTION FOR VIEWING ALL THE USERS WHO VIEWED THE BUSINESS END

	/*------------------------ BUSINESS SUPPORT SECTION END ------------------------*/



}

