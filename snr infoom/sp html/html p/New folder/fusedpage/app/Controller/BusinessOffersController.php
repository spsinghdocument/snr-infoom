<?php
App::uses('AppController', 'Controller');
/**
 * BusinessOffers Controller
 *
 * @property BusinessOffer $BusinessOffer
 */
class BusinessOffersController extends AppController {
	public $name = 'BusinessOffers';	
	public $helpers = array('Html', 'Form', 'Session', 'Text', 'Image');
	public $components = array('Session', 'Email', 'Auth', 'Location', 'Fp');

	public $wallUrl = '/users/dashboard/';

	//BEFORE FILTER STARTS
	function beforeFilter(){
		parent::beforeFilter();
		if(!empty($this->Auth))
			$this->Auth->allowedActions = array('fetch_business_offers_listing_data', 'fetch_business_offers');
	}
	//BEFORE FILTER ENDS

	/*---------------------------- FRONT SECTION START ----------------------------------------*/
	//FUNCTION FOR UPLOADING THE IMAGE START
	public function upload_image(){ //pr($_FILES);die;
		$this->layout = 'ajax';
		$ret = '';

		if($_FILES['image']['name'] != ''){
			$file_name = $this->Fp->uploadFile('../webroot/img/front_end/business/offers/', $_FILES['image']);
			if($file_name != '')
				$ret = $file_name;
		}
		echo $ret;
		exit;
	}
	//FUNCTION FOR UPLOADING THE IMAGE END


	//FUNCTION FOR ADDING A NEW OFFER START
	public function add_new_offer(){ //pr($_POST);die;
		$this->layout = 'ajax';
		Controller::loadModel('BusinessRecommend');
		Controller::loadModel('BusinessSubscriber');
		Controller::loadModel('User');
		Controller::loadModel('Admin');
		Controller::loadModel('Business');

		$saveData['business_id'] = $_POST['business_id'];
		$saveData['name'] = trim(ucwords($_POST['BusinessOfferName']));
		$saveData['title'] = trim($_POST['BusinessOfferTitle']);
		$saveData['description'] = trim($_POST['BusinessEnquiryDescription']);
		$saveData['price'] = trim($_POST['BusinessOfferPrice']);
		$saveData['image'] = $_POST['BusinessOfferImage'];
		$saveData['status'] = '1';
		if($this->BusinessOffer->save($saveData))
		{
			$busiRes_id[] = '';
			$busiSubs_id[] = '';

			$busiResArr = $this->BusinessRecommend->find('all', array('fields'=>array('BusinessRecommend.user_id'), 'conditions'=>array('BusinessRecommend.business_id'=>$_POST['business_id'])));

			$busiSubsArr = $this->BusinessSubscriber->find('all', array('fields'=>array('BusinessSubscriber.user_id'), 'conditions'=>array('BusinessSubscriber.business_id'=>$_POST['business_id'])));

			if(!empty($busiResArr)){
				foreach($busiResArr as $busiRes){
					$busiRes_id[] = $busiRes['BusinessRecommend']['user_id'];
				}
			}

			if(!empty($busiSubsArr)){
				foreach($busiSubsArr as $busiSubs){
					$busiSubs_id[] = $busiSubs['BusinessSubscriber']['user_id'];
				}
			}
			$user_id = array_merge($busiRes_id, $busiSubs_id);
			$email_user_id = array_unique($user_id);
			
			$useremail = $this->User->find('list', array('fields'=>array('User.email', 'User.email'), 'conditions'=>array('User.id'=>$email_user_id, 'User.status'=>'1')));
			foreach($useremail as $subscriber){ //echo $subscriber;die;
				$user_name = $this->User->find('first', array('fields'=>array('User.first_name', 'User.last_name'), 'conditions'=>array('User.email'=>$subscriber)));
				$business_name = $this->Business->find('first', array('fields'=>array('Business.title'), 'conditions'=>array('Business.id'=>$_POST['business_id'])));
					$this->set('businessname', $business_name['Business']['title']);
					$this->set('username', $user_name['User']['first_name'].' '.$user_name['User']['first_name']);
					$this->set('offer', $_POST['BusinessOfferTitle']);
					/* EMAIL FOR BUSINESS SUBSCRIBER AND RECOMMENDED START */
					$this->Email->to	   = $subscriber;
					//$this->Email->to	   = 'saurabh_kumar@seologistics.com';
					$this->Email->from	   = EMAIL_ADMIN_FROM;
					$this->Email->subject  = 'Business Offer Subscribers';
					$this->Email->template = 'front_end/business_offer_add';
					$this->Email->sendAs   = 'html'; 
					$this->Email->send();
					/* EMAIL FOR BUSINESS SUBSCRIBER AND RECOMMENDED END */
				}
				

				/* EMAIL FOR ADMIN START */
				$adminArr = $this->Admin->find('first', array('conditions'=>array('Admin.id'=>'1')));
				$business_name = $this->Business->find('first', array('fields'=>array('Business.title'), 'conditions'=>array('Business.id'=>$_POST['business_id'])));
				$this->set('businessname', $business_name['Business']['title']);
				$this->set('offer', $_POST['BusinessOfferTitle']);
				$this->set('username', $adminArr['Admin']['username']);
				//$this->Email->to	   = $adminArr['Admin']['email'];
				$this->Email->to	   = 'saurabh_kumar@seologistics.com';
				$this->Email->from	   = EMAIL_ADMIN_FROM;
				$this->Email->subject  = 'New Deal Added';
				$this->Email->template = 'admin/business_offer_add';
				$this->Email->sendAs   = 'html'; 
				$this->Email->send();
				/* EMAIL FOR ADMIN END */
			
			echo '1';
		}
		else
		{
			echo '<font color="red">Please Try Later!!</font>';
		}
		exit;		
	}
	//FUNCTION FOR ADDING A NEW OFFER END

