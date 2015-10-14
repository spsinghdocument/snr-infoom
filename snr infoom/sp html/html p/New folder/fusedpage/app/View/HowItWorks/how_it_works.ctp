<script>
function fp_show(tabopen,cl) 
{
	i=1;
	
	while (document.getElementById("pulic_"+i))
	 {
	 document.getElementById("pulic_"+i).style.display='none';
	 document.getElementById("a"+i).className='';
	 i++;
	 
	 }
	 document.getElementById(tabopen).style.display='block';
	 document.getElementById(cl).className='sel';
}

</script>
<style>
.menu{width:auto; background:#646363; height:30px; border:solid 1px #E2E2E2; border-bottom:0;}
.menu ul{list-style:none; margin:0px; padding:0px;}
.menu ul li{float:left; display:block; }
.menu ul li a{text-decoration:none; height:20px;padding:8px 10px 2px 10px; text-align:center; display:block; font-size:12px; color:#fff; font-weight:bold;}
.menu ul li a:hover{background:#1361A3; color:#FFF;}
.menu ul li a.sel{background:#1361A3; color:#FFF;}
.tabcont{ border:1px solid #E2E2E2; border-top:none; padding:10px 10px;}

</style>
<?php
	$heading = '';
	$content = '';
?>


<div class="tablink">
	<div class="menu">
		<ul>
			<li><a href="javascript://" class="sel" id="a1" onclick="fp_show('pulic_1', 'a1')"><span>Business</span></a></li>
			<li><a href="javascript://" id="a2" onclick="fp_show('pulic_2', 'a2')"><span>User</span></a></li>
		</ul>
	</div>
</div>

<div id="pulic_1">
	<div class="deshboadmidmian" style="background:none;">
		<?php
			$headingArr = $this->Fused->fetchWorksContent('business');
			if(!empty($headingArr)){
				$heading = $headingArr['HowItWork']['heading'];
				$content = $headingArr['HowItWork']['content'];
			}
		?>
		<div class="litingHed"><?php echo $heading;?></div>
		<div class="listingTxt">
			<?php echo nl2br($content);?>
		</div>

		<!-- FOR PAGE CONTENT START -->
		<?php
			$pageContentArr = $this->Fused->fetchHIWPageContent('business');
			if(!empty($pageContentArr)){
			foreach($pageContentArr as $listing){ //pr($listing);die;
		?>
		<div class="listingtextIner">
			<div class="left" style="width:730px;" id="hiw_<?php echo $listing['HowItWork']['id'];?>">
				See how <span><?php echo $listing['HowItWork']['heading'];?>,</span>
				<?php /* echo $this->Text->truncate($listing['HowItWork']['content'], 400, array('ellipsis'=>'... <a href="javascript:void(0);" style="color:#FF0000; text-decoration:none;" onclick="return fetchFullContent('.$listing['HowItWork']['id'].');">Read More</a>', 'html'=>true, 'exact'=>true)); */

				echo $this->Text->truncate($listing['HowItWork']['content'], 400, array('ellipsis'=>'... <a href="'.$listing['HowItWork']['link'].'" style="color:#FF0000; text-decoration:none;" target="_blank">View More</a>', 'html'=>true, 'exact'=>true));
				?>
			</div>

			<?php
			if($listing['HowItWork']['image'] != ''){
				$realImagePath = '../webroot/img/front_end/business/'.$listing['HowItWork']['image'];
				if(is_file($realImagePath)){
			?>
			<div class="right" style="width:160px;">
				<a href="<?php echo $listing['HowItWork']['link'];?>" target="_blank"><?php echo $this->Image->resize('front_end/business/'.$listing['HowItWork']['image'], 137, 93, array('alt'=>''));?></a>
			</div>
			<div class="clr"></div>
			<?php }} ?>
		</div>
		<!-- FOR PAGE CONTENT END -->
		<?php }} ?>

	</div>
</div>

<div id="pulic_2" style="display:none;">
	<div class="deshboadmidmian" style="background:none;">
		<?php
			$headingArr = $this->Fused->fetchWorksContent('user');
			if(!empty($headingArr)){
				$heading = $headingArr['HowItWork']['heading'];
				$content = $headingArr['HowItWork']['content'];
			}
		?>
		<div class="litingHed"><?php echo $heading;?></div>
		<div class="listingTxt">
			<?php echo nl2br($content);?>
		</div>

		<!-- FOR PAGE CONTENT START -->
		<?php
			/* $pageContentArr = $this->Fused->fetchHIWPageContent('user');
			if(!empty($pageContentArr)){
			foreach($pageContentArr as $listing){*/ //pr($listing);die;
		?>
		<!-- <div class="listingtextIner">
			<div class="left" style="width:730px;" id="hiw_<?php echo $listing['HowItWork']['id'];?>">
				See how <span><?php echo $listing['HowItWork']['heading'];?>,</span>
				<?php echo $this->Text->truncate($listing['HowItWork']['content'], 400, array('ellipsis'=>'... <a href="javascript:void(0);" style="color:#FF0000; text-decoration:none;" onclick="return fetchFullContent('.$listing['HowItWork']['id'].');">Read More</a>', 'html'=>true, 'exact'=>true));?>
			</div>

			<?php
			if($listing['HowItWork']['image'] != ''){
				$realImagePath = '../webroot/img/front_end/business/'.$listing['HowItWork']['image'];
				if(is_file($realImagePath)){
			?>
			<div class="right" style="width:160px;">
				<?php echo $this->Image->resize('front_end/business/'.$listing['HowItWork']['image'], 137, 93, array('alt'=>''));?>
			</div>
			<div class="clr"></div>
			<?php }} ?>
		</div> -->
		<!-- FOR PAGE CONTENT END -->
		<?php //}} ?>

	</div>
</div>


<script type="text/javascript">
function fetchFullContent(id){
	if(id != ''){
		$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH.'how_it_works/fetch_specific_content/';?>",
			data: "id="+id,
			beforeSend:function(){
				var bSend = '<div align="center"><?php echo $this->Html->image("ajax/pic-loader.gif", array("alt"=>""));?></div>';
				$('#hiw_'+id).html(bSend);
			},
			success: function(response){
					$('#hiw_'+id).html(response);
					
			}
		});
	}else
		return false;
}
</script>