<?php $groupCount = $this->Fused->countGroup(); 
	  $groupMemberCount = $this->Fused->countGroupMember();
	  $groupInterstedCount = $this->Fused->countGroupIntersted();
 	  $groupCityCount = $this->Fused->countGroupCity();
$viewListing_1 = $this->Fused->fetch_group_locations(); //pr($viewListing_1);die;
$this->set('viewListing_1', $viewListing_1);
?>
			<!--Start inside right part -->
			<div class="insiderightbox">
				<div class="insidetopflbox">
					<div><span class="insidehd">Groups</span></div>	
				</div>
				<div class="clr"></div>
				<div class="groupsmapboxmain">
					<!-- GROUP MAP SECTIONS START -->
					<?php echo $this->Element('FrontEnd/group_map');?>
					<!-- GROUP MAP SECTIONS END -->
					<div class="groupsmapbtmcity">
						<div class="groupcityboxbg"><a href="javascript:void(0);">Groups<br /><span><?php if($groupCount > 0){ echo $groupCount; } else { echo '0'; }?></span></a></div>
						<div class="groupcityboxbg"><a href="javascript:void(0);">Members<br /><span><?php if($groupMemberCount > 0){ echo $groupMemberCount; } else { echo '0'; }?></span></a></div>
						<div class="groupcityboxbg"><a href="javascript:void(0);">Interested<br /><span><?php if($groupInterstedCount > 0){ echo $groupInterstedCount; } else { echo '0'; }?></span></a></div>
						<div class="groupcityboxbg last"><a href="javascript:void(0);">Cities<br /><span><?php if($groupCityCount > 0){ echo $groupCityCount; } else { echo '0'; }?></span></a></div>
						<div class="clr"></div>
					</div>
				</div>
				<!--Start deshboard mid part -->
				<div class="userdeshboardmid">
					<div class="groupmidhd">Recently Updated Groups</div>
				<?php if(!empty($viewListing)){
					$i = 1;
					foreach($viewListing as $listing){
				?>
					<div class="grouplistbgmain">
						<div class="grouplistno"><?php echo $i; ?></div>
						<div class="grouplistnofrhd">
							<a href="<?php echo SITE_PATH.'groups/details/'.$this->Fused->encrypt($listing['Group']['id']).'/'.$listing['Group']['alias_name'].'/';?>"><?php echo $this->Text->truncate($listing['Group']['title'], 50, array('ending'=>'...'));
						?></a>
						</div>

						<div class="gruplisttext">
							<?php echo $this->Text->truncate($listing['Group']['description'], 400, array('ending'=>'...')); ?>
						</div>
						<div class="gruplisttextfr">
							<p><strong>8,757</strong></p>
							<p>OC Hikers &amp;</p>
							<p>Backpackers!</p>
						</div>
						<div class="clr"></div>
					</div>
					<?php $i++; } ?>
				<?php }else{ ?>
					<span style="margin-left:150px;">No Groups Available!</span>	
				<?php } ?>
					
				</div>				
				<!--End deshboard mid part -->

			<!-- GROUP RIGHT SECTION START  -->
			<?php echo $this->Element('FrontEnd/group_right_section');?>
			<!-- GROUP RIGHT SECTION END  -->
				<div class="clr"></div>
			</div>
			<!--End inside right part -->
			