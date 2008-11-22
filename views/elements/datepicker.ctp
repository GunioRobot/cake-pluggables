<?php
	if(!isset($include_js)){
		$include_js = true;		
	}
	if($include_js){
		//include required libraries
		echo $html->css("/jqcake/css/datepicker/ui.datepicker", null, array(), false);
	    echo $javascript->link('/jqcake/js/jquery/ui/packed/ui.datepicker.packed.js');
		echo $javascript->link('/jqcake/js/jquery/ui/i18n/ui.datepicker-ja.js');
	}
	
	if(!isset($multiple)){
		$multiple = false;
	}
?>

<script type="text/javascript" charset="utf-8">
 $(document).ready(function(){
   $.datepicker.regional['ja'];
 });
	jQuery(function($){
		$('#<?= $elementid ?>').datepicker({
			showOn: 'button',
			buttonImage: '<?= $this->webroot ?>jqcake/img/calendar.gif',
			buttonImageOnly: true,
			rangeSeparator: ' ~ '
			<?php 
			if($multiple){
				echo ", rangeSelect: true," . "\n";
				echo "numberOfMonths: 2" ."\n";
			}
			?>
			<?php if(isset($defaultDate) && $defaultDate <> ""){
				$defaultDate = explode("-",$defaultDate);
				echo ", defaultDate: new Date('{$defaultDate[0]}, {$defaultDate[1]}, {$defaultDate[2]}')". "\n"; 
			}
			?>
		}); 
	});
</script>