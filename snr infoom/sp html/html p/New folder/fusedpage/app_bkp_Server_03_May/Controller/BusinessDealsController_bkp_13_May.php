<?php
App::uses('AppController', 'Controller');
/**
 * BusinessDeals Controller
 *
 * @property BusinessDeal $BusinessDeal
 */
class BusinessDealsController extends AppController {
	public $name = 'BusinessDeals';	
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
	public function fetch_business_deals(){ //pr($_POST);die;
		$this->layout = 'ajax';

		$ret = '';
		$this->BusinessDeal->recursive = -1;
		/*$businessDealsArr = $this->BusinessDeal->find('all', array('conditions'=>array('BusinessDeal.business_id'=>$_POST['business_id'], 'BusinessDeal.status'=>'1'), 'limit'=>PAGING_SIZE, 'order'=>array('BusinessDeal.id'=>'DESC'))); */

		$businessDealsArr = $this->BusinessDeal->find('all', array('conditions'=>array('BusinessDeal.business_id'=>$_POST['business_id'], 'BusinessDeal.status'=>'1', 'OR'=>array('DATE(BusinessDeal.end_date) >='=>date('Y-m-d'), 'DATE(BusinessDeal.end_date)'=>'0000-00-00', 'BusinessDeal.end_date IS NULL')), 'limit'=>PAGING_SIZE, 'order'=>array('BusinessDeal.id'=>'DESC')));



		if(!empty($businessDealsArr))
			$ret = $businessDealsArr; //pr($ret);die;
		$this->set('dealsArr', $ret);
	}
	//FUNCTION FOR FETCHING THE DEALS FOR LISTING END

	//FUNCTION FOR FETCHING THE ADD DEALS FORM START
	public function fetch_add_deals_form(){ //pr($_POST); die;
		$this->layout = 'ajax';
	}
	//FUNCTION FOR FETCHING THE ADD DEALS FORM END

	//FUNCTION FOR UPLOADING THE IMAGE START
	public function upload_image(){ //pr($_FILES);die;
		$this->layout = 'ajax';
		$ret = '';

		if($_FILES['image']['name'] != ''){
			$file_name = $this->Fp->uploadFile('../webroot/img/front_end/business/deals/', $_FILES['image']);
			if($file_name != '')
				$ret = $file_name;
		}
		echo $ret;
		exit;
	}
	//FUNCTION FOR UPLOADING THE IMAGE END

	public function edit_image(){ //pr($_POST);die;
		$this->layout = 'ajax';

		$ret = '';
		//upload the new image
		if($_FILES['image']['name'] != ''){
			$file_name = $this->Fp->uploadFile('../webroot/img/front_end/business/deals/', $_FILES['image']);
			if($file_name != '')
				$ret = $file_name;
		}

		//delete the old image
		if($ret != ''){
			if($_POST['old_image'] != ''){
				$oldImagePath = '../webroot/img/front_end/business/deals/'.$_POST['old_image'];
				if(is_file($oldImagePath))
					unlink($oldImagePath);
			}
		}

		echo $ret;
		die;
	}

	//FUNCTION FOR ADDING A DEAL START
	public function add_deals_data(){ //pr($_POST);die;
		$this->layout = 'ajax';

		$saveData['business_id'] = $_POST['business_id'];
		$saveData['title'] = $_POST['BusinessDealTitle'];
		$saveData['price'] = $_POST['BusinessDealPrice'];
		$saveData['tagline'] = $_POST['BusinessDealTagline'];
		$saveData['description'] = $_POST['BusinessDealDescription'];
		$saveData['image'] = $_POST['BusinessDealImage'];
		$saveData['start_date'] = $_POST['BusinessDealStartDate'];
		$saveData['end_date'] = $_POST['BusinessDealEndDate'];
		$saveData['fine_prints'] = $_POST['BusinessDealFinePrints'];
		$saveData['high_lights'] = $_POST['BusinessDealHighLights'];
		$saveData['status'] ='1';

		if($this->BusinessDeal->save($saveData)){
			echo 'saved';
		}else{
			echo '<font color="red">Please Try Later</font>';
		}
		exit;
	}
	//FUNCTION FOR ADDING A DEAL END

	//FUNCTION FOR EDITING A DEAL START
	public function fetch_edit_deals_form(){ //pr($_POST);die;
		$this->layout = 'ajax';
		
		$this->BusinessDeal->recursive = -1;
		$businessArr = $this->BusinessDeal->findById($_POST['id']);
		if(!empty($businessArr))
			$this->set('businessArr', $businessArr);
		else{
			echo '<font color="red">Invalid Selection!!</font>';
			die;
		}		
	}
	//FUNCTION FOR EDITING A DEAL END

