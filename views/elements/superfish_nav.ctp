<?php 
echo $html->script("/jqcake/js/superfish/superfish");
echo $html->script("/jqcake/js/superfish/hoverIntent");
?>
<script type="text/javascript">
// initialise plugins
$(document).ready(function(){ 
    $("ul.sf-menu").superfish({ 
        pathClass:  'current' 
    }); 
}); 
</script>