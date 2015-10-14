<?php
App::uses('AppController', 'Controller');
/**
 * Mails Controller
 *
 * @property Mail $Mail
 */
class MailsController extends AppController {
	public $name = 'Mails';	
	public $helpers = array('Html', 'Form', 'Session', 'Text', 'Image');
	public $components = array('Session', 'Email', 'Auth', 'Location', 'Fp');

	public $wallUrl = '/users/dashboard/';

	//BEFORE FILTER STARTS
	function beforeFilter(){
		parent::beforeFilter();
		if(!empty($this->Auth))
			$this->Auth->allowedActions = array();
	}
	//BEFORE FILTER ENDS

	/*---------------------------- FRONT SECTION START ----------------------------------------*/
	//FUNCTION FOR MESSAGE LISTING START
	public function listing(){
		$other_recent_member_id = '';

		$or['receiver_id'] = $this->Session->read('Auth.User.User.id');
		$or['sender_id'] = $this->Session->read('Auth.User.User.id');

		$this->Mail->recursive = -1;
		$mailArr = $this->Mail->find('first', array('fields'=>array('Mail.sender_id', 'Mail.receiver_id'), 'conditions'=>array('Mail.deleted'=>'0', 'Mail.admin_delete'=>'0', 'OR'=>$or),  'order'=>array('Mail.modified'=>'DESC')));

		if(!empty($mailArr)){
			$other_recent_member_id = $mailArr['Mail']['sender_id'];
			if($mailArr['Mail']['sender_id'] == $this->Session->read('Auth.User.User.id'))
				$other_recent_member_id = $mailArr['Mail']['receiver_id'];
		}
		$this->set('other_recent_member_id', $other_recent_member_id);
	}
	//FUNCTION FOR MESSAGE LISTING END

	//FUNCTION FOR ARCHIVING THE SENDER START
	public function arhive_sender(){ //pr($_POST);die;
		$this->layout = 'ajax';

		$setArchiveUserConditions['Mail.sender_id'] = $_POST['sender_id'];
		$setArchiveUserConditions['Mail.receiver_id'] = $this->Session->read('Auth.User.User.id');

		if($this->Mail->updateAll(array('Mail.deleted'=>'1'), $setArchiveUserConditions))
			echo 'archived';
		else
			echo '<font color="red">Error!!</font>';
		exit;
	}
	//FUNCTION FOR ARCHIVING THE SENDER END

	//FUNCTION FOR MARKING A MESSAGE AS READ/ UNREAD START
	public function mark_read_unread(){ //pr($_POST);
		$this->layout = 'ajax';

		$setArchiveUserConditions['Mail.sender_id'] = $_POST['sender_id'];
		$setArchiveUserConditions['Mail.receiver_id'] = $this->Session->read('Auth.User.User.id');
		
		if($_POST['type'] == 'read'){ //mark the unread messages as read
			if($this->Mail->updateAll(array('Mail.read'=>'1'), $setArchiveUserConditions)){
				echo 'read';
			}else
				echo '<font color="red">Error!!</font>';
		}else{ //mark the last read message as unread
			$setArchiveUserConditions['Mail.read'] = '1';
			$mailArr = $this->Mail->find('first', array('fields'=>array('Mail.id'), 'conditions'=>$setArchiveUserConditions, 'order'=>array('Mail.id'=>'DESC')));
			if(!empty($mailArr)){
				$id = $mailArr['Mail']['id'];

				$saveData['id'] = $id;
				$saveData['read'] = '0';
				if($this->Mail->save($saveData))
					echo 'unread';
				else
					echo '<font color="red">Error!!</font>';
			}
		}
		exit;
	}
	//FUNCTION FOR MARKING A MESSAGE AS READ/ UNREAD END

	//FUNCTION FOR COUNTING THE TOTAL UNREAD MESSAGES START
	public function fetch_total_unread_msgs(){
		$this->layout = 'ajax';

		$mailsCount = $this->Mail->find('count', array('conditions'=>array('Mail.receiver_id'=>$this->Session->read('Auth.User.User.id'), 'Mail.deleted'=>'0', 'Mail.admin_delete'=>'0', 'Mail.read'=>'0')));
		echo $mailsCount;
		exit;
	}
	//FUNCTION FOR COUNTING THE TOTAL UNREAD MESSAGES END

