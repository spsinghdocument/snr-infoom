<?php
App::uses('AppController', 'Controller');
/**
 * Faqs Controller
 *
 * @property Faq $Faq
 */
class GroupGalleriesController extends AppController {
	public $name = 'GroupGalleries';	
	public $helpers = array('Html', 'Form', 'Session', 'Text', 'Image');
	public $components = array('Session', 'Cookie', 'Email', 'Auth', 'Fp');

	//BEFORE FILTER STARTS
	function beforeFilter(){
		parent::beforeFilter();
		if(!empty($this->Auth)){
			$this->Auth->allowedActions = array('*');
		}
	}
	//BEFORE FILTER ENDS

	/*---------------------------- ADMIN SECTION START ----------------------------------------*/
	
	/*---------------------------- ADMIN SECTION END ------------------------------------------*/

	/*---------------------------- FRONT SECTION START ------------------------------------------*/

	//FUNCTON FOR UPLAODING THE IMAGE START
	public function upload_image(){ //pr($_FILES);die;
		$this->layout = 'ajax';
		if($_FILES['image']['name'] != ''){
			$file_name = $this->Fp->uploadFile('../webroot/img/front_end/groups/', $_FILES['image']);
			if($file_name != '')
				$ret = $file_name;
		}

		echo $ret;
		exit;
	}
	//FUNCTON FOR UPLAODING THE IMAGE END

	//FUNCTON FOR UPLAODING THE VIDEO START
	public function upload_video(){ //pr($_FILES);die;
		$this->layout = 'ajax';
		$ret = '';
		if($_FILES['image']['name'] != ''){
			$file_name = $this->Fp->upload_major_videos('../webroot/img/front_end/groups/flv/', '../webroot/img/front_end/groups/flv/images/', $_FILES['image']);
			if($file_name != '')
				$ret = $file_name;
		}

		echo $ret;
		exit;
	}
	//FUNCTON FOR UPLAODING THE VIDEO END

	//FUNCTION FOR FETCHING THE CORRESPONDING GROUP GALLERY DATA START
	function fetch_corresponding_groups_data(){
		$this->layout = 'ajax';

		//$this->BusinessFeed->recursive = -1;
		$this->set('feed', $this->GroupGallery->findById($_POST['id']));
	}
	//FUNCTION FOR FETCHING THE CORRESPONDING GROUP GALLERY DATA END

	//FUNCTION FOR SAVING THE GROUP GALLERY SECTION START(SAURABH 5/6/2013)
	public function save_group_image_data(){ //pr($_POST);die;
		$this->layout = 'ajax';

		$saveData['user_id'] = $_POST['user_id'];
		$saveData['image'] = $_POST['image'];
		$saveData['group_id'] = $_POST['group_id'];
		$saveData['status'] = '1';

		if($this->GroupGallery->save($saveData)){
			$id = $this->GroupGallery->id;
			echo 'saved*'.$id;
		}else
			echo 'error*<font color="red">Please Try Later!!</font>';
		exit;
	}
	//FUNCTION FOR SAVING THE GROUP GALLERY SECTION END(SAURABH 5/6/2013)

	//FUNCTION FOR SAVING THE GROUP GALLERY VEDIO SECTION START(SAURABH 5/6/2013)
	public function save_group_vedio_data(){ //pr($_POST);die;
		$this->layout = 'ajax';

		$saveData['user_id'] = $this->Session->read('Auth.User.User.id');
		$saveData['video'] = $_POST['video'];
		$saveData['group_id'] = $_POST['group_id'];
		$saveData['status'] = '1'; //pr($saveData);die;

		if($this->GroupGallery->save($saveData)){
			$id = $this->GroupGallery->id;
			echo 'saved*'.$id;
		}else
			echo 'error*<font color="red">Please Try Later!!</font>';
		exit;
	}
	//FUNCTION FOR SAVING THE GROUP GALLERY VEDIO SECTION END(SAURABH 5/6/2013)

	//FUNCTION FOR VIEWING THE VIDEO/ IMAGE START 5/17/2013
	public function view_content($type, $id){ //echo 'test';die;
		$this->layout = 'FrontEnd/Pop_up/default';

		$this->GroupGallery->recursive = -1;
		$galleryArr = $this->GroupGallery->findById($this->Fp->decrypt($id)); //pr($galleryArr);die;
		$this->set('businessArr', $galleryArr);
		$this->set('type', $type);
	}
	//FUNCTION FOR VIEWING THE VIDEO/ IMAGE END 5/17/2013

	//FUNCTION FOR POPULATING THE NEW VIDEO START
	public function populate_new_video(){ //pr($_POST);die;
		$this->layout = 'ajax';

		$this->GroupGallery->recursive = -1;
		$galleryArr = $this->GroupGallery->findById($_POST['id']); //pr($galleryArr);die;
		$this->set('video', $galleryArr);
		$this->set('count', $_POST['count']);
	}
	//FUNCTION FOR POPULATING THE NEW VIDEO END

	//FUNCTION FOR UPLAODING THE GROUPS IMAGE START
	public function upload_groups_image(){ //pr($_FILES);die;
		$this->layout = 'ajax';
		if($_FILES['group_image']['name'] != ''){
			$file_name = $this->Fp->uploadFile('../webroot/img/front_end/groups/', $_FILES['group_image']);
			if($file_name != '')
				$ret = $file_name;
		}
		echo $ret;
		exit;
	}
	//FUNCTION FOR UPLAODING THE GROUPS IMAGE END

	//FUNCTION FOR SAVING THE DATA START
	function save_image_data(){ //pr($_POST);die;
		$this->layout = 'ajax';

		$saveData['group_id'] = $_POST['group_id'];
		$saveData['image'] = $_POST['image'];
		$saveData['user_id'] = $this->Session->read('Auth.User.User.id');
		$saveData['status'] = '1';

		$ret = '';
		$this->GroupGallery->save($saveData, false);
		$ret = $this->GroupGallery->id;

		//$this->set('id', $ret);
		$this->set('post', $_POST);

		$this->GroupGallery->recursive = -1;
		$this->set('gallArr', $this->GroupGallery->find('all', array('conditions'=>array('GroupGallery.id'=>$ret))));
	}
	//FUNCTION FOR SAVING THE DATA END

	//FUNCTION FOR DELETING A PHOTO/ VIDEO START
	public function delete_record(){ //pr($_POST);die;
		$this->layout = 'ajax';

		$this->GroupGallery->recursive = -1;
		$gallArr = $this->GroupGallery->findById($_POST['id']); //pr($gallArr);die;
		if(!empty($gallArr)){
			if($gallArr['GroupGallery']['user_id'] == $this->Session->read('Auth.User.User.id')){
				if($gallArr['GroupGallery']['image'] != ''){//for physical image
					$imageRealURL = '../webroot/img/front_end/groups/'.$gallArr['GroupGallery']['image'];
					if(is_file($imageRealURL))
						unlink($imageRealURL);
				}else{// for physicam video and its corresponding image
					//delete video
					$videoURL = '../webroot/img/front_end/groups/flv/'.$gallArr['GroupGallery']['image'];
					if(is_file($videoURL))
						unlink($videoURL);

					//delete image
					$videoImage = str_replace('.flv', '.jpg', $gallArr['GroupGallery']['video']);
					$videoImageURL = '../webroot/img/front_end/groups/flv/images/'.$videoImage;
					if(is_file($videoImageURL))
						unlink($videoImageURL);
				}

				//delete the record from table
				if($this->GroupGallery->delete($gallArr['GroupGallery']['id']))
					$msg = 'deleted';
			}else
				$msg = 'Unauthorized Action!!';
		}else
			$msg = '';

		echo $msg;
		exit;
	}
	//FUNCTION FOR DELETING A PHOTO/ VIDEO END


	/*----------- ALBUM SECTION START --------------------------*/
	//FUNCTION FOR CREATING A NEW ALBUM START
	public function create_album($group_id=null){
		$this->layout = 'ajax';
		$group_id = $this->Fp->decrypt($group_id);
		$this->set('group_id', $group_id);
	}
	//FUNCTION FOR CREATING A NEW ALBUM END
	/*----------- ALBUM SECTION END  --------------------------*/

	//FUNCTION FOR VALIDATING THE ALBUM NAME START
	public function validate_album_name(){//pr($_POST);die;
		$this->layout = 'ajax';
		Controller::loadModel('GroupAlbum');

		$album_name = trim($_POST['folder_name']);
		$msg = 'OK';

		$albumCount = $this->GroupAlbum->find('count', array('conditions'=>array('GroupAlbum.name'=>$album_name, 'GroupAlbum.group_id'=>$_POST['group_id'])));
		if($albumCount > 0)
			$msg = 'Please use another name!';
		echo $msg;
		exit;
	}
	//FUNCTION FOR VALIDATING THE ALBUM NAME END

