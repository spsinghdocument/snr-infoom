<?php
class FusedHelper extends AppHelper {
	var $helpers = array('Html', 'Form', 'Ajax', 'Js', 'Javascript','Session');

	//FUNCTION FOR ENCRYPTION START
	public function encrypt($data){
		return base64_encode($data);
	}
	//FUNCTION FOR ENCRYPTION END

	//FUNCTION FOR DECRYPTION START
	public function decrypt($data){
		return base64_decode($data);
	}
	//FUNCTION FOR DECRYPTION END

	//FUNCTION FOR FETCHING THE PARENT CATEGORIES START
	public function fetchAllParentCategories(){
		App::import('Model', 'Category');
		$this->Category = new Category();
		$return = '';

		$catArr = $this->Category->find('list', array('fields'=>array('Category.id', 'Category.name'), 'conditions'=>array('Category.parent_id'=>'0')));
		if(!empty($catArr))
			$return = $catArr;
		return $return;
	}
	//FUNCTION FOR FETCHING THE PARENT CATEGORIES END

	//FUNCTION FOR FETCHING THE CATEGORY NAME START
	public function fetchCategoryDetails($id){
		App::import('Model', 'Category');
		$this->Category = new Category();
		$return = '';

		$catArr = $this->Category->findById($id);
		if(!empty($catArr))
			$return = $catArr;
		return $return;
	}
	//FUNCTION FOR FETCHING THE CATEGORY NAME END

	//FUNCTION FOR FETCHING THE CATEGORY NAME START
	public function fetchAllActiveSubscribedEmails(){
		App::import('Model', 'Newsletter');
		$this->Newsletter = new Newsletter();
		$ret = '';

		$this->Newsletter->recursive = -1;
		$subsArr = $this->Newsletter->find('fetchAllSubscribedEmails', array('fields'=>array('Newsletter.email'), 'conditions'=>array('Newsletter.status'=>'1')));
		if(!empty($subsArr))
			$ret = $subsArr;
		return $ret;
	}
	//FUNCTION FOR FETCHING THE CATEGORY NAME END

	//FUNCTION FOR FETCHING ALL AUSTRALIA STATES START
	public function fetchAllAustraliaStates(){
		App::import('Model', 'State');
		$this->State = new State();
		$ret = '';

		$stateArr = $this->State->find('list', array('fields'=>array('State.id', 'State.state')));
		if(!empty($stateArr))
			$ret = $stateArr;
		return $ret;
	}
	//FUNCTION FOR FETCHING ALL AUSTRALIA STATES END

	//FUNCTION FOR FETCHING THE CORRESPONDING SUBURBS START
	public function fetchCorrespondingSuburbs($stateId){
		App::import('Model', 'Suburb');
		$this->Suburb = new Suburb();
		$ret = '';

		$suburbArr = $this->Suburb->find('list', array('fields'=>array('Suburb.id', 'Suburb.suburb'), 'conditions'=>array('Suburb.state_id'=>$stateId)));
		if(!empty($suburbArr))
			$ret = $suburbArr;
		return $ret;
	}
	//FUNCTION FOR FETCHING THE CORRESPONDING SUBURBS END

	//FUNCTION FOR FETCHING ALL ACTIVE CATEGORIES START
	public function fetchAllCategories(){
		App::import('Model', 'Category');
		$this->Category = new Category();

		$ret = '';

		$catArr = $this->Category->find('list', array('fields'=>array('Category.id', 'Category.name'), 'conditions'=>array('Category.status'=>'1', 'Category.parent_id'=>'0'), 'order'=>array('Category.name'=>'ASC')));
		if(!empty($catArr))
			$ret = $catArr;
		return $ret;
	}
	//FUNCTION FOR FETCHING ALL ACTIVE CATEGORIES END

	//FUNCTION FOR FETCHING ALL ACTIVE SUB-CATEGORIES START
	public function fetchAllSubCategories($id=null){
		App::import('Model', 'Category');
		$this->Category = new Category();

		$ret = '';

		$catArr = $this->Category->find('list', array('fields'=>array('Category.id', 'Category.name'), 'conditions'=>array('Category.status'=>'1', 'Category.parent_id'=>$id), 'order'=>array('Category.name'=>'ASC')));
		if(!empty($catArr))
			$ret = $catArr;
		return $ret;
	}
	//FUNCTION FOR FETCHING ALL ACTIVE SUB-CATEGORIES END

