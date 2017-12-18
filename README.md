# Link Preview 

This is my first package published via a VCS (git in this case).

I have added new lines to the source of the [original package][original].

This package was created only for my personal use and learning purposes.

___

Using a package directly from Github [requires to add a "repositories" attribute][info] to the `composer.json` for the project that requires the package.

```json
{
  // ...
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/JCarlosR/link-preview"
    }
  ],
  // ...
}
```

I can remove that step uploading the package to packagist. But I won't do that because I just wanted to use the package with small changes.

[original]: https://github.com/dusterio/link-preview
[info]: https://getcomposer.org/doc/02-libraries.md
