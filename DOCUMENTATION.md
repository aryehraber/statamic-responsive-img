## Installation

1. Simply copy the `ResponsiveImg` folder into `site/addons/`.
2. Ensure you are [Serving Cached Images Directly](https://docs.statamic.com/tags/glide#serving-cached-images)
3. That's it!

## Usage

ResponsiveImg makes use of Statamic's shorthand tag syntax:

```html
{{ responsive_img:[image_name] }}
```

Add additional attributes by using the `attr` option:

```html
{{ responsive_img:[image_name] attr="id:my-id|class:some-class" }}
```
