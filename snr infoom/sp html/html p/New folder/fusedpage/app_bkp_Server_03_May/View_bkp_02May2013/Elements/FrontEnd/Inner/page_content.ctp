<?php for($i=1; $i<=5; $i++){?>
<div class="deshlistbox">
	<div class="deshboadflimg">
		<?php echo $this->Html->image('front_end/desh_boad_list_img_sml.jpg', array('alt'=>''));?>
	</div>

	<div class="deshboarlistfrbox">
		<div class="busnissimgfrhd">
			<a href="javascript:void(0);">Coffee one</a>
		</div>
		<div class="deshtextsml">Toronto</div>
		<div class="deshboardbluetext">
			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis diam quam, mollis vitae dictum sit amet, sollicitudin ac enim...
		</div>

		<div class="deshboardwhitebox">
			<div class="likeboxfl">
				<div class="deshboardsmlimg">
					<a href="javascript:void(0);"><?php echo $this->Html->image('front_end/desh_board_sml_img1.jpg', array('alt'=>''));?></a>
				</div>
				<div class="deshboardsmlimg">
					<a href="javascript:void(0);"><?php echo $this->Html->image('front_end/busniss_dtl_sml_img1.jpg', array('alt'=>''));?></a>
				</div>
				<div class="deshboardsmlimg">
					<a href="javascript:void(0);"><?php echo $this->Html->image('front_end/desh_board_sml_img2.jpg', array('alt'=>''));?></a>
				</div>
				<div class="deshboardsmlimg">
					<a href="javascript:void(0);"><?php echo $this->Html->image('front_end/desh_board_sml_img3.jpg', array('alt'=>''));?></a>
				</div>
				<div class="deshboardsmlimg">
					<a href="javascript:void(0);"><?php echo $this->Html->image('front_end/busniss_dtl_sml_img4.jpg', array('alt'=>''));?></a>
				</div>
			</div>

			<div class="likeboxfr">
				<a href="javascript:void(0);"><?php echo $this->Html->image('front_end/like_icon.jpg', array('alt'=>''));?></a><span>20 People</span> recommended this
			</div>
			<div class="clr"></div>

			<div class="coomentlinbox">
				<div class="commentfltext"><span>3  People </span>you know recommended this</div>
				<div class="commentfrlink"><a href="javascript:void(0);">Comments</a></div>
				<div class="clr"></div>
			</div>

			<div>
				<div class="commentflimg">
					<?php echo $this->Html->image('front_end/comment_fl_img.jpg', array('alt'=>''));?>
				</div>

				<div class="commentfrboxmain">
					<div class="commetarrow">
						<?php echo $this->Html->image('front_end/comment_arrow.jpg', array('alt'=>''));?>
					</div>
						<textarea name="" cols="" rows="" class="commentfrbox"></textarea>
				</div>
				<div class="clr"></div>
			</div>
		</div>
	</div>					
	<div class="clr"></div>
	<div class="pstbtn">
		<?php echo $this->Form->submit('front_end/post_btn.png', array('div'=>false));?>
	</div>
</div>
<?php } ?>