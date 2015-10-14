<div class="headerMidbox">
	<div class="headermidbg">
		<!--Start tab part -->
		<div class="tabbox">
			<ul class="tablink">
				<li><a href="javascript:void(0);" class="sel">Keywords</a></li>
				<li><a href="javascript:void(0);">Location</a></li>
				<li><a href="javascript:void(0);">Category</a></li>
			</ul>
			<div class="clr"></div>
		</div>
		<!--End tab part -->
		<div class="whatboxmain">
			<div class="whatbox">
				<div class="whattophd">What?</div>
				<div class="whatinputboxmain">
					<input name="" type="text" class="whaatinputbg" value="Enter your keyword" onfocus="clearText(this)" onblur="replaceText(this)" />
				</div>
			</div>
			<div class="wharebox">
				<div class="whattophd">Where?</div>
				<div class="whatinputboxmain">
					<input name="" type="text" class="whaatinputbg" value="Enter your keyword" onfocus="clearText(this)" onblur="replaceText(this)" />
				</div>
			</div>
			<div class="findbtn"><?php echo $this->Form->submit('front_end/find_btn.gif', array('div'=>false));?></div>
			<div class="clr"></div>
		</div>
	</div>
</div>