	//FUNCTION FOR FETCHING THE SENDER-RECEIVER MESSAGES START
	public function fetch_sender_messages(){ //pr($_POST);die;
		$this->layout = 'ajax';


		/*$or['0']['Mail.receiver_id'] = $_POST['sender_id'];
		$or['0']['Mail.sender_id'] = $this->Session->read('Auth.User.User.id');
		$or['1']['Mail.receiver_id'] = $this->Session->read('Auth.User.User.id');
		$or['1']['Mail.sender_id'] = $_POST['sender_id'];

		$conditions['Mail.deleted'] = '0';
		$conditions['Mail.admin_delete'] = '0';
		$conditions['OR'] = $or; //pr($conditions);die;

		$this->Mail->unbindModel(array('belongsTo'=>array('Receiver')));
		$msgArr = $this->Mail->find('all', array('conditions'=>$conditions, 'limit'=>PAGING_SIZE, 'order'=>array('Mail.modified'=>'DESC'))); //pr($msgArr);die;
		$this->set('msgArr', $msgArr); */

		$this->set('other_recent_member_id', $_POST['sender_id']);
		$this->set('directory', $_POST['directory']);
	}
	//FUNCTION FOR FETCHING THE SENDER-RECEIVER MESSAGES END

	//FUNCTION FOR FETCHING THE SENDER-RECEIVER MESSAGES WITH CHECKBOXES START
	public function fetch_sender_messages_with_checkboxes(){ //pr($_POST);die;
		$this->layout = 'ajax';
		$this->set('other_recent_member_id', $_POST['sender_id']);
		$this->set('directory', $_POST['directory']);
	}
	//FUNCTION FOR FETCHING THE SENDER-RECEIVER MESSAGES WITH CHECKBOXES END

	//FUNCTION FOR UPLOADING THE ATTACHEMNT STRAT
	public function upload_attachment(){ //pr($_FILES);die;
		$this->layout = 'ajax';

		Controller::loadModel('Attachment');
		if($_FILES['Attachment']['name'] != ''){
			$file_name = $this->Fp->uploadFile('../webroot/img/front_end/attachments/', $_FILES['Attachment']);

			$saveData['file_name'] = $_FILES['Attachment']['name'];
			$saveData['uploaded_name'] = $file_name;
			$saveData['status'] = '1';
			if($this->Attachment->save($saveData, false))
				$lastUploadedId = $this->Attachment->id;
				$dataToSend = $lastUploadedId.'*'.$_FILES['Attachment']['name'].'*'.$file_name;
		}
		echo $dataToSend;
		exit;
	}
	//FUNCTION FOR UPLOADING THE ATTACHEMNT END

	//FUNCTION FOR SAVING THE USER MESSAGE START
	public function submit_user_message(){ //pr($_POST);die;
		$this->layout = 'ajax';

		$ret = '';

		$saveData['sender_id'] = $this->Session->read('Auth.User.User.id');
		$saveData['receiver_id'] = $_POST['receiver_id'];
		$saveData['message'] = trim($_POST['message']);
		$saveData['attachment_ids'] = trim($_POST['attachments_ids']);

		if($this->Mail->save($saveData, false)){
			$ret = 'success' ;
		}

		$this->set('ret', $ret);
		$this->set('post', $_POST);
	}
	//FUNCTION FOR SAVING THE USER MESSAGE END

	//FUNCTION FOR SENDING THE MESSAGE TO MULTIPLE USERS START
	public function submit_multiple_messages(){ //pr($_POST);die;
		$this->layout = 'ajax';

		$saveData['sender_id'] = $this->Session->read('Auth.User.User.id');
		$saveData['message'] = trim($_POST['message']);
		$saveData['attachment_ids'] = trim($_POST['attachments_ids']);

		$expArr = explode(',', $_POST['receiver_id']);

		foreach($expArr as $to){
			$saveData['receiver_id'] = $to;
			$this->Mail->create();
			$this->Mail->save($saveData, false);
		}
		echo 'done';
		exit;
	}
	//FUNCTION FOR SENDING THE MESSAGE TO MULTIPLE USERS END

	//FUNCTION FOR SENDING THE MESSAGE TO MULTIPLE USERS START
	public function submit_forward_messages(){ //pr($_POST);die;
		$this->layout = 'ajax';

		$saveData['sender_id'] = $this->Session->read('Auth.User.User.id');
		$saveData['message'] = trim($_POST['message']);
		$saveData['attachment_ids'] = trim($_POST['attachments_ids']);
		$saveData['forwards'] = trim($_POST['forward_ids']);

		$expArr = explode(',', $_POST['receiver_id']);

		foreach($expArr as $to){
			$saveData['receiver_id'] = $to;
			$this->Mail->create();
			$this->Mail->save($saveData, false);
		}
		echo 'done';
		exit;
	}
	//FUNCTION FOR SENDING THE MESSAGE TO MULTIPLE USERS END

