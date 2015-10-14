<!--Page Javascript include start---->
    <?php //pr($this->data);die;
        echo $this->Html->script('add_Business/ddaccordion');	
	echo $this->Html->script('add_Business/loopedslider');
	echo $this->Html->script('add_Business/function');
	echo $this->Html->script('ajax_upload/ajaxupload');
    ?>
    <!--Page Script provided by designer-->
    <script type="text/javascript">
function show_box(c){
            if(document.getElementById(c).style.display=='none')
                        document.getElementById(c).style.display='block';
            else
                        document.getElementById(c).style.display='none';
}
</script>

<script type="text/javascript">
ddaccordion.init({
	headerclass: "expandable", //Shared CSS class name of headers group that are expandable
	contentclass: "categoryitems", //Shared CSS class name of contents group
	revealtype: "click", //Reveal content when user clicks or onmouseover the header? Valid value: "click" or "mouseover
	mouseoverdelay: 200, //if revealtype="mouseover", set delay in milliseconds before header expands onMouseover
	collapseprev: true, //Collapse previous content (so only one open at any time)? true/false 
	defaultexpanded: [0], //index of content(s) open by default [index1, index2, etc]. [] denotes no content
	onemustopen: false, //Specify whether at least one header should be open always (so never all headers closed)
	animatedefault: false, //Should contents open by default be animated into view?
	persiststate: false, //persist state of opened contents within browser session?
	toggleclass: ["", "openheader"], //Two CSS classes to be applied to the header when it's collapsed and expanded, respectively ["class1", "class2"]
	togglehtml: ["prefix", "", ""], //Additional HTML added to the header when it's collapsed and expanded, respectively  ["position", "html1", "html2"] (see docs)
	animatespeed: "fast", //speed of animation: integer in milliseconds (ie: 200), or keywords "fast", "normal", or "slow"
	oninit:function(headers, expandedindices){ //custom code to run when headers have initalized
		//do nothing
	},
	onopenclose:function(header, index, state, isuseractivated){ //custom code to run whenever a header is opened or closed
		//do nothing
	}
})

</script>
<script type="text/javascript">

var dom = (document.getElementById) ? true : false;
var ns5 = (!document.all && dom || window.opera) ? true: false;
var ie5 = ((navigator.userAgent.indexOf("MSIE")>-1) && dom) ? true : false;
var ie4 = (document.all && !dom) ? true : false;
var nodyn = (!ns5 && !ie4 && !ie5 && !dom) ? true : false;

var origWidth, origHeight;

// avoid error of passing event object in older browsers
if (nodyn) { event = "nope" }

///////////////////////  CUSTOMIZE HERE   ////////////////////
// settings for tooltip 
// Do you want tip to move when mouse moves over link?
var tipFollowMouse= true;    
// Be sure to set tipWidth wide enough for widest image
var tipWidth= 250;
var offX= 10;    // how far from mouse to show tip
var offY= 10; 
var tipFontFamily= "Verdana, arial, helvetica, sans-serif";
var tipFontSize = "10pt";
// set default text color and background color for tooltip here
// individual tooltips can have their own (set in messages arrays)
// but don't have to
var tipFontColor= "#333333";
var tipBgColor= "#f5f9fc"; 
var tipBorderColor= "#b2d0eb";
var tipBorderWidth= 1;
var tipBorderStyle= "ridge";
var tipPadding= 4;

// tooltip content goes here (image, description, optional bgColor, optional textcolor)
var messages = new Array();

</script>
 <!--Page Script provided by designer-->
<?php echo $this->Html->script('add_Business/rates');?>
<!--Page Javascript include End---->

