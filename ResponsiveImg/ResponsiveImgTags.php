<?php

namespace Statamic\Addons\ResponsiveImg;

use Statamic\API\Asset;
use Statamic\Extend\Tags;

class ResponsiveImgTags extends Tags
{
    /**
     * Handle {{ responsive_img:[name] }} tags
     *
     * @return string
     */
    public function __call($name, $args)
    {
        return $this->index(array_get($this->context, $this->tag_method));
    }

    /**
     * Handle {{ responsive_img image="..." }} tags
     *
     * @return string
     */
    public function index($image = null)
    {
        $image = $image ?: $this->get('image');

        if (! $image = Asset::find($image)) {
            return null;
        }

        return $this->view($this->getViewName(), [
            'attributes' => $this->getAttributeString(),
            'image' => ResponsiveImg::make($image, $this->get('quality', 75)),
        ]);
    }

    protected function getViewName()
    {
        $useDataSrc = $this->getBool('data-src', false) || $this->getBool('data-attr', false);

        return $useDataSrc ? 'img-data-attr' : 'img';
    }
}