	//FUNCTION TO FETCH THE BUSINESS OFFERS START
	public function fetch_business_offers(){ //pr($_POST);die;
		$this->layout = 'ajax';
		$business_id = $_POST['business_id'];

		$ret = '';
		//$this->BusinessOffer->recursive = -1;
		$this->BusinessOffer->unbindModel(array('belongsTo'=>array('User', 'Business')));
		$businessOfferArr = $this->BusinessOffer->find('all', array('conditions'=>array('BusinessOffer.business_id'=>$business_id, 'BusinessOffer.status'=>'1'), 'limit'=>PAGING_SIZE, 'order'=>array('BusinessOffer.id'=>'DESC')));
		if(!empty($businessOfferArr))
			$ret = $businessOfferArr; //pr($ret);die;
		$this->set('offersArr', $ret);
	}
	//FUNCTION TO FETCH THE BUSINESS OFFERS END

	//AJAX FUNCTION FOR FETCHING THE DATA FOR PAGINATION START
	public function fetch_business_offers_listing_data(){ //pr($_POST);die;
		$this->layout = 'ajax';

		//$this->BusinessOffer->recursive = -1;
		/*$offersArr = $this->Fp->set_scroll_pagination_data('BusinessOffer', $_POST['last_viewed_page'], PAGING_SIZE, array('BusinessOffer.business_id'=>$_POST['business_id'], 'BusinessOffer.status'=>'1'), array('Business.id'=>'DESC')); */

		$limitArr = ($_POST['last_viewed_page'] * PAGING_SIZE).','.PAGING_SIZE;
		$offersArr = $this->BusinessOffer->find('all', array('conditions'=>array('BusinessOffer.business_id'=>$_POST['business_id'], 'BusinessOffer.status'=>'1'), 'limit'=>$limitArr, 'order'=>array('BusinessOffer.id'=>'DESC')));
		/*if(!empty($offersArr))
			pr($offersArr);
		else
			echo 'test';die; */

		$this->set('offersArr', $offersArr);
	}
	//AJAX FUNCTION FOR FETCHING THE DATA FOR PAGINATION END

