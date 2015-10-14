<?php
	if(!empty($viewListing)){
		foreach($viewListing as $listing){ //pr($listing);die;
?>
			<div class="faqmainbox">
				<div class="faqinbox expandable">
					<a href="javascript:void(0);"><?php echo $listing['Faq']['question'];?></a>
				</div>
				<div class="categoryitems">
					<div class="faqans"><?php echo $listing['Faq']['answer'];?></div>
				</div>
			</div>
<?php
		}
	}else
		echo 'Complete';
?>