<?php
	if(empty($include_js)){
		$include_js = true;		
	}
	if($include_js){
		//include required libraries
		echo $html->css("/jqcake/css/datepicker/ui.datepicker", null, array(), false);
	    echo $html->script('/jqcake/js/jquery/ui/packed/ui.datepicker.packed.js');
		echo $html->script('/jqcake/js/jquery/ui/i18n/ui.datepicker-ja.js');
	}
	
	if(empty($multiple)){
		$multiple = false;
	}
	
	if(empty($rangeSeparator)){
	    $rangeSeparator = ' ~ ';
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
		rangeSeparator: '<?= $rangeSeparator ?>',
		<?php 
        if(!empty($beforeShowDay)){
            echo ", beforeShowDay: $beforeShowDay,";
        }
        
		if($multiple){
			echo "rangeSelect: true,";
			echo "\n\t\t" . "numberOfMonths: 2," ."\n";
		}
		
		if(isset($defaultDate) && $defaultDate <> ""){
			$defaultDate = explode("-",$defaultDate);
			echo ", defaultDate: new Date('{$defaultDate[0]}, {$defaultDate[1]}, {$defaultDate[2]}')". "\n"; 
		}
		?>
	}); 
});
</script>