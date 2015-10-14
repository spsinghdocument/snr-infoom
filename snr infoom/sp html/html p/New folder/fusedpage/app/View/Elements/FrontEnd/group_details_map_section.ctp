<?php if($grpArr['Group']['user_id'] == $this->Session->read('Auth.User.User.id')){?>
<div class="mapitbox">
	<div class="btnimage fr">
		<?php echo $this->Html->link('<span>Edit</span>', '/groups/edit/'.$this->Fused->encrypt($grpArr['Group']['id']).'/'.$grpArr['Group']['alias_name'].'/', array('escape'=>false));?>
	</div>
	<div class="clr"></div>
</div>
<?php } ?>