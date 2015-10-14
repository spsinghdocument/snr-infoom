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
		$feedbacksArr = $this->BusinessFeedback->find('all', array('fields'=>array('BusinessFeedback.feedback', 'BusinessFeedback.rating', 'User.usertype', 'User.first_name', 'User.city', 'User.image'), 'conditions'=>array('BusinessFeedback.business_id'=>$businessId, 'BusinessFeedback.status'=>'1')));
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
	public function fetchUserDashboardFeeds($user_id=null){
		App::import('Model', 'BusinessSubscriber');
		$this->BusinessSubscriber = new BusinessSubscriber();

		App::import('Model', 'BusinessFeed');
		$this->BusinessFeed = new BusinessFeed();

		$ret = '';

		if($user_id == null)
			$user_id = $this->Session->read('Auth.User.User.id');

		//fetch the subscribed businesses start
		$subscribedBusinesses = $this->BusinessSubscriber->find('list', array('fields'=>array('BusinessSubscriber.business_id'), 'conditions'=>array('BusinessSubscriber.user_id'=>$user_id, 'BusinessSubscriber.status'=>'1')));		
		//fetch the subscribed businesses start

		//fetch business_feeds start
		if(!empty($subscribedBusinesses)){
			$ret = $this->BusinessFeed->find('all', array('conditions'=>array('BusinessFeed.business_id'=>$subscribedBusinesses, 'BusinessFeed.status'=>'1'), 'limit'=>PAGING_SIZE, 'order'=>array('BusinessFeed.modified'=>'DESC')));
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

	//FUNCTION FOR COUNT FAVORITE USER START(SAURABH 5/2/2013)
	function countFavorite($business_id){
		App::import('Model', 'Favorite');
		$this->Favorite = new Favorite();
		$favoriteCount = $this->Favorite->find('count', array('conditions'=>array('Favorite.business_id'=>$business_id, 'Favorite.user_id'=>$this->Session->read('Auth.User.User.id'), 'Favorite.status'=>'1')));
		return $favoriteCount;
	}
	//FUNCTION FOR COUNT FAVORITE USER END(SAURABH 5/2/2013)

	//FUNCTION FOR COUNT FAVORITE USER START(SAURABH 5/2/2013)
	function countUserFavorite(){
		App::import('Model', 'Favorite');
		$this->Favorite = new Favorite();
		$return = '';
		$favoriteArr = $this->Favorite->find('count', array('conditions'=>array('Favorite.user_id'=>$this->Session->read('Auth.User.User.id'))));
		if(!empty($favoriteArr)){
			$return = $favoriteArr;
		}
		return $return;
	}
	//FUNCTION FOR COUNT FAVORITE USER END(SAURABH 5/2/2013)

	//FUNCTION FOR COUNT USER BUSINESS START(SAURABH 5/2/2013)
	function countUserBusiness(){
		App::import('Model', 'Business');
		$this->Business = new Business();
		$return = '';
		$userBusinessArr = $this->Business->find('count', array('conditions'=>array('Business.user_id'=>$this->Session->read('Auth.User.User.id'))));
		if(!empty($userBusinessArr)){
			$return = $userBusinessArr;
		}
		return $return;
	}
	//FUNCTION FOR COUNT USER BUSINESS END(SAURABH 5/2/2013)

	//FUNCTION FOR FETCH POPULAR BUSINESS ON FEED TAB START(SAURABH 5/2/2013)
	function fetchPopularBusiness(){
		App::import('Model', 'Business');
		$this->Business = new Business();
		$return = '';

		$popularBusinessArr = $this->Business->find('all', array('conditions'=>array('Business.status'=>'1'), 'limit'=>'3', 'order'=>array('Business.views'=>'DESC')));
		if(!empty($popularBusinessArr)){
			$return = $popularBusinessArr;
		}
		return $return;
	}
	//FUNCTION FOR FETCH POPULAR BUSINESS ON FEED TAB END(SAURABH 5/2/2013)

	//FUNCTION FOR FETCH BUSINESS YOU MAY KNOW ON BUSINESS TAB START(SAURABH 5/2/2013)
	function business_you_may_know(){
		App::import('Model', 'Business');
		$this->Business = new Business();
		$return = '';
		$businessCatId = $this->Business->find('all', array('fields'=>array('Business.id','Business.category_id'), 'conditions'=>array('Business.user_id'=>$this->Session->read('Auth.User.User.id'))));
		$cat_id = '';
		foreach($businessCatId as $busiCatId){
			$cat_id[] = $busiCatId['Business']['category_id'];
		} 
		if(!empty($cat_id)){
			$business_know = $this->Business->find('all', array('conditions'=>array('Business.category_id'=>$cat_id), 'limit'=>'5', 'order'=>'rand()'));
		} else {
			$business_know = $this->Business->find('all', array('conditions'=>array('Business.status'=>'1'), 'limit'=>'5', 'order'=>'rand()'));
		}
			if(!empty($business_know)){
				$return = $business_know;
			}
			return $return;
	}
	//FUNCTION FOR FETCH BUSINESS YOU MAY KNOW ON BUSINESS TAB END(SAURABH 5/2/2013)

	//FUNCTION FOR FETCHING THE BUSINESS SUBSCRIBERS START
	public function fetchBusinessSubscribers($business_id){ //echo $business_id;die;
			App::import('Model', 'BusinessSubscriber');
			$this->BusinessSubscriber  = new BusinessSubscriber();

			$subscribersArr = $this->BusinessSubscriber->find('all',  array('fields'=>array('User.id', 'User.first_name', 'User.last_name', 'User.image', 'User.gender'), 'conditions'=>array('BusinessSubscriber.business_id'=>$business_id, 'BusinessSubscriber.status'=>'1'), 'limit'=>12, 'order'=>array('BusinessSubscriber.id'=>'DESC')));

			return $subscribersArr;
	}
	//FUNCTION FOR FETCHING THE BUSINESS SUBSCRIBERS END

	//FUNCTION FOR COUNT RECEIVED REQUEST START(SAURABH 5/3/2013)
	 function countReceivedRequest(){
		App::import('Model', 'Friend');
		$this->Friend = new Friend();
		$return = '';
		$receivedRequestArr = $this->Friend->find('count', array('conditions'=>array('Friend.request_received'=>$this->Session->read('Auth.User.User.id'), 'Friend.friendship_status'=>'0')));
		return $receivedRequestArr;
	}
	//FUNCTION FOR COUNT RECEIVED REQUEST END(SAURABH 5/3/2013)

	//FUNCTION FOR FETCHING THE USER_ID FROM THE USER USERNAME START
	public function fetchUserIdFromUsername($username){
		App::import('Model', 'User');
		$this->User = new User();
		$ret = '';

		$this->User->recursive = -1;
		$userArr = $this->User->find('first', array('fields'=>array('User.id'), 'conditions'=>array('User.username'=>$username)));
		if(!empty($userArr))
			$ret = $userArr['User']['id'];
		return $ret;
	}
	//FUNCTION FOR FETCHING THE USER_ID FROM THE USER USERNAME END

	//FUNCTION FOR COUNT USER FRIEND START(SAURABH 5/4/2013)
	function countUserFriend(){
		App::import('Model', 'Friend');
		$this->Friend = new Friend();

		$return = '';
		$receivedRequestArr = $this->Friend->find('count', array('conditions'=>array('OR'=>array('Friend.request_sent'=>$this->Session->read('Auth.User.User.id'), 'Friend.request_received'=>$this->Session->read('Auth.User.User.id')), 'Friend.friendship_status'=>'1')));
		return $receivedRequestArr;
	}
	//FUNCTION FOR COUNT USER FRIEND END(SAURABH 5/4/2013)

	//FUNCTION FOR SHOW RECEIVED FRIEND ON SEARCH LIST START(SAURABH 5/4/2013)
	function fetchReceivedFriend($received_id){
		App::import('Model', 'Friend');
		$this->Friend = new Friend();
		$user_id = $this->Session->read('Auth.User.User.id');

		$return = array('Friend'=>array('friendship_status'=>'', 'id'=>''));
		$friendArr = $this->Friend->find('first', array('fields'=>array('Friend.friendship_status','Friend.id'), 'OR'=>array('User.friendship_status'=>'0', 'User.friendship_status'=>'1'), 'conditions'=>array('Friend.request_sent'=>$user_id, 'Friend.request_received'=>$received_id)));
		if(!empty($friendArr))
			$return = $friendArr;
		return $return;
	}
	//FUNCTION FOR SHOW RECEIVED FRIEND ON SEARCH LIST END(SAURABH 5/4/2013)

	//FUNCTION FOR FETCHING THE OFFER CATEGORIES START
	public function fetchOfferCategories(){
		App::import('Model', 'OfferCategory');
		$this->OfferCategory = new OfferCategory();

		$catArr = $this->OfferCategory->find('list', array('fields'=>array('OfferCategory.id', 'OfferCategory.name'), 'conditions'=>array('OfferCategory.status'=>'1'), 'order'=>array('OfferCategory.name'=>'ASC')));
		return $catArr;
	}
	//FUNCTION FOR FETCHING THE OFFER CATEGORIES END

	//FUNCTION FOR FETCHING THE CORRESPONDING OFFER CATEGORY START
	public function fetchCorrespondingOfferCategory($id){
		App::import('Model', 'OfferCategory');
		$this->OfferCategory = new OfferCategory();

		$ret = '';
		$catArr = $this->OfferCategory->findById($id);
		if(!empty($catArr))
			$ret = $catArr['OfferCategory']['name'];
		return $ret;
	}
	//FUNCTION FOR FETCHING THE CORRESPONDING OFFER CATEGORY END

	//FUNCTION FOR FETCHING THE RECENT USER FEEDS START(SAURABH 5/6/2013)
 public function fetchUsersRecentFeeds($profile_id=null){
  App::import('Model', 'BusinessFeed');
  $this->BusinessFeed = new BusinessFeed();
 
  App::import('Model', 'Friend');
  $this->Friend = new Friend();
 
  $user_id = $this->Session->read('Auth.User.User.id');
  if($profile_id != ''){
   App::import('Model', 'User');
   $this->User = new User();
 
   $this->User->recursive = -1;
   $userArr = $this->User->find('first', array('fields'=>array('User.id'), 'conditions'=>array('User.username'=>$profile_id)));
   $user_id = $userArr['User']['id'];
  }
 
  $friendsArr = $this->Friend->find('all', array('fields'=>array('Friend.request_sent','Friend.request_received'), 'conditions'=>array('OR'=>array('Friend.request_sent'=>$user_id, 'Friend.request_received'=>$user_id), 'Friend.friendship_status'=>'1')));
 
  if(!empty($friendsArr)){
  $request_sent = '';
  $request_received = '';
  foreach($friendsArr as $friendArr){
   $request_sent[] = $friendArr['Friend']['request_sent'];
   $request_received[] = $friendArr['Friend']['request_received'];
  } 
   $friend_id = array_merge($request_sent, $request_received);
   $business_user_id = array_unique($friend_id);
 
  $ret = '';
  //$this->BusinessFeed->recursive = -1;
 
  $feedsArr = $this->BusinessFeed->find('all', array('conditions'=>array('BusinessFeed.user_id'=>$business_user_id, 'BusinessFeed.status'=>'1'), 'limit'=>PAGING_SIZE, 'order'=>array('BusinessFeed.id'=>'DESC')));
  } else {
   $ret = '';
   $feedsArr = $this->BusinessFeed->find('all', array('conditions'=>array('BusinessFeed.user_id'=>$user_id, 'BusinessFeed.status'=>'1'), 'limit'=>PAGING_SIZE, 'order'=>array('BusinessFeed.id'=>'DESC')));
  }
  //pr($feedsArr); die;
  if(!empty($feedsArr))
   $ret = $feedsArr;
  return $ret;
  
 }
 //FUNCTION FOR FETCHING THE RECENT USER FEEDS END(SAURABH 5/6/2013)

 //FUNCTION FOR FETCHING THE DEFAULT BUSINESS BANNER DETAILS START
 public function fetchDefaultBanner(){
	App::import('Model', 'BusinessDefaultBanner');
	$this->BusinessDefaultBanner = new BusinessDefaultBanner();

	$defaultBannerArr = $this->BusinessDefaultBanner->find('first', array('conditions'=>array('BusinessDefaultBanner.id'=>'1', 'BusinessDefaultBanner.status'=>'1')));
	return $defaultBannerArr;
 }
 //FUNCTION FOR FETCHING THE DEFAULT BUSINESS BANNER DETAILS END

 //FUNCTION FOR FETCH ALL FEEDS COMMENTS END(SAURABH 5/9/2013)
	function fetchAllComments($feed_id){
		App::import('MOdel', 'Comment');
		$this->Comment = new Comment();
		
		$return = '';
		$commentArr = $this->Comment->find('all', array('conditions'=>array('Comment.feed_id'=>$feed_id)));
		if(!empty($commentArr)){
			$return = $commentArr;
		}
		return $return;
	}
	//FUNCTION FOR FETCH ALL FEEDS COMMENTS END(SAURABH 5/9/2013)
 
}
?>