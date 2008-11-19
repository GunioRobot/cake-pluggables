<?php echo $javascript->link("/jqcake/js/hints/hint"); ?>
<script type="text/javascript">			
	$(document).ready(function() {
		$('input:text').hint();
		$('textarea').hint();
	})
</script>
