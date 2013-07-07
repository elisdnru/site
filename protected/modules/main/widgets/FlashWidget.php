<?php

class FlashWidget extends DWidget
{
    public $width = 0;
    public $height = 0;
    public $src = '';

     public function run()
     {
         $width = (int)$this->width;
         $height = (int)$this->height;

         if (!$width && !$height)
         {
             $width = 640;
             $height = 480;
         }
         elseif ($width && !$height)
             $height = $width / 640 * 480;
         elseif (!$width && $height)
             $width = $height / 480 * 640;

         $this->render('Flash', array(
             'width'=>$width,
             'height'=>$height,
             'src'=>$this->src,
         ));
     }
}
