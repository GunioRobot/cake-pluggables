<form method="post" action="">
    <?= $form->text("Search.{$search_name}.keywords"); ?>
    <input name="search" type="submit" value="<?= __('Search', true); ?>" />
    <br /><br />
</form>
