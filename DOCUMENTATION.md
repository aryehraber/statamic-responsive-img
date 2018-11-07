## Installation

1. Simply copy the `ResponsiveImg` folder into `site/addons/`
2. Ensure you are [Serving Cached Images Directly](https://docs.statamic.com/tags/glide#serving-cached-images)
3. That's it!

## Usage

ResponsiveImg makes use of Statamic's shorthand tag syntax:

```html
{{ responsive_img:[image_name] }}
```

Add additional attributes by using the `attr` option:

```html
{{ responsive_img:[image_name] attr="id:my-id|class:some-class|alt:Lorem Ipsum" }}
```

To lazy-load images using JS, add the `data-attr` option:

```html
{{ responsive_img:[image_name] data-attr="true" }}
```

Loop over an array of images using the `assets` tag:

```html
{{ assets:gallery }}
  {{ responsive_img:id attr="class:image-{ index }|alt:{ alt }" }}
{{ /assets:gallery }}
```

To add glide image manipulation parameters, add the `glide` option with pseudo json (using '' instead of "" for values):

```html
{{ responsive_img:url glide="{'w':800,'h':500,'fit':'crop_focal'}" attr="class:w-full" data-attr="false" quality="83" }}
```

## Parameters

| Name | Type | Default | Description |
|--------|------|---------|-------------|
| `quality` | Integer | `75` | Defines the quality of the image (see [Glide parameters](https://docs.statamic.com/tags/glide#parameters)). |
| `attr` | String | | Add additional HTML attributes to the `<img>` tag, specify multiple attributes by pipe delimiting them. |
| `data-attr` | Boolean | `false` | Change `src` & `srcset` into data-attributes (for lazy-loading using your own JS). |
| `glide` | Json | `null` | Add glide image manipulation paramaters including 'fit':'crop_focal' to use focal point from statamic. |