	//FUNCTION FOR EDITING A DEAL START
	public function edit_deals_data(){ //pr($_POST);die;
		$this->layout = 'ajax';

		$saveData['id'] = $_POST['BusinessDealId'];
		$saveData['title'] = $_POST['BusinessDealTitle'];
		$saveData['price'] = $_POST['BusinessDealPrice'];
		$saveData['tagline'] = $_POST['BusinessDealTagline'];
		$saveData['description'] = $_POST['BusinessDealDescription'];
		$saveData['image'] = $_POST['BusinessDealImage'];
		$saveData['start_date'] = $_POST['BusinessDealStartDate'];
		$saveData['end_date'] = $_POST['BusinessDealEndDate'];
		$saveData['fine_prints'] = $_POST['BusinessDealFinePrints'];
		$saveData['high_lights'] = $_POST['BusinessDealHighLights'];
		$saveData['status'] ='1'; //pr($saveData);die;

		if($this->BusinessDeal->save($saveData)){
			echo 'saved';
		}else{
			echo '<font color="red">Please Try Later</font>';
		}
		exit;
	}
	//FUNCTION FOR EDITING A DEAL END

	//FUNCTION FOR DELETING A BUSINESS DEAL START
	public function delete_deal(){ //pr($_POST);die;
		$this->layout = 'ajax';

		$this->BusinessDeal->recursive = -1;
		$offerArr = $this->BusinessDeal->findById($_POST['id']);
		if(!empty($offerArr)){
			//delete the image
			if($offerArr['BusinessDeal']['image'] != ''){
				$imagePath = '../webroot/img/front_end/business/deals/'.$offerArr['BusinessDeal']['image'];
				if(is_file($imagePath))
					unlink($imagePath);
			}

			//delete the record
			if($this->BusinessDeal->delete($_POST['id']))
				echo 'deleted';
			else
				echo '';
		}else
			echo '';
		exit;
	}
	//FUNCTION FOR DELETING A BUSINESS DEAL START
	/*---------------------------- FRONT SECTION END ----------------------------------------*/

	/*---------------------------- ADMIN SECTION START --------------------------------------*/
	//FUNCTION FOR MANAGING THE DEALS START
	public function admin_manage($business_id){
		if($business_id != ''){
			$this->BusinessDeal->recursive = -1;
			$this->paginate = array('conditions'=>array('BusinessDeal.business_id'=>$business_id), 'limit'=>PAGING_SIZE, 'order'=>array('BusinessDeal.id'=>'DESC'));
			$this->set('viewListing', $this->paginate('BusinessDeal'));
		}else
			$this->redirect('/admin/businesses/manage/');
	}
	//FUNCTION FOR MANAGING THE DEALS END

	//FUNCTION FOR MANAGING THE STATUS START
	public function admin_status_update($business_id, $id, $newStatus){
		if($id != ''){
			$pageCount = $this->BusinessDeal->find('count', array('conditions'=>array('BusinessDeal.id'=>$id)));
			if($pageCount > 0){
				$saveData['id'] = $id;
				$saveData['status'] = $newStatus;
				if($newStatus == '1')
					$message = 'Activated';
				else
					$message = 'Deactivated';
				if($this->BusinessDeal->save($saveData, false))
					$this->Session->setFlash(__('Deal '.$message.' Successfully!!', true), 'message', array('class'=>'message-green'));
				else
					$this->Session->setFlash(__('No Associated Deal Found!!', true), 'message', array('class'=>'message-red'));
			}else
				$this->Session->setFlash(__('No Associated Deal Found!!', true), 'message', array('class'=>'message-red'));
		}else
			$this->Session->setFlash(__('No Associated Deal Found!!', true), 'message', array('class'=>'message-red'));
		$this->redirect('/admin/business_deals/manage/'.$business_id.'/');
		exit;
	}
	//FUNCTION FOR MANAGING THE STATUS END

	//FUNCTION FOR VIEWING THE DEAL START
	public function admin_view($id){
		$this->layout = 'FancyBox/fancy_box_popup';
		$this->set('dealArr', $this->BusinessDeal->findById($id));
	}
	//FUNCTION FOR VIEWING THE DEAL END

