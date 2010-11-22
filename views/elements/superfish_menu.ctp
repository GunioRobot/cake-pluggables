<?php 
echo $html->script("/jqcake/js/superfish/superfish");
echo $html->script("/jqcake/js/superfish/hoverIntent");
?>
<script type="text/javascript">
// initialise plugins
jQuery(function(){
    jQuery('ul.sf-menu').superfish();
});
</script>