<!-- FETCH THE BUSINESS PLAN START -->
<?php $businessPlan = $this->Fused->fetchBusinessMembershipPlan($this->data['Business']['id']);?>
<!-- FETCH THE BUSINESS PLAN START -->
<div class="midinsidemain">
			<div class="businessinbox">
			<?php echo $this->Form->create('Business', array('action'=>'edit_business', 'type'=>'file')); ?>

			<?php
				echo $this->Form->hidden('Business.id');
				echo $this->Form->hidden('Business.country');
				echo $this->Form->hidden('Business.state');
				echo $this->Form->hidden('Business.state_code');
			 ?>
			<div class="mailtophdbox">
					<div class="insideflhd">Edit Business</div>
					<div class="helptext"><a href="#">Help to add your business</a></div>
					<div class="clr"></div>
				</div>
			<!--Start business box -->	
			<div class="businesstobg">
				<div class="businesstoinputbox">
				 <div class="formlabletop">Business Name:</div>
				 <div class="formfieldtop"><input type="text" class="forminputtop validate[required]" name="data[Business][title]" value="<?php echo $this->data['Business']['title']; ?>"></div>
				 <div class="questionmark"><a onmouseout="hideTip()" onmouseover="doTooltip(event,0)" href="#"><img alt="" src="<?php echo SITE_PATH.'img/add_business/';?>question_mark_icon.jpg"></a></div>
				<div class="clr"></div>
				</div>
				<div class="businesstoinputbox">
				 <div class="formlabletopfr">Category:</div>
				 <div class="formfieldtopsel"><? echo $this->Form->input('Business.category_id',array('type'=>'select','label'=>false,'div'=>false,'class'=>'forminputtopsel validate[required]','empty'=>'--Select Category--','onchange'=>'return validate_subcategory(this.value);')); ?></div>
				 <div class="clr"></div>
				</div>
				<div class="clr"></div>
				<div class="businesstoinputbox">
				 <div class="formlabletop">Sub Category:</div>
				 <div class="formfieldtopsel" id="sub-category">
				     <?php 
					echo $this->Form->select('Business.subcategory_id', $this->Fused->fetchAllSubCategories($this->data['Business']['category_id']), array('div'=>false, 'label'=>false, 'empty'=>'Select', 'class'=>'forminputtopsel', 'value'=>$this->data['Business']['subcategory_id']));
			             ?>
				   </div>
				 <div class="clr"></div>
				</div>
				<div class="clr"></div>
			</div>
			<div align="center"><img alt="" src="<?php echo SITE_PATH.'img/front_end/';?>business_btm_shadow.jpg"></div>
			<!--End business box -->
			<!--Start according part -->		
			<div>
				<div class="accordionmainbox">
				<div class="accordion">
					<div class="menuheader expandable" headerindex="0h"><span class="accordprefix"></span>
						<div class="accordion"><a href="javascript://">Business Details</a></div>
					<span class="accordsuffix"></span></div>
					<div class="categoryitems insPad" contentindex="0c" style="display: none;">
						<div class="accwhitebox">
							<div class="formlablebig">Tagline:</div>
							<div class="formfieldbig"><input type="text" class="forminputbig validate[required]" name="data[Business][tagline]" maxlength="120" value="<?php echo $this->data['Business']['tagline'];?>"></div>
							<div class="clr"></div>

							<div class="formlablebig">Tags (comma seperated):</div>
							<div class="formfieldbig"><input type="text" class="forminputbig" name="data[Business][tags]" maxlength="255" value="<?php echo $this->data['Business']['tags'];?>"></div>
							<div class="clr"></div>

							<div class="formlablebig">Email Address:</div>
							<div class="formfieldbig"><input type="text" class="forminputbig validate[required,custom[email]" name="data[Business][email]" value="<?php echo $this->data['Business']['email']; ?>"></div>
							<div class="questionmark"><a onmouseout="hideTip()" onmouseover="doTooltip(event,1)" href="#"><img alt="" src="<?php echo SITE_PATH.'img/add_business/';?>question_mark_icon.jpg"></a></div>
							<div class="clr"></div>

							<div class="formlablebig">Street:</div>
							<div class="formfieldbig"><input type="text" class="forminputbig validate[required]" name="data[Business][street]" value="<?php echo $this->data['Business']['street']; ?>"></div>
							<div class="clr"></div>

							<div class="formlablebig">Zip Code:</div>
							<div class="formfieldbig"><input type="text" class="forminputbig validate[required,maxSize[10],custom[onlyLetterNumber]]" name="data[Business][zip]" onkeyup='fetchPostalCode(this.value);' autocomplete='off' value="<?php echo $this->data['Business']['zip']; ?>"></div>
							<div class="clr"></div>

							<div class="formlablebig">City:</div>
							<div class="formfieldbig"><input type="text" class="forminputbig" id="BusinessCity" name="data[Business][city]" value="<?php echo $this->data['Business']['city'];?>" readonly=readonly>
							<div id="suggestions" style="border:1px solid #B8B8B8; width:22%; display:none; position:absolute; background-color:#FFFFFF; margin-top:2px; border-radius:6px; max-height:200px; overflow-x:hidden; overflow-y:scroll;"></div>
							</div>
							
							<div class="clr"></div>
							<div class="formlablebig">Phone No:</div>
							<div class="formfieldbig"><input type="text" class="forminputbig validate[required,custom[phone,maxSize[15]]]" name="data[Business][phone]" value="<?php echo $this->data['Business']['phone'];?>"></div>
							<div class="clr"></div>

							<div class="formlablebig">Website:</div>
							<div class="formfieldbig">
								<input type="text" class="forminputbig validate[custom[url]]" name="data[Business][website]" value="<?php echo $this->data['Business']['website'];?>">
							</div>
							<div class="questionmark"><a onmouseout="hideTip()" onmouseover="doTooltip(event,2)" href="#"><img alt="" src="<?php echo SITE_PATH.'img/add_business/';?>question_mark_icon.jpg"></a></div>
							<div class="clr"></div>

							<div class="formlablebig">Hours:</div>
							<div class="textareabox">
								<textarea class="textareaboxinput" rows="" cols="" name="data[Business][hours]" style="resize:none;"><?php echo $this->data['Business']['hours']?></textarea>
							</div>
							<div class="questionmark"><a onmouseout="hideTip()" onmouseover="doTooltip(event, 3)" href="#"><img alt="" src="<?php echo SITE_PATH.'img/add_business/';?>question_mark_icon.jpg"></a></div>
							<div class="clr"></div>
						</div>	
					</div>
				</div>
			</div>	
				<div class="accordionmainbox">
				<div class="accordion">
					<div class="menuheader expandable" headerindex="1h"><span class="accordprefix"></span>
						<div class="accordion"><a href="javascript://">Fusedpage Internal Use Only</a></div>
					<span class="accordsuffix"></span></div>
					<div class="categoryitems insPad" contentindex="1c" style="display: none;">
						<div class="accwhitebox">
							<div class="formlablebig">Your Name:</div>
							<div class="formfieldbig"><input type="text" class="forminputbig validate[required]" name="data[Business][your_name]" readonly=readonly value="<?php echo $this->Session->read('Auth.User.User.first_name')." ".$this->Session->read('Auth.User.User.last_name'); ?>"></div>
							<div class="clr"></div>
							<div class="formlablebig">Email Address:</div>
							<div class="formfieldbig"><input type="text" class="forminputbig validate[required]" name="data[Business][your_email]" readonly=readonly value="<?php echo $this->Session->read('Auth.User.User.email'); ?>"></div>
							<div class="clr"></div>
							<div class="formlablebig">Best Number to Contact You:</div>
							<div class="formfieldbig">
								<input type="text" class="forminputbig validate[required,custom[phone]" name="data[Business][contact_no]" value="<?php echo $this->data['Business']['contact_no'];?>">
							</div>
							<div class="clr"></div>
							<!--<div class="formlablebig">Best Time to Contact You:</div>
							<div style="margin-left:10px;" class="stepfieldfr fl">
								<div class="selectmain">
								<select class="selsmlinput" name="">
									<option>8:00 AM</option>
								</select>
							</div>
						<div class="selectmain">
							<select class="selsmlinput" name="">
								<option>Eastern</option>
							</select>
						</div>
							</div>-->
							<div class="clr"></div>
						</div>	
					</div>
				</div>
			</div>
				<div class="accordionmainbox">
				<div class="accordion">
					<div class="menuheader expandable" headerindex="2h"><span class="accordprefix"></span>
						<div class="accordion"><a href="javascript://">Business Image</a></div>
					<span class="accordsuffix"></span></div>
					<div class="categoryitems insPad" contentindex="2c" style="display: none;">
						<div class="accwhitebox">
							
							<!-- BANNER SECTION START -->
							<?php
								$image1 = ''; $image2 = ''; $image3 = ''; $image4 = ''; $image5 = '';
								if(!empty($this->data['BusinessBanner'])){
									echo $this->Form->hidden('Banner.id', array('value'=>$this->data['BusinessBanner'][0]['id']));
									$image1 = $this->data['BusinessBanner'][0]['banner_1'];
									$image2 = $this->data['BusinessBanner'][0]['banner_2'];
									$image3 = $this->data['BusinessBanner'][0]['banner_3'];
									$image4 = $this->data['BusinessBanner'][0]['banner_4'];
									$image5 = $this->data['BusinessBanner'][0]['banner_5'];
								}

							if($businessPlan == '1'){
							?>
							<div class="formlablebig">Banner 1:</div>
							<div style="background:none; padding-top:11px; width:300px;" class="formfieldbig">
								<input type="file" id="banner_1"><?php echo $this->Form->hidden('Banner.banner_1', array('value'=>$image1));?>
								<div id="banner_1_error" style="color:#FF0000;"></div>
							</div>
							<span id="banner_1_span">
							<?php
								if($image1 != ''){
									$image1Path = '../webroot/img/front_end/business/banners/'.$image1;
									if(is_file($image1Path)){
										$image1Path = 'front_end/business/banners/'.$image1;
										echo $this->Image->resize($image1Path, 80, 50, array('alt'=>''));
									}
								}
							?>
							</span>
							<div class="clr"></div>
							<?php }else{ ?>
							<div class="formlablebig">Banner 1:</div>
							<div style="background:none; padding-top:11px; width:300px;" class="formfieldbig">
								<input type="file" id="banner_1"><?php echo $this->Form->hidden('Banner.banner_1', array('value'=>$image1));?>
								<div id="banner_1_error" style="color:#FF0000;"></div>
							</div>
							<span id="banner_1_span">
							<?php
								if($image1 != ''){
									$image1Path = '../webroot/img/front_end/business/banners/'.$image1;
									if(is_file($image1Path)){
										$image1Path = 'front_end/business/banners/'.$image1;
										echo $this->Image->resize($image1Path, 80, 50, array('alt'=>''));
									}
								}
							?>
							</span>
							<div class="clr"></div>

							<div class="formlablebig">Banner 2:</div>
							<div style="background:none; padding-top:11px; width:300px;"" class="formfieldbig">
								<input type="file" id="banner_2"><?php echo $this->Form->hidden('Banner.banner_2', array('value'=>$image2));?>
								<div id="banner_2_error" style="color:#FF0000;"></div>
							</div>
							<span id="banner_2_span">
							<?php
								if($image2 != ''){
									$image1Path = '../webroot/img/front_end/business/banners/'.$image2;
									if(is_file($image1Path)){
										$image1Path = 'front_end/business/banners/'.$image2;
										echo $this->Image->resize($image1Path, 80, 50, array('alt'=>''));
									}
								}
							?>
							</span>
							<div class="clr"></div>

							<div class="formlablebig">Banner 3:</div>
							<div style="background:none; padding-top:11px; width:300px;"" class="formfieldbig">
								<input type="file" id="banner_3"><?php echo $this->Form->hidden('Banner.banner_3', array('value'=>$image3));?>
								<div id="banner_3_error" style="color:#FF0000;"></div>
							</div>
							<span id="banner_3_span">
							<?php
								if($image3 != ''){
									$image1Path = '../webroot/img/front_end/business/banners/'.$image3;
									if(is_file($image1Path)){
										$image1Path = 'front_end/business/banners/'.$image3;
										echo $this->Image->resize($image1Path, 80, 50, array('alt'=>''));
									}
								}
							?>
							</span>
							<div class="clr"></div>

							<div class="formlablebig">Banner 4:</div>
							<div style="background:none; padding-top:11px; width:300px;"" class="formfieldbig">
								<input type="file" id="banner_4"><?php echo $this->Form->hidden('Banner.banner_4', array('value'=>$image4));?>
								<div id="banner_4_error" style="color:#FF0000;"></div>
							</div>
							<span id="banner_4_span">
							<?php
								if($image4 != ''){
									$image1Path = '../webroot/img/front_end/business/banners/'.$image4;
									if(is_file($image1Path)){
										$image1Path = 'front_end/business/banners/'.$image4;
										echo $this->Image->resize($image1Path, 80, 50, array('alt'=>''));
									}
								}
							?>
							</span>
							<div class="clr"></div>

							<div class="formlablebig">Banner 5:</div>
							<div style="background:none; padding-top:11px; width:300px;"" class="formfieldbig">
								<input type="file" id="banner_5"><?php echo $this->Form->hidden('Banner.banner_5', array('value'=>$image5));?>
								<div id="banner_5_error" style="color:#FF0000;"></div>
							</div>
							<span id="banner_5_span">
							<?php
								if($image5 != ''){
									$image1Path = '../webroot/img/front_end/business/banners/'.$image5;
									if(is_file($image1Path)){
										$image1Path = 'front_end/business/banners/'.$image5;
										echo $this->Image->resize($image1Path, 80, 50, array('alt'=>''));
									}
								}
							?>
							</span>
							<div class="clr"></div>
							<?php } ?>
							<!-- BANNER SECTION END -->


							<div class="formlablebig">Upload Logo:</div>
							<div style="background:none; padding-top:11px; width:300px;" class="formfieldbig">
								<?php echo $this->Form->file('Business.logo');?>
							</div>
							<?php echo $this->Html->image("front_end/business/".$this->data['Business']['image'], array("height"=>'50px','width'=>'50px'));?>
							<div class="clr"></div>
						</div>	
					</div>
				</div>
			</div>	
				<div class="accordionmainbox">
				<div class="accordion">
					<div class="menuheader expandable" headerindex="3h"><span class="accordprefix"></span>
						<div class="accordion"><a href="javascript://">About Us</a></div>
					<span class="accordsuffix"></span></div>
					<div class="categoryitems insPad" contentindex="3c" style="display: none;">
						<div class="accwhitebox">
							<div class="formlablebig">About Us:</div>
							<div class="textareabox">
								<textarea class="textareaboxinput" rows="" cols="" name="data[Business][about_us]" style="resize:none;"><?php echo $this->data['Business']['about_us'];?></textarea>
							</div>
							<div class="clr"></div>	
						</div>	
					</div>
				</div>
			</div>		
			<div align="center" style="padding-top:15px;"><?php echo $this->Form->submit('front_end/submit_btn.png'); ?></div>		
			</div>
			</form>
		      </div>
			<!--End according part -->
			<!-- 0 -->
			  <script type="text/javascript">messages[0] = new Array('','Lorem Ipsum is simply dummy text of the printing and typesetting industry.'); </script>
			  <!-- end -->
			  
			  <!-- 1 -->
			  <script type="text/javascript">messages[1] = new Array('','Lorem Ipsum is simply dummy text of the printing and typesetting industry.'); </script>
			  <!-- end -->	
			   <!-- 1 -->
			  <script type="text/javascript">messages[2] = new Array('','Website URL format should be http://www.abc.com'); </script>
			  <!-- end -->	
			  <!-- 1 -->
			  <script type="text/javascript">messages[3] = new Array('','Please provide here your Business Opening and Closing hours.'); </script>
			  <!-- end -->	
			  </div>
