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
        return $this->index(array_get($this->context, $name));
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

        //retrieve glide parameter from pseudo json
        $glide = json_decode(str_replace("'","\"",$this->getParam('glide')), true);
        if(!is_array($glide)) $glide  = [];

        //if there is a focal crop, set focal in glide syntax
        if(isset($glide["fit"]) && $glide["fit"] == "crop_focal")
        {
            $glide["fit"] = "crop";
            if ($focus = $image->get('focus')) {
                $glide["fit"] .= '-' . $focus;
            }
        }

        $view = $this->getBool('data-attr', false) ? 'img-data-attr' : 'img';

        return $this->view($view, [
            'attributes' => $this->getAttributeString(),
            'image' => ResponsiveImg::make($image, $this->get('quality', 75), $glide),
        ]);
    }
}
