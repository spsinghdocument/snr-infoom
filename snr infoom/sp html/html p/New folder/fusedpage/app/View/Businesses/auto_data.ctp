<?php if(!empty($searchArr)){ ?>
<div id="saurabh">
	<?php foreach($searchArr as $searchArr){ $page = 1; ?>
	<div class="friendmainbox" style="margin-bottom:5px;">
	<a href="javascript:void(0);" onclick="setData('<?php echo $searchArr['Business']['title']; ?>');" style="text-decoration:none;"><?php echo $searchArr['Business']['title']; ?></a>
	</div>
	<?php } ?>
</div>
<span id="loder" style="display:none;"><?php echo $this->Html->image("ajax/small-facebook.gif",array("alt"=>"", "style"=>"margin-left:100px;"));?></span>
	<div id="view_more" style="color:#FF0000; margin:2px; text-align:center; cursor:pointer;" onclick="return fetchData();">View More</div>
<?php echo $this->Form->hidden('lastViewedPage', array('div'=>false, 'label'=>false, 'value'=>$page)); ?>
<?php } else { ?>
	<div style="color:#FF0000; margin:2px; text-align:center;">No Record Found!!</div>
<?php } ?>

<script type="text/javascript">
function fetchData(){
	var key = $('#BusinessKeyword').val();
	var lastViewedPage = parseInt($('#lastViewedPage').val());
	if(lastViewedPage != 0)
		$('#lastViewedPage').val((lastViewedPage + 1));
	if(lastViewedPage != '0'){
	$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH.'businesses/auto_loding_data/';?>",
			data: "last_viewed_page="+lastViewedPage+"&key="+key,
			beforeSend:function(){
				//var bSend = '<?php echo $this->Html->image("ajax/small-facebook.gif",array("alt"=>"", "style"=>"margin-left:100px;"));?>';
				$('#loder').show();
			},
			success: function(response){ 
				if(!response.match(/END/g)){
					$('#saurabh').append(response);
					$('#loder').hide();
				}else{
					$('#view_more').html('<font color="red">No More Content To List</font>');
				}
			}
		});
	}
}
</script>