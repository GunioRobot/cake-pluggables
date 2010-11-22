<?php if ($this->Session->check('Message.flash')): ?>
<div id="outer_message" style="height:30px">
<script type="text/javascript">
  $(document).ready(function(){
      $("div.message").show();
  });
</script>
<?php
echo $this->Session->flash(); 
echo $this->Session->flash('auth');
?>
</div>
<?php endif; ?>