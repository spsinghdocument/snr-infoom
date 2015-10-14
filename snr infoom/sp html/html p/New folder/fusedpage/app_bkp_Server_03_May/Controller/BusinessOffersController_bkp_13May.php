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
			$this->Auth->allowedActions = array('fetch_business_offers_listing_data');
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

		$saveData['business_id'] = $_POST['business_id'];
		$saveData['name'] = trim(ucwords($_POST['BusinessOfferName']));
		$saveData['title'] = trim($_POST['BusinessOfferTitle']);
		$saveData['description'] = trim($_POST['BusinessEnquiryDescription']);
		$saveData['price'] = trim($_POST['BusinessOfferPrice']);
		$saveData['image'] = $_POST['BusinessOfferImage'];
		$saveData['status'] = '1';

		if($this->BusinessOffer->save($saveData))
			echo '1';
		else
			echo '<font color="red">Please Try Later!!</font>';
		exit;		
	}
	//FUNCTION FOR ADDING A NEW OFFER END

	//FUNCTION TO FETCH THE BUSINESS OFFERS START
	public function fetch_business_offers(){ //pr($_POST);die;
		$this->layout = 'ajax';
		$business_id = $_POST['business_id'];

		$ret = '';
		$this->BusinessOffer->recursive = -1;
		$businessOfferArr = $this->BusinessOffer->find('all', array('conditions'=>array('BusinessOffer.business_id'=>$business_id, 'BusinessOffer.status'=>'1'), 'limit'=>PAGING_SIZE, 'order'=>array('BusinessOffer.id'=>'DESC')));
		if(!empty($businessOfferArr))
			$ret = $businessOfferArr; //pr($ret);die;
		$this->set('offersArr', $ret);
	}
	//FUNCTION TO FETCH THE BUSINESS OFFERS END

	//AJAX FUNCTION FOR FETCHING THE DATA FOR PAGINATION START
	public function fetch_business_offers_listing_data(){ //pr($_POST);die;
		$this->layout = 'ajax';

		$this->BusinessOffer->recursive = -1;
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
	
		//to fetch the data
		if($_POST['type'] == 'load'){
			$this->BusinessOffer->recursive = -1;
			$this->set('offerArr', $this->BusinessOffer->findById($_POST['id']));
		}

		//to save the data start
		if($_POST['type'] == 'save'){
			$saveData['id'] = $_POST['id'];
			$saveData['name'] = $_POST['name'];
			$saveData['title'] = $_POST['title'];
			$saveData['description'] = $_POST['description'];
			$saveData['price'] = $_POST['price'];

			//add the new image
			if($_POST['newImage'] != ''){
				$saveData['image'] = $_POST['newImage'];

				//delete the old image
				if($_POST['oldImage'] != ''){
					$realImagePath = '../webroot/img/front_end/business/offers/'.$_POST['oldImage'];
					if(is_file($realImagePath))
						unlink($realImagePath);
				}
			}

			if($this->BusinessOffer->save($saveData)){
				echo 'saved';
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

	/* ======================  OFFER CATEGORIES START ====================================== */
	//FUNCTION FOR ADDING A NEW CATEGORY START
	public function add_category(){ //pr($_POST); die;
		Controller::loadModel('OfferCategory');

		//validate the category, first
		$categoeyCount = $this->OfferCategory->find('count', array('conditions'=>array('OfferCategory.name'=>trim($_POST['category']))));
		if($categoeyCount == 0){
			$saveData['name'] = trim($_POST['category']);
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
