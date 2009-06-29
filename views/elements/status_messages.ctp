<?php if ($session->check('Message.flash')): ?>
<div id="outer_message" style="height:30px">
<script type="text/javascript">
  $(document).ready(function(){
      $("div.message").show();
  });
</script>
<?php $session->flash(); ?>
</div>
<?php endif; ?>