<?php echo $html->css("/jqcake/css/status_box/status", null, array(), false);  ?>
<div id="status_box">
    <ul id="flow" class="flow">
    <?php $i = 1; 
    foreach($status as $id=>$name): ?>
      <?php 
      $li_class = null;
      if($i==count($status)){
        $li_class = "last";
      } elseif($id==$current or $id < $current){
			$li_class = "finished";
	  //–¯ŽØ
	  } elseif($id == 87 && $current == 86){
      	$li_class = "selected";
	  } elseif($id == 88 && $current == 86){
      	$li_class = "selected";
      } elseif($id == 89 && $current == 87){
      	$li_class = "selected";
      } elseif($id == 90 && $current == 89){
      	$li_class = "selected";	  
      } elseif($id == 102 && $current == 90){
      	$li_class = "selected";
      } elseif($id == 103 && $current == 102){
      	$li_class = "selected";
		
	  //ŽÐ‘î
	  } elseif($id == 101 && $current == 88){
      	$li_class = "selected";
	  } elseif($id == 102 && $current == 101){
      	$li_class = "selected";
      }	  
      ?>      
      <li <?php if(!is_null($li_class)) echo 'class="' . $li_class . '"'; ?>><span class="step<?= $i ?>"><?= $name ?></span></li>
    <?php $i++; endforeach; ?>
    </ul>
   
</div>
