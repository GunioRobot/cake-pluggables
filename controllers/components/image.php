<?php

require_once APP_DIR . '/plugins/jqcake/vendors/lib/' . 'image.php';

/**
 * ImageComponent
 *
 * @uses Image
 */
class ImageComponent extends Object
{

    protected $file = array();

    /**
     * file setter
     *
     * @param string $file $_FILES result (for one file upload only)
     *
     * @access public
     * @return void
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * add
     *
     * aggregates a image to the file system prefixing its name with
     * company id.
     *
     * @param string $type the type of image that is being uploaded,
     * a valid type can be a lowercassed model name to which images
     * are to be mapped
     * @param string $company_id company id to prefix the filename
     *
     * @access public
     * @return boolean
     */
    public function add($type, $company_id)
    {
        if (!$this->found()) return false;

        $name        = $this->file['name'];
        $source      = $this->file['tmp_name'];
        $img_dir     = "img/uploads/$type";
        $tmb_dir     = "img/uploads/$type/small";
        $file_format = WWW_ROOT . '%s/%s_%s';

        $target_file = sprintf($file_format, $img_dir, $company_id, $name);
        $thumbl_file = sprintf($file_format, $tmb_dir, $company_id, $name);
        $uploaded    = is_uploaded_file($source);

        if ($uploaded && move_uploaded_file($source, $target_file)) {
            Image::thumbnail($target_file, $thumbl_file, 200);
        }

        return (file_exists($target_file) && file_exists($thumbl_file));
    }

    /**
     * image detector
     *
     * tells if the image was uploaded and its ready to be processed
     *
     * @access public
     * @return boolean
     */
    public function found()
    {
        # file must be array
        if (!is_array($this->file)) return false;

        # file must have 'name' & 'tmp_name'
        if (empty($this->file['name']) || empty($this->file['tmp_name'])) {
            return false;
        }
        return true;
    }

    /**
     * gets the original name of the image
     *
     * @access public
     * @return string image filename
     */
    public function getName()
    {
        if ($this->found($this->file)) {
            return basename($this->file['name']);
        } else {
            return '';
        }
    }
}

?>
