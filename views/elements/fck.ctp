<?php
require_once('plugins/jqcake/vendors/fckeditor/fckeditor.php');
$sBasePath =  $this->webroot . "fckeditor/";
$skinpath = $sBasePath . 'editor/skins/' . 'office2003/';

$oFCKeditor = new FCKeditor("data[$model][$field]") ;
$oFCKeditor->BasePath	= $sBasePath ;
$oFCKeditor->Config['AutoDetectLanguage']	= false ;
$oFCKeditor->Config['DefaultLanguage'] = 'ja';
$oFCKeditor->Config['SkinPath'] = $skinpath;
if(!empty($this->data[$model][$field])){
	$oFCKeditor->Value	= $this->data[$model][$field] ;
}
$oFCKeditor->Create() ;
?>
