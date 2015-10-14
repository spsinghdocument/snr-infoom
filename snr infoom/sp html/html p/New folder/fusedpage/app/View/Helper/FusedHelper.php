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
	public function fetchAllActiveSubscribedEmails__(){
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

	//FUNCTION FOR FETCHING THE CATEGORY NAME START
	public function fetchAllActiveSubscribedEmails(){
		App::import('Model', 'User');
		$this->User = new User();
		$ret = '';

		$this->User->recursive = -1;
		$subsArr = $this->User->find('list', array('fields'=>array('User.email', 'User.email'), 'conditions'=>array('User.status'=>'1')));
		pr($subsArr);
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
	/* public function validateUserForBusiness(){
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
	} */

	public function validateUserForBusiness($business_id){
		App::import('Model', 'Business');
		$this->Business = new Business();

		$ret = 'false';

		$businessCount = $this->Business->find('count', array('conditions'=>array('Business.id'=>$business_id, 'Business.user_id'=>$this->Session->read('Auth.User.User.id'))));
		if($businessCount > 0)
			$ret = 'true';
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
		$feedsArr = $this->BusinessFeed->find('all', array('conditions'=>array('BusinessFeed.status'=>'1', 'BusinessFeed.business_id'=>$business_id, 'BusinessFeed.recommend'=>'0'), 'limit'=>PAGING_SIZE, 'order'=>array('BusinessFeed.id'=>'DESC')));
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
			if($busiCatId['Business']['category_id'] != '0'){
				$cat_id[] = $busiCatId['Business']['category_id'];
			}
		} 
		if(!empty($cat_id)){
			$business_know = $this->Business->find('all', array('conditions'=>array('Business.category_id'=>$cat_id), 'limit'=>'5'));
		} else {
			$business_know = $this->Business->find('all', array('conditions'=>array('Business.status'=>'1'), 'limit'=>'5'));
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

			$subscribersArr = $this->BusinessSubscriber->find('all',  array('fields'=>array('User.id', 'User.first_name', 'User.last_name', 'User.image', 'User.gender', 'User.username'), 'conditions'=>array('BusinessSubscriber.business_id'=>$business_id, 'BusinessSubscriber.status'=>'1'), 'limit'=>12, 'order'=>array('BusinessSubscriber.id'=>'DESC')));

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

	function countReceivedIgnoredRequest(){
		App::import('Model', 'Friend');
		$this->Friend = new Friend();
		$return = '';
		$receivedRequestCount = $this->Friend->find('count', array('conditions'=>array('Friend.request_received'=>$this->Session->read('Auth.User.User.id'), 'Friend.friendship_status'=>array('0', '2'))));
		return $receivedRequestCount;
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

		/*$friendArr = $this->Friend->find('first', array('fields'=>array('Friend.friendship_status','Friend.id'), 'OR'=>array('Friend.friendship_status'=>'0', 'Friend.friendship_status'=>'1'), 'conditions'=>array('Friend.request_sent'=>$user_id, 'Friend.request_received'=>$received_id)));*/

		$or = array('0'=>array('Friend.request_sent'=>$received_id, 'Friend.request_received'=>$user_id), array('Friend.request_sent'=>$user_id, 'Friend.request_received'=>$received_id));
		$this->Friend->recursive = -1;
        $friendArr = $this->Friend->find('first', array('conditions'=>array('OR'=>$or)));

		if(!empty($friendArr))
			$return = $friendArr;
		return $return;
	}
	//FUNCTION FOR SHOW RECEIVED FRIEND ON SEARCH LIST END(SAURABH 5/4/2013)

	//FUNCTION FOR FETCHING THE OFFER CATEGORIES START
	public function fetchOfferCategories(){
		App::import('Model', 'OfferCategory');
		$this->OfferCategory = new OfferCategory();

		$catArr = $this->OfferCategory->find('list', array('fields'=>array('OfferCategory.id', 'OfferCategory.name'), 'conditions'=>array('OfferCategory.status'=>'1', 'OfferCategory.user_id'=>$this->Session->read('Auth.User.User.id')), 'order'=>array('OfferCategory.name'=>'ASC')));
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
	public function fetchUsersRecentFeeds($profile_id=null){ //echo $profile_id;
		App::import('Model', 'Business');
		App::import('Model', 'BusinessFeed');
		App::import('Model', 'BusinessSubscriber');
		App::import('Model', 'Recommended');
		$this->Business = new Business();
		$this->BusinessFeed = new BusinessFeed();
		$this->BusinessSubscriber = new BusinessSubscriber();
		$this->Recommended = new Recommended();

		App::import('Model', 'Friend');
		$this->Friend = new Friend();

		$user_id = $this->Session->read('Auth.User.User.id');
		if($profile_id != ''){
			App::import('Model', 'User');
			$this->User = new User();

			$this->User->recursive = -1;
			$userArr = $this->User->find('first', array('fields'=>array('User.id'), 'conditions'=>array('User.username'=>$profile_id)));
			$user_id = $userArr['User']['id'];
		} //echo $user_id;

		//FOR FRIENDS START
		$friendsArr = $this->Friend->find('all', array('fields'=>array('Friend.request_sent','Friend.request_received'), 'conditions'=>array('Friend.friendship_status'=>'1', 'OR'=>array('Friend.request_sent'=>$user_id, 'Friend.request_received'=>$user_id))));

		if(!empty($friendsArr)){ //pr($friendsArr);die;
		$request_sent = array();
		$request_received = array();
		foreach($friendsArr as $friendArr){ //pr($friendArr);die;
			if($friendArr['Friend']['request_sent'] != $this->Session->read('Auth.User.User.id')){
				$request_sent[] = $friendArr['Friend']['request_sent'];
			}

			if($friendArr['Friend']['request_received'] != $this->Session->read('Auth.User.User.id')){
				$request_received[] = $friendArr['Friend']['request_received'];
			}
		}
		$friend_id = array_merge($request_sent, $request_received); //pr($friend_id);
		$business_user_id = array_unique($friend_id); //pr($business_user_id);
		//FOR FRIENDS END

		$businessSubsArr = $this->BusinessSubscriber->find('all', array('conditions'=>array('BusinessSubscriber.user_id'=>$business_user_id, 'BusinessSubscriber.status'=>'1')));
		$businessfeed_id = '';
		if(!empty($businessSubsArr)){ 			
			foreach($businessSubsArr as $businessSubs){
				$businessfeed_id[] = $businessSubs['BusinessSubscriber']['business_id'];
			} 
		} //pr($businessfeed_id);die;

		$this->Business->recursive = -1;
		$businessArr = $this->Business->find('all', array('fields'=>array('Business.id'), 'conditions'=>array('Business.user_id'=>$business_user_id, 'Business.status'=>'1'))); //pr($businessArr);die;
		$Userbusiness_id = '';
		if(!empty($businessArr)){
			foreach($businessArr as $business){
				$Userbusiness_id[] = $business['Business']['id'];
			}
		} //pr($Userbusiness_id);die;

		$ret = '';
		//$Userbusiness_id = '';
		//$this->BusinessFeed->recursive = -1;
		$businessfeed_id ='';
		$feedsArr = $this->BusinessFeed->find('all', array('conditions'=>array('OR'=>array('BusinessFeed.user_id'=>$business_user_id, 'BusinessFeed.group_user_id'=>$business_user_id, 'BusinessFeed.business_id'=>$businessfeed_id, 'BusinessFeed.business_id'=>$Userbusiness_id, 'BusinessFeed.marketting'=>'0'), 'BusinessFeed.status'=>'1'), 'limit'=>PAGING_SIZE, 'order'=>array('BusinessFeed.modified'=>'DESC')));
		//pr($feedsArr);die;

		/*-------- FOR RECOMMENDS POSTING START ------------------*/


		}else{

			$businessSubsArr = $this->BusinessSubscriber->find('all', array('conditions'=>array('BusinessSubscriber.user_id'=>$this->Session->read('Auth.User.User.id'))));
			$businesssubscriberfeed_id = '';
			if(!empty($businessSubsArr)){
				foreach($businessSubsArr as $businessSubs){
				$businesssubscriberfeed_id[] = $businessSubs['BusinessSubscriber']['business_id'];
				}
			}
			//$businesssubscriberfeed_id = '';

			$businessUserIdArr = $this->Business->find('all', array('conditions'=>array('Business.user_id'=>$this->Session->read('Auth.User.User.id'))));
			$business_id = '';
			if(!empty($businessUserIdArr)){
				foreach($businessUserIdArr as $businessUserId){
				$business_id[] = $businessUserId['Business']['id'];
				}
			} //pr($business_id);

			//$businessfeed_id = '';
			$ret = '';
			$feedsArr = $this->BusinessFeed->find('all', array('conditions'=>array('OR'=>array('BusinessFeed.user_id'=>$user_id, 'BusinessFeed.business_id'=>$business_id, 'BusinessFeed.business_id'=>$businesssubscriberfeed_id, 'BusinessFeed.marketting'=>'0'), 'BusinessFeed.status'=>'1'), 'limit'=>PAGING_SIZE, 'order'=>array('BusinessFeed.id'=>'DESC')));
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
		$commentArr = $this->Comment->find('all', array('conditions'=>array('Comment.feed_id'=>$feed_id, 'Comment.status'=>'1')));
		if(!empty($commentArr)){
			$return = $commentArr;
		}
		return $return;
	}
	//FUNCTION FOR FETCH ALL FEEDS COMMENTS END(SAURABH 5/9/2013)


	//FUNCTION FOR COUNT FEED RECOMMENDED START(SAURABH 5/10/2013)
	function fetchFeedRecommended($recommended_id){ //echo $recommended_id;
		App::import('Model', 'Recommended');
		$this->Recommended = new Recommended();

		$count = $this->Recommended->find('count', array('conditions'=>array('Recommended.feed_id'=>$recommended_id, 'Recommended.status'=>'1', 'Recommended.comment_id'=>'')));
		return $count;
	}
	//FUNCTION FOR COUNT FEED RECOMMENDED END(SAURABH 5/10/2013)

	//FUNCTION FOR COUNT FEED RECOMMENDED START(SAURABH 5/10/2013)
	function fetchUserFeed($feed_id, $user_id){ //echo $feed_id.', '.$user_id;
		App::import('Model', 'Recommended');
		$this->Recommended = new Recommended();

		$count = $this->Recommended->find('count', array('conditions'=>array('Recommended.feed_id'=>$feed_id, 'Recommended.user_id'=>$user_id, 'Recommended.status'=>'1', 'Recommended.comment_id'=>'')));
		return $count;
	}
	//FUNCTION FOR COUNT FEED RECOMMENDED END(SAURABH 5/10/2013)

	//FUNCTION FOR FETCH USER IMAGE FOR RECOMMENDED START(SAURABH 5/13/2013)
	function fetchUserImage($feed_id){
		App::import('Model', 'Recommended');
		$this->Recommended = new Recommended();

		$return = '';
		$userImageArr = $this->Recommended->find('all', array('conditions'=>array('Recommended.feed_id'=>$feed_id, 'Recommended.status'=>'1', 'Recommended.comment_id'=>''),'limit'=>'5', 'order'=>array('Recommended.modified'=>'DESC')));
			return $userImageArr;
	}
	//FUNCTION FOR FETCH USER IMAGE FOR RECOMMENDED END(SAURABH 5/13/2013)

	//FUNCTION FOR FETCH OFFER COMMENTS START(SAURABH 5/13/2013)
	function fetchOfferComments($offer_id){
		App::import('Model', 'OfferComment');
		$this->OfferComment = new OfferComment();
		$return = '';
		$commentArr = $this->OfferComment->find('all', array('conditions'=>array('OfferComment.offer_id'=>$offer_id)));
		if(!empty($commentArr)){
			$return = $commentArr;
		}
		return $return;
	}
	//FUNCTION FOR FETCH OFFER COMMENTS END(SAURABH 5/13/2013)

	//FUNCTION FOR FETCH USER IMAGE FOR OFFER RECOMMENDED START(SAURABH 5/13/2013)
	function fetchOfferUserImage($offer_id){
		App::import('Model', 'OfferRecommended');
		$this->OfferRecommended = new OfferRecommended();

		$return = '';
		$userImageArr = $this->OfferRecommended->find('all', array('conditions'=>array('OfferRecommended.offer_id'=>$offer_id, 'OfferRecommended.status'=>'1'),'limit'=>'5', 'order'=>array('OfferRecommended.modified'=>'DESC')));
			return $userImageArr;
	}
	//FUNCTION FOR FETCH USER IMAGE FOR OFFER RECOMMENDED END(SAURABH 5/13/2013)

	//FUNCTION FOR COUNT FEED RECOMMENDED START(SAURABH 5/10/2013)
	function fetchOfferRecommended($offer_id){ //echo $recommended_id;
		App::import('Model', 'OfferRecommended');
		$this->OfferRecommended = new OfferRecommended();

		$count = $this->OfferRecommended->find('count', array('conditions'=>array('OfferRecommended.offer_id'=>$offer_id, 'OfferRecommended.status'=>'1')));
		return $count;
	}
	//FUNCTION FOR COUNT FEED RECOMMENDED END(SAURABH 5/10/2013)

	//FUNCTION FOR COUNT FEED RECOMMENDED START(SAURABH 5/10/2013)
	function fetchUserOffer($offer_id,$user_id){ //echo $recommended_id;
		App::import('Model', 'OfferRecommended');
		$this->OfferRecommended = new OfferRecommended();

		$count = $this->OfferRecommended->find('count', array('conditions'=>array('OfferRecommended.offer_id'=>$offer_id, 'OfferRecommended.user_id'=>$user_id, 'OfferRecommended.status'=>'1')));
		return $count;
	}
	//FUNCTION FOR COUNT FEED RECOMMENDED END(SAURABH 5/10/2013)


	//FUNCTION FOR FETCH DEAL COMMENTS START(SAURABH 5/13/2013)
	function fetchDealComments($deal_id){
		App::import('Model', 'DealComment');
		$this->DealComment = new DealComment();
		$return = '';
		$commentArr = $this->DealComment->find('all', array('conditions'=>array('DealComment.deal_id'=>$deal_id)));
		if(!empty($commentArr)){
			$return = $commentArr;
		}
		return $return;
	}
	//FUNCTION FOR FETCH DEAL COMMENTS END(SAURABH 5/13/2013)

	//FUNCTION FOR FETCH USER IMAGE FOR DEAL RECOMMENDED START(SAURABH 5/13/2013)
	function fetchDealUserImage($deal_id){
		App::import('Model', 'DealRecommended');
		$this->DealRecommended = new DealRecommended();

		$return = '';
		$userImageArr = $this->DealRecommended->find('all', array('conditions'=>array('DealRecommended.deal_id'=>$deal_id, 'DealRecommended.status'=>'1'),'limit'=>'5', 'order'=>array('DealRecommended.modified'=>'DESC')));
			return $userImageArr;
	}
	//FUNCTION FOR FETCH USER IMAGE FOR DEAL RECOMMENDED END(SAURABH 5/13/2013)

	//FUNCTION FOR COUNT DEAL RECOMMENDED START(SAURABH 5/10/2013)
	function fetchDealRecommended($deal_id){ //echo $recommended_id;
		App::import('Model', 'DealRecommended');
		$this->DealRecommended = new DealRecommended();

		$count = $this->DealRecommended->find('count', array('conditions'=>array('DealRecommended.deal_id'=>$deal_id, 'DealRecommended.status'=>'1')));
		return $count;
	}
	//FUNCTION FOR COUNT FEED RECOMMENDED END(SAURABH 5/10/2013)

	//FUNCTION FOR COUNT FEED RECOMMENDED START(SAURABH 5/10/2013)
	function fetchUserDeal($deal_id,$user_id){ //echo $recommended_id;
		App::import('Model', 'DealRecommended');
		$this->DealRecommended = new DealRecommended();

		$count = $this->DealRecommended->find('count', array('conditions'=>array('DealRecommended.deal_id'=>$deal_id, 'DealRecommended.user_id'=>$user_id, 'DealRecommended.status'=>'1')));
		return $count;
	}
	//FUNCTION FOR COUNT FEED RECOMMENDED END(SAURABH 5/10/2013)

	//FUNCTION FOR FETCHING THE RECENT MESSAGES OF ALL SENDERS START
	public function fetchMailsListing(){
		App::import('Model', 'Mail');
		$this->Mail = new Mail();
		
		/*$mailsArr = $this->Mail->find('all', array('fields'=>array('MAX(id) as id', 'Mail.sender_id', 'Mail.message', 'Mail.created'), 'conditions'=>array('Mail.receiver_id'=>$this->Session->read('Auth.User.User.id'), 'Mail.deleted'=>'0', 'Mail.admin_delete'=>'0'), 'group'=>'Mail.sender_id', 'order'=>array('Mail.id'=>'DESC'))); */
		
		$mailsArr = $this->Mail->query("SELECT MAX(id) as id, sender_id, message, `read`, deleted, created FROM fp_mails WHERE receiver_id = '".$this->Session->read('Auth.User.User.id')."' AND deleted = '0' AND admin_delete = '0' GROUP BY sender_id ORDER BY id DESC"); //pr($mailsArr);die;

		return $mailsArr;
	}
	//FUNCTION FOR FETCHING THE RECENT MESSAGES OF ALL SENDERS END

	//FUNCTION FOR FETCHING THE USER DETAILS FOR MESSAGE SECTION START
	public function fetchMessageUserDetails($id){
		App::import('Model', 'User');
		$this->User = new User();
		
		$this->User->recursive = -1;
		$usrArr = $this->User->find('first', array('fields'=>array('User.id', 'User.first_name', 'User.last_name', 'User.gender', 'User.image'), 'conditions'=>array('User.id'=>$id)));
		return $usrArr;
	}
	//FUNCTION FOR FETCHING THE USER DETAILS FOR MESSAGE SECTION END

	//FUNCTION FOR FETCHING THE TOTAL INBOX UNREAD MSGS COUNTER START
	public function countTotalInboxMessages($sender_id=null){
		App::import('Model', 'Mail');
		$this->Mail = new Mail();

		if($sender_id != ''){
			$mailsCount = $this->Mail->find('count', array('conditions'=>array('Mail.sender_id'=>$sender_id, 'Mail.receiver_id'=>$this->Session->read('Auth.User.User.id'), 'Mail.deleted'=>'0', 'Mail.admin_delete'=>'0', 'Mail.read'=>'0')));
		}else{
			$mailsCount = $this->Mail->find('count', array('conditions'=>array('Mail.receiver_id'=>$this->Session->read('Auth.User.User.id'), 'Mail.deleted'=>'0', 'Mail.admin_delete'=>'0', 'Mail.read'=>'0')));
		}
		return $mailsCount;
	}
	//FUNCTION FOR FETCHING THE TOTAL INBOX UNREAD MSGS COUNTER END

	//FUNCTION FOR MARKING THE MESSAGE AS READ START
	public function mark_message_as_read($msg_id){
		App::import('Model', 'Mail');
		$this->Mail = new Mail();

		$saveData['id'] = $msg_id;
		$saveData['read'] = '1';
		$this->Mail->save($saveData, false);
	}
	//FUNCTION FOR MARKING THE MESSAGE AS READ END

	//FUNCTION FOR FETCHING THE RECENT CONVERSATIONS START
	public function fetchRecentConversations(){
		App::import('Model', 'Mail');
		$this->Mail = new Mail();

		$other_recent_member_id = '';

		$or['receiver_id'] = $this->Session->read('Auth.User.User.id');
		$or['sender_id'] = $this->Session->read('Auth.User.User.id');

		$this->Mail->recursive = -1;
		$mailArr = $this->Mail->find('first', array('fields'=>array('Mail.sender_id', 'Mail.receiver_id'), 'conditions'=>array('Mail.deleted'=>'0', 'Mail.admin_delete'=>'0', 'OR'=>$or),  'order'=>array('Mail.modified'=>'DESC')));

		if(!empty($mailArr)){
			$other_recent_member_id = $mailArr['Mail']['sender_id'];
			if($mailArr['Mail']['sender_id'] == $this->Session->read('Auth.User.User.id'))
				$other_recent_member_id = $mailArr['Mail']['receiver_id'];

			echo $other_recent_member_id;die;
		}
	}
	//FUNCTION FOR FETCHING THE RECENT CONVERSATIONS END

	//FUNCTION FOR FETCHING THE USER NAME START
	public function fetchUserName($id){
		App::import('Model', 'User');
		$this->User = new User();

		$ret = '';

		$this->User->recursive = -1;
		$userArr = $this->User->find('first', array('fields'=>array('User.first_name', 'User.last_name'), 'conditions'=>array('User.id'=>$id)));
		if(!empty($userArr))
			$ret = $userArr['User']['first_name'].' '.$userArr['User']['last_name'];

		return $ret;
	}
	//FUNCTION FOR FETCHING THE USER NAME END

	//FUNCTION FOR COUNTING INDIVIDUAL MESSAGES START
	public function countTotalIndividualMessages($other_id){
		App::import('Model', 'Mail');
		$this->Mail = new Mail();

		$or['0']['Mail.receiver_id'] = $other_id;
		$or['0']['Mail.sender_id'] = $this->Session->read('Auth.User.User.id');
		$or['1']['Mail.receiver_id'] = $this->Session->read('Auth.User.User.id');
		$or['1']['Mail.sender_id'] = $other_id;

		$conditions['Mail.deleted'] = '0';
		$conditions['Mail.admin_delete'] = '0';
		$conditions['OR'] = $or; //pr($conditions);die;
		
		$msgCount = $this->Mail->find('count', array('conditions'=>$conditions));
		return $msgCount;
	}
	//FUNCTION FOR COUNTING INDIVIDUAL MESSAGES END

	//FUNCTION FOR FETCHING THE RECENT CONVERSATIONS START
	public function fetchRecentIndividualConversations($other_id, $directory=null){
		App::import('Model', 'Mail');
		$this->Mail = new Mail();

		$or['0']['Mail.receiver_id'] = $other_id;
		$or['0']['Mail.sender_id'] = $this->Session->read('Auth.User.User.id');
		$or['1']['Mail.receiver_id'] = $this->Session->read('Auth.User.User.id');
		$or['1']['Mail.sender_id'] = $other_id;

		/* $conditions['Mail.deleted'] = '0';
		$conditions['Mail.admin_delete'] = '0'; */

		if($directory != '')
			$conditions['Mail.folder_id'] = $directory; // for custom directory
		else
			$conditions['Mail.folder_id'] = '1'; // for inbox
		$conditions['OR'] = $or; //pr($conditions);die;
		
		$this->Mail->unbindModel(array('belongsTo'=>array('Receiver')));
		$msgArr = $this->Mail->find('all', array('conditions'=>$conditions, 'order'=>array('Mail.modified'=>'DESC')));
		return $msgArr;
	}
	//FUNCTION FOR FETCHING THE RECENT CONVERSATIONS END

	//FUNCTION FOR FETCHING THE USER DETAILS START
	public function fetchUserDetails($id){
		App::import('Model', 'User');
		$this->User = new User();

		$ret = '';

		$this->User->recursive = -1;
		$userArr = $this->User->find('first', array('conditions'=>array('OR'=>array('User.id'=>$id, 'User.username'=>$id))));
		return $userArr;
	}
	//FUNCTION FOR FETCHING THE USER DETAILS END

	//FUNCTION FOR FETCHING THE ATTACHMENTS DETAILS START
	public function fetchAttachmentDetails($id){
		App::import('Model', 'Attachment');
		$this->Attachment = new Attachment();

		$ret = '';

		$attaArr = $this->Attachment->findById($id);
		if(!empty($attaArr))
			$ret = $attaArr;
		return $ret;
	}
	//FUNCTION FOR FETCHING THE ATTACHMENTS DETAILS END

	//FUNCTION FOR FETCHING THE DIRECTORY DATA START
	public function fetchDirectoryData($other_id, $folder_id){
		App::import('Model', 'Mail');
		$this->Mail = new Mail();

		$or['0']['Mail.receiver_id'] = $other_id;
		$or['0']['Mail.sender_id'] = $this->Session->read('Auth.User.User.id');
		$or['1']['Mail.receiver_id'] = $this->Session->read('Auth.User.User.id');
		$or['1']['Mail.sender_id'] = $other_id;

		$conditions['Mail.folder_id'] = $folder_id; // for inbox
		$conditions['OR'] = $or; //pr($conditions);die;
		
		$this->Mail->unbindModel(array('belongsTo'=>array('Receiver')));
		$msgArr = $this->Mail->find('all', array('conditions'=>$conditions, 'order'=>array('Mail.modified'=>'ASC')));
		return $msgArr;
	}
	//FUNCTION FOR FETCHING THE DIRECTORY DATA START

	//FUNCTION FOR FETCHING THE CUSTOM DIRECTORIES START
	public function fetchCustomDirectories(){
		App::import('Model', 'Folder');
		$this->Folder = new Folder();

		$ret = '';
		$foldersArr = $this->Folder->find('list', array('fields'=>array('Folder.id', 'Folder.name'), 'conditions'=>array('Folder.user_id'=>$this->Session->read('Auth.User.User.id'))));
		if(!empty($foldersArr))
			$ret = $foldersArr;
		return $ret;
	}
	//FUNCTION FOR FETCHING THE CUSTOM DIRECTORIES END

	//FUNCTION FOR FETCHING THE OTHER DIRECTORIES START
	public function fetchUserDirectories($openDirectory){
		App::import('Model', 'Folder');
		$this->Folder = new Folder();

		//$ret = '<option value="">'.$openDirectory.'</option>';
		$ret = '<option value="">Select</option>';

		//first fetch the reserved folders
		$reservedArr = $this->Folder->find('list', array('fields'=>array('Folder.id', 'Folder.name'), 'conditions'=>array('Folder.user_id'=>'', 'Folder.id <>'=>$openDirectory)));
		if(!empty($reservedArr)){
			foreach($reservedArr as $id => $val){
				$ret .= '<option value="'.$id.'">'.$val.'</option>';
			}
		}

		$foldersArr = $this->Folder->find('list', array('fields'=>array('Folder.id', 'Folder.name'), 'conditions'=>array('Folder.user_id'=>$this->Session->read('Auth.User.User.id'), 'Folder.id <>'=>$openDirectory)));
		if(!empty($foldersArr)){
			foreach($foldersArr as $id => $val){
				$ret .= '<option value="'.$id.'">'.$val.'</option>';
			}
		}

		return $ret;
	}
	//FUNCTION FOR FETCHING THE OTHER DIRECTORIES END

	//FUNCTION FOR FETCHING THE PARTICULAR MESSAGES START
	public function fetchForwardedMessages($ids){
		App::import('Model', 'Mail');
		$this->Mail = new Mail();

		$expArr = explode(',', $ids['Mail']['forwarded_ids']);

		$this->Mail->unbindModel(array('belongsTo'=>array('Receiver')));
		$msgArr = $this->Mail->find('all', array('conditions'=>array('Mail.id'=>$expArr)));
		return $msgArr;
	}
	//FUNCTION FOR FETCHING THE PARTICULAR MESSAGES END

	//FUNCTION FOR COUNT GROUP USER START(SAURABH 5/15/2013)
	function countGroup(){
		App::import('Model', 'Group');
		$this->Group = new Group();

		$count = $this->Group->find('count', array('counditions'=>array('Group.user_id'=>$this->Session->read('Auth.User.User.id'), 'Group.status'=>'1')));
		return $count;
	}
	//FUNCTION FOR COUNT GROUP USER END(SAURABH 5/15/2013)

	//FUNCTION FOR COUNT GROUP MEMBER START(SAURABH 6/1/2013)
	function countGroupMember(){
		App::import('Model', 'Group');
		$this->Group = new Group();

		$count = $this->Group->find('all', array('fields'=>array('SUM(Group.subscribe_users) as group_member'), 'conditions'=>array('Group.status'=>'1')));
		if(!empty($count)){
				$count = $count[0][0]['group_member'];
			}
		return $count;
	}
	//FUNCTION FOR COUNT GROUP MEMBER END(SAURABH 6/1/2013)

	//FUNCTION FOR COUNT GROUP INTERSTED USER START(SAURABH 5/15/2013)
	function countGroupIntersted(){
		App::import('Model', 'GroupRecommend');
		$this->GroupRecommend = new GroupRecommend();

		$count = $this->GroupRecommend->find('count', array('counditions'=>array('GroupRecommend.status'=>'1')));
		return $count;
	}
	//FUNCTION FOR COUNT GROUP INTERSTED USER END(SAURABH 5/15/2013)

	//FUNCTION FOR COUNT GROUP CITY USER START(SAURABH 5/15/2013)
	function countGroupCity(){
		App::import('Model', 'Group');
		App::import('Model', 'User');
		$this->Group = new Group();
		$this->User = new User();

		$groupArr = $this->Group->find('all', array('fields'=>array('Group.id', 'Group.user_id'), 'counditions'=>array('Group.status'=>'1'), 'group'=>'Group.user_id'));
			$group_user_id = '';
			foreach($groupArr as $group){
				$group_user_id[] = $group['Group']['user_id'];
			}
			$count = $this->User->find('count', array('fields'=>array('User.id', 'User.city'), 'conditions'=>array('User.id'=>$group_user_id, 'User.city <>'=>''), 'group'=>'User.city'));
		return $count;
	}
	//FUNCTION FOR COUNT GROUP CITY USER END(SAURABH 5/15/2013)

	//FUNCTION FOR FETCH GROUP USER ID START(SAURABH 5/15/2013)
	function groupUserId(){
		App::import('Model', 'Group');
		$this->Group = new Group();

		$ret = '';
		$this->Group->recursive = -1;
		$groupArr = $this->Group->find('first', array('conditions'=>array('Group.user_id'=>$this->Session->read('Auth.User.User.id'))));
		if(!empty($groupArr)){
			if($groupArr['Group']['id'] != '')
				$ret = $groupArr['Group']['id'];
		}
		return $ret;
	}
	//FUNCTION FOR FETCH GROUP USER ID END(SAURABH 5/15/2013)

	//FUNCTION FOR FETCH USER ABOUT US DETAILS START(SAURABH 5/15/2013)
	function groupUserAboutUs($group_id){
		App::import('Model', 'Group');
		$this->Group = new Group();

		$ret = '';
		$groupAboutArr = $this->Group->find('first', array('conditions'=>array('Group.id'=>$group_id, 'Group.user_id'=>$this->Session->read('Auth.User.User.id'))));
		if(!empty($groupAboutArr)){
			if($groupAboutArr['Group']['description'] != '')
				$ret = $groupAboutArr['Group']['description'];
		}
		return $ret;
	}
	//FUNCTION FOR FETCH USER ABOUT US DETAILS END(SAURABH 5/15/2013)

	//FUNCTION TO FETCH THE POPULAR GROUPS START
	public function fetchPopularGroups(){
		App::import('Model', 'Group');
		$this->Group = new Group();

		$ret = '';
		$groupArr = $this->Group->find('all', array('conditions'=>array('Group.user_id'=>$this->Session->read('Auth.User.User.id')), 'order'=>array('Group.modified'=>'DESC'), 'limit'=>3));
		if(!empty($groupArr))
			$ret = $groupArr;
		return $ret;
	}
	//FUNCTION TO FETCH THE POPULAR GROUPS END

	//FUNCTION FOR FETCH RECENT GALLERY GROUP IMAGE START(SAURABH 5/16/2013)
	function fetchRecentGroupImage($group_id){
		App::import('Model', 'GroupGallery');
		$this->GroupGallery = new GroupGallery();
		$user_id = $this->Session->read('Auth.User.User.id');

		$return = '';
		$recentsArr = $this->GroupGallery->find('all', array('conditions'=>array('GroupGallery.group_id'=>$group_id, 'GroupGallery.user_id'=>$user_id, 'GroupGallery.status'=>'1')));
		if(!empty($recentsArr)){
			$return = $recentsArr;
		}
		return $return;
	}
	//FUNCTION FOR FETCH RECENT GALLERY GROUP IMAGE END(SAURABH 5/16/2013)

	//FUNCTION FOR FETCHING THE GROUP VIDEOS START 5/17/2013
	public function fetchGroupVideos($id){
		App::import('Model', 'GroupGallery');
		$this->GroupGallery = new GroupGallery();

		$videoArr = $this->GroupGallery->find('all', array('fields'=>array('GroupGallery.id', 'GroupGallery.video'), 'conditions'=>array('GroupGallery.group_id'=>$id, 'GroupGallery.status'=>'1'), 'limit'=>PAGING_SIZE, 'order'=>array('GroupGallery.id'=>'ASC')));
		return $videoArr;
	}
	//FUNCTION FOR FETCHING THE GROUP VIDEOS END 5/17/2013

	//FUNCTION FOR FETCHING THE PHOTOS SECTION START 5/18/2013
	public function fetchAlbumPhotos($grpId, $albmId){
		App::import('Model', 'GroupGallery');
		$this->GroupGallery = new GroupGallery();

		$ret = '';

		$this->GroupGallery->recursive = -1;
		$grpArr = $this->GroupGallery->find('all', array('conditions'=>array('GroupGallery.group_id'=>$grpId, 'GroupGallery.album_id'=>$albmId, 'GroupGallery.image <>'=>''), 'limit'=>PAGING_SIZE, 'order'=>array('GroupGallery.id'=>'ASC')));
		return $grpArr;
	}
	//FUNCTION FOR FETCHING THE PHOTOS SECTION END 5/18/2013
	
	//FUNCTION FOR FETCHING THE ALBUMS START 5/20/2013
	public function fetchGroupsAlbums($grpId){
		App::import('Model', 'GroupAlbum');
		$this->GroupAlbum = new GroupAlbum();

		$ret = '';

		$this->GroupAlbum->recursive = -1;
		$grpArr = $this->GroupAlbum->find('all', array('conditions'=>array('GroupAlbum.group_id'=>$grpId, 'GroupAlbum.status'=>'1'), 'limit'=>PAGING_SIZE, 'order'=>array('GroupAlbum.id'=>'ASC')));
		if(!empty($grpArr))
			$ret = $grpArr;
		return $ret;
	}
	//FUNCTION FOR FETCHING THE ALBUMS END 5/20/2013

	//FUNCTION FOR COUNTING THE ALBUM PHOTOS START
	public function countAlbumPhotos($album_id){
		App::import('Model', 'GroupGallery');
		$this->GroupGallery = new GroupGallery();

		$ret = '';

		$grpCount = $this->GroupGallery->find('count', array('conditions'=>array('GroupGallery.album_id'=>$album_id, 'GroupGallery.status'=>'1')));
		return $grpCount;
	}
	//FUNCTION FOR COUNTING THE ALBUM PHOTOS END

/********** UPDATE 21 MAY By SAURABH Start ***********/

	//FUNCTION FOR FETCH RECENTLY UPDATE BUSINESS START(SAURABh 5/18/2013)
	function recentlyUpdateBusiness(){
		App::import('Model', 'Business');
		$this->Business = new Business();
		$user_Id = $this->Session->read('Auth.User.User.id');

		$ret = '';
		/*$recentBusinessArr = $this->Business->find('all', array('conditions'=>array('OR'=>array('Business.user_id'=>'', 'Business.user_id <>'=>$user_Id),'Business.status'=>'1'), 'order'=>array('Business.id'=>'DESC')));*/

		$recentBusinessArr = $this->Business->find('all', array('conditions'=>array('Business.status'=>'1'), 'limit'=>'5', 'order'=>array('Business.modified'=>'DESC')));

		if(!empty($recentBusinessArr)){
			$ret = $recentBusinessArr;
		}
		return $ret;
	}
	//FUNCTION FOR FETCH RECENTLY UPDATE BUSINESS END(SAURABH 5/18/2013)

	//FUNCTION FOR FETCH FEATURED BUSINESS START(SAURABh 6/1/2013)
	function featuredBusiness(){
		App::import('Model', 'Business');
		$this->Business = new Business();
		$user_Id = $this->Session->read('Auth.User.User.id');

		$ret = '';
		$featuredBusinessArr = $this->Business->find('all', array('conditions'=>array('Business.featured'=>'1', 'Business.status'=>'1'), 'order'=>array('Business.id'=>'DESC')));
		if(!empty($featuredBusinessArr)){
			$ret = $featuredBusinessArr;
		}
		return $ret;
	}
	//FUNCTION FOR FETCH FEATURED BUSINESS END(SAURABH 6/1/2013)

	//FUNCTION FOR FETCH USER IMAGE FOR BUSINESS RECOMMENDED START(SAURABH 5/13/2013)
	function fetchBusinessUserImage($business_id){
		App::import('Model', 'BusinessRecommend');
		$this->BusinessRecommend = new BusinessRecommend();

		$return = '';
		$this->BusinessRecommend->unbindModel(array('belongsTo'=>array('Business')));
		$businessuserImageArr = $this->BusinessRecommend->find('all', array('conditions'=>array('BusinessRecommend.business_id'=>$business_id, 'BusinessRecommend.status'=>'1'), 'group'=>array('BusinessRecommend.user_id'),'limit'=>'8', 'order'=>array('BusinessRecommend.modified'=>'DESC')));
		//pr($businessuserImageArr);die;
		return $businessuserImageArr;
	}
	//FUNCTION FOR FETCH USER IMAGE FOR BUSINESS RECOMMENDED END(SAURABH 5/13/2013)

	//FUNCTION FOR FETCH ALL BUSINESS STATE START(SAURABH 5/17/2013)
	public function fetchAllBusinessCity(){
		App::import('Model', 'Business');
		$this->Business = new Business();
		$ret = '';

		$cityArr = $this->Business->find('list', array('fields'=>array('Business.id', 'Business.city'), 'group'=>array('Business.city')));
		if(!empty($cityArr))
			$ret = $cityArr;
		return $ret;
	}
	//FUNCTION FOR FETCH ALL BUSINESS STATE END(SAURABH 5/17/2013)

	//FUNCTION FOR CHECKING WHETHER THE LOGGED IN USER HAS ALREADY GROUP OR NOT START(SAURABH 5/20/2013)
	public function validateUserForGroup($group_id){  
		App::import('Model', 'Group');
		$this->Group = new Group();

		$ret = '';

		$groupArr = $this->Group->find('first', array('conditions'=>array('Group.id'=>$group_id)));
		if(!empty($groupArr)){
			if($groupArr['Group']['user_id'] != '')
				$ret = $groupArr['Group']['user_id'];
		}
		return $ret;
	}
	//FUNCTION FOR CHECKING WHETHER THE LOGGED IN USER HAS ALREADY GROUP OR NOT END (SAURABh 5/20/2013)

	//FUNCTION FOR FETCH USER IMAGE FOR EVENT RECOMMENDED START(SAURABH 5/20/2013)
	function fetchEventUserImage($event_id){
		App::import('Model', 'EventRecommended');
		$this->EventRecommended = new EventRecommended();

		$return = '';
		$userImageArr = $this->EventRecommended->find('all', array('conditions'=>array('EventRecommended.event_id'=>$event_id, 'EventRecommended.status'=>'1'),'limit'=>'5', 'order'=>array('EventRecommended.modified'=>'DESC')));
			return $userImageArr;
	}
	//FUNCTION FOR FETCH USER IMAGE FOR EVENT RECOMMENDED END(SAURABH 5/20/2013)

	//FUNCTION FOR COUNT EVENT RECOMMENDED START(SAURABH 5/20/2013)
	function fetchEventRecommended($event_id){ //echo $recommended_id;
		App::import('Model', 'EventRecommended');
		$this->EventRecommended = new EventRecommended();

		$count = $this->EventRecommended->find('count', array('conditions'=>array('EventRecommended.event_id'=>$event_id, 'EventRecommended.status'=>'1')));
		return $count;
	}
	//FUNCTION FOR COUNT EVENT RECOMMENDED END(SAURABH 5/20/2013)

	//FUNCTION FOR COUNT EVENT RECOMMENDED START(SAURABH 5/20/2013)
	function fetchUserEvent($event_id,$user_id){ //echo $recommended_id;
		App::import('Model', 'EventRecommended');
		$this->EventRecommended = new EventRecommended();

		$count = $this->EventRecommended->find('count', array('conditions'=>array('EventRecommended.event_id'=>$event_id, 'EventRecommended.user_id'=>$user_id, 'EventRecommended.status'=>'1')));
		return $count;
	}
	//FUNCTION FOR COUNT EVENT RECOMMENDED END(SAURABH 5/20/2013)

	//FUNCTION FOR FETCH EVENT COMMENTS START(SAURABH 5/20/2013)
	function fetchEventComments($event_id){
		App::import('Model', 'EventComment');
		$this->EventComment = new EventComment();
		$return = '';
		$commentArr = $this->EventComment->find('all', array('conditions'=>array('EventComment.event_id'=>$event_id)));
		if(!empty($commentArr)){
			$return = $commentArr;
		}
		return $return;
	}
	//FUNCTION FOR FETCH EVENT COMMENTS END(SAURABH 5/20/2013)

	//FUNCTION FOR FETCHING THE GROUP SUBSCRIBERS START
	public function fetchGroupSubscribers($group_id){ //echo $business_id;die;
			App::import('Model', 'GroupSubscriber');
			$this->GroupSubscriber  = new GroupSubscriber();

			$subscribersArr = $this->GroupSubscriber->find('all',  array('fields'=>array('User.id', 'User.first_name', 'User.last_name', 'User.image', 'User.gender', 'User.username'), 'conditions'=>array('GroupSubscriber.group_id'=>$group_id, 'GroupSubscriber.status'=>'1'), 'limit'=>12, 'order'=>array('GroupSubscriber.id'=>'DESC')));

			return $subscribersArr;
	}
	//FUNCTION FOR FETCHING THE GROUP SUBSCRIBERS END

	//FUNCTION FOR FETCHING THE BUSINESS OWNER START
	public function fetchGroupOwner($group_id){
		App::import('Model', 'Group');
		$this->Group = new Group();

		$ret = '';
		
		$businessArr = $this->Group->find('first', array('fields'=>array('Group.user_id'), 'conditions'=>array('Group.id'=>$group_id)));
		if(!empty($businessArr))
			$ret = $businessArr['Group']['user_id'];
		return $ret;
	}
	//FUNCTION FOR FETCHING THE BUSINESS OWNER END

	//FUNCTION FOR VALIDATING THE SUBSCRIBER FOR A CORRESPONDING USER START
	public function validateSubscribedGroup($group_id){
		App::import('Model', 'GroupSubscriber');
		$this->GroupSubscriber = new GroupSubscriber();

		$subscribeCount = $this->GroupSubscriber->find('count', array('conditions'=>array('GroupSubscriber.group_id'=>$group_id, 'GroupSubscriber.user_id'=>$this->Session->read('Auth.User.User.id'), 'GroupSubscriber.status'=>'1')));

		return $subscribeCount;
	}
	//FUNCTION FOR VALIDATING THE SUBSCRIBER FOR A CORRESPONDING USER END

	//FUNCTION FOR FETCH USER IMAGE FOR GROUP RECOMMENDED START(SAURABH 5/20/2013)
	function fetchGroupUserImage($group_id){
		App::import('Model', 'GroupRecommend');
		$this->GroupRecommend = new GroupRecommend();

		$return = '';
		$groupuserImageArr = $this->GroupRecommend->find('all', array('conditions'=>array('GroupRecommend.group_id'=>$group_id, 'GroupRecommend.status'=>'1'), 'group'=>array('GroupRecommend.user_id'),'limit'=>'8', 'order'=>array('GroupRecommend.modified'=>'DESC')));
			return $groupuserImageArr;
	}
	//FUNCTION FOR FETCH USER IMAGE FOR GROUP RECOMMENDED END(SAURABH 5/20/2013)

	//FUNCTION FOR FETCH USER IMAGE FOR BUSINESS RECOMMENDED START(SAURABH 5/20/2013)
	function fetchCountGroupRecommend($group_id){
		App::import('Model', 'GroupRecommend');
		$this->GroupRecommend = new GroupRecommend();
		$user_Id = $this->Session->read('Auth.User.User.id');
		$return = '';
		$countUserRecoArr = $this->GroupRecommend->find('count', array('conditions'=>array('GroupRecommend.group_id'=>$group_id, 'GroupRecommend.user_id'=>$user_Id, 'GroupRecommend.status'=>'1')));
			return $countUserRecoArr;
	}
	//FUNCTION FOR FETCH USER IMAGE FOR BUSINESS RECOMMENDED END(SAURABH 5/20/2013)

	//FUNCTION FOR FETCH USER GROUP RECENT FEED DATA START(SAURABH 5/21/2013)
	function fetchGroupsRecentFeeds($group_id){
		App::import('Model', 'BusinessFeed');
		App::import('Model', 'GroupSubscriber');	
		$this->BusinessFeed = new BusinessFeed();
		$this->GroupSubscriber = new GroupSubscriber();

		$return = '';
		$groupsArr = $this->GroupSubscriber->find('all', array('conditions'=>array('GroupSubscriber.group_id'=>$group_id, 'GroupSubscriber.status'=>'1')));
		$group_user_id = '';
		foreach($groupsArr as $group){
			$group_user_id[] = $group['GroupSubscriber']['user_id'];
		}
		
		$feedsArr = $this->BusinessFeed->find('all', array('conditions'=>array('OR'=>array('BusinessFeed.group_user_id'=>$group_user_id, 'BusinessFeed.group_user_id'=>$this->Session->read('Auth.User.User.id')), 'BusinessFeed.status'=>'1')));
		if(!empty($feedsArr)){
			$return = $feedsArr;
		}
		return $return;
	}
	//FUNCTION FOR FETCH USER GROUP RECENT FEED DATA END(SAURABH 5/21/2013)

	//FUNCTION FOR FETCH ALL FEEDS COMMENTS END(SAURABH 5/9/2013)
	function fetchAllGroupComments($group_id){
		App::import('MOdel', 'GroupComment');
		$this->GroupComment = new GroupComment();
		
		$return = '';
		$commentArr = $this->GroupComment->find('all', array('conditions'=>array('GroupComment.feed_id'=>$group_id)));
		if(!empty($commentArr)){
			$return = $commentArr;
		}
		return $return;
	}

	//FUNCTION FOR FETCH USER IMAGE FOR BUSINESS RECOMMENDED START(SAURABH 5/13/2013)
	function fetchCountBusinessRecommend($business_id){
		App::import('Model', 'BusinessRecommend');
		$this->BusinessRecommend = new BusinessRecommend();
		$user_Id = $this->Session->read('Auth.User.User.id');
		$return = '';
		$countBusinnessRecoArr = $this->BusinessRecommend->find('count', array('conditions'=>array('BusinessRecommend.business_id'=>$business_id, 'BusinessRecommend.user_id'=>$user_Id, 'BusinessRecommend.status'=>'1')));
			return $countBusinnessRecoArr;
	}
	//FUNCTION FOR FETCH USER IMAGE FOR BUSINESS RECOMMENDED END(SAURABH 5/13/2013)

	//FUNCTION FOR FETCH BUSINESS RECOMMENDED START(SAURABH 5/13/2013)
	function fetchCountTotalBusinessRecommend($business_id){
		App::import('Model', 'BusinessRecommend');
		$this->BusinessRecommend = new BusinessRecommend();
		$return = '';
		$countBusinnessRecoArr = $this->BusinessRecommend->find('count', array('conditions'=>array('BusinessRecommend.business_id'=>$business_id, 'BusinessRecommend.status'=>'1')));
			return $countBusinnessRecoArr;
	}
	//FUNCTION FOR FETCH BUSINESS RECOMMENDED(SAURABH 5/13/2013)

	//FUNCTION FOR FETCH ALL FEEDS COMMENTS END(SAURABH 5/9/2013)


	//FUNCTION FOR FETCH ALL BUSINESS CATEGORY START(SAURABh 5/22/2013)
	function fetchAllBusinessCategories(){
		App::import('Model', 'Category');
		$this->Category = new Category();
		$ret = '';
		$categoryArr = $this->Category->find('all', array('conditions'=>array('Category.parent_id'=>'0', 'Category.status'=>'1'), 'limit'=>'25'));
		if(!empty($categoryArr)){
			return $categoryArr;
		}
	}
	//FUNCTION FOR FETCH ALL BUSINESS CATEGORY END(SAURABh 5/22/2013)

	//FUNCTION FOR FETCH BUSINESS CITY FOR HEADER SEARCH START(SAURABH 5/23/2013)
	function fetchBusinessCity(){
		App::import('Model', 'Business');
		$this->Business = new Business();
		$ret = '';
		$locationArr = $this->Business->find('all', array('fields'=>array('Business.id', 'Business.city'), 'conditions'=>array('Business.status'=>'1'), 'group'=>'Business.city'));
		if(!empty($locationArr)){ 
			return $locationArr;
		}
	}
	//FUNCTION FOR FETCH BUSINESS CITY FOR HEADER SEARCH END(SAURABH 5/23/2013)

/********** UPDATE 21 MAY By SAURABH End ***********/

/*------------------ 21 MAY 2013 ------------------------------*/
	//FUNCTION FOR SHOWING THE ALBUM DATA START
	public function ShowAlbumData($album_id){
		App::import('Model', 'GroupGallery');
		$this->GroupGallery = new GroupGallery();

		//$this->GroupGallery->recursive = -1;
		$this->GroupGallery->unbindModel(array('belongsTo'=>array('User')));
		$gallArr = $this->GroupGallery->find('all', array('conditions'=>array('GroupGallery.album_id'=>$album_id, 'GroupGallery.status'=>'1'), 'limit'=>'1'));
		return $gallArr;
	}

	public function ShowAlbumData_one($album_id){
		App::import('Model', 'GroupGallery');
		$this->GroupGallery = new GroupGallery();

		//$this->GroupGallery->recursive = -1;
		$this->GroupGallery->unbindModel(array('belongsTo'=>array('Group', 'User')));
		$gallArr = $this->GroupGallery->find('first', array('conditions'=>array('GroupGallery.album_id'=>$album_id, 'GroupGallery.status'=>'1')));
		return $gallArr;
	}
	//FUNCTION FOR SHOWING THE ALBUM DATA END
	/*------------------ 21 MAY 2013 ------------------------------*/

	//FUNCTION FOR FETCHING THE REFFERAL PAYMENTS START 5/22/2013
	public function fetchRefferalPayments(){
		App::import('Model', 'ReferralPayment');
		$this->ReferralPayment = new ReferralPayment();

		$ret = '';

		$refpayment = $this->ReferralPayment->find('all', array('fields'=>array('SUM(ReferralPayment.amount) as payment'), 'conditions'=>array('ReferralPayment.inviter_id'=>$this->Session->read('Auth.User.User.id'))));
		if(!empty($refpayment))
			$ret = $refpayment[0][0]['payment'];
		return $ret;
	}
	//FUNCTION FOR FETCHING THE REFFERAL PAYMENTS END 5/22/2013

	//FUNCTION FOR FETCHING THE ADDRESSES FOR THE GROUPS START 5/23/2013
	public function fetch_group_locations(){
		App::import('Model', 'Group');
		$this->Group = new Group();

		$ret = '';

		$this->Group->unbindModel(array('hasMany'=>array('GroupGallery', 'GroupBanner')));
		$grpArr = $this->Group->find('all', array('fields'=>array('Group.id', 'Group.title', 'Group.alias_name', 'User.city', 'User.state', 
		'User.country'), 'conditions'=>array('Group.status'=>'1')));
		if(!empty($grpArr)){
			$count = 0;
			foreach($grpArr as $grp){ //pr($grp);die;
				$ret[$count]['id'] = $grp['Group']['id'];
				$ret[$count]['title'] = $grp['Group']['title'];
				$ret[$count]['alias_name'] = $grp['Group']['alias_name'];
				$ret[$count]['city'] = $grp['User']['city'];
				$ret[$count]['state'] = $grp['User']['state'];
				$ret[$count]['country'] = $grp['User']['country'];
				$count++;
			}
		} //pr($ret);die;

		return $ret;
	}
	//FUNCTION FOR FETCHING THE ADDRESSES FOR THE GROUPS END 5/23/2013

	//FUNCTION FOR FETCHING THE MEMBERSHIP PLAN START 5/24/2013
	public function fetchMembershipPlan($businerss_id){
		App::import('Model', 'PurchasedMembership');
		$this->PurchasedMembership = new PurchasedMembership();

		$ret = 'hide';

		$this->PurchasedMembership->recursive = -1;
		$businessArr = $this->PurchasedMembership->find('first', array('conditions'=>array('PurchasedMembership.business_id'=>$businerss_id), 'limit'=>1, 'order'=>array('PurchasedMembership.id'=>'DESC'))); //pr($businessArr);die;
		if(!empty($businessArr)){
			//first, check the expiration date
			$todayDate = strtotime(date('Y-m-d'));
			$expiryDate = strtotime(date('Y-m-d', strtotime($businessArr['PurchasedMembership']['expires_on'])));

			if($todayDate <= $expiryDate){
				//check for membership plan,
				if($businessArr['PurchasedMembership']['membership_id'] != 4)
					$ret = 'show';
			}else
				$ret = 'show';
		}
		return $ret;
	}
	//FUNCTION FOR FETCHING THE MEMBERSHIP PLAN END   5/24/2013

	//FUNCTION FOR AUTHENTICATING THE SOCIAL MEDIA ICONS START
	public function authticateSocialAccounts(){ //pr($this->Session->read('Auth.User.User'));die;
		$twitter = '';
		$facebook = '';
		//for twitter validation start
		/*if(($this->Session->read('Auth.User.User.twitter_oauth_token') != '') && ($this->Session->read('Auth.User.User.twitter_oauth_verifier') != '')){
			$twitter = 'authenticated';
		} */
		if($this->Session->read('Auth.User.User.social_twitter') == '1'){
			$twitter = 'authenticated';
		}
		//for twitter validation end

		//for facebook start
		/* if($this->Session->read('Auth.User.User.facebook_oauth_token') != ''){
			$facebook = 'authenticated';
		} */
		if($this->Session->read('Auth.User.User.social_facebook') == '1'){
			$facebook = 'authenticated';
		}
		//for facebook end

		$ret = array('twitter'=>$twitter, 'facebook'=>$facebook);
		return $ret;
	}
	//FUNCTION FOR AUTHENTICATING THE SOCIAL MEDIA ICONS END

	//FUNCTION FOR FETCHING THE MEMBERSHIPS PACKAGES START
	public function fetchMembershipPackages(){
		App::import('Model', 'Membership');
		$this->Membership = new Membership();

		$membrArr = $this->Membership->find('all');
		return $membrArr;
	}
	//FUNCTION FOR FETCHING THE MEMBERSHIPS PACKAGES END

	//FUNCTION FOR FETCHING THE MEMBERSHIP PLAN START 5/31/2013
	public function fetchBusinessMembershipPlan($businerss_id){
		App::import('Model', 'PurchasedMembership');
		$this->PurchasedMembership = new PurchasedMembership();

		/* $ret = '1';

		$this->PurchasedMembership->recursive = -1;
		$businessArr = $this->PurchasedMembership->find('first', array('conditions'=>array('PurchasedMembership.business_id'=>$businerss_id), 'limit'=>1, 'order'=>array('PurchasedMembership.id'=>'DESC'))); //pr($businessArr);die;
		if(!empty($businessArr)){
			//first, check the expiration date
			$todayDate = strtotime(date('Y-m-d'));
			$expiryDate = strtotime(date('Y-m-d', strtotime($businessArr['PurchasedMembership']['expires_on'])));

			if($todayDate <= $expiryDate){
				$ret = $businessArr['PurchasedMembership']['membership_id'];
			}
		}
		return $ret; */

		$ret = '0';

		$this->PurchasedMembership->recursive = -1;
		$businessArr = $this->PurchasedMembership->find('first', array('conditions'=>array('PurchasedMembership.business_id'=>$businerss_id), 'limit'=>1, 'order'=>array('PurchasedMembership.id'=>'DESC'))); //pr($businessArr);die;
		if(!empty($businessArr)){
			//first, check the expiration date
			$todayDate = strtotime(date('Y-m-d'));
			$expiryDate = strtotime(date('Y-m-d', strtotime($businessArr['PurchasedMembership']['expires_on'])));

			if($todayDate <= $expiryDate){
				$ret = $businessArr['PurchasedMembership']['membership_id'];
			}else{
				$ret = '1';
			}
		}
		return $ret;
	}

	public function fetchSupportContact(){
		App::import('Model', 'SupportContact');
		$this->SupportContact = new SupportContact();

		$ret = '';
		$supportArr = $this->SupportContact->findById('1');
		if(!empty($supportArr))
			$ret = $supportArr['SupportContact']['phone'];
		return $ret;
	}
	//FUNCTION FOR FETCHING THE MEMBERSHIP PLAN END   5/31/2013

	//FUNCTION FOR SHOWING THE EMAIL PROVIDERS START
	public function fetchEmailProviders(){
		$providers = array('aol'=>'AOL', 'plaxo'=>'Plaxo', 'rediff'=>'Rediff', 'terra'=>'Terra', 'walla'=>'Walla', 'xing'=>'Xing', 'zapak'=>'Zapak');
		return $providers;
	}
	//FUNCTION FOR SHOWING THE EMAIL PROVIDERS END

	//FUNCTION FOR FETCHING THE MARKETTING POSTS AVAILABILITY FOR BUSINESS START 6/5/2013
	public function fetchMarkettingAvailable($business_id, $business_plan){
		Controller::loadModel('PurchasedMembership');
		Controller::loadModel('Membership');
		$this->PurchasedMembership = new PurchasedMembership();
		$this->Membership = new Membership();

		$available = 'no';

		//find the total provided feeds
		$this->Membership->recursive = -1;
		$availableFiedsArr = $this->Membership->find('first', array('fields'=>array('Membership.advertising_feeds'), 'conditions'=>array('Membership.id'=>$business_plan)));
		$availableFieds = $availableFiedsArr['Membership']['advertising_feeds'];

		//fetch the date of purchase of membership plan
		$this->PurchasedMembership->recursive = -1;
		$purchasedDateArr = $this->PurchasedMembership->find('first', array('conditions'=>array('PurchasedMembership.business_id'=>$business_id, 'PurchasedMembership.membership_id'=>$business_plan), 'order'=>array('PurchasedMembership.id'=>'DESC'), 'limit'=>1));
		$purchasedDate = date('Y-m-d', strtotime($purchasedDateArr['PurchasedMembership']['purchased_on']));

		//fetch the total Used marketting feeds
		Controller::loadModel('BusinessFeed');
		$this->BusinessFeed = new BusinessFeed();

		$usedFeeds = $this->BusinessFeed->find('count', array('conditions'=>array('BusinessFeed.business_id'=>$business_id, 'BusinessFeed.marketting'=>'1', 'DATE(BusinessFeed.created) >='=>$purchasedDate)));

		//check for used feeds & calculate availability
		if($availableFieds > $usedFeeds)
			$available = 'yes';
		return $available;
	}
	//FUNCTION FOR FETCHING THE MARKETTING POSTS AVAILABILITY FOR BUSINESS END   6/5/2013

	//FETCH THE BUSINESS DETAILS SATRT
	public function fetchBusinessDetails($id){
		Controller::loadModel('Business');
		$this->Business = new Business();

		$this->Business->recursive = -1;
		return $this->Business->findById($id);
	}
	//FETCH THE BUSINESS DETAILS END

	//FUNCTION FOR FETCH MOST POPULAR FEED START
	public function fetchMostPopularFeed(){
		App::import('Model', 'BusinessRecommend');
		App::import('Model', 'Business');
		$this->BusinessRecommend = new BusinessRecommend();
		$this->Business = new Business();
		$ret = '';
		$business_id = '';
		$query = "select count(business_id) as business, business_id from  fp_business_recommends group by business_id order by business DESC";
		$businessArr = $this->BusinessRecommend->query($query);
		foreach($businessArr as $business){
			$business_id[] = $business['fp_business_recommends']['business_id'];
		}
		//pr($business_id);
		$popularbusinessArr = $this->Business->find('all', array('conditions'=>array('Business.id'=>$business_id, 'Business.status'=>'1'), 'limit'=>5));
		if(!empty($popularbusinessArr)){
			$ret = $popularbusinessArr;
		}
		return $ret;
	}
	//FUNCTION FOR FETCH MOST POPULAR FEED END

	//FUNCTION FOR VALIDATING THE FEED START
	public function validateTheUserFeed($visibility, $profile=null, $feed_user_id){ //echo $visibility.', '.$profile.', '.$feed_user_id;
		App::import('Model', 'User');
		$this->User = new User();
		//echo $feed_user_id;
		$visibilityArr = array('friend', 'me');
		$ret = 'show';

		if(in_array($visibility, $visibilityArr)){
			if($this->Session->read('Auth.User.User.id') != ''){ //check whether logged in or not
				if($profile != ''){//for profile page
					//1. First for me
					
					if($visibility == 'me')
						$ret = 'hide';
					elseif($visibility == 'friend'){ // 2. For Friend
						// 2.1 Validate the FriendShip
						if($this->validateFriendship($feed_user_id) == 'not_friend')
							$ret = 'hide';

						// Check profile user and session user are friend or not
						$profileUserId = $this->User->find('first', array('fields'=>array('User.id'), 'conditions'=>array('User.username'=>$profile)));
						$proUserId = $profileUserId['User']['id'];
						if($this->validateFriendship($proUserId) == 'friend')
					    $ret = 'show';
					}
				}else{ //if page is dashboard
					
					if($visibility == 'me'){ //if feed is for feed user id
						if($this->Session->read('Auth.User.User.id') != $feed_user_id)
							$ret = 'hide';
					}elseif($visibility == 'friend'){ // 2. For Friend
					  // 2.1 Validate the FriendShip
					  if($this->validateFriendship($feed_user_id) == 'not_friend')
					   $ret = 'hide';
					  if($this->Session->read('Auth.User.User.id') == $feed_user_id)
					   $ret = 'show';
					 }
				}
			}
		}
		return $ret;
	}
	//FUNCTION FOR VALIDATING THE FEED END

	//FUNCTION FOR VALIDATING THE FRIENDSHIP STATUS BETWEEN TWO USERS START
	public function validateFriendship($feed_user_id){ 
		App::import('Model', 'Friend');
		$this->Friend = new Friend();

		$conditions[0]["Friend.request_sent"] = $feed_user_id;
		$conditions[0]["Friend.request_received"] = $this->Session->read('Auth.User.User.id');
		$conditions[1]["Friend.request_sent"] = $this->Session->read('Auth.User.User.id');
		$conditions[1]["Friend.request_received"] = $feed_user_id;

		$frndArr = $this->Friend->find('count', array('conditions'=>array('Friend.friendship_status'=>'1', 'OR'=>$conditions)));
		if($frndArr > 0)
			$ret = 'friend';
		else
			$ret = 'not_friend';
		return $ret;

	}
	//FUNCTION FOR VALIDATING THE FRIENDSHIP STATUS BETWEEN TWO USERS END

	//FUNCTION FOR FETCH PROFILE USER DETAILS START
	public function fetchProfileUser($page=NULL){
		App::import('Model', 'User');
		$this->User = new User();

		$ret = '';
		$this->User->recursive = -1;
		$profileArr = $this->User->find('first', array('conditions'=>array('User.username'=>$page)));
		return $profileArr;
	}
	//FUNCTION FOR FETCH PROFILE USER DETAILS END


	//FUNCTION FOR CHECK USER FRIEND STATUS START
	public function checkFriendStatus($userr_id){ //echo $user_id;
		App::import('Model', 'Friend');
		$this->Friend = new Friend();
		$user_id = $this->Session->read('Auth.User.User.id');
		
		$return = array('Friend'=>array('friendship_status'=>'', 'id'=>''));
		/*$friendArr = $this->Friend->find('first', array('fields'=>array('Friend.friendship_status','Friend.id'), 'OR'=>array('User.friendship_status'=>'0', 'User.friendship_status'=>'1'), 'conditions'=>array('Friend.request_sent'=>$user_id, 'Friend.request_received'=>$userr_id)));*/

		$or = array('0'=>array('Friend.request_sent'=>$userr_id, 'Friend.request_received'=>$user_id), array('Friend.request_sent'=>$user_id, 'Friend.request_received'=>$userr_id));
		$this->Friend->recursive = -1;
        $friendArr = $this->Friend->find('first', array('conditions'=>array('OR'=>$or)));
		
		if(!empty($friendArr))
			$return = $friendArr;
		return $return;
	}
	//FUNCTION FOR CHECK USER FRIEND STATUS END

	/*-------------------- 17 JUNE 2013 START ARUN KUMAR CHAUHAN --------------*/
	public function fetchAllCountries(){
		App::import('Model', 'Country');
		$this->Country = new Country();

		$countryArr = $this->Country->find('list', array('fields'=>array('Country.country_iso_code_3', 'Country.countries_name'), 'conditions'=>array('NOT'=>array('Country.country_iso_code_3'=>array('USA', 'CAN')))));
		return $countryArr;
	}
	/*-------------------- 17 JUNE 2013 END ARUN KUMAR CHAUHAN ---------------*/

	/*-------------------- HOW IT WORKS SECTION 21 JUNE 2013 START ARUN KUMAR CHAUHAN ---------------*/
	//FUNCTON FOR FETCHING THE HEADING AND CONTENT START
	public function fetchWorksContent($type){
		App::import('Model', 'HowItWork');
		$this->HowItWork = new HowItWork();

		$typeArr = array('business'=>'1', 'user'=>'2');

		$headingArr = $this->HowItWork->findById($typeArr[$type]);
		return $headingArr;
	}
	//FUNCTON FOR FETCHING THE HEADING AND CONTENT END

	//FUNCTION FOR FETCHING THE PAGE CONTENT START
	public function fetchHIWPageContent($type){
		App::import('Model', 'HowItWork');
		$this->HowItWork = new HowItWork();

		$headingArr = $this->HowItWork->find('all', array('fields'=>array('HowItWork.id', 'HowItWork.heading', 'HowItWork.content', 'HowItWork.image', 'HowItWork.link'), 'conditions'=>array('HowItWork.status'=>'1', 'HowItWork.type'=>$type, 'HowItWork.id >'=>'2'), 'order'=>array('HowItWork.id'=>'DESC')));
		return $headingArr;
	}
	//FUNCTION FOR FETCHING THE PAGE CONTENT END
	/*-------------------- HOW IT WORKS SECTION 21 JUNE 2013 END ARUN KUMAR CHAUHAN ---------------*/

	//FUNCTION FOR VALIDATING THE GIVEN LINK START
	public function validateLink($link){
		$http = substr($link, 0, 4);
		if($http != 'http')
			$link = 'http://'.$link;
		return $link;
	}
	//FUNCTION FOR VALIDATING THE GIVEN LINK END

	//FUNCTION FOR FETCHING THE META TAGS START
	public function fetchMetaTags($controller, $action){
		App::import('Model', 'MetaTag');
		$this->MetaTag = new MetaTag();
		$metaTagArr = $this->MetaTag->find('first', array('fields'=>array('MetaTag.meta_keywords', 'MetaTag.meta_description'), 'conditions'=>array('MetaTag.controller'=>$controller, 'MetaTag.action'=>$action)));
		return $metaTagArr;
	}
	//FUNCTION FOR FETCHING THE META TAGS END

	//FUNCTION FOR FETCHING ALL THE USER NAMES FOR LISTING START
	public function fetchAllUsersForListing(){
		App::import('Model', 'User');
		$this->User = new User();
	
		$ret = array();
		$this->User->recursive = -1;
		$userArr = $this->User->find('all', array('fields'=>array('User.id', 'User.first_name', 'User.last_name'), 'conditions'=>array('User.status'=>'1')));
		if(!empty($userArr)){ //pr($userArr);die;
			foreach($userArr as $user){ //pr($user);die;
				$ret[$user['User']['id']] = $user['User']['first_name'].' '.$user['User']['last_name'];
			}
		}
		return  $ret;
	}
	//FUNCTION FOR FETCHING ALL THE USER NAMES FOR LISTING END

	//FUNCTION FOR FETCHING ALL MEMBERSHIP PLANS START
	public function fetchAllMembershipsForListing(){
		App::import('Model', 'Membership');
		$this->Membership = new Membership();

		$membershipArr = $this->Membership->find('list', array('fields'=>array('Membership.id', 'Membership.name')));
		return $membershipArr;
	}
	//FUNCTION FOR FETCHING ALL MEMBERSHIP PLANS END

	//FIND THE DATE DIFFERENCE START
	public function date_diff($start, $end){
		$d_start = new DateTime($start);
		$d_end = new DateTime($end);
		$diff = $d_start->diff($d_end);
		$aaa =  (int)$diff->format('%y');
		if($aaa == 1)
			$ret = 'year';
		else
			$ret = 'month';
		return $ret;
	}
	//FIND THE DATE DIFFERENCE END

	//FETCH THE CURRENT PLAN TYPE START
	public function fetchBusinessPlanType($businerss_id){
		App::import('Model', 'PurchasedMembership');
		$this->PurchasedMembership = new PurchasedMembership();

		$ret = 'month';
		$this->PurchasedMembership->recursive = -1;
		$businessArr = $this->PurchasedMembership->find('first', array('conditions'=>array('PurchasedMembership.business_id'=>$businerss_id), 'limit'=>1, 'order'=>array('PurchasedMembership.id'=>'DESC'))); //pr($businessArr);die;
		if(!empty($businessArr)){
			$ret = $this->date_diff($businessArr['PurchasedMembership']['purchased_on'], $businessArr['PurchasedMembership']['expires_on']);
		}
		return $ret;
	}
	//FETCH THE CURRENT PLAN TYPE END

	//FUNCTION FOR FETCHING THE PLAN TYPES START
	public function fetch_plan_type($plan_id){
		App::import('Model', 'Membership');
		$this->Membership = new Membership();

		$ret = array();

		$membershipArr = $this->Membership->find('first', array('fields'=>array('Membership.pricing_month', 'Membership.pricing_year'), 'conditions'=>array('Membership.id'=>$plan_id))); //pr($membershipArr);die;
		if($plan_id != '1'){
			foreach($membershipArr['Membership'] as $key => $value){ //echo $key .'=>'. $value;die;
				if(($key == 'pricing_month') && ($value != '')){
					$ret['month'] = 'Month/ $'.$value;
				}
				if(($key == 'pricing_year') && ($value != '')){
					$ret['year'] = 'Year/ $'.$value;
				}
			}
		}else{
			$ret['Free'] = 'Free';
		}
		return $ret;
	}
	//FUNCTION FOR FETCHING THE PLAN TYPES END

	//FETCH THE FRIENDSHIP DETAILS START
	public function fetch_friendship_details($profile_id){
		App::import('Model', 'Friend');
		$this->Friend = new Friend();

		$or = array('0'=>array('Friend.request_sent'=>$this->Session->read('Auth.User.User.id'), 'Friend.request_received'=>$profile_id), '1'=>array('Friend.request_sent'=>$profile_id, 'Friend.request_received'=>$this->Session->read('Auth.User.User.id')));

		$this->Friend->recursive = -1;
		$frndsArr = $this->Friend->find('first', array('conditions'=>array('OR'=>$or))); //pr($frndsArr);die;

		return $frndsArr;
	}
	//FETCH THE FRIENDSHIP DETAILS END

	//FUNCTION FOR FETCHING THE IGNORED FRIENDS START
	public function ignoredFriends(){
		App::import('Model', 'Friend');
		$this->Friend = new Friend();

		$this->Friend->unbindModel(array('belongsTo'=>array('Received')));
		$ignoredFriendsArr = $this->Friend->find('all', array('conditions'=>array('Friend.request_received'=>$this->Session->read('Auth.User.User.id'), 'Friend.friendship_status'=>'2'), 'order'=>array('Friend.modified'=>'DESC'))); //pr($ignoredFriendsArr);die;
		return $ignoredFriendsArr;
	}
	//FUNCTION FOR FETCHING THE IGNORED FRIENDS END

	//FUNCTION FOR CALCULATING THE USER AGE START
	public function calculateAge($dob){
		$year = '';
		if($dob != ''){
			$start  = date('1987-08-24');
			$end    = date('Y-m-d');
			$d_start    = new DateTime($start);
			$d_end      = new DateTime($end);
			$diff = $d_start->diff($d_end);
			$year = $diff->format('%y');
		}
		return $year;
	}
	//FUNCTION FOR CALCULATING THE USER AGE END

	//FUNCTION FOR FETCHING THE RECOMMENEDED COMMENT START 7/17/2013
	public function fetchUserRecommendedCommentCount($feed_id, $comment_id, $type=null){ //echo $feed_id.', '.$comment_id;die;
		App::import('Model', 'Recommended');
		$this->Recommended = new Recommended();

		$con['Recommended.feed_id'] = $feed_id;
		$con['Recommended.comment_id'] = $comment_id;
		$con['Recommended.status'] = '1';

		if($type == ''){ // check for user recommend
			$con['Recommended.user_id'] = $this->Session->read('Auth.User.User.id');
		}
		$ret = $this->Recommended->find('count', array('conditions'=>$con));
		return $ret;
	}
	//FUNCTION FOR FETCHING THE RECOMMENEDED COMMENT END 7/17/2013

	//FUNCTION FOR FETCHING THE FEED START
	public function fetchFeedDetails($feed_id){
		App::import('Model', 'BusinessFeed');
		$this->BusinessFeed = new BusinessFeed();
	}
	//FUNCTION FOR FETCHING THE FEED END

	//FUNCTION FOR VALIDATING THE USER OFFER-DEAL RATING START
	public function validateOfferDealRating($id, $type='offer_id'){
		App::import('Model', 'OffersDealsRating');
		$this->OffersDealsRating = new OffersDealsRating();

		$ret = '';

		$conditions['user_id'] = $this->Session->read('Auth.User.User.id');
		$conditions[$type] = $id;
		
		$this->OffersDealsRating->recursive = -1;
		$RatingArr = $this->OffersDealsRating->find('first', array('conditions'=>$conditions));
		if(!empty($RatingArr)){
			$ret = $RatingArr['OffersDealsRating']['rating'];
		}
		return $ret;
	}
	//FUNCTION FOR VALIDATING THE USER OFFER-DEAL RATING END

	//FUNCTION FOR FETCHING THE PLAN NAMES ARRAY START
	public function fetchAllPlansNames(){
		App::import('Model', 'Membership');
		$this->Membership = new Membership();

		$this->Membership = new Membership();

		$memArr = $this->Membership->find('list', array('fields'=>array('Membership.name')));
		return $memArr;
	}
	//FUNCTION FOR FETCHING THE PLAN NAMES ARRAY END

	//FUNCTION FOR FETCHING THE USER CITIES START
	public function fetchUserStateCities(){
		App::import('Model', 'Postcode');
		$this->Postcode = new Postcode();

		$StateCode = 'NY';

		if($this->Session->read('Auth.User.User.state_code') != '')
			$StateCode = $this->Session->read('Auth.User.User.state_code');

		$postCodeArr = $this->Postcode->find('list', array('fields'=>array('Postcode.CityName', 'Postcode.CityName'), 'conditions'=>array('Postcode.ProvinceAbbr'=>$StateCode), 'group'=>'Postcode.CityName', 'order'=>array('Postcode.CityName'=>'ASC')));
		return $postCodeArr;
	}
	//FUNCTION FOR FETCHING THE USER CITIES END

	//FUNCTION FOR FETCHING THE PLAN CITIES START
	public function fetchPlanCities($planId){
		App::import('Model', 'Membership');
		$this->Membership = new Membership();

		$membrArr = $this->Membership->find('first', array('fields'=>array('Membership.push_marketing'), 'conditions'=>array('Membership.id'=>$planId)));
		return $membrArr['Membership']['push_marketing'];
	}
	//FUNCTION FOR FETCHING THE PLAN CITIES END

	//FUNCTION FOR FETCHING THE USER SELECTED CITIES START
	public function fetchUserSelectedCities($business_id){
		App::import('Model', 'PushMarketting');
		$this->PushMarketting = new PushMarketting();

		$ret = '';

		$this->PushMarketting->recursive = -1;
		$citiesArr = $this->PushMarketting->find('list', array('fields'=>array('PushMarketting.city_name'), 'conditions'=>array('PushMarketting.business_id'=>$business_id, 'PushMarketting.user_id'=>$this->Session->read('Auth.User.User.id'))));

		if(!empty($citiesArr))
			$ret = $citiesArr;
		return $ret;
	}
	//FUNCTION FOR FETCHING THE USER SELECTED CITIES END


	//FUNCTION FOR CHECK INVITES FRIENDS START
	public function checkInviteFriends($id){
		App::import('Model', 'Invite');
		$this->Invite = new Invite();
		$ret = '';
		$count = $this->Invite->find('count', array('conditions'=>array('Invite.inviter_id'=>$id)));
		if(!empty($count)){
			$ret = $count;
		}
		return $ret;
	}
	//FUNCTION FOR CHECK INVITES FRIENDS END
}
?>