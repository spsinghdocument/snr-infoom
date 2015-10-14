<script language="JavaScript" type="text/javascript">
//var m = jQuery.noConflict();
$(document).ready(function() {	
	$(".massa").click(function(e) {          
		e.preventDefault();
		$("div#currency_flg").toggle();
		$(".massa").toggleClass("menu-open");
	});
	
	$("div#currency_flg").mouseup(function() {
		return false
	});
	$(document).mouseup(function(e) {
		if($(e.target).parent("a.massa").length==0) {
			$(".massa").removeClass("menu-open");
			$("div#currency_flg").hide();
		}
	});			
	
});



//var us = jQuery.noConflict();
$(document).ready(function() {
	
	$(".profst").click(function(e) {          
		e.preventDefault();
		$("div#profile_status").toggle();
		$(".profst").toggleClass("menu-open");
	});
	
	$("div#profile_status").mouseup(function() {
		return false
	});
	$(document).mouseup(function(e) {
		if($(e.target).parent("a.profst").length==0) {
			$(".profst").removeClass("menu-open");
			$("div#profile_status").hide();
		}
	});			
	
});


$(document).ready(function() {	
	$(".massa1").click(function(e) {          
		e.preventDefault();
		$("div#currency_flg1").toggle();
		$(".massa1").toggleClass("menu-open");
	});
	
	$("div#currency_flg1").mouseup(function() {
		return false
	});
	$(document).mouseup(function(e) {
		if($(e.target).parent("a.massa1").length==0) {
			$(".massa1").removeClass("menu-open");
			$("div#currency_flg1").hide();
		}
	});			
	
});



//var us = jQuery.noConflict();
$(document).ready(function() {
	
	$(".profst").click(function(e) {          
		e.preventDefault();
		$("div#profile_status").toggle();
		$(".profst").toggleClass("menu-open");
	});
	
	$("div#profile_status").mouseup(function() {
		return false
	});
	$(document).mouseup(function(e) {
		if($(e.target).parent("a.profst").length==0) {
			$(".profst").removeClass("menu-open");
			$("div#profile_status").hide();
		}
	});			
	
});
</script>

<div class="headerMidbox">
	<div class="headermidbg">
			<!--Start tab part -->
			<div class="tabbox">
				<ul class="tablink">
					<li><a href="javaScript:void(0);">Keywords</a></li>
					<li><a href="#" class="massa1">Location</a>
					<div class="popshowlocn" id="currency_flg1" style="display:none;">
							<div class="bottompart">
								<div class="midpart">								
									<div class="popshowHd">Choose</div>
									<!--Start Scroll box middle -->
									<div class="scrollBox" id="scrollbar1">
										<div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
										<div class="viewport">
											<div class="overview">
											<?php $locationArr = $this->Fused->fetchBusinessCity(); //pr($locationArr);?>
												<ul>	
													<?php 
													if(!empty($locationArr)){
													foreach($locationArr as $location){
														if(!empty($location['Business']['city'])){?>
													<li><a href="javaScript:void(0);" onclick="return categorysearch('<?php echo $location['Business']['city'];?>','location');"><?php echo $location['Business']['city'];?></a></li>
													<?php } } } ?>
												</ul>
											</div>
										</div>
									</div>
								</div>
							</div>
					  </div>

					</li>
					<li><a href="#" class="massa">Category</a>
					<div class="popshow" id="currency_flg" style="display:none;">
							<div class="bottompart">
								<div class="midpart">								
									<div class="popshowHd">Choose</div>
									<!--Start Scroll box middle -->
									<div class="scrollBox" id="scrollbar1">
										<div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>
										<div class="viewport">
											<div class="overview">
											<?php $categoryArr = $this->Fused->fetchAllBusinessCategories();?>
												<ul>	
													<?php foreach($categoryArr as $category){?>
													<li><a href="javaScript:void(0);" onclick="return categorysearch('<?php echo $category['Category']['id'];?>','category');"><?php echo $category['Category']['name']; ?></a></li>
													<?php } ?>
												</ul>
											</div>
										</div>
									</div>
								</div>
							</div>
					  </div>					
					</li>
				</ul>
				<div class="clr"></div>
			</div>
			<!--End tab part -->
			<div class="whatboxmain">
				<div class="whatbox">
					<div class="whattophd">What?</div>
					<div class="whatinputboxmain">
						<!-- <input name="" type="text" class="whaatinputbg" value="Enter your keyword" onfocus="clearText(this)" onblur="replaceText(this)" /> -->
						<?php echo $this->Form->input('Business.key', array('div'=>false, 'label'=>false, 'error'=>false, 'class'=>'whaatinputbg', 'placeholder'=>'Enter your keyword')); ?>
					</div>
				</div>
				<div class="wharebox">
					<div class="whattophd">Where?</div>
					<div class="whatinputboxmain">
						<!-- <input name="" type="text" class="whaatinputbg" value="Enter your keyword" onfocus="clearText(this)" onblur="replaceText(this)" /> -->
						<?php echo $this->Form->input('Business.loc', array('div'=>false, 'label'=>false, 'error'=>false, 'class'=>'whaatinputbg', 'placeholder'=>'Enter your keyword')); ?>
					</div>
				</div>
				<div class="findbtn" onclick="categorysearch('','normal');"><?php echo $this->Form->submit('front_end/find_btn.gif', array('div'=>false));?></div>
				<div class="clr"></div>
			</div>
		</div>
</div>

<script type="text/javascript">
function categorysearch(keyword,type){
	if(type != ''){
		if(type == 'location'){
			var key = '';
			var loc = '';
			$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH.'businesses/main_header_search/';?>",
			data: "keyword="+keyword+"&type="+type+"&key="+key+"&loc="+loc,
			beforeSend:function(){
			//alert(categoryId);
				var bSend = '<?php echo $this->Html->image("ajax/ajax-loader.gif",array("alt"=>"", "style"=>"margin-left:275px;"));?>'; 
				$('#main_header_search').html(bSend);
				$('#currency_flg1').hide();
			},
			success: function(response){
				$('#main_header_search').html(response);
			}
		});
		} else if(type == 'category'){
			var key = '';
			var loc = '';
			$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH.'businesses/main_header_search/';?>",
			data: "keyword="+keyword+"&type="+type+"&key="+key+"&loc="+loc,
			beforeSend:function(){
			//alert(categoryId);
				var bSend = '<?php echo $this->Html->image("ajax/ajax-loader.gif",array("alt"=>"", "style"=>"margin-left:275px;"));?>'; 
				$('#main_header_search').html(bSend);
				$('#currency_flg').hide();
			},
			success: function(response){
				$('#main_header_search').html(response);
			}
		});
		} else {
			var key = $('#BusinessKey').val();
			var loc = $('#BusinessLoc').val();
			var keyword = '';
			$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH.'businesses/main_header_search/';?>",
			data: "keyword="+keyword+"&type="+type+"&key="+key+"&loc="+loc,
			beforeSend:function(){
			//alert(categoryId);
				var bSend = '<?php echo $this->Html->image("ajax/ajax-loader.gif",array("alt"=>"", "style"=>"margin-left:275px;"));?>'; 
				$('#main_header_search').html(bSend);
				
				
			},
			success: function(response){
				$('#main_header_search').html(response);
			}
		});
		}
	}
}
</script>