<script type="text/javascript">
$(document).ready(function(){
	$('.userdeshboadfl').hide();
	$('#AddBusiness').validationEngine();
});
function validate_subcategory(id){
var type="";
	if(id != ''){
		$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH.'categories/fetch_sub_categories/';?>",
			data: "category_id="+id+"&type="+type,
			beforeSend:function(){
				var bSend = '<div align="left"><?php echo $this->Html->image("ajax/pic-loader.gif", array("alt"=>"Loading...", "border"=>"0", "style"=>"margin-left:10px;"));?></div>';
				$('#sub-category').html(bSend);
			},
			success: function(response){
				$('#sub-category').html(response);	
			}
		});
	}
}
function fetchPostalCode(postCode){
	if(postCode.length >= 5){
		$.ajax({
			type: "POST",
			url: "<?php echo SITE_PATH.'users/fetch_post_codes_details/';?>",
			data: "postcode="+postCode,
			dataType:"json",
			beforeSend:function(){
				var bSend = '<div align="center"><?php echo $this->Html->image("ajax/pic-loader.gif", array("alt"=>"Loading...", "border"=>"0", "align"=>"center"));?></div>';
				$('#suggestions').show();
				$('#suggestions').html(bSend);
			},
			success: function(response){
				if(response.data != ''){
					cityArr = response;
					$('#suggestions').html('');
					for(temp in response.data){
						$('#suggestions').append('<div style="cursor:pointer; margin:2px;" onclick="return validateState('+temp+')">'+response.data[temp]['Postcode']['CityName']+'</div>');
						
					}
				}else
					$('#suggestions').html('<div style="color:#FF0000; margin:2px; text-align:center;">No City Found!!</div>');
			}
		});
	}else{
		$('#BusinessCity').val('');
		$('#suggestions').html('');
		$('#suggestions').hide();
	}
}

