<?php 
	if(!empty($dealsArr)){
	foreach($dealsArr as $deal){ //pr($deal);die;
		$dealImage = 'front_end/business/noimage.jpg';
		if($deal['BusinessDeal']['image'] != ''){
			$offerImagePath = '../webroot/img/front_end/business/deals/'.$deal['BusinessDeal']['image'];
			if(is_file($offerImagePath))
				$dealImage = 'front_end/business/deals/'.$deal['BusinessDeal']['image'];
		}
?>
<div class="deshlistbox">
	<div class="dealdtlboxfl">
		<a href="javascript:void(0);"><?php echo $this->Image->resize($dealImage, 118, 93, array('alt'=>''));?></a>
	</div>
	<div class="dealdtlboxfr">
		<div class="busnissimgfrhd fl"><a href="javascript:void(0);"><?php echo $deal['BusinessDeal']['title'];?></a></div>
		<div class="price">Price:<span>$<?php echo $deal['BusinessDeal']['price'];?></span></div>
		<div class="clr"></div>
		<div class="tagline"><?php echo $deal['BusinessDeal']['tagline'];?></div>
		<div class="deshtextsml">Lorem ipsum dolor sit amet Duis diamquam, mollis....</div>
		<div>
			<div class="viewdtlbtn"><a href="javascript:void(0);" onclick="return view_details('<?php echo $deal['BusinessDeal']['id'];?>');"><?php echo $this->Html->image('front_end/view_dtl_btn.png', array('alt'=>''));?></a></div>
			<?php if($deal['BusinessDeal']['start_date'] != ''){?>
				<div class="startdate">Start Date</div>
				<div class="sdateimg"><?php echo date('d M', strtotime($deal['BusinessDeal']['start_date']));?></div>
				<div class="enddate">End Date</div>
				<div class="edateimg"><?php echo date('d M', strtotime($deal['BusinessDeal']['end_date']));?></div>
			<?php } ?>
			<div class="clr"></div>
		</div>	
	</div>
	<div class="clr"></div>

	<!-- EDIT DELETE SECTION START -->
	<?php if($this->Fused->fetchBusinessOwner($deal['BusinessDeal']['business_id']) == $this->Session->read('Auth.User.User.id')){?>
	<div class="edittext" style="text-align:left;">
		<a title="Edit" href="javascript:void(0);" style="float:left;" onclick="return validateDealsTabs('edit', '<?php echo $deal['BusinessDeal']['id'];?>')"><img alt="" src="/fusedpage/img/front_end/edit_icon.png"></a>
		<!-- **************** -->
		<a title="Delete" href="javascript:void(0);" style="float:left; margin-left:10px;" onclick="return deleteBusinesDeal('<?php echo $deal['BusinessDeal']['id'];?>');"><img alt="" src="/fusedpage/img/admin/delete_icon.gif/"></a>
	</div>
	<div class="clr"></div>
	<?php } ?>
	<!-- EDIT DELETE SECTION END   -->

	<div class="deshboardwhitebox">
		<div class="likeboxfl">
			<div class="deshboardsmlimg">
				<a href="javascript:void(0);"><?php echo $this->Html->image('front_end/desh_board_sml_img1.jpg', array('alt'=>''));?></a>
			</div>
			<div class="deshboardsmlimg">
				<a href="javascript:void(0);"><?php echo $this->Html->image('front_end/busniss_dtl_sml_img1.jpg', array('alt'=>''));?></a>
			</div>
			<div class="deshboardsmlimg">
				<a href="javascript:void(0);"><?php echo $this->Html->image('front_end/desh_board_sml_img2.jpg', array('alt'=>''));?></a>
			</div>
			<div class="deshboardsmlimg">
				<a href="javascript:void(0);"><?php echo $this->Html->image('front_end/desh_board_sml_img3.jpg', array('alt'=>''));?></a>
			</div>
			<div class="deshboardsmlimg">
				<a href="javascript:void(0);"><?php echo $this->Html->image('front_end/busniss_dtl_sml_img4.jpg', array('alt'=>''));?></a>
			</div>
		</div>
		<div class="offerlikeboxfr">
			<?php echo $this->Html->image('front_end/like_icon.jpg', array('alt'=>''));?><span>20 People</span> recommended this
		</div>
		<div class="clr"></div>

		<div class="coomentlinbox">
			<div class="commentfltext"><span>3  People </span>you know recommended this</div>
			<div class="commentfrlink">
				<a href="javascript:void(0);">Recommend</a><a href="javascript:void(0);">Comments</a>
			</div>
			<div class="clr"></div>
		</div>
		<div>
			<div class="commentflimg">
				<?php echo $this->Html->image('front_end/comment_fl_img.jpg', array('alt'=>''));?>
			</div>
			<div class="offcommentbox">
				<div class="offcommetarrow">
					<?php echo $this->Html->image('front_end/comment_arrow.jpg', array('alt'=>''));?>
				</div>
				<textarea name="" cols="" rows="" class="offcommentfrbox"></textarea>
			</div>
			<div class="clr"></div>
		</div>
	</div>
</div>
<?php }}else{ ?>
<div class="deshlistbox" style="text-align:center; color:#FF0000; margin-top:50px;">
	No Deals Available!!
</div>
<?php } ?>