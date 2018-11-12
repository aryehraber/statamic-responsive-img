<?php

namespace Statamic\Addons\ResponsiveImg;

use Statamic\Assets\Asset;
use Statamic\Extend\Extensible;
use Statamic\Imaging\ImageGenerator;

class ResponsiveImg
{
    use Extensible;

    public $svg;
    protected $image;
    protected $quality;
    protected $glide;

    public function __construct(Asset $image, $quality, $glide)
    {
        $this->image = $image;
        $this->quality = $quality;
        $this->glide = $glide;

        if (! $this->image) {
            throw new Exception;
        }
    }

    public static function make(Asset $image, $quality, $glide)
    {
        return (new self($image, $quality, $glide));
    }

    public function getSrc()
    {
        return $this->getManipulatedImage();
    }

    public function getSrcset()
    {
        $srcset = $this->calculateWidths()->map(function ($width) {
            $image = $this->getManipulatedImage(['w' => $width]);

            return "{$image} {$width}w";
        })->implode(', ');

        $srcset .= ", {$this->getSvg()} 32w";

        return $srcset;
    }

    public function getSvg()
    {
        if (! is_null($this->svg)) {
            return $this->svg;
        }

        $base64Image = 'data:image/jpeg;base64,'.$this->getTinyImage();

        $svg = $this->view('svg', [
            'width' => $this->getWidth(),
            'height' => $this->getHeight(),
            'base64Image' => $base64Image,
        ]);

        return $this->svg = 'data:image/svg+xml;base64,'.base64_encode($svg);
    }

    public function getWidth()
    {
        if(isset($this->glide['w']))
            return $this->glide['w'];
        elseif(isset($this->glide['h']))
            return $this->getWidthBasedOnHeight($this->glide['h'],$this->glide);
        return $this->image->width();
    }

    public function getHeight()
    {
        if(isset($this->glide['h']))
            return $this->glide['h'];
        elseif(isset($this->glide['w']))
            return $this->getHeightBasedOnWidth($this->glide['w'],$this->glide);
        return $this->image->height();
    }

    public function getSize()
    {
        $file = 'img/'.app(ImageGenerator::class)->generateByAsset($this->image, $this->glide);
        return filesize($file);
    }

    public function getAspectRatio($params)
    {
        if(isset($params['w']))
            $width = $this->image->width();
        else
            $width = $params['w'];
        if(isset($params['h']))
            $height = $this->image->height();
        else
            $height = $params['h'];
        return $width/$height;
    }

    public function getHeightBasedOnWidth($w,$params)
    {
        return (int)$w/$this->getAspectRatio($params);
    }

    public function getWidthBasedOnHeight($h,$params)
    {
        return (int)$h*$this->getAspectRatio($params);
    }

    protected function calculateWidths()
    {
        $width = $this->getWidth();
        $height = $this->getHeight();
        $fileSize = $this->getSize();

        $targetWidths = collect();

        $targetWidths->push($width);

        $ratio = $height / $width;
        $area = $width * $width * $ratio;

        $predictedFileSize = $fileSize;
        $pixelPrice = $predictedFileSize / $area;

        while (true) {
            $predictedFileSize *= 0.7;
            $newWidth = (int) floor(sqrt(($predictedFileSize / $pixelPrice) / $ratio));

            if ($this->finishedCalculating($predictedFileSize, $newWidth)) {
                return $targetWidths;
            }

            $targetWidths->push($newWidth);
        }
    }

    protected function finishedCalculating(int $predictedFileSize, int $newWidth)
    {
        if ($newWidth < 20) {
            return true;
        }

        if ($predictedFileSize < (1024 * 10)) {
            return true;
        }

        return false;
    }

    protected function getTinyImage()
    {
        $path = $this->getManipulatedImage(['w' => 32, 'blur' => 8]);

        $image = file_get_contents(webroot_path(urldecode($path)));

        return base64_encode($image);
    }

    protected function getManipulatedImage($params = [])
    {
        //add defaults
        $params = array_merge(['fm' => 'jpg', 'q' => $this->quality], $params);

        //negotiate glide params into params
        $glide_params = $this->glide;
        if(isset($params['w'])) unset($glide_params['w']);
        if(isset($params['h'])) unset($glide_params['h']);
        $params = array_merge($glide_params, $params);

        //add missing dimensions according to aspect ratio
        if(isset($params['w']) && !isset($params['h']))
            $params['h'] = $this->getHeightBasedOnWidth($params['w'],$this->glide);
        if(isset($params['h']) && !isset($params['w']))
            $params['w'] = $this->getWidthBasedOnHeight($params['h'],$this->glide);

        return $this->image->manipulate($params);
    }
}