function validateState(temp){

	$('#BusinessCountry').val(cityArr.data[temp]['Postcode']['CountryName']);
	$('#BusinessState').val(cityArr.data[temp]['Postcode']['ProvinceName']);
	$('#BusinessStateCode').val(cityArr.data[temp]['Postcode']['ProvinceAbbr']);
	$('#BusinessCity').val(cityArr.data[temp]['Postcode']['CityName']);

	$('#suggestions').html('');
	$('#suggestions').hide();
}

/*-------------  IMAGE UPLOAD SECTION START -----------------------------*/
function validateImageExtention(ext){
	var ret = '';
	if((ext == 'jpg') || (ext == 'jpeg') || (ext == 'png') || (ext == 'gif')){
		ret = '1';
	}else
		ret = '0';
	return ret;
}

$(document).ready(function(){ //alert('test'); return false;
	var FeedsImage = $('#banner_1'), interval;
	new AjaxUpload(FeedsImage, {
		action: "<?php echo SITE_PATH.'businesses/upload_business_banner/';?>",
		name: "image",
		onSubmit : function(file, ext){			
			var ret = validateImageExtention(ext);
			if(ret == '0'){
				$('#banner_1_error').html('<font color="red">Invalid Image!!</font>');
				return false;
			}else
				$('#banner_1_error').html('');

			var bSend = '<?php echo $this->Html->image("ajax/pic-loader.gif", array("alt"=>"Loading...", "border"=>"0", "align"=>"center"));?>';
			$('#banner_1_error').html(bSend);
		},
		onComplete: function(file, response){
			$('#banner_1_error').html('');
			$('#BannerBanner1').val(response);
			if(response != ''){
				var aSend = '<img src="<?php echo SITE_PATH;?>img/front_end/business/banners/'+response+'" style="height:50px; width:80px;"/>';
				$('#banner_1_span').html(aSend);
			}
		}
	});
});
$(document).ready(function(){ //alert('test'); return false;
	var FeedsImage = $('#banner_2'), interval;
	new AjaxUpload(FeedsImage, {
		action: "<?php echo SITE_PATH.'businesses/upload_business_banner/';?>",
		name: "image",
		onSubmit : function(file, ext){			
			var ret = validateImageExtention(ext);
			if(ret == '0'){
				$('#banner_2_error').html('<font color="red">Invalid Image!!</font>');
				return false;
			}else
				$('#banner_2_error').html('');

			var bSend = '<?php echo $this->Html->image("ajax/pic-loader.gif", array("alt"=>"Loading...", "border"=>"0", "align"=>"center"));?>';
			$('#banner_2_error').html(bSend);
		},
		onComplete: function(file, response){
			$('#banner_2_error').html('');
			$('#BannerBanner2').val(response);
			if(response != ''){
				var aSend = '<img src="<?php echo SITE_PATH;?>img/front_end/business/banners/'+response+'" style="height:50px; width:80px;"/>';
				$('#banner_2_span').html(aSend);
			}
		}
	});
});
$(document).ready(function(){ //alert('test'); return false;
	var FeedsImage = $('#banner_3'), interval;
	new AjaxUpload(FeedsImage, {
		action: "<?php echo SITE_PATH.'businesses/upload_business_banner/';?>",
		name: "image",
		onSubmit : function(file, ext){			
			var ret = validateImageExtention(ext);
			if(ret == '0'){
				$('#banner_3_error').html('<font color="red">Invalid Image!!</font>');
				return false;
			}else
				$('#banner_3_error').html('');

			var bSend = '<?php echo $this->Html->image("ajax/pic-loader.gif", array("alt"=>"Loading...", "border"=>"0", "align"=>"center"));?>';
			$('#banner_3_error').html(bSend);
		},
		onComplete: function(file, response){
			$('#banner_3_error').html('');
			$('#BannerBanner3').val(response);
			if(response != ''){
				var aSend = '<img src="<?php echo SITE_PATH;?>img/front_end/business/banners/'+response+'" style="height:50px; width:80px;"/>';
				$('#banner_3_span').html(aSend);
			}
		}
	});
});
$(document).ready(function(){ //alert('test'); return false;
	var FeedsImage = $('#banner_4'), interval;
	new AjaxUpload(FeedsImage, {
		action: "<?php echo SITE_PATH.'businesses/upload_business_banner/';?>",
		name: "image",
		onSubmit : function(file, ext){			
			var ret = validateImageExtention(ext);
			if(ret == '0'){
				$('#banner_4_error').html('<font color="red">Invalid Image!!</font>');
				return false;
			}else
				$('#banner_4_error').html('');

			var bSend = '<?php echo $this->Html->image("ajax/pic-loader.gif", array("alt"=>"Loading...", "border"=>"0", "align"=>"center"));?>';
			$('#banner_4_error').html(bSend);
		},
		onComplete: function(file, response){
			$('#banner_4_error').html('');
			$('#BannerBanner4').val(response);
			if(response != ''){
				var aSend = '<img src="<?php echo SITE_PATH;?>img/front_end/business/banners/'+response+'" style="height:50px; width:80px;"/>';
				$('#banner_4_span').html(aSend);
			}
		}
	});
});
$(document).ready(function(){ //alert('test'); return false;
	var FeedsImage = $('#banner_5'), interval;
	new AjaxUpload(FeedsImage, {
		action: "<?php echo SITE_PATH.'businesses/upload_business_banner/';?>",
		name: "image",
		onSubmit : function(file, ext){			
			var ret = validateImageExtention(ext);
			if(ret == '0'){
				$('#banner_5_error').html('<font color="red">Invalid Image!!</font>');
				return false;
			}else
				$('#banner_5_error').html('');

			var bSend = '<?php echo $this->Html->image("ajax/pic-loader.gif", array("alt"=>"Loading...", "border"=>"0", "align"=>"center"));?>';
			$('#banner_5_error').html(bSend);
		},
		onComplete: function(file, response){
			$('#banner_5_error').html('');
			$('#BannerBanner5').val(response);
			if(response != ''){
				var aSend = '<img src="<?php echo SITE_PATH;?>img/front_end/business/banners/'+response+'" style="height:50px; width:80px;"/>';
				$('#banner_5_span').html(aSend);
			}
		}
	});
});
/*-------------  IMAGE UPLOAD SECTION END   -----------------------------*/
</script>