	//AJAX FUNCTION FOR EDITING THE OFFER START
	public function edit_business_offer(){ //pr($_POST);die;
		$this->layout = 'ajax';
		Controller::loadModel('BusinessRecommend');
		Controller::loadModel('BusinessSubscriber');
		Controller::loadModel('User');
		Controller::loadModel('Business');
	
		//to fetch the data
		if($_POST['type'] == 'load'){
			$this->BusinessOffer->recursive = -1;
			$this->set('offerArr', $this->BusinessOffer->findById($_POST['id']));
		}

		//to save the data start
		if($_POST['type'] == 'save'){ //pr($_POST);die;
			$saveData['id'] = $_POST['id'];
			$saveData['name'] = $_POST['name'];
			$saveData['title'] = $_POST['title'];
			$saveData['description'] = $_POST['description'];
			$saveData['price'] = $_POST['price'];

			//add the new image
			if($_POST['newImage'] != ''){
				$saveData['image'] = $_POST['newImage'];

				//delete the old image
				/* if($_POST['oldImage'] != ''){
					$realImagePath = '../webroot/img/front_end/business/offers/'.$_POST['oldImage'];
					if(is_file($realImagePath))
						unlink($realImagePath);
				} */
			}

			if($this->BusinessOffer->save($saveData)){
				echo 'saved';
				$busiRes_id[] = '';
				$busiSubs_id[] = '';
			$businessArr = $this->BusinessOffer->find('first', array('conditions'=>array('BusinessOffer.id'=>$_POST['id'])));
			$business_id = $businessArr['BusinessOffer']['business_id'];

			$busiResArr = $this->BusinessRecommend->find('all', array('fields'=>array('BusinessRecommend.user_id'), 'conditions'=>array('BusinessRecommend.business_id'=>$business_id)));

			$busiSubsArr = $this->BusinessSubscriber->find('all', array('fields'=>array('BusinessSubscriber.user_id'), 'conditions'=>array('BusinessSubscriber.business_id'=>$business_id)));

			if(!empty($busiResArr)){
				foreach($busiResArr as $busiRes){
					$busiRes_id[] = $busiRes['BusinessRecommend']['user_id'];
				}
			}

			if(!empty($busiSubsArr)){
				foreach($busiSubsArr as $busiSubs){
					$busiSubs_id[] = $busiSubs['BusinessSubscriber']['user_id'];
				}
			}
			$user_id = array_merge($busiRes_id, $busiSubs_id);
			$email_user_id = array_unique($user_id);
			
			$useremail = $this->User->find('list', array('fields'=>array('User.email', 'User.email'), 'conditions'=>array('User.id'=>$email_user_id, 'User.status'=>'1')));
			foreach($useremail as $subscriber){ //echo $subscriber;die;
				$user_name = $this->User->find('first', array('fields'=>array('User.first_name', 'User.last_name'), 'conditions'=>array('User.email'=>$subscriber)));
				$business_name = $this->Business->find('first', array('fields'=>array('Business.title'), 'conditions'=>array('Business.id'=>$business_id)));
				
					$this->set('businessname', $business_name['Business']['title']);
					$this->set('username', $user_name['User']['first_name'].' '.$user_name['User']['first_name']);
					$this->set('offer', $_POST['title']);
					/* EMAIL FOR BUSINESS SUBSCRIBER AND RECOMMENDED START */
					//$this->Email->to	   = $subscriber;
					$this->Email->to	   = 'saurabh_kumar@seologistics.com';
					$this->Email->from	   = EMAIL_ADMIN_FROM;
					$this->Email->subject  = 'Business Offer Subscribers';
					$this->Email->template = 'front_end/business_offer';
					$this->Email->sendAs   = 'html'; 
					$this->Email->send();
					/* EMAIL FOR BUSINESS SUBSCRIBER AND RECOMMENDED END */
				}
				/* EMAIL FOR ADMIN START */
				$adminArr = $this->Admin->find('first', array('conditions'=>array('Admin.id'=>'1')));
				$business_name = $this->Business->find('first', array('fields'=>array('Business.title'), 'conditions'=>array('Business.id'=>$business_id)));
				$this->set('businessname', $business_name['Business']['title']);
				$this->set('offer', $_POST['title']);
				$this->set('username', $adminArr['Admin']['username']);
				//$this->Email->to	   = $adminArr['Admin']['email'];
				$this->Email->to	   = 'saurabh_kumar@seologistics.com';
				$this->Email->from	   = EMAIL_ADMIN_FROM;
				$this->Email->subject  = 'New Deal Added';
				$this->Email->template = 'admin/business_offer_edit';
				$this->Email->sendAs   = 'html'; 
				$this->Email->send();
				/* EMAIL FOR ADMIN END */
				die;
			}else{
				echo '<font color="red">Error!! Please Try Later!</font>';
			}
		}
	}
	//AJAX FUNCTION FOR EDITING THE OFFER END

	//AJAX FUNCTION FOR DELETING THE OFFER START
	public function delete_offer(){ //pr($_POST);die;
		$this->layout = 'ajax';

		$this->BusinessOffer->recursive = -1;
		$offerArr = $this->BusinessOffer->findById($_POST['id']);
		if(!empty($offerArr)){
			//delete the image
			if($offerArr['BusinessOffer']['image'] != ''){
				$imagePath = '../webroot/img/front_end/business/offers/'.$offerArr['BusinessOffer']['image'];
				if(is_file($imagePath))
					unlink($imagePath);
			}

			//delete the record
			if($this->BusinessOffer->delete($_POST['id']))
				echo 'deleted';
			else
				echo '';
		}else
			echo '';
		exit;
	}
	//AJAX FUNCTION FOR DELETING THE OFFER END


