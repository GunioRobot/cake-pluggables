<?php

/**
 * Image manipulation tools
 *
 * <code>
 *
 *  // filename of the exitent-image to work with
 *  $source = 'x.jpg';
 *
 *  // filename of the thumbnail to create
 *  $target = 'x_thumb.jpg';
 *
 *  // attempt to create the thumbnail with size 222
 *  Image::thumbnail($source, $target, 222);
 *
 *  // check if the image was created? 
 *  if (Image::isError()) {
 *      // show error if failed
 *      echo Image::getError();
 *  }
 *
 * </code>
 * 
 * @package       
 * @version     $Id:$
 * @copyright   1997-2005 The PHP Group
 * @license     PHP Version 3.0 {@link http://www.php.net/license/3_0.txt}
 */
class Image
{
    const TYPE_JPG = 'jpg';
    const TYPE_PNG = 'png';
    const TYPE_ERR = 'err';

    private static $error = '';
    private static $template = '

        ERROR!! Thumbnail can not be created! 
        %s
        
        
        ';

    public static function per($old, $size)
    {
        return $size * 100 / $old;
    }

    public static function thumbnail($source, $target, $size)
    {
        $type = self::getType($source);

        if (self::isValidType($type)) {
            if (!file_exists($source)) {
                self::buildError("Thumbnail source ($source) was not found");
                return;
            }
            if (self::isJpeg($type)) {
                $fh = imagecreatefromjpeg($source);
            } else {
                $fh = imagecreatefrompng($source);
            }
        } else {
            self::buildError("File type ($source) is not supported!");
            return;
        }

        $true_width = imagesx($fh);
        $true_height = imagesy($fh);

        if ($true_width < $size) {
            return copy($source, $target);
        }

        $per = self::per($true_width, $size);
        $width = $true_width / 100 * $per;
        $height = $true_height / 100 * $per;

        $res = imagecreatetruecolor($width, $height);
        $sampled = imagecopyresampled($res, $fh, 0, 0, 0, 0, $width, $height,
            $true_width, $true_height);

        ob_start();
        if (self::isJpeg($type)) {
            imagejpeg($res);
        } else {
            imagepng($res);
        }
        $data = ob_get_contents();
        ob_end_clean();

        file_put_contents($target, $data);
    }

    public static function getType($fname)
    {
        if (preg_match('/\.jpg$/i', $fname)) {
            return self::TYPE_JPG;
        }
        if (preg_match('/\.png$/i', $fname)) {
            return self::TYPE_PNG;
        }
        return self::TYPE_ERR;
    }

    public static function getError()
    {
        return self::$error;
    }

    public static function isError()
    {
        return (self::$error != '');
    }

    public static function isJpeg($type)
    {
        return self::TYPE_JPG == $type;
    }

    public static function isPng($type)
    {
        return self::TYPE_PNG == $type;
    }

    public static function isValidType($type)
    {
        return in_array($type, self::getValidTypes());
    }

    public static function getValidTypes()
    {
        return array(self::TYPE_PNG, self::TYPE_JPG);
    }

    private static function buildError($msg)
    {
        self::$error = sprintf(self::$template, $msg);
    }

}

?>
