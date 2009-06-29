<?php 
echo $javascript->link("/jqcake/js/superfish/superfish");
echo $javascript->link("/jqcake/js/superfish/hoverIntent");
?>
<script type="text/javascript">
// initialise plugins
    $(document).ready(function(){ 
        $("ul.sf-menu").superfish({ 
            pathClass:  'current' 
        }); 
    }); 
</script>