	//FUNCTION FOR FETCHING THE BUSINESS FEEDBACKS START
	public function fetchBusinessFeedbacks($businessId){
		App::import('Model', 'BusinessFeedback');
		$this->BusinessFeedback = new BusinessFeedback();

		$ret = '';

		$this->BusinessFeedback->unbindModel(array('belongsTo'=>array('Business')));
		$feedbacksArr = $this->BusinessFeedback->find('all', array('fields'=>array('BusinessFeedback.feedback', 'User.usertype', 'User.first_name', 'User.city', 'User.image'), 'conditions'=>array('BusinessFeedback.business_id'=>$businessId, 'BusinessFeedback.status'=>'1')));
		if(!empty($feedbacksArr))
			$ret = $feedbacksArr;
		return $ret;
	}
	//FUNCTION FOR FETCHING THE BUSINESS FEEDBACKS END

	//FUNCTION FOR FETCHING THE BUSINESS FEEDBACKS COUNT START
	public function fetchBusinessFeedbacksCount($businessId){
		App::import('Model', 'BusinessFeedback');
		$this->BusinessFeedback = new BusinessFeedback();

		$feedbacksCount = $this->BusinessFeedback->find('count', array('conditions'=>array('BusinessFeedback.business_id'=>$businessId, 'BusinessFeedback.user_id'=>$this->Session->read('Auth.User.User.id'))));
		return $feedbacksCount;
	}
	//FUNCTION FOR FETCHING THE BUSINESS FEEDBACKS COUNT END

	//FUNCTION FOR VALIDATING THE USER RATING START
	function validateUserRating($businessId){
		App::import('Model', 'BusinessRating');
		$this->BusinessRating = new BusinessRating();

		
		$ratingCount = $this->BusinessRating->find('count', array('conditions'=>array('BusinessRating.business_id'=>$businessId, 'BusinessRating.user_id'=>$this->Session->read('Auth.User.User.id'))));
		return $ratingCount;

	}
	//FUNCTION FOR VALIDATING THE USER RATING END

	//FUNCTION TO FETCH THE USER RATING START
	function fetchUserRating($businessId){
		App::import('Model', 'BusinessRating');
		$this->BusinessRating = new BusinessRating();

		
		$ratingArr = $this->BusinessRating->find('first', array('fields'=>array('BusinessRating.rating'), 'conditions'=>array('BusinessRating.business_id'=>$businessId, 'BusinessRating.user_id'=>$this->Session->read('Auth.User.User.id'))));
		return $ratingArr['BusinessRating']['rating'];

	}
	//FUNCTION TO FETCH THE USER RATING END

	//FUNCTION TO FETCH THE POPULAR BUSINESSES START
	public function fetchPopularBusinesses(){
		App::import('Model', 'Business');
		$this->Business = new Business();

		$ret = '';

		$this->Business->recursive = -1;
		$businessArr = $this->Business->find('all', array('conditions'=>array('Business.status'=>'1'), 'order'=>array('Business.views'=>'DESC'), 'limit'=>5));
		if(!empty($businessArr))
			$ret = $businessArr;
		return $ret;
	}
	//FUNCTION TO FETCH THE POPULAR BUSINESSES END

	//FUNCTION FOR FETCHING THE CLAIM STATUS START
	public function fetchBusinessClaimStatus($business_id){
		App::import('Model', 'Business');
		$this->Business = new Business();

		$ret = '';
		$this->Business->recursive = -1;
		$businessArr = $this->Business->find('first', array('fields'=>array('Business.user_id'), 'conditions'=>array('Business.id'=>$business_id)));
		if(!empty($businessArr)){
			if($businessArr['Business']['user_id'] != '')
				$ret = $businessArr['Business']['user_id'];
		}
		return $ret;
	}
	//FUNCTION FOR FETCHING THE CLAIM STATUS END

	//FUNCTION FOR FETCHING THE BUSINESS ALIAS NAME START
	public function fetchAliasName($business_id){
		App::import('Model', 'Business');
		$this->Business = new Business();

		$ret = '';
		$this->Business->recursive = -1;
		$businessArr = $this->Business->find('first', array('fields'=>array('Business.alias_name'), 'conditions'=>array('Business.id'=>$business_id)));
		if(!empty($businessArr)){
			if($businessArr['Business']['alias_name'] != '')
				$ret = $businessArr['Business']['alias_name'];
		}
		return $ret;
	}
	//FUNCTION FOR FETCHING THE BUSINESS ALIAS NAME END

