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
			<?php echo $this->Form->create('Group', array('action'=>'add_groups', 'type'=>'file')); ?>

			
			<div class="mailtophdbox">
					<div class="insideflhd">Add Group</div>
					
					<div class="clr"></div>	
				</div>
			
			<!--Start according part -->		
			
				
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

							<div class="accwhitebox">
							<div class="formlablebig">Banner Upload:</div>
							<?php echo $this->Form->file('Group.image', array('div'=>false, 'label'=>false, 'error'=>false)); ?>
							<div class="clr"></div>	
							
						</div>
						</div>	
					
				</div>
			
				
				
				
			<div align="center" style="padding-top:15px;"><?php echo $this->Form->submit('front_end/submit_btn.png'); ?></div>		
			<?php echo $this->Form->end(); ?>
			</div>
			
		      </div>
			
</div>