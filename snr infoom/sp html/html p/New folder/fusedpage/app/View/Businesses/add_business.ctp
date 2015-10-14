<!--Page Javascript include start---->
    <?php
        echo $this->Html->script('add_Business/ddaccordion');	
	echo $this->Html->script('add_Business/loopedslider');
	echo $this->Html->script('add_Business/function');
    ?>
    <!--Page Script provided by designer-->
    <script type="text/javascript">
function show_box(c)

{

            if(document.getElementById(c).style.display=='none')

            {
                        document.getElementById(c).style.display='block';
            }

            else
			

            {
                        document.getElementById(c).style.display='none';
            }

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
var tipFontSize= "10pt";
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
<?php echo $this->Html->script('add_Business/rates');	 ?>
<!--Page Javascript include End---->
<?php echo $this->Session->flash();?>
<div class="midinsidemain" style="padding:0px;">
			<div class="businessinbox">
			<?php echo $this->Form->create('Business', array('action'=>'add_business', 'type'=>'file','id'=>'AddBusiness')); ?>

			<?php
				echo $this->Form->hidden('Business.country');
				echo $this->Form->hidden('Business.state');
				echo $this->Form->hidden('Business.state_code');
			 ?>
			<div class="mailtophdbox">
					<div class="insideflhd">Add Business</div>
					<div class="helptext" style="float:left;"><a href="<?php echo SITE_PATH; ?>businesses/business_listings/">Click for search business</a></div>
					<div class="helptext"><a href="#">Help to add your business</a></div>
					<div class="clr"></div>	
				</div>
			<!--Start business box -->	
			<div class="businesstobg">
				<div class="businesstoinputbox">
				 <div class="formlabletop">Business Name:</div>
				 <div class="formfieldtop"><input type="text" class="forminputtop validate[required]" name="data[Business][title]"></div>
				 <div class="questionmark"><a onmouseout="hideTip()" onmouseover="doTooltip(event,0)" href="#"><img alt="" src="<?php echo SITE_PATH.'img/front_end/';?>question_mark_icon.jpg"></a></div>
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
					echo $this->Form->select('Business.subcategory_id', array(), array('div'=>false, 'label'=>false, 'empty'=>'Select', 'class'=>'forminputtopsel'));
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
							<div class="formfieldbig"><input type="text" class="forminputbig validate[required]" name="data[Business][tagline]" maxlength="120"></div>
							<div class="clr"></div>

							<div class="formlablebig">Tags (comma seperated):</div>
							<div class="formfieldbig"><input type="text" class="forminputbig" name="data[Business][tags]" maxlength="255"></div>
							<div class="clr"></div>

							<div class="formlablebig">Email Address:</div>
							<div class="formfieldbig"><input type="text" class="forminputbig validate[required,custom[email]" name="data[Business][email]"></div>
							<div class="questionmark"><a onmouseout="hideTip()" onmouseover="doTooltip(event,1)" href="#"><img alt="" src="<?php echo SITE_PATH.'img/front_end/';?>question_mark_icon.jpg"></a></div>
							<div class="clr"></div>

							<div class="formlablebig">Street:</div>
							<div class="formfieldbig"><input type="text" class="forminputbig validate[required]" name="data[Business][street]"></div>
							<div class="clr"></div>
							<div class="formlablebig">Zip Code:</div>
							<div class="formfieldbig"><input type="text" class="forminputbig validate[required,maxSize[10],custom[onlyLetterNumber]]" name="data[Business][zip]" onkeyup='fetchPostalCode(this.value);' autocomplete='off'></div>
							<div class="clr"></div>
							<div class="formlablebig">City:</div>
							<div class="formfieldbig"><input type="text" class="forminputbig" id="BusinessCity1" name="data[Business][city]" readonly=readonly>
							<div id="suggestions" style="border:1px solid #B8B8B8; width:22%; display:none; position:absolute; background-color:#FFFFFF; margin-top:2px; border-radius:6px; max-height:200px; overflow-x:hidden; overflow-y:scroll;"></div>
							</div>
							
							<div class="clr"></div>
							<div class="formlablebig">Phone No:</div>
							<div class="formfieldbig"><input type="text" class="forminputbig validate[required,custom[phone,maxSize[15]]]" name="data[Business][phone]"></div>
							<div class="clr"></div>
							<div class="formlablebig">Website:</div>
							<div class="formfieldbig"><input type="text" class="forminputbig validate[,custom[url]" name="data[Business][website]"></div>
							<div class="questionmark"><a onmouseout="hideTip()" onmouseover="doTooltip(event,2)" href="#"><img alt="" src="<?php echo SITE_PATH.'img/front_end/';?>question_mark_icon.jpg"></a></div>
							<div class="clr"></div>
							<div class="formlablebig">Hours:</div>
							<div class="textareabox"><textarea class="textareaboxinput" rows="" cols="" name="data[Business][hours]" style="resize:none;"></textarea></div>
							<div class="questionmark"><a onmouseout="hideTip()" onmouseover="doTooltip(event,3)" href="#"><img alt="" src="<?php echo SITE_PATH.'img/front_end/';?>question_mark_icon.jpg"></a></div>
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
							<div class="formfieldbig"><input type="text" class="forminputbig validate[required,custom[phone]" name="data[Business][contact_no]" value="<?php echo $this->Session->read('Auth.User.User.phone'); ?>"></div>
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
						<div class="accordion"><a href="javascript://">Business Images</a></div>
					<span class="accordsuffix"></span></div>
					<div class="categoryitems insPad" contentindex="2c" style="display: none;">
						<div class="accwhitebox">
							<div class="formlablebig">Banner Upload:</div>
							<!-- <div style="background:none; padding-top:11px;" class="formfieldbig validate[required]" id="Banner_parent"><input type="file" size="50" name="data[Business][banners][]" multiple=multiple></div> -->
							<div style="background:none; padding-top:11px;" class="formfieldbig" id="Banner_parent">
								<input type="file" name="data[Business][banners][]">
							</div>
							<div class="clr"></div>	

							<div class="formlablebig">Business Logo:</div>
							<div style="background:none; padding-top:11px;" class="formfieldbig">
								<?php echo $this->Form->file('Business.logo');?>
							</div>
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
							<div class="textareabox"><textarea class="textareaboxinput" rows="" cols="" name="data[Business][about_us]" style="resize:none;"></textarea></div>
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
			success: function(response){// alert(response); return false;
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
		$('#BusinessCity1').val('');
		$('#suggestions').html('');
		$('#suggestions').hide();
	}
}

function validateState(temp){
	$('#BusinessCountry').val(cityArr.data[temp]['Postcode']['CountryName']);
	$('#BusinessState').val(cityArr.data[temp]['Postcode']['ProvinceName']);
	$('#BusinessStateCode').val(cityArr.data[temp]['Postcode']['ProvinceAbbr']);
	$('#BusinessCity1').val(cityArr.data[temp]['Postcode']['CityName']);

	$('#suggestions').html('');
	$('#suggestions').hide();
}
</script>