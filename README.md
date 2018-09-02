# ResponsiveImg

**Never think about creating responsive images again.**

This addon makes it super simple to output an `img` with multiple srcset sizes defined to ensure browsers only ever download the size it needs based on the viewport. Additionally, a base64-encoded SVG will be inlined to show a tiny, blurred image while the real image is loading -- this will ensure the image renders at the correct size on initial page load without an extra network request.

For more info on how this works, read Spatie's [Responsive Image docs](https://docs.spatie.be/laravel-medialibrary/v7/responsive-images/getting-started-with-responsive-images).

## Example

Below is a simple example with a banner image with a width of 2500px:

```html
---
banner: /assets/img/hero-banner.jpg
---
<div>
  {{ responsive_img:banner }}
</div>
```

Rendered HTML:
```html
<div>
  <img class="w-100"  srcset="/img/containers/main/img/banner.jpg/9a12bee729f5e9d54316cf52c7c32a84.jpg 4048w, /img/containers/main/img/banner.jpg/4213119b5797a6097187c9fabbd7d36b.jpg 3386w, /img/containers/main/img/banner.jpg/d9a2b75c9dade4bde9f3ee753b685774.jpg 2833w, /img/containers/main/img/banner.jpg/edaf92d116165c7886e42690d0a43059.jpg 2370w, /img/containers/main/img/banner.jpg/e3e409c33cadf5eebde31cf4b2d1a739.jpg 1983w, /img/containers/main/img/banner.jpg/21f2e6245018424b2147ac3908ee37ed.jpg 1659w, /img/containers/main/img/banner.jpg/8b86c9c1219d7c7cc214c68da8f35149.jpg 1388w, /img/containers/main/img/banner.jpg/93c7aa86dddb56536fedc38b650fc147.jpg 1161w, /img/containers/main/img/banner.jpg/00151c070cec0d0e1b51dfc3967a3a30.jpg 971w, /img/containers/main/img/banner.jpg/32f32aef3b98a307d357d018fcfac4e0.jpg 813w, /img/containers/main/img/banner.jpg/aef29906c4b3eae64097c922998e5994.jpg 680w, /img/containers/main/img/banner.jpg/d8b5b2ae93234511d65f5508a80b079b.jpg 569w, /img/containers/main/img/banner.jpg/7655c101a179991251bc19b1adc4264d.jpg 476w, /img/containers/main/img/banner.jpg/e77bd6e5356020f568f284482e93f2f3.jpg 398w, /img/containers/main/img/banner.jpg/3af161686714b473dd209871b9e1b9fc.jpg 333w, data:image/svg+xml;base64,PCFET0NUWVBFIHN2ZyBQVUJMSUMgIi0vL1czQy8vRFREIFNWRyAxLjEvL0VOIiAiaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkIj4KPHN2ZyB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHhtbDpzcGFjZT0icHJlc2VydmUiIHg9IjAiCiB5PSIwIiB2aWV3Qm94PSIwIDAgNDA0OCAyNjIzIj4KICA8aW1hZ2Ugd2lkdGg9IjQwNDgiIGhlaWdodD0iMjYyMyIgeGxpbms6aHJlZj0iZGF0YTppbWFnZS9qcGVnO2Jhc2U2NCwvOWovNEFBUVNrWkpSZ0FCQVFFQVlBQmdBQUQvL2dBN1ExSkZRVlJQVWpvZ1oyUXRhbkJsWnlCMk1TNHdJQ2gxYzJsdVp5QkpTa2NnU2xCRlJ5QjJPVEFwTENCeGRXRnNhWFI1SUQwZ056VUsvOXNBUXdBSUJnWUhCZ1VJQndjSENRa0lDZ3dVRFF3TEN3d1pFaE1QRkIwYUh4NGRHaHdjSUNRdUp5QWlMQ01jSENnM0tTd3dNVFEwTkI4bk9UMDRNand1TXpReS85c0FRd0VKQ1FrTUN3d1lEUTBZTWlFY0lUSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5LzhBQUVRZ0FGQUFnQXdFaUFBSVJBUU1SQWYvRUFCOEFBQUVGQVFFQkFRRUJBQUFBQUFBQUFBQUJBZ01FQlFZSENBa0tDLy9FQUxVUUFBSUJBd01DQkFNRkJRUUVBQUFCZlFFQ0F3QUVFUVVTSVRGQkJoTlJZUWNpY1JReWdaR2hDQ05Dc2NFVlV0SHdKRE5pY29JSkNoWVhHQmthSlNZbktDa3FORFUyTnpnNU9rTkVSVVpIU0VsS1UxUlZWbGRZV1ZwalpHVm1aMmhwYW5OMGRYWjNlSGw2ZzRTRmhvZUlpWXFTazVTVmxwZVltWnFpbzZTbHBxZW9xYXF5czdTMXRyZTR1YnJDdzhURnhzZkl5Y3JTMDlUVjF0ZlkyZHJoNHVQazVlYm42T25xOGZMejlQWDI5L2o1K3YvRUFCOEJBQU1CQVFFQkFRRUJBUUVBQUFBQUFBQUJBZ01FQlFZSENBa0tDLy9FQUxVUkFBSUJBZ1FFQXdRSEJRUUVBQUVDZHdBQkFnTVJCQVVoTVFZU1FWRUhZWEVUSWpLQkNCUkNrYUd4d1Frak0xTHdGV0p5MFFvV0pEVGhKZkVYR0JrYUppY29LU28xTmpjNE9UcERSRVZHUjBoSlNsTlVWVlpYV0ZsYVkyUmxabWRvYVdwemRIVjJkM2g1ZW9LRGhJV0doNGlKaXBLVGxKV1dsNWlabXFLanBLV21wNmlwcXJLenRMVzJ0N2k1dXNMRHhNWEd4OGpKeXRMVDFOWFcxOWpaMnVMajVPWG01K2pwNnZMejlQWDI5L2o1K3YvYUFBd0RBUUFDRVFNUkFEOEFvd2FPOG82VmNqMEFoaG5wVGRKMTJOeUZiQXJjT3B3SGdNSytFeEN4Vk9mSTRuMUV1SVhVMWl4YkN4VzJYQXJUMmdyaXNoYjc1dU9sWElyc01Pb3J6YXRPbzNkbkhQR0tzN3Rua2R0SzZuaHNWbzI5ek1aQjg1b29yOW14TkdtNVhjVnNmQ2N6WFU2T3lsZGdNbW0zbHpMRko4akVVVVY4Zk9sRDJ6VmtkMUtVcmJuLzJRPT0iPjwvaW1hZ2U+Cjwvc3ZnPgo= 32w" onload="this.onload=null;this.sizes=Math.ceil(this.getBoundingClientRect().width/window.innerWidth*100)+'vw';" sizes="1px">
</div>
```

## Credits

A big thank you to [Spatie](https://spatie.be) for the idea and the recursive size calculation in their [Laravel Medialibrary](https://docs.spatie.be/laravel-medialibrary/v7/responsive-images/getting-started-with-responsive-images#) package.
