<?php echo $this->Form->select('state_drop', $statesArr, array('empty'=>'Select', 'class'=>'passinput validate[required]', 'style'=>'padding:5px 5px; width:253px;', 'onchange'=>'return validateStates(this.value);'));?>