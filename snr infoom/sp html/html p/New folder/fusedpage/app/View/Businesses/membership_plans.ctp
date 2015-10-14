 <!-- FETCH THE MEMBERSHIP PLAN FOR THE CORRESPONDING BUSINESS START -->
<?php   $businessPlan = (int)$this->Fused->fetchBusinessMembershipPlan($this->Fused->decrypt($this->params['pass'][0]));
	$this->set('businessPlan', $businessPlan);

	//FETCH THE BUSINESS DETAILS
	$this->set('businessArr', $this->Fused->fetchBusinessDetails($this->Fused->decrypt($this->params['pass'][0])));

	//$https_site_path = str_replace('http://', 'https://', SITE_PATH);
	$https_site_path = str_replace('http://', 'http://', SITE_PATH);
	$this->set('https_site_path', $https_site_path);
?>
<!-- FETCH THE MEMBERSHIP PLAN FOR THE CORRESPONDING BUSINESS END -->

<h3>Upgrade Business</h3>

<!-- TOP LEFT SECTION START -->
<?php echo $this->Element('FrontEnd/membership_top_left');?>
<!-- TOP LEFT SECTION END -->

<!-- REFERRAL PROGRAM START -->
<?php echo $this->Element('FrontEnd/referral_program');?>
<!-- REFERRAL PROGRAM END   -->
<div class="clr"></div>	

<!-- MEMBERSHIP DETAILS PLAN START -->
<?php echo $this->Element('FrontEnd/membership_plans');?>
<!-- MEMBERSHIP DETAILS PLAN END -->