	//FUNCTION FOR DOWNLOADING THE ATTACHMENT START
	public function download($uploadedName){
		$this->layout = 'ajax';

		$this->set('file', '../webroot/img/front_end/attachments/'.$uploadedName);
	}
	//FUNCTION FOR DOWNLOADING THE ATTACHMENT END

	//FUNCTION FOR CREATING A NEW MAIL START
	public function new_mail(){
		$post = '';
		if(!empty($this->request->data)){ //pr($this->request->data);die;
			$post = $this->request->data;
		}

		$this->set('post', $post);
	}
	//FUNCTION FOR CREATING A NEW MAIL END

	//FUNCTION TO FETCH THE SIMILAR USERS START
	public function fetch_similar_users(){ //pr($_POST);die;
		$this->layout = 'ajax';

		$not[] = $this->Session->read('Auth.User.User.id');
		if($_POST['send_ids'] != ''){
			$expArr = explode(',', $_POST['send_ids']);
			foreach($expArr as $exp){
				$not[] = $exp;
			}
		}

		Controller::loadModel('User');		
		$keyword = trim($_POST['name']);
		$this->User->recursive = -1;
		/*$userlistArr = $this->User->find('all', array('conditions'=>array('User.id <>'=>$this->Session->read('Auth.User.User.id'), 'User.status'=>'1', 'OR'=>array(
			'User.first_name LIKE'=>"%".$keyword."%",
			'User.last_name LIKE'=>"%".$keyword."%",
			'CONCAT(User.first_name, " ", User.last_name) LIKE'=>"%".$keyword."%",
			'User.email LIKE'=>"%".$keyword."%",
			)), 'order'=>array('User.first_name'=>'ASC'))); */

		$userlistArr = $this->User->find('all', array('conditions'=>array('User.status'=>'1', 'OR'=>array(
			'User.first_name LIKE'=>"%".$keyword."%",
			'User.last_name LIKE'=>"%".$keyword."%",
			'CONCAT(User.first_name, " ", User.last_name) LIKE'=>"%".$keyword."%",
			'User.email LIKE'=>"%".$keyword."%",
			), 'NOT'=>array('User.id'=>$not)), 'order'=>array('User.first_name'=>'ASC')));


		$this->set('searchArr', $userlistArr);
	}
	//FUNCTION TO FETCH THE SIMILAR USERS END

	//FUNCTION TO KNOW THE MESSAGE STATUS START
	public function know_msg_status(){ //pr($_POST);die;
		$this->layout = 'ajax';

		$mailsCount = $this->Mail->find('count', array('conditions'=>array('Mail.sender_id'=>$_POST['sender_id'], 'Mail.receiver_id'=>$this->Session->read('Auth.User.User.id'), 'Mail.deleted'=>'0', 'Mail.admin_delete'=>'0', 'Mail.read'=>'0')));
		echo $mailsCount;
		exit;
	}
	//FUNCTION TO KNOW THE MESSAGE STATUS END

	//FUNCTION FOR MOVING THE CONVERSATION TO TRASH START
	public function move_conversation_to_trash(){ //pr($_POST);die;
		$this->layout = 'ajax';

		$expArr = explode(',', $_POST['del_ids']);

		foreach($expArr as $id){
			$updateData = '';
			if($id != ''){
				if($_POST['directory'] == '1'){// move to trash
					$updateData['id'] = $id;
					$updateData['folder_id'] = '2'; // MOVE TO TRASH
					$this->Mail->save($updateData, false);
				}else{ // delete permanently
					$this->Mail->delete($id);
				}				
			}
		}
		echo 'deleted';
		exit;
	}
	//FUNCTION FOR MOVING THE CONVERSATION TO TRASH END

	//FUNCTION FOR ARCHIVING THE CONVERSATION START
	public function move_conversation_to_archive(){ //pr($_POST);die;
		$this->layout = 'ajax';

		$expArr = explode(',', $_POST['arcv_ids']);

		foreach($expArr as $id){
			$updateData = '';
			if($id != ''){
				$updateData['id'] = $id;
				$updateData['folder_id'] = '3'; // MOVE TO ARCHIVE
				$this->Mail->save($updateData, false);
			}
		}
		echo 'archived';		

		exit;
	}
	//FUNCTION FOR ARCHIVING THE CONVERSATION END

