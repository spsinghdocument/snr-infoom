
<style>
input.gsc-search-button, input.gsc-search-button:hover, input.gsc-search-button:focus {
    background-color: #006BB8;
    background-image: none;
    border-color: #336699;
    filter: none;
}
.cse .gsc-search-button input.gsc-search-button-v2, input.gsc-search-button-v2 {
    height: 18px;
    margin-top: 2px;
    min-width: 13px;
    padding: 6px 27px;
    width: 13px;
}

.cse .gsc-control-cse, .gsc-control-cse {
    background: none!important;
    border: none!important;
}

.gsc-control-cse {
   background-color: #none!important;
   border: none!important;
    font-family: Arial,sans-serif;
}



input {
    font-family: Arial,Helvetica,sans-serif;
    font-size: 12px;
    vertical-align: middle;
}

.cse .gsc-control-cse div, .gsc-control-cse div {
}
.gsc-control-cse div {
    position: static;
}
input.gsc-input, .gsc-input-box, .gsc-input-box-hover, .gsc-input-box-focus {
    border-color: #CCCCCC;
    padding: 3px;
}
.gsc-input-box {
    background: none repeat scroll 0 0 #FFFFFF;
    border: 1px solid #D9D9D9;
    height: 25px;
}
</style>
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
												<ul id="more_city">	
													<?php if(!empty($locationArr)){
														foreach($locationArr as $location){
														if(!empty($location['Business']['city'])){?>
													<li><a href="javaScript:void(0);" onclick="return categorysearch('<?php echo $location['Business']['city'];?>','location');"><?php echo $location['Business']['city'];?></a></li>
													<?php } } }?>
												</ul>
												<div style="float:right; margin-right:10px;"><a href="javaScript:void(0);" onclick="return moreCity();" style="background:none!important;"><span id="see" style="color:red;" onclick="return seemorecat();">See more</span></a>
												<a href="javaScript:void(0);" onclick="return popularCity();" style="background:none!important;"><span id="popular" style="color:red; display:none;" onclick="return seepopcat();">Popular city</span></a></div>
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
												<ul id="more_category">	
													<?php if(!empty($categoryArr)){
														foreach($categoryArr as $category){
														if(!empty($category['Category']['name'])){?>

													<li><a href="javaScript:void(0);" onclick="return categorysearch('<?php echo $category['Category']['id'];?>','category');"><?php echo $category['Category']['name']; ?></a></li>
													<?php } } }?>
												</ul>
												<div style="float:right; margin-right:10px;"><a href="javaScript:void(0);" onclick="return moreCategory();" style="background:none!important;"><span id="see1" style="color:red;" onclick="return seemorecity();">See more</span></a>
												<a href="javaScript:void(0);" onclick="return popularCategory();" style="background:none!important;"><span id="popular1" style="color:red; display:none;" onclick="return seepopcity();">Popular category</span></a></div>
												
												
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

			<!--
				<div id="cse-search-form" style="width: 100%;">Loading</div>
				<script src="http://www.google.com/jsapi" type="text/javascript"></script>
				<script type="text/javascript">
				  google.load('search', '1', {language : 'en'});
				  google.setOnLoadCallback(function() {
					
					var customSearchOptions = {};
					var imageSearchOptions = {};
					 imageSearchOptions['layout'] = 'google.search.ImageSearch.LAYOUT_COLUMN';
					 customSearchOptions['enableImageSearch'] = true;
					
					var customSearchControl = new google.search.CustomSearchControl('014578160933466534636:oxac7gi6hle', customSearchOptions);
					customSearchControl.setResultSetSize(google.search.Search.FILTERED_CSE_RESULTSET, customSearchOptions);
					var options = new google.search.DrawOptions();
					options.setSearchFormRoot('cse-search-form');
					customSearchControl.draw('cse', options);
				  }, true);
				 
				</script>
				-->



					<div id='cse-search-form' style='width: 100%;'>Loading</div>
				<script src='http://www.google.com/jsapi' type='text/javascript'></script>
				<script type='text/javascript'>
				google.load('search', '1', {language: 'en'});
				google.setOnLoadCallback(function() {
				  var customSearchOptions = {};
				  var imageSearchOptions = {};
				  imageSearchOptions['layout'] = 'google.search.ImageSearch.LAYOUT_COLUMN';
				  customSearchOptions['enableImageSearch'] = true;
				  var customSearchControl =   new google.search.CustomSearchControl('014578160933466534636:oxac7gi6hle');
				  customSearchControl.setResultSetSize(google.search.Search.FILTERED_CSE_RESULTSET);
				  var options = new google.search.DrawOptions();
	
				  options.setSearchFormRoot('cse-search-form');
				  customSearchControl.draw('cse', options);

				}, true);
				</script>


				<link rel="stylesheet" href="http://www.google.com/cse/style/look/default.css" type="text/css" />

				

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

function moreCategory(){
	$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH.'businesses/fetch_all_category/';?>",
			//data: "keyword="+keyword+"&type="+type+"&key="+key+"&loc="+loc,
			beforeSend:function(){
			//alert(categoryId);
				var bSend = '<?php echo $this->Html->image("ajax/ajax-loader.gif",array("alt"=>"", "style"=>"margin-left:275px;"));?>'; 
				$('#more_category').html(bSend);
				
				
			},
			success: function(response){
				$('#more_category').html(response);
			}
		});
}

function popularCategory(){
	$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH.'businesses/fetch_popular_category/';?>",
			//data: "keyword="+keyword+"&type="+type+"&key="+key+"&loc="+loc,
			beforeSend:function(){
			//alert(categoryId);
				var bSend = '<?php echo $this->Html->image("ajax/ajax-loader.gif",array("alt"=>"", "style"=>"margin-left:275px;"));?>'; 
				$('#more_category').html(bSend);
				
				
			},
			success: function(response){
				$('#more_category').html(response);
			}
		});
}

function moreCity(){
	$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH.'businesses/fetch_all_city/';?>",
			//data: "keyword="+keyword+"&type="+type+"&key="+key+"&loc="+loc,
			beforeSend:function(){
			//alert(categoryId);
				var bSend = '<?php echo $this->Html->image("ajax/ajax-loader.gif",array("alt"=>"", "style"=>"margin-left:275px;"));?>'; 
				$('#more_city').html(bSend);
				
				
			},
			success: function(response){
				$('#more_city').html(response);
			}
		});
}

function popularCity(){
	$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH.'businesses/fetch_popular_city/';?>",
			//data: "keyword="+keyword+"&type="+type+"&key="+key+"&loc="+loc,
			beforeSend:function(){
			//alert(categoryId);
				var bSend = '<?php echo $this->Html->image("ajax/ajax-loader.gif",array("alt"=>"", "style"=>"margin-left:275px;"));?>'; 
				$('#more_city').html(bSend);
				
				
			},
			success: function(response){
				$('#more_city').html(response);
			}
		});
}

function seemorecat(){
	$('#popular').show();
	$('#see').hide();
}

function seepopcat(){
	$('#popular').hide();
	$('#see').show();
}

function seemorecity(){
	$('#popular1').show();
	$('#see1').hide();

}

function seepopcity(){
	$('#popular1').hide();
	$('#see1').show();

}
</script>