	/***** FOR COMMENT AND RECOMMENDED START *****/
	//FUNCTION FOR SAVE OFFER COMMENTS START(SAURABH 5/13/2013)
	function saveComment(){
		Controller::loadModel('OfferComment');
		$this->layout = 'ajax';
		$user_id = $_POST['user_id'];
		$offer_id = $_POST['offer_id'];
		$comment = $_POST['comment'];

		$saveData['user_id'] = $user_id;
		$saveData['offer_id'] = $offer_id;
		$saveData['comment'] = $comment;
		$saveData['status'] = '1';
		$this->OfferComment->save($saveData);

		$this->set('comment', $comment);

		$last_id = $this->OfferComment->id;
		$commentArr = $this->OfferComment->find('first', array('OfferComment.id'=>$last_id));
		$this->set('commentArr', $commentArr);
		$userr_id = $commentArr['OfferComment']['user_id'];
		$this->set('userr_id', $userr_id);
		$this->set('last_id', $last_id);
	}
	//FUNCTION FOR SAVE OFFER COMMENTS END(SAURABH 5/13/2013)

	//FUNCTION FOR DELETE OFFER COMMENT START(SAURABH 5/9/2013)
	function delete_offer_comment(){
		Controller::loadModel('OfferComment'); 
		$this->layout = 'ajax';
		$comment_id = $_POST['comment_id'];

		if($this->OfferComment->delete($comment_id)){
			echo 'deleted';
		}
		exit;
	}
	//FUNCTION FOR DELETE OFFER COMMENT END(SAURABH 5/9/2013)


	//FUNCTION FOR ADD RECOMMENDE FOR START(SAURABH 5/10/2013)
	function add_recommended(){
		Controller::loadModel('OfferRecommended');
		$this->layout = 'ajax';
		$saveData['offer_id'] = $_POST['offer_id'];
		$saveData['user_id'] = $_POST['user_id'];
		$saveData['status'] = '1';

		$this->OfferRecommended->save($saveData);

		$last_id = $this->OfferRecommended->id;
		$recArr = $this->OfferRecommended->find('first', array('conditions'=>array('OfferRecommended.id'=>$last_id)));
		$offer_id = $recArr['OfferRecommended']['offer_id'];
			
		$CountRecommended = $this->OfferRecommended->find('count', array('conditions'=>array('OfferRecommended.offer_id'=>$offer_id, 'OfferRecommended.status'=>'1')));
		//$this->set('CountRecommended', $CountRecommended);
		echo $CountRecommended.' person has recommended';
		exit;
	}
	//FUNCTION FOR ADD RECOMMENDED FOR OFFER END (SAURABH 5/10/2013)

	//FUNCTION FOR FETCH USER IMAGE FOR OFFER START(SAURABh 5/10/2013)
	function fetch_user_image(){
		Controller::loadModel('OfferRecommended');
		$this->layout = 'ajax';
		$deal_id = $_POST['offer_id'];
		$user_id = $_POST['user_id'];

		$userImage = $this->OfferRecommended->find('first', array('conditions'=>array('OfferRecommended.offer_id'=>$deal_id, 'OfferRecommended.user_id'=>$user_id)));
		$this->set('userImage', $userImage);
	}
	//FUNCTION FOR FETCH USER IMAGE FOR OFFER START(SAURABh 5/10/2013)
	/***** FOR COMMENT AND RECOMMENDED END *****/

	/* ======================  OFFER CATEGORIES START ====================================== */
	//FUNCTION FOR ADDING A NEW CATEGORY START
	public function add_category(){ //pr($_POST); die;
		Controller::loadModel('OfferCategory');

		//validate the category, first
		$categoeyCount = $this->OfferCategory->find('count', array('conditions'=>array('OfferCategory.name'=>trim($_POST['category']), 'OfferCategory.user_id'=>$this->Session->read('Auth.User.User.id'))));
		if($categoeyCount == 0){
			$saveData['name'] = ucwords(trim($_POST['category']));
			$saveData['user_id'] = $this->Session->read('Auth.User.User.id');
			$saveData['status'] = '1';
			if($this->OfferCategory->save($saveData))
				$msg = 'saved';
			else
				$msg = '<font color="red">Please Try Later!!</font>';
		}else
			$msg = '<font color="red">This Category Already Present!!</font>';
		echo $msg;
		exit;
	}
	//FUNCTION FOR ADDING A NEW CATEGORY END

