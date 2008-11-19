<?php //pr($this); ?>
<form method="post" action="">
    <?= $form->text("Search.{$search_name}.keywords"); ?>
    <input type="submit" value="<?= __('Search', true); ?>">
    <br /> <br />
</form>
