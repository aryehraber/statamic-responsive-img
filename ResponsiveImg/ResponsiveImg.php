<?php

namespace Statamic\Addons\ResponsiveImg;

use Statamic\API\URL;
use Statamic\API\File;
use Statamic\Assets\Asset;
use Statamic\Extend\Extensible;

class ResponsiveImg
{
    use Extensible;

    public $svg;
    protected $image;
    protected $quality;

    public function __construct(Asset $image, $quality)
    {
        $this->image = $image;
        $this->quality = $quality;

        if (! $this->image) {
            throw new Exception;
        }
    }

    public static function make(Asset $image, $quality)
    {
        return (new self($image, $quality));
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
            'width' => $this->image->width(),
            'height' => $this->image->height(),
            'base64Image' => $base64Image,
        ]);

        return $this->svg = 'data:image/svg+xml;base64,'.base64_encode($svg);
    }

    public function getWidth()
    {
        return $this->image->width();
    }

    protected function calculateWidths()
    {
        $width = $this->image->width();
        $height = $this->image->height();
        $fileSize = $this->image->size();

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
        $image = File::get(urldecode($path));

        return base64_encode($image);
    }

    protected function getManipulatedImage($params = [])
    {
        $default = ['fm' => 'jpg', 'q' => $this->quality];

        return URL::makeRelative($this->image->manipulate(array_merge($default, $params)));
    }
}
