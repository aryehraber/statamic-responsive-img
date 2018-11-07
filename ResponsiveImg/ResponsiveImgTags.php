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
        $image = array_get($this->context, $this->tag_method);

        if (! $image = Asset::find($image)) {
            return null;
        }

        $glide = json_decode(str_replace("'","\"",$this->getParam('glide')), true);
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
