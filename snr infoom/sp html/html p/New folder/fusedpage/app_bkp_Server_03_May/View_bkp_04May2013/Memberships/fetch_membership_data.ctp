<!-- LIST DETAIL OF PLAN PREMIUM START -->
<?php 
echo $this->Form->hidden('Membership.id', array('value'=>$membershipArr['Membership']['id']));
if($membershipArr['Membership']['pricing_year'] != ''){?>
	<div class="yearlybox">
		<input name="plan_type" type="radio" value="year" checked="checked" style="margin:0 6px 3px 0;" />Yearly $<?php echo number_format($membershipArr['Membership']['pricing_year'], 2);?>

		<?php if($membershipArr['Membership']['pricing_tagline'] != ''){?>
			<span>(<?php echo $membershipArr['Membership']['pricing_tagline'];?>)</span>
		<?php } ?>
	</div>
<?php } ?>

<?php if($membershipArr['Membership']['pricing_month'] != ''){?>
	<div class="yearlybox">
		<input name="plan_type" type="radio" value="month" style="margin:0 6px 3px 0;" <?php if($membershipArr['Membership']['pricing_year'] == ''){echo 'checked="checked"';}?>/>Monthly $<?php echo number_format($membershipArr['Membership']['pricing_month'], 2);?>
		<span>(Yearly  $<?php echo number_format((($membershipArr['Membership']['pricing_month'])*12),2);?>)</span>
	</div>
<?php } ?>
<!-- LIST DETAIL OF PLAN PREMIUM END -->