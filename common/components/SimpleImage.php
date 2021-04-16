<?php
namespace common\components;

class SimpleImage {

    var $image;
    var $image_type;
    var $image_info;

    function load($filename) {
        $this->image_info = getimagesize($filename);
        $this->image_type = $this->image_info[2];
        if( $this->image_type == IMAGETYPE_JPEG ) {
            $this->image = imagecreatefromjpeg($filename);
        } elseif( $this->image_type == IMAGETYPE_GIF ) {
            $this->image = imagecreatefromgif($filename);
        } elseif( $this->image_type == IMAGETYPE_PNG ) {
            $this->image = imagecreatefrompng($filename);
        }
    }
    function save($filename, $image_type=IMAGETYPE_PNG, $compression=75, $permissions=null) {
        if( $image_type == IMAGETYPE_JPEG ) {
            imagejpeg($this->image,$filename,$compression);
        } elseif( $image_type == IMAGETYPE_GIF ) {
            imagegif($this->image,$filename);
        } elseif( $image_type == IMAGETYPE_PNG ) {
            imagepng($this->image,$filename);
        }
        if( $permissions != null) {
            chmod($filename,$permissions);
        }
    }
    function output($image_type=IMAGETYPE_JPEG) {
        if( $image_type == IMAGETYPE_JPEG ) {
            imagejpeg($this->image);
        } elseif( $image_type == IMAGETYPE_GIF ) {
            imagegif($this->image);
        } elseif( $image_type == IMAGETYPE_PNG ) {
            imagepng($this->image);
        }
    }
    function getWidth() {
        return imagesx($this->image);
    }
    function getHeight() {
        return imagesy($this->image);
    }
    function resizeToHeight($height) {
        $ratio = $height / $this->getHeight();
        $width = $this->getWidth() * $ratio;
        $this->resize(floor($width),floor($height), false);
    }
    function resizeToWidth($width) {
        $ratio = $width / $this->getWidth();
        $height = $this->getHeight() * $ratio;
        $this->resize(floor($width),floor($height), false);
    }
    function scale($scale) {
        $width = $this->getWidth() * $scale/100;
        $height = $this->getHeight() * $scale/100;
        $this->resize($width,$height, false);
    }
    function resize($width,$height, $check = true, $dst_x = 0, $dst_y = 0) {
        $new_image = imagecreatetruecolor($width, $height);

        $col_transparent = imagecolorallocatealpha($new_image, 255, 255, 255, 127);
        imagefill($new_image, 0, 0, $col_transparent);  // set the transparent colour as the background.
        imagecolortransparent ($new_image, $col_transparent); // actually make it transparent


        if($check) {
            $org_width  = $this->image_info[0];
            $org_height  = $this->image_info[1];

            if($org_width >= $org_height) {
                if($org_width > $width) {
                    $this->resizeToWidth($width);
                    $dst_x = 0;
                    $dst_y = floor(($height - $this->getHeight()) / 2);
                    $width = $this->getWidth();
                    $height = $this->getHeight();
                }
                else {
                    $dst_x = floor(($width - $this->getWidth()) / 2);
                    $dst_y = floor(($height - $this->getHeight()) / 2);
                    $width = $this->getWidth();
                    $height = $this->getHeight();
                }
            }
            elseif($org_height > $org_width) {
                if($org_height > $height) {
                    $this->resizeToHeight($height);
                    $dst_x = floor(($width - $this->getWidth()) / 2);
                    $dst_y = 0;
                    $width = $this->getWidth();
                    $height = $this->getHeight();
                }
                else {
                    $dst_x = floor(($width - $this->getWidth()) / 2);
                    $dst_y = floor(($height - $this->getHeight()) / 2);
                    $width = $this->getWidth();
                    $height = $this->getHeight();
                }
            }
        }



        imagecopyresampled($new_image, $this->image, $dst_x, $dst_y, 0, 0, $width, $height, $this->getWidth(), $this->getHeight());

        imagesavealpha($new_image, true);

        $this->image = $new_image;

    }
}
?>