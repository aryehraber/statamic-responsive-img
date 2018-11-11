<?php

namespace Statamic\Addons\ResponsiveImg;

use Statamic\API\Asset;
use Statamic\Extend\Tags;
use Statamic\API\Path;
use Statamic\Imaging\ImageGenerator;

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

        if(count($glide))
        {
            //compose glide_manipulation identifier
            $file_glide_id = "";
            foreach($glide as $k=>$v)
                $file_glide_id .= $k.'-'.$v.'_';

            //compose new filename based on glide manipulations
            $file_path_el = explode("/",$image->path());
            $file_path_el_new = [];
            foreach($file_path_el as $k=>$fpe)
            {
                if($k==(count($file_path_el)-1))
                    $file_path_el_new[] = $file_glide_id.$fpe;
                else
                    $file_path_el_new[] = $fpe;
            }

            $file_path_new = "glide_manipulations/".implode("/",$file_path_el_new);

            //check if manipulated image is already existent
            if (! $image_new = Asset::find($image->container()->id().'::'.$file_path_new)) {
                //if image is not yet existent, generate it
                $file = app(ImageGenerator::class)->generateByAsset($image, $glide);
                $file = new \Symfony\Component\HttpFoundation\File\UploadedFile('img/'.$file, $file_path_new);

                //ad it as an asset
                $image_new = Asset::create()
                              ->container($image->container())
                              ->path($file_path_new)
                              ->get();
                $image_new->upload($file);
                $image_new->save();

            }
            $image = $image_new;
        }

        $view = $this->getBool('data-attr', false) ? 'img-data-attr' : 'img';

        return $this->view($view, [
            'attributes' => $this->getAttributeString(),
            'image' => ResponsiveImg::make($image, $this->get('quality', 75)),
        ]);
    }
}
