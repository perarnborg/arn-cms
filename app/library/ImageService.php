<?php
class ImageService {
    private $imageDir;
    private $imageServiceDir;
    function __construct()
    {
        $this->imageDir = '/';
        $this->imageServiceDir = '../../public/images/image_service/';
    }
    public static function getImageServiceUrl($src, $width = null, $height = null, $option = null, $quality = null) {
        $url = '/imagesevice/image'.urlencode($src);
        if($width) {
            $url .= (strpos('?', $url) > -1 ? '&' : '?').'width='.$width;
        }
        if($height) {
            $url .= (strpos('?', $url) > -1 ? '&' : '?').'height='.$height;
        }
        if($option) {
            $url .= (strpos('?', $url) > -1 ? '&' : '?').'option='.$option;
        }
        if($quality) {
            $url .= (strpos('?', $url) > -1 ? '&' : '?').'quality='.$quality;
        }
        return $url;
    }

    public function getImage($src, $width, $height, $quality, $option = 'auto')
    {
        $fileName = $this->generateImage($src, $width, $height, $quality, $option);
        header('Last-Modified: '.gmdate('D, d M Y H:i:s', filemtime($fileName)).' GMT', true, 200);
        header('Content-Length: '.filesize($fileName));
        header('Content-Type: image/' . $this->getImageFileExtension($src));
        print file_get_contents($fileName);
        return true;
    }
    private function generateImage($src, $width, $height, $quality, $option = 'auto')
    {
        $fileName = $this->getImageFileName($src, $width, $height, $quality, $option);
        if(!file_exists($fileName)) {
            $srcFileName = $this->imageDir . $src;
            if(!file_exists($srcFileName)) {
                return false;
            }
            try{
                $resize = new ImageResize($srcFileName);
                if($width != null || $height != null) {
                    $resize->resizeImage($width, $height, $option);                    
                }
                $resize->saveImage($fileName, $quality);
            } catch(Exception $ex) {
                return false;
            }
        }
        return $fileName;
    }
    private function getImageFileName($src, $width, $height, $quality, $option)
    {
        $extension = $this->getImageFileExtension($src);
        return $this->imageServiceDir . 'image-' . str_replace('/', '_', $src) . '-' . $width . '-' . $height . '-' . $option . '-' . $quality . $extension;
    }
    private function getImageFileExtension($src)
    {
        if(strpos($src, '.') > -1) {
            return substr($src, strpos($src, '.') + 1);
        }
        return '';
    }
    public function concatenateImages($fileNames, $savePath, $direction) {
        $spritesWidth = 0;
        $spritesHeight = 0;
        $images = array();
        foreach($fileNames as $fileName) {
            $image = new imageResize($fileName);
            if($direction == 'vertical') {
                $spritesHeight += $image->height;
                if($spritesWidth < $image->width) {
                    $spritesWidth = $image->width;
                }
            } else {
                $spritesWidth += $image->width;
                if($spritesHeight < $image->height) {
                    $spritesHeight = $image->height;
                }
            }
            array_push($images, $image);
        }
        $sprites = imagecreatetruecolor($spritesWidth, $spritesHeight);
        imagealphablending($sprites, false);
        imagesavealpha($sprites,true);
        $transparent = imagecolorallocatealpha($sprites, 255, 255, 255, 127);
        imagefilledrectangle($sprites, 0, 0, $spritesWidth, $spritesHeight, $transparent);
        $positionX = 0;
        $positionY = 0;
        foreach ($images as $i=>$image) {
            imagecopyresampled($sprites, $image->image, $positionX, $positionY, 0, 0, $image->width, $image->height, $image->width, $image->height);
            if($direction == 'vertical') {
                $positionY += $image->height;
            } else {
                $positionX += $image->width;
            }
        }
        imagepng($sprites, $this->imageDir . $savePath, 0);
    }
    public function generateSprites($images, $savePath, $direction, $quality) {
        $fileNames = array();
        foreach($images as $image) {
            $this->generateImage($image->src, $image->width, $image->height, $quality, $image->option);
            $fileName = $this->getImageFileName($image->src, $image->width, $image->height, $quality, $image->option);
            array_push($fileNames, $fileName);
        }
        $this->concatenateImages($fileNames, $savePath, $direction);
    }
}
?>
