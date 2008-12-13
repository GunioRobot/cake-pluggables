<?php

/**
 * UploadComponent 
 *
 * @uses        Object
 * @package       
 * @version     $id:$
 * @copyright   1997-2005 The PHP Group
 * @license     PHP Version 3.0 {@link http://www.php.net/license/3_0.txt}
 */
class UploadComponent extends Object {

    // @todo, move this to a client class
    public $valid_types = array('image/jpeg', 'image/png', 'application/pdf');

    /**
     * filename extension getter
     *
     * @param   strlen  $str
     * @access  public
     * @return  string
     */
    public function getFileExtension($str) {
        $i = strrpos($str,".");
        if (!$i) { return ""; }
        $l = strlen($str) - $i;
        $ext = substr($str,$i+1,$l);
        return $ext;
    }

    /**
     * file upload and storer
     *
     * checks if a given file was uploaded and stored correctly
     *
     * @param   Array   $file   a copy of the file information
     *                          returned by $_FILES
     * @param   String  $fname  the filename to use for storing the
     *                          file
     * @access  public
     * @return  Boolean
     */
    public function uploaded_and_stored($file, $fname)
    {
        $tmp = $file['tmp_name'];
        return ($this->isValid($file) && move_uploaded_file($tmp, $fname));
    }

    /**
     * checks if the uploaded file is valid 
     * 
     * @param   Array   $file   same as the one returned by $_FILES
     * @access  public
     * @return  Boolean 
     */
    public function isValid($file)
    {
        return in_array($file['type'], $this->valid_types);
    }

    /**
     * file agregator
     *
     * adds a file to an ad
     *
     * @param   mixed   $file
     * @param   mixed   $target     a blank parameter in which the
     *                              target file witll be written
     * @access  public
     * @return  Boolean
     */
    public function add($file, &$target){
        $target = $this->_generateFilename($file);
        $up_pic = self::target($target);
        $up_thm = self::target($target, true); 
        $stored = $this->uploaded_and_stored($file, $up_pic);

        // do not create thumbnails if file is not supported (pdf)
        if (Image::isValidType(Image::getType($up_pic))) {
            Image::thumbnail($up_pic, $up_thm, 333);
        }

        return ((!Image::isError()) && $stored);
    }

    public static function target($filename, $thumb = false)
    {
        $subdir = 'chirashi';
        if ($thumb) $subdir = 'thumbs';
        return WWW_ROOT . "uploads" . DS . $subdir . DS . $filename;
    }

    /**
     * filename generator
     *
     * @param   Array   $file   a copy of the file information
     *                          returned by $_FILES
     * @access  private
     * @return  String
     */
    private function _generateFilename($file)
    {
        $ext = $this->getFileExtension($file['name']);
        return date('Ymdhis') . "_" . rand(1000, 9999) . "." . $ext;
    }

}

?>