	//FUNCTION FOR DELETING THE DEAL START
	public function admin_delete($business_id, $delete_id){
		$this->BusinessDeal->recursive = -1;
		$offerArr = $this->BusinessDeal->findById($delete_id);
		if(!empty($offerArr)){
			//delete the image
			if($offerArr['BusinessDeal']['image'] != ''){
				$imageRealPath = '../webroot/img/front_end/business/deals/'.$offerArr['BusinessDeal']['image'];
				if(is_file($imageRealPath))
					unlink($imageRealPath);
			}

			//delete the record from table
			if($this->BusinessDeal->delete($offerArr['BusinessDeal']['id']))
				$this->Session->setFlash(__('Deal Deleted Successfully!!', true), 'message', array('class'=>'message-green'));
			else
				$this->Session->setFlash(__('Please Try Later!!', true), 'message', array('class'=>'message-red'));
			$this->redirect('/admin/business_deals/manage/'.$business_id.'/');
		}else
			$this->redirect('/admin/business_deals/manage/'.$business_id.'/');
		exit;
	}
	//FUNCTION FOR DELETING THE DEAL END

	//FUNCTION FOR EDITING A OFFER START
	public function admin_edit($business_id, $deal_id){
		if(!empty($this->request->data)){ //pr($this->request->data);die;
			$allowed_types = unserialize(ALLOWED_IMAGE_TYPES);
			$continue = 'true';
			$logoName = '';

			//upload the image
			if($this->request->data['BusinessDeal']['image_1']['name'] != ''){
				if(in_array($this->request->data['BusinessDeal']['image_1']['type'], $allowed_types)){
					$fileName = $this->Fp->uploadFile('../webroot/img/front_end/business/deals/', $this->request->data['BusinessDeal']['image_1']);
					if($fileName != ''){
						//delete the old file start
						if($this->request->data['BusinessDeal']['old_image'] != ''){
							$realImagePath = '../webroot/img/front_end/business/deals/'.$this->request->data['BusinessDeal']['old_image'];
							if(is_file($realImagePath))
								unlink($realImagePath);
						}
						//delete the old file end
						$this->request->data['BusinessDeal']['image'] = $fileName;
					}
				}else{
					$this->Session->setFlash(__('Please Upload only *.gif, *.jpg, *.png image only!', true), 'message', array('class'=>'message-red'));
					$continue = 'false';
				}
			}
			

			//continue to save the data
			if($continue == 'true'){
				if($this->BusinessDeal->save($this->request->data))
					$this->Session->setFlash(__('Deal Updated Successfully!!', true), 'message', array('class'=>'message-green'));
				else
					$this->Session->setFlash(__('Please Try Later!!', true), 'message', array('class'=>'message-red'));
				$this->redirect('/admin/business_deals/manage/'.$this->request->data['BusinessDeal']['business_id'].'/');
			}
		}

		if(($business_id != '') && ($deal_id != '')){
			$this->BusinessDeal->recursive = -1;
			$this->data = $this->BusinessDeal->findById($deal_id);
		}else
			$this->redirect('/admin/business_deals/manage/'.$business_id.'/');
	}
	//FUNCTION FOR EDITING A OFFER END

	//FUNCTION FOR ADDING A NEW DEAL START
	public function admin_add($business_id){
		if(!empty($this->request->data)){ //pr($this->request->data);die;
			$allowed_types = unserialize(ALLOWED_IMAGE_TYPES);
			$continue = 'true';
			$logoName = '';

			//upload the image
			if($this->request->data['BusinessDeal']['image_1']['name'] != ''){
				if(in_array($this->request->data['BusinessDeal']['image_1']['type'], $allowed_types)){
					$fileName = $this->Fp->uploadFile('../webroot/img/front_end/business/deals/', $this->request->data['BusinessDeal']['image_1']);
					if($fileName != '')
						$this->request->data['BusinessDeal']['image'] = $fileName;
				}else{
					$this->Session->setFlash(__('Please Upload only *.gif, *.jpg, *.png image only!', true), 'message', array('class'=>'message-red'));
					$continue = 'false';
				}
			}
			

			//continue to save the data
			if($continue == 'true'){
				$this->request->data['BusinessDeal']['status'] = '1';
				if($this->BusinessDeal->save($this->request->data))
					$this->Session->setFlash(__('Deal Added Successfully!!', true), 'message', array('class'=>'message-green'));
				else
					$this->Session->setFlash(__('Please Try Later!!', true), 'message', array('class'=>'message-red'));
				$this->redirect('/admin/business_deals/manage/'.$this->request->data['BusinessDeal']['business_id'].'/');
			}
		}
	}
	//FUNCTION FOR ADDING A NEW DEAL END

	//FUNCTION FOR FETCHING THE BUSINESS DETAILS START
	public function fetch_business_deals_details(){ //pr($_POST);die;
		$this->layout = 'ajax';

		$this->set('dealsArr', $this->BusinessDeal->findById($_POST['business_deal_id']));
	}
	//FUNCTION FOR FETCHING THE BUSINESS DETAILS END
	/*---------------------------- ADMIN SECTION END ----------------------------------------*/

}