	//FUNCTION FOR SETTING THE OVERALL RATING OF AN OFFER START
	public function set_total_rating(){ //pr($_POST);die;
		Controller::loadModel('OffersDealsRating');
		Controller::loadModel('BusinessOffer');
		$this->layout = false;
		$this->render = false;

		$id = $_POST['id'];
		$new_rating = $_POST['rating'];

		$preRatingArr = $this->BusinessOffer->find('first', array('fields'=>array('BusinessOffer.rating'), 'conditions'=>array('BusinessOffer.id'=>$id)));
		$prev_rating = (float)$preRatingArr['BusinessOffer']['rating'];

		if($prev_rating != 0){
			$newRating = round((($new_rating + $prev_rating)/2), 1);
			if($newRating > 5){
				$newRating = 5;
			}
		}else{
			$newRating = $new_rating;
		}
		
		// update the overall rating for business
		$saveOfferRatingData['id'] = $id;
		$saveOfferRatingData['rating'] = $new_rating;
		$this->BusinessOffer->save($saveOfferRatingData, false);

		//save the new rating value in business rating table
		$saveRatingsData['offer_id'] = $id;
		$saveRatingsData['user_id'] = $this->Session->read('Auth.User.User.id');
		$saveRatingsData['rating'] = $_POST['rating'];
		$this->OffersDealsRating->save($saveRatingsData, false);
		exit;
	}
	//FUNCTION FOR SETTING THE OVERALL RATING OF AN OFFER END
	/* ======================  OFFER CATEGORIES END ======================================== */
	/*---------------------------- FRONT SECTION END ----------------------------------------*/


	/*---------------------------- ADMIN SECTION START ----------------------------------------*/
	//FUNCTION FOR LISTING THE BUSINESS OFFERS START
	public function admin_manage($business_id){// echo $business_id;
		controller::loadModel('Business');
		if($business_id != ''){
			$this->Business->recursive = -1;
			$businessCount = $this->Business->find('count', array('conditions'=>array('Business.id'=>$business_id)));
			if($businessCount > 0){ //echo 'test';die;
				$this->BusinessOffer->recursive = -1;
				$this->paginate = array('conditions'=>array('BusinessOffer.business_id'=>$business_id), 'limit'=>PAGING_SIZE, 'order'=>array('BusinessOffer.id'=>'DESC'));
				$this->set('viewListing', $this->paginate('BusinessOffer'));
			}else
				$this->redirect('/admin/businesses/manage/');
		}else
			$this->redirect('/admin/businesses/manage/');
	}
	//FUNCTION FOR LISTING THE BUSINESS OFFERS END

	//FUNCTION FOR MANAGING THE CATEGORIES START
	public function admin_status_update($business_id, $id, $newStatus){
		if($id != ''){
			$pageCount = $this->BusinessOffer->find('count', array('conditions'=>array('BusinessOffer.id'=>$id)));
			if($pageCount > 0){
				$saveData['id'] = $id;
				$saveData['status'] = $newStatus;
				if($newStatus == '1')
					$message = 'Activated';
				else
					$message = 'Deactivated';
				if($this->BusinessOffer->save($saveData, false))
					$this->Session->setFlash(__('Offer '.$message.' Successfully!!', true), 'message', array('class'=>'message-green'));
				else
					$this->Session->setFlash(__('No Associated Offer Found!!', true), 'message', array('class'=>'message-red'));
			}else
				$this->Session->setFlash(__('No Associated Offer Found!!', true), 'message', array('class'=>'message-red'));
		}else
			$this->Session->setFlash(__('No Associated Offer Found!!', true), 'message', array('class'=>'message-red'));
		$this->redirect('/admin/business_offers/manage/'.$business_id.'/');
		exit;
	}
	//FUNCTION FOR MANAGING THE CATEGORIES END

	//FUNCTION FOR DELETING THE OFFER START
	public function admin_delete($business_id, $delete_id){
		$this->BusinessOffer->recursive = -1;
		$offerArr = $this->BusinessOffer->findById($delete_id);
		if(!empty($offerArr)){
			//delete the image
			if($offerArr['BusinessOffer']['image'] != ''){
				$imageRealPath = '../webroot/img/front_end/business/offers/'.$offerArr['BusinessOffer']['image'];
				if(is_file($imageRealPath))
					unlink($imageRealPath);
			}

			//delete the record from table
			if($this->BusinessOffer->delete($offerArr['BusinessOffer']['id']))
				$this->Session->setFlash(__('Offer Deleted Successfully!!', true), 'message', array('class'=>'message-green'));
			else
				$this->Session->setFlash(__('Please Try Later!!', true), 'message', array('class'=>'message-red'));
			$this->redirect('/admin/business_offers/manage/'.$business_id.'/');
		}else
			$this->redirect('/admin/business_offers/manage/'.$business_id.'/');
		exit;
	}
	//FUNCTION FOR DELETING THE OFFER END

