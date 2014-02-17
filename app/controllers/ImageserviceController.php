<?php

class ImageserviceController extends ControllerBase
{
    public function initialize()
    {        
    }

    public function imageAction($src = false)
    {
        if($src) {
            $width = isset($_GET['width']) ? (int)$_GET['width'] : null;
            $height = isset($_GET['height']) ? (int)$_GET['height'] : null;
            $option = isset($_GET['option']) ? $_GET['option'] : 'auto';
            $quality = isset($_GET['quality']) ? (int)$_GET['quality'] : 95;
            if($src):
                $imageService = new ImageService();
                if($imageService->getImage($src, $width, $height, $quality, $option)){
                    return;
                }
            endif;
        }
        header("HTTP/1.0 404 Not Found");
    }
}
