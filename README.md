# ResponsiveImg

**Never think about creating responsive images again.**

This addon makes it super simple to output an `img` with multiple srcset sizes defined to ensure browsers only ever download the size it needs based on the viewport. Additionally, a base64-encoded SVG will be inlined to show a tiny, blurred image while the real image is loading -- this will ensure the image renders at the correct size on initial page load without an extra network request.

For more info on how this works, read Spatie's [Responsive Image docs](https://docs.spatie.be/laravel-medialibrary/v7/responsive-images/getting-started-with-responsive-images).

## Credits

A big thank you to [Spatie](https://spatie.be) for the idea and the recursive size calculation in their [Laravel Medialibrary](https://docs.spatie.be/laravel-medialibrary/v7/responsive-images/getting-started-with-responsive-images#) package.
