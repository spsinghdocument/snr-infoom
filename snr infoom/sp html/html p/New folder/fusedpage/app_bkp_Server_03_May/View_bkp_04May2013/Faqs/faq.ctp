<h3>Frequently Asked Questions</h3>
<?php
	if(!empty($viewListing)){
?>
	<div id="main_data_container">
<?php		$page = 1;
		foreach($viewListing as $listing){ //pr($listing);die;
?>
		<div class="faqmainbox">
			<div class="faqinbox">
				<a href="javascript:void(0);"><?php echo $listing['Faq']['question'];?></a>
			</div>
			<div class="categoryitems">
				<div class="faqans"><?php echo $listing['Faq']['answer'];?></div>
			</div>
		</div>
<?php		} ?>
	</div>
	<div id="load_more" align="center" style="display:none;">
		<?php 
			echo '<span id="loader_span">'.$this->Html->image('ajax/pic-loader.gif', array('alt'=>'', 'border'=>0)).' Loading More</span>';
			echo $this->Form->hidden('lastViewedPage', array('div'=>false, 'label'=>false, 'value'=>$page));
		?>
	</div>
<?php	}else{
?>
	<div class="faqans" style="text-align:center; color:#FF0000;">No FAQ Available!!</div>
<?php } ?>

<script type="text/javascript">
$(document).ready(function(){
	$('.categoryitems:first').show().addClass("Selected");
});

$('.faqinbox').live('click',function(){
	$('.Selected').hide().removeClass('Selected');
	$(this).next('.categoryitems').show();
	$(this).next('.categoryitems').addClass("Selected");
});

$(window).scroll(function(){
	if($(window).scrollTop() >= ($(document).height() - $(window).height()))
		fetchData();
});

function fetchData(){
	var lastViewedPage = parseInt($('#lastViewedPage').val());
	if(lastViewedPage != 0)
		$('#lastViewedPage').val((lastViewedPage + 1));
	if(lastViewedPage != '0'){
		$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH.'faqs/fetch_paging_data/';?>",
			data: "last_viewed_page="+lastViewedPage,
			beforeSend:function(){
				$('#load_more').show();
			},
			success: function(response){
				if(response != 'Complete'){
					$('#main_data_container').append(response);
					$('#load_more').hide();
				}else{
					$('#lastViewedPage').val('0');
					$('#loader_span').html('');
				}
			}
		});
	}else
		return false;
}
</script>