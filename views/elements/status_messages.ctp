<?php if ($session->check('Message.flash')): ?>
<div id="outer_message" style="height:30px">
<script type="text/javascript">
  $(document).ready(function(){
      $("div.message").show();
      //$("div.message").fadeTo(10000, 1);   
  });
</script>
<?php $session->flash(); ?>
</div>
<?php endif; ?>