<?php echo $html->css("/jqcake/css/status_box/status", null, array(), false);  ?>
<div id="status_box">
    <ul id="flow" class="flow">
    <?php $i = 1; 
    foreach($status as $id=>$name): ?>
      <?php 
      $li_class = null;
      if($id==$current){
      	$li_class = "selected";
      }elseif($i==count($status)){
        $li_class = "last";
      }
      ?>
      <li <?php if(!is_null($li_class)) echo 'class="' . $li_class . '"'; ?>><span class="step<?= $i ?>"><?= $name ?></span></li>
 
    <?php $i++; endforeach; ?>
    </ul>
   
</div>
