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

Loop over an array of images using the `assets` tag:

```html
{{ assets:gallery }}
  {{ responsive_img:id attr="class:image-{ index }|alt:{ alt }" }}
{{ /assets:gallery }}
```

To lazy-load images using JS, add the `data-src` option:

```html
{{ responsive_img:[image_name] data-src="true" }}
```

## Parameters

| Name | Type | Default | Description |
|--------|------|---------|-------------|
| `quality` | Integer | `75` | Defines the quality of the image (see [Glide parameters](https://docs.statamic.com/tags/glide#parameters)). |
| `attr` | String | | Add additional HTML attributes to the `<img>` tag, specify multiple attributes by pipe delimiting them. |
| `data-src` | Boolean | `false` | Change `src` & `srcset` into `data-src` & `data-srcset` (for lazy-loading using JS). |