	//FUNCTION FOR ARCHIVING THE CONVERSATION START
	public function move_conversation_to_folder(){ //pr($_POST);die;
		$this->layout = 'ajax';

		$expArr = explode(',', $_POST['checked_ids']);

		foreach($expArr as $id){
			$updateData = '';
			if($id != ''){
				$updateData['id'] = $id;
				$updateData['folder_id'] = $_POST['move_folder_id']; // MOVE TO FOLDER
				$this->Mail->save($updateData, false);
			}
		}
		echo 'moved';		

		exit;
	}
	//FUNCTION FOR ARCHIVING THE CONVERSATION END

	//FUNCTION FOR SHOWING THE DIRECTORY DATA START
	public function show_directory_data(){ //pr($_POST);die;
		$this->layout = 'ajax';

		/*Controller::loadmodel('Folder');

		$this->Folder->recursive = -1;
		$folderArr = $this->Folder->find('first', array('fields'=>array('Folder.id'), 'conditions'=>array('Folder.name'=>$_POST['folder_name']))); */

		//$this->set('folder_id', $folderArr['Folder']['id']);
		$this->set('folder_id', $_POST['folder_id']);
		$this->set('other_recent_member_id', $_POST['sender_id']);
	}
	//FUNCTION FOR SHOWING THE DIRECTORY DATA END

	//FUNCTION FOR CREATING THE CUSTOM DIRECTORY STRAT
	public function create_custom_directory(){
		$this->layout = 'ajax';


	}
	//FUNCTION FOR CREATING THE CUSTOM DIRECTORY END

	//FUNCTION FOR VALIDATING A PROVIDED FOLDER NAME START
	public function validate_folder_name(){ //pr($_POST);die;
		$this->layout = 'ajax';

		$continue = 'true';
		$msg = 'OK';
		$newFoldername = trim($_POST['folder_name']);
		Controller::loadmodel('Folder');

		//fetch the reserved folders
		$folderArr = $this->Folder->find('list', array('fields'=>array('Folder.name'), 'conditions'=>array('Folder.user_id'=>'')));
		$reserverdFolders = '';
		if(!empty($folderArr)){
			foreach($folderArr as $folder){
				$reserverdFolders[] = strtolower($folder);
			}
		}

		if(in_array(strtolower($newFoldername), $reserverdFolders)){
			$msg = 'Please use another name';
			$continue = 'false';
		}

		//check if the name is not created by the logged in user previously
		if($continue == 'true'){
			$folderCount = $this->Folder->find('count', array('conditions'=>array('Folder.user_id'=>$this->Session->read('Auth.User.User.id'), 'Folder.name'=>$newFoldername)));
			if($folderCount > 0)
				$msg = 'Please use another name';
		}
		echo $msg;
		exit;
	}
	//FUNCTION FOR VALIDATING A PROVIDED FOLDER NAME END

	//FUNCTION FOR SAVING THE NEW DIRECTORY START
	public function save_new_directory(){ //pr($_POST);die;
		$this->layout = 'ajax';

		Controller::loadmodel('Folder');

		$saveData['user_id'] = $this->Session->read('Auth.User.User.id');
		$saveData['name'] = trim($_POST['folder_name']);
		$saveData['status'] = '1';

		if($this->Folder->save($saveData, false))
			echo 'OK';
		else
			echo 'Please Try Later';
		exit;
	}
	//FUNCTION FOR SAVING THE NEW DIRECTORY END

	//FUNCTION FOR SENDING THE EMAIL FROM PROFILE PAGE START
	public function send_email($receiver_id){
		$this->layout = 'ajax';

		Controller::loadModel('User');

		$this->User->recursive = -1;
		$usrArr = $this->User->find('first', array('fields'=>array('User.id', 'User.first_name', 'User.last_name'), 'conditions'=>array('User.id'=>$receiver_id)));
		$this->set('usrArr', $usrArr);
	}

	public function submit_profile_message(){ //pr($_POST);die;
		$this->layout = 'ajax';

		$saveData['sender_id'] = $this->Session->read('Auth.User.User.id');
		$saveData['receiver_id'] = $_POST['receiver_id'];
		$saveData['message'] = $_POST['msg'];
		if($this->Mail->save($saveData))
			echo 'sent';
		else
			echo 'fail';
		exit;
	}
	//FUNCTION FOR SENDING THE EMAIL FROM PROFILE PAGE END
	/*---------------------------- FRONT SECTION END ------------------------------------------*/
}
