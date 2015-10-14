<?php if(!empty($cityArr)){ ?>
<div id="saurabh_city">
	<?php foreach($cityArr as $cityArr){ $page = 1; ?>
	<div class="friendmainbox" style="margin-bottom:5px;">
		<?php 
			if($cityArr['Business']['city'] != ''){
				$country = ", ".$cityArr['Business']['country'];
			} else {
				$country = $cityArr['Business']['country'];
			}
		?>
	<a href="javascript:void(0);" onclick="setCityData('<?php echo $cityArr['Business']['city']; ?>');" style="text-decoration:none;"><?php echo $cityArr['Business']['city'].$country; ?></a>
	</div>
	<?php } ?>
</div>
<span id="loderr" style="display:none;"><?php echo $this->Html->image("ajax/small-facebook.gif",array("alt"=>"", "style"=>"margin-left:100px;"));?></span>
<div id="view_more_citys" style="color:#FF0000; margin:2px; text-align:center; cursor:pointer;" onclick="return fetchData();">View More</div>
<?php echo $this->Form->hidden('lastViewedPage', array('div'=>false, 'label'=>false, 'value'=>$page)); ?>

<?php } else { ?>
	<div style="color:#FF0000; margin:2px; text-align:center;">No Record Found!!</div>
<?php } ?>


<script type="text/javascript">
function fetchData(){
	var city = $('#BusinessCity').val();
	var lastViewedPage = parseInt($('#lastViewedPage').val());
	if(lastViewedPage != 0)
		$('#lastViewedPage').val((lastViewedPage + 1));
	if(lastViewedPage != '0'){
	$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH.'businesses/auto_loding_city_data/';?>",
			data: "last_viewed_page="+lastViewedPage+"&city="+city,
			beforeSend:function(){
				//var bSend = '<?php echo $this->Html->image("ajax/small-facebook.gif",array("alt"=>"", "style"=>"margin-left:275px;"));?>';
				//$('#view_more_citys').show();
				$('#loderr').show();
			},
			success: function(response){
				if(!response.match(/END/g)){
					$('#saurabh_city').append(response);
					//$('#view_more').hide();
					$('#loderr').hide();
				}else{
					$('#view_more_citys').html('<font color="red">No More Content To List</font>');
				}
			}
		});
	}
}
</script>