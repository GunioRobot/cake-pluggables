<?php
echo $html->css("/jqcake/css/facebox/facebox", null, array(), false); 
echo $javascript->link("/jqcake/js/facebox/facebox");
echo $javascript->link("/jqcake/js/jquery/jquery.livequery");
echo $javascript->link("/jqcake/js/jquery/jquery.bgiframe.pack");
$facebox_img_dir = $this->webroot . "jqcake/img/facebox/";
?>
<script type="text/javascript">
$(document).ready(function(){
  $('a[rel*=facebox]').facebox({
        "opacity":3.0,
        "loadingImage":"<?= $facebox_img_dir . "loading.gif" ?>", 
        "closeImage":"<?= $facebox_img_dir . "closelabel.gif" ?>"
  });
  
  $(function() {
	$('.popup').livequery(function() {
		$(this).bgiframe();
	});	
  }); 
})


/*
jQuery(document).ready(function($) {
  $('a[rel*=facebox]').facebox()
})
*/

</script>