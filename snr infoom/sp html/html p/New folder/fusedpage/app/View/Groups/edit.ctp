<!-- VALIDATION ENGINE START -->
<script type="text/javascript">	
	$(document).ready(function(){
		$("#GroupAddGroupsForm").validationEngine()	
	});	
</script>
<!-- VALIDATION ENGINE END -->
<script type="text/javascript">
$(document).ready(function(){
	$('.userdeshboadfl').hide();
	
	$('#AddBusiness').validationEngine();
});
</script>
<div class="midinsidemain" style="padding:0px;">
	<div class="businessinbox">
		<div class="mailtophdbox">
			<div class="insideflhd">Edit Group</div>
			<div class="clr"></div>	
		</div>
		
		<?php 
			echo $this->Form->create('Group', array('action'=>'edit', 'type'=>'file'));
			echo $this->Form->hidden('Group.id', array('value'=>$this->data['Group']['id']));
			echo $this->Form->hidden('Group.banner_id', array('value'=>$this->data['GroupBanner'][0]['id']));
		?>
		<div class="accordion">
			<div class="accwhitebox">
				<div class="formlablebig">Title:</div>
				<div class="formfieldbig">
					<?php echo $this->Form->input('Group.title', array('div'=>false, 'label'=>false, 'type'=>'text', 'error'=>false, 'class'=>'forminputbig validate[required]')); ?>
				</div>
				<div class="clr"></div>

				<div class="formlablebig">About:</div>
				<div class="textareabox">
					<?php echo $this->Form->textarea('Group.description', array('div'=>false, 'label'=>false, 'error'=>false, 'style'=>'resize:none;', 'cols'=>'', 'rows'=>'', 'class'=>'textareaboxinput validate[required]')); ?>
				</div>
				<div class="clr"></div>

				<div class="formlablebig">Banner:</div>
				<div style="float:left; height:44px; margin:0 0 10px 10px; width: 600px;">
					<?php echo $this->Form->file('Group.image', array('div'=>false, 'label'=>false, 'error'=>false, 'style'=>'margin-top:8px;'));
					echo $this->Form->hidden('Group.old_banner', array('value'=>$this->data['Group']['image']));

					//display old banner
					if($this->data['Group']['image'] != ''){
						$imageRealPath = '../webroot/img/front_end/groups/'.$this->data['Group']['image'];
						if(is_file($imageRealPath)){
					?>
					<span style="float:right; margin-right:137px;"><?php echo $this->Image->resize('front_end/groups/'.$this->data['Group']['image'], 130, 50, array('alt'=>''));?></span>
					<?php
						}
					}
					?>
				</div>
				<div class="clr"></div>

				<div class="formlablebig">&nbsp;</div>
				<div>
					<?php echo $this->Form->submit('front_end/submit_btn.png', array('div'=>false));?>
				</div>
				<div class="clr"></div>
			</div>
		</div>
		<?php echo $this->Form->end();?>
	</div>
</div>