<?php if ($session->check('Message.flash')): ?>
<div id="outer_message" style="height:30px">
<script type="text/javascript">
  $(document).ready(function(){
      //$(".message").show();
      $("div.message").fadeTo(10000, 1, function () { $(this).remove(); });     
  });
</script>
<?php $session->flash(); ?>
</div>
<?php endif; ?>