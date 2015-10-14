<!-- for fancybox Start -->
<?php
	echo $this->Html->Css('fancyboxcss/jquery.fancybox-1.3.4');
	echo $this->Html->Script('fancyboxjs/jquery.fancybox-1.3.4.pack.js');
?>
<script type="text/javascript">
	$(document).ready(function(){
		$("a.fancyclass").fancybox();
	});
 </script>
<!-- for fancybox End -->

<div class="rightMid">
	<!-- DISPLAY MESSAGE START -->
	<?php echo $this->Session->flash();?>
	<!-- DISPLAY MESSAGE END -->
	<div class="mainHd">Manage FAQ Meta Tags</div>

	<div>
		<table cellpadding="0" cellspacing="0" width="100%">
			<tr class="rpHd"> 
				<td width="30%">Meta Title</td>
				<td width="30%">Meta Keywords</td>
				<td width="20%" align="center">Last Modified</td>
				<td width="20%" align="center">Options</td>
			</tr>
			
			<tr class="rpFirstRow">
				<td><?php echo $this->Text->truncate($metaArr['FaqMeta']['meta_title'], 100, array('ellipsis'=>'...', 'exact'=>true, 'html'=>true));?></td>
				<td><?php echo $this->Text->truncate($metaArr['FaqMeta']['meta_keyword'], 100, array('ellipsis'=>'...', 'exact'=>true, 'html'=>true));?></td>
				<td align="center"><?php echo date('d M, Y', strtotime($metaArr['FaqMeta']['modified']));?></td>
				<td align="center"><?php
					//view
					echo $this->Html->link($this->Html->image('admin/view_icon.gif', array('alt'=>'', 'border'=>0)), '/admin/faq_metas/view/', array('escape'=>false, 'title'=>'View', 'class'=>'fancyclass'));
					//edit
					echo $this->Html->link($this->Html->image('admin/edit_icon.gif', array('alt'=>'', 'border'=>0)), '/admin/faq_metas/edit/', array('escape'=>false, 'title'=>'Edit', 'style'=>'margin-left:5px;'));
				?></td>
			</tr>
		</table>
	</div>
	<div class="clr"></div>
</div>