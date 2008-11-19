<?php 
echo $html->css("/jqcake/css/superfish/superfish", null, array(), true); 
echo $javascript->link("/jqcake/js/superfish/superfish");
echo $javascript->link("/jqcake/js/superfish/hoverIntent");
?>
<script type="text/javascript">
// initialise plugins
jQuery(function(){
    jQuery('ul.sf-menu').superfish();
});
</script>