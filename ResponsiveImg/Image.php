<?php

namespace Statamic\Addons\ResponsiveImg;

use Statamic\Assets\Asset;
use Statamic\Extend\Extensible;

class Image
{
    use Extensible;

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

    public static function getSrcset(Asset $image, $quality)
    {
        return (new self($image, $quality))->srcset();
    }

    public function srcset()
    {
        $srcset = $this->calculateWidths()->map(function ($width) {
            $image = $this->getManipulatedImage(['w' => $width]);

            return "{$image} {$width}w";
        })->implode(', ');

        $srcset .= ", {$this->generateSvg()} 32w";

        return $srcset;
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

    protected function generateSvg()
    {
        $base64Image = 'data:image/jpeg;base64,'.$this->getTinyImage();

        $svg = $this->view('svg', [
            'imageWidth' => $this->image->width(),
            'imageHeight' => $this->image->height(),
            'base64Image' => $base64Image,
        ]);

        return 'data:image/svg+xml;base64,'.base64_encode($svg);
    }

    protected function getTinyImage()
    {
        $imagePath = $this->getManipulatedImage(['w' => 32, 'blur' => 8]);

        return base64_encode(file_get_contents(webroot_path($imagePath)));
    }

    protected function getManipulatedImage($params)
    {
        $default = ['fm' => 'jpg', 'q' => $this->quality];

        return $this->image->manipulate(array_merge($default, $params));
    }
}
