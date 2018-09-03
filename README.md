# ResponsiveImg

**Never think about creating responsive images again.**

This addon makes it super simple to output an `img` with multiple srcset sizes defined to ensure browsers only ever download the size it needs based on the viewport. Additionally, a base64-encoded SVG will be inlined to show a tiny, blurred image while the real image is loading -- this will ensure the image renders at the correct size on initial page load without an extra network request.

For more info on how this works, read Spatie's [Responsive Image docs](https://docs.spatie.be/laravel-medialibrary/v7/responsive-images/getting-started-with-responsive-images).

## Example

Below is a simple example of a banner image with a width of 2500px:

```html
---
banner: /assets/img/hero-banner.jpg
---
<div>
  {{ responsive_img:banner attr="class:w-full" }}
</div>
```

Rendered HTML:
```html
<div>
  <img class="w-full" srcset="/img/containers/main/img/banner.jpg/3a679c0fc2a494827cd78b9facbaf696.jpg 2500w, /img/containers/main/img/banner.jpg/86eb8f18c80bc4adb298f7d4aba23d98.jpg 2091w, /img/containers/main/img/banner.jpg/c43a27815f3003963dfe551aa80c088e.jpg 1749w, /img/containers/main/img/banner.jpg/ac56820bdeeb5e996abc606b40945d83.jpg 1464w, /img/containers/main/img/banner.jpg/f5c1a4ee11018fcafe1f07f41d2da07a.jpg 1224w, /img/containers/main/img/banner.jpg/cd8d32990fb26bde830403f19d0a0662.jpg 1024w, /img/containers/main/img/banner.jpg/6561461f81d6540cd5a635bf5d44dde6.jpg 857w, /img/containers/main/img/banner.jpg/019b9c8a02a7dc1291f9e60b29a2fc15.jpg 717w, /img/containers/main/img/banner.jpg/3613eed0a83dcb41766e8afdc425a59b.jpg 600w, /img/containers/main/img/banner.jpg/5495e24e576ba9b9cc2b49a4b4a25957.jpg 502w, /img/containers/main/img/banner.jpg/ffb73621c90e0fe4e7c7d4901dc151cb.jpg 420w, /img/containers/main/img/banner.jpg/6960fb223088098ca0c9b02fc114a087.jpg 351w, /img/containers/main/img/banner.jpg/baaebfbfd6755aa87317a224f9be302a.jpg 294w, /img/containers/main/img/banner.jpg/36bb43d811cccde3d1d5cd63909c48b1.jpg 246w, /img/containers/main/img/banner.jpg/5d6d9b6e1caa09376b1a5b6198a57df4.jpg 205w, data:image/svg+xml;base64,PCFET0NUWVBFIHN2ZyBQVUJMSUMgIi0vL1czQy8vRFREIFNWRyAxLjEvL0VOIiAiaHR0cDovL3d3dy53My5vcmcvR3JhcGhpY3MvU1ZHLzEuMS9EVEQvc3ZnMTEuZHRkIj4KPHN2ZyB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHhtbDpzcGFjZT0icHJlc2VydmUiIHg9IjAiCiB5PSIwIiB2aWV3Qm94PSIwIDAgMjUwMCAxNjIwIj4KICA8aW1hZ2Ugd2lkdGg9IjI1MDAiIGhlaWdodD0iMTYyMCIgeGxpbms6aHJlZj0iZGF0YTppbWFnZS9qcGVnO2Jhc2U2NCwvOWovNEFBUVNrWkpSZ0FCQVFFQVlBQmdBQUQvL2dBN1ExSkZRVlJQVWpvZ1oyUXRhbkJsWnlCMk1TNHdJQ2gxYzJsdVp5QkpTa2NnU2xCRlJ5QjJPVEFwTENCeGRXRnNhWFI1SUQwZ056VUsvOXNBUXdBSUJnWUhCZ1VJQndjSENRa0lDZ3dVRFF3TEN3d1pFaE1QRkIwYUh4NGRHaHdjSUNRdUp5QWlMQ01jSENnM0tTd3dNVFEwTkI4bk9UMDRNand1TXpReS85c0FRd0VKQ1FrTUN3d1lEUTBZTWlFY0lUSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5TWpJeU1qSXlNakl5LzhBQUVRZ0FGQUFnQXdFaUFBSVJBUU1SQWYvRUFCOEFBQUVGQVFFQkFRRUJBQUFBQUFBQUFBQUJBZ01FQlFZSENBa0tDLy9FQUxVUUFBSUJBd01DQkFNRkJRUUVBQUFCZlFFQ0F3QUVFUVVTSVRGQkJoTlJZUWNpY1JReWdaR2hDQ05Dc2NFVlV0SHdKRE5pY29JSkNoWVhHQmthSlNZbktDa3FORFUyTnpnNU9rTkVSVVpIU0VsS1UxUlZWbGRZV1ZwalpHVm1aMmhwYW5OMGRYWjNlSGw2ZzRTRmhvZUlpWXFTazVTVmxwZVltWnFpbzZTbHBxZW9xYXF5czdTMXRyZTR1YnJDdzhURnhzZkl5Y3JTMDlUVjF0ZlkyZHJoNHVQazVlYm42T25xOGZMejlQWDI5L2o1K3YvRUFCOEJBQU1CQVFFQkFRRUJBUUVBQUFBQUFBQUJBZ01FQlFZSENBa0tDLy9FQUxVUkFBSUJBZ1FFQXdRSEJRUUVBQUVDZHdBQkFnTVJCQVVoTVFZU1FWRUhZWEVUSWpLQkNCUkNrYUd4d1Frak0xTHdGV0p5MFFvV0pEVGhKZkVYR0JrYUppY29LU28xTmpjNE9UcERSRVZHUjBoSlNsTlVWVlpYV0ZsYVkyUmxabWRvYVdwemRIVjJkM2g1ZW9LRGhJV0doNGlKaXBLVGxKV1dsNWlabXFLanBLV21wNmlwcXJLenRMVzJ0N2k1dXNMRHhNWEd4OGpKeXRMVDFOWFcxOWpaMnVMajVPWG01K2pwNnZMejlQWDI5L2o1K3YvYUFBd0RBUUFDRVFNUkFEOEFvd2FPOG82VmNqMEFoaG5wVGRKMTJOeUZiQXJjT3B3SGdNSytFeEN4Vk9mSTRuMUV1SVhVMWl4YkN4VzJYQXJUMmdyaXNoYjc1dU9sWElyc01Pb3J6YXRPbzNkbkhQR0tzN3Rua2R0SzZuaHNWbzI5ek1aQjg1b29yOW14TkdtNVhjVnNmQ2N6WFU2T3lsZGdNbW0zbHpMRko4akVVVVY4Zk9sRDJ6VmtkMUtVcmJuLzJRPT0iPjwvaW1hZ2U+Cjwvc3ZnPgo= 32w" onload="this.onload=null;this.sizes=Math.ceil(this.getBoundingClientRect().width/window.innerWidth*100)+'vw';" sizes="1px">
</div>
```

## Credits

A big thank you to [Spatie](https://spatie.be) for the idea and the recursive size calculation in their [Laravel Medialibrary](https://docs.spatie.be/laravel-medialibrary/v7/responsive-images/getting-started-with-responsive-images#) package.