	//FUNCTION FOR SAVING THE NEW ALBUM START
	public function save_new_album(){ //pr($_POST);die;
		$this->layout = 'ajax';
		Controller::loadModel('GroupAlbum');

		$saveData['name'] = $_POST['album_name'];
		$saveData['group_id'] = $_POST['group_id'];
		$saveData['status'] = '1';
		if($this->GroupAlbum->save($saveData)){
			$last_insert_id = $this->GroupAlbum->id;
			$msg = 'OK*'.$last_insert_id;
		}else
			$msg = 'Please Try Later!';
		echo $msg;
		die;
	}
	//FUNCTION FOR SAVING THE NEW ALBUM END

	//FUNCTION FOR UPLOADING THE IMAGES TO ALBUM START
	public function upload_album_photos(){ //pr($_FILES);die;
		$this->layout = 'ajax';
		
		//CREATE CUSTOM FILES ARRAY FOR MULTIPLE UPLOAD
		$newUploadedFiles = '';
		foreach($_FILES['image']['name'] as $key=>$val){
			$newArr = '';
			$imageName = '';
			$newArr['name'] = $_FILES['image']['name'][$key];
			$newArr['type'] = $_FILES['image']['type'][$key];
			$newArr['tmp_name'] = $_FILES['image']['tmp_name'][$key];
			$newArr['error'] = $_FILES['image']['error'][$key];
			$newArr['size'] = $_FILES['image']['size'][$key]; //pr($newArr);die;
			$imageName = $this->Fp->uploadFile('../webroot/img/front_end/groups/', $newArr);

			if($key == 0)
				$newUploadedFiles = $imageName;
			else
				$newUploadedFiles .= ','.$imageName;			
		}
		echo $newUploadedFiles;
		exit;
	}
	//FUNCTION FOR UPLOADING THE IMAGES TO ALBUM END

	//FUNCTION FOR PUBLISHING THE TEMPORARY IMAGES START
	public function publish_images(){ //pr($_POST);die;
		$this->layout = 'ajax';

		$explodedArr = explode(',', $_POST['uploaded_images']);
		$this->set('uploadedImagesArr', $explodedArr);
	}
	//FUNCTION FOR PUBLISHING THE TEMPORARY IMAGES END

	//FUNCTION FOR SAVING THE IMAGE SECTION START
	public function save_album_data(){ //pr($_POST);die;
		$this->layout = 'ajax';

		$album_id = $_POST['album_id'];
		$group_id = $_POST['group_id'];

		//explode the images to upload
		$expArr = explode(',', $_POST['up_image']);

		$saveData['group_id'] = $group_id;
		$saveData['user_id'] = $this->Session->read('Auth.User.User.id');
		$saveData['album_id'] = $album_id;
		$saveData['status'] = '1';

		if(!empty($expArr)){ //pr($expArr);die;
			foreach($expArr as $m){
				$saveData['image'] = '';
				$saveData['image'] = $m;
				$this->GroupGallery->create();
				$this->GroupGallery->save($saveData, false);
			}
		}

		$this->set('album_id', $album_id);
	}
	//FUNCTION FOR SAVING THE IMAGE SECTION END

	//FUNCTION FOR DELETING ALBUM START
	public function delete_album(){ //pr($_POST);die;
		set_time_limit(0);
		$this->layout = 'ajax';

		$this->GroupGallery->recursive = -1;
		$albArr = $this->GroupGallery->find('all', array('conditions'=>array('GroupGallery.album_id'=>$_POST['album_id'])));
		if(!empty($albArr)){
			foreach($albArr as $alb){
				$imagePath = '../webroot/img/front_end/groups/'.$alb['GroupGallery']['image'];
				if(is_file($imagePath))
					unlink($imagePath);

				//delete the record
				$this->GroupGallery->delete($alb['GroupGallery']['id']);
			}
		}

		//delete the album name
		Controller::loadModel('GroupAlbum');
		$this->GroupAlbum->delete($_POST['album_id']);
		echo 'deleted';
		exit;
	}
	//FUNCTION FOR DELETING ALBUM END

	//FUNCTION FOR FETCHING THE ALBUM IMAGES START
	public function fetch_album_data(){// pr($_POST);die;
		$this->layout = 'ajax';

		//$this->GroupGallery->recursive = -1;
		$albArr = $this->GroupGallery->find('all', array('conditions'=>array('GroupGallery.album_id'=>$_POST['album_id'])));

		$this->set('gallArr', $albArr);
	}
	//FUNCTION FOR FETCHING THE ALBUM IMAGES END

	/*---------------------------- FRONT SECTION END --------------------------------------------*/

}