	//FUNCTION FOR VIEWING THE OFFER START
	public function admin_view($id){
		$this->layout = 'FancyBox/fancy_box_popup';
		$this->set('offerArr', $this->BusinessOffer->findById($id));
	}
	//FUNCTION FOR VIEWING THE OFFER END

	//FUNCTION FOR EDITING A OFFER START
	public function admin_edit($business_id, $offer_id){
		if(!empty($this->request->data)){ //pr($this->request->data);die;
			$allowed_types = unserialize(ALLOWED_IMAGE_TYPES);
			$continue = 'true';
			$logoName = '';

			//upload the image
			if($this->request->data['BusinessOffer']['image_1']['name'] != ''){
				if(in_array($this->request->data['BusinessOffer']['image_1']['type'], $allowed_types)){
					$fileName = $this->Fp->uploadFile('../webroot/img/front_end/business/offers/', $this->request->data['BusinessOffer']['image_1']);
					if($fileName != ''){
						//delete the old file start
						if($this->request->data['BusinessOffer']['old_image'] != ''){
							$realImagePath = '../webroot/img/front_end/business/offers/'.$this->request->data['BusinessOffer']['old_image'];
							if(is_file($realImagePath))
								unlink($realImagePath);
						}
						//delete the old file end
						$this->request->data['BusinessOffer']['image'] = $fileName;
					}
				}else{
					$this->Session->setFlash(__('Please Upload only *.gif, *.jpg, *.png image only!', true), 'message', array('class'=>'message-red'));
					$continue = 'false';
				}
			}
			

			//continue to save the data
			if($continue == 'true'){
				if($this->BusinessOffer->save($this->request->data))
					$this->Session->setFlash(__('Offer Updated Successfully!!', true), 'message', array('class'=>'message-green'));
				else
					$this->Session->setFlash(__('Please Try Later!!', true), 'message', array('class'=>'message-red'));
				$this->redirect('/admin/business_offers/manage/'.$this->request->data['BusinessOffer']['business_id'].'/');
			}
		}

		if(($business_id != '') && ($offer_id != '')){
			$this->BusinessOffer->recursive = -1;
			$this->data = $this->BusinessOffer->findById($offer_id);
		}else
			$this->redirect('/admin/business_offers/manage/'.$business_id.'/');
	}
	//FUNCTION FOR EDITING A OFFER END

	//FUNCTION FOR ADDING A NEW OFFER START
	public function admin_add($business_id){
		if(!empty($this->request->data)){ //pr($this->request->data);die;
			$allowed_types = unserialize(ALLOWED_IMAGE_TYPES);
			$continue = 'true';
			$logoName = '';

			//upload the image
			if($this->request->data['BusinessOffer']['image_1']['name'] != ''){
				if(in_array($this->request->data['BusinessOffer']['image_1']['type'], $allowed_types)){
					$fileName = $this->Fp->uploadFile('../webroot/img/front_end/business/offers/', $this->request->data['BusinessOffer']['image_1']);
					if($fileName != '')
						$this->request->data['BusinessOffer']['image'] = $fileName;
				}else{
					$this->Session->setFlash(__('Please Upload only *.gif, *.jpg, *.png image only!', true), 'message', array('class'=>'message-red'));
					$continue = 'false';
				}
			}
			

			//continue to save the data
			if($continue == 'true'){
				$this->request->data['BusinessOffer']['status'] = '1';
				if($this->BusinessOffer->save($this->request->data))
					$this->Session->setFlash(__('Offer Added Successfully!!', true), 'message', array('class'=>'message-green'));
				else
					$this->Session->setFlash(__('Please Try Later!!', true), 'message', array('class'=>'message-red'));
				$this->redirect('/admin/business_offers/manage/'.$this->request->data['BusinessOffer']['business_id'].'/');
			}
		}
	}
	//FUNCTION FOR ADDING A NEW OFFER END
	/*---------------------------- ADMIN SECTION END ----------------------------------------*/

}