	//FUNCTION FOR CHECKING WHETHER THE LOGGED IN USER HAS ALREADY BUSINESS OR NOT START
	public function validateUserForBusiness(){
		App::import('Model', 'Business');
		$this->Business = new Business();

		$ret = '';
		$this->Business->recursive = -1;
		$businessArr = $this->Business->findByUser_id($this->Session->read('Auth.User.User.id'));
		if(!empty($businessArr)){
			if($businessArr['Business']['id'] != '')
				$ret = $businessArr['Business']['id'];
		}
		return $ret;
	}
	//FUNCTION FOR CHECKING WHETHER THE LOGGED IN USER HAS ALREADY BUSINESS OR NOT END

	//FUNCTION TO FETCH THE BUSINESS OFFERS START
	public function fetchBusinessOffers($business_id){
		App::import('Model', 'BusinessOffer');
		$this->BusinessOffer = new BusinessOffer();

		$ret = '';
		$this->BusinessOffer->recursive = -1;
		$businessOfferArr = $this->BusinessOffer->find('all', array('conditions'=>array('BusinessOffer.business_id'=>$business_id, 'BusinessOffer.status'=>'1'), 'limit'=>PAGING_SIZE, 'order'=>array('BusinessOffer.id'=>'DESC')));
		if(!empty($businessOfferArr))
			$ret = $businessOfferArr;
		return $ret;
	}
	//FUNCTION TO FETCH THE BUSINESS OFFERS END

	//FUNCTION FOR FETCHING THE RECENT FEEDS START
	public function fetchBusinessRecentFeeds($business_id){
		App::import('Model', 'BusinessFeed');
		$this->BusinessFeed = new BusinessFeed();

		$ret = '';
		//$this->BusinessFeed->recursive = -1;
		$feedsArr = $this->BusinessFeed->find('all', array('conditions'=>array('BusinessFeed.status'=>'1', 'BusinessFeed.business_id'=>$business_id), 'limit'=>PAGING_SIZE, 'order'=>array('BusinessFeed.id'=>'DESC')));
		if(!empty($feedsArr))
			$ret = $feedsArr;
		return $ret;
	}
	//FUNCTION FOR FETCHING THE RECENT FEEDS END

	//FUNCTION FOR VALIDATING THE SUBSCRIBER FOR A CORRESPONDING USER START
	public function validateSubscribedBusiness($business_id){
		App::import('Model', 'BusinessSubscriber');
		$this->BusinessSubscriber = new BusinessSubscriber();

		$subscribeCount = $this->BusinessSubscriber->find('count', array('conditions'=>array('BusinessSubscriber.business_id'=>$business_id, 'BusinessSubscriber.user_id'=>$this->Session->read('Auth.User.User.id'), 'BusinessSubscriber.status'=>'1')));

		return $subscribeCount;
	}
	//FUNCTION FOR VALIDATING THE SUBSCRIBER FOR A CORRESPONDING USER END

	//FUNCTION FOR FETCHING THE USER DASHBOARD FEEDS START
	public function fetchUserDashboardFeeds(){
		App::import('Model', 'BusinessSubscriber');
		$this->BusinessSubscriber = new BusinessSubscriber();

		App::import('Model', 'BusinessFeed');
		$this->BusinessFeed = new BusinessFeed();

		$ret = '';

		//fetch the subscribed businesses start
		$subscribedBusinesses = $this->BusinessSubscriber->find('list', array('fields'=>array('BusinessSubscriber.business_id'), 'conditions'=>array('BusinessSubscriber.user_id'=>$this->Session->read('Auth.User.User.id'), 'BusinessSubscriber.status'=>'1')));		
		//fetch the subscribed businesses start

		//fetch business_feeds start
		if(!empty($subscribedBusinesses)){
			$ret = $this->BusinessFeed->find('all', array('conditions'=>array('BusinessFeed.business_id'=>$subscribedBusinesses, 'BusinessFeed.status'=>'1'), 'limit'=>PAGING_SIZE, 'order'=>array('BusinessFeed.id'=>'DESC')));
		}
		//fetch business_feeds end

		return $ret;
	}
	//FUNCTION FOR FETCHING THE USER DASHBOARD FEEDS END

	//FUNCTION FOR FETCHING THE BUSINESS OWNER START
	public function fetchBusinessOwner($business_id){
		App::import('Model', 'Business');
		$this->Business = new Business();

		$ret = '';
		$this->Business->recursive = -1;
		$businessArr = $this->Business->find('first', array('fields'=>array('Business.user_id'), 'conditions'=>array('Business.id'=>$business_id)));
		if(!empty($businessArr))
			$ret = $businessArr['Business']['user_id'];
		return $ret;
	}
	//FUNCTION FOR FETCHING THE BUSINESS OWNER END
}
?>