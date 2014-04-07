LinkPreview [![Build Status](https://secure.travis-ci.org/kasp3r/link-preview.png)](http://travis-ci.org/kasp3r/link-preview)
===========

A PHP library to easily get website information (title, description, image...) from given url.

## Dependencies

* PHP >= 5.3
* Guzzle

## Installation

### composer

To install LinkPreview with composer you need to create `composer.json` in your project root and add:

```json
{
    "require": {
        "kasp3r/link-preview": "dev-master"
    }
}
```

Then run

```bash
$ wget -nc http://getcomposer.org/composer.phar
$ php composer.phar install
```

Library will be installed in vendor/kasp3r/link-preview

In your project include composer autoload file from vendor/autoload.php

## Usage

```php
$linkPreview = new LinkPreview('http://github.com');
$parsed = $linkPreview->getParsed();
foreach ($parsed as $parserName => $link) {
    echo $parserName . PHP_EOL . PHP_EOL;

    echo $link->getUrl() . PHP_EOL;
    echo $link->getRealUrl() . PHP_EOL;
    echo $link->getTitle() . PHP_EOL;
    echo $link->getDescription() . PHP_EOL;
    echo $link->getImage() . PHP_EOL;
}
```


**Output**

```
general

http://github.com
https://github.com/
GitHub Â· Build software better, together.
GitHub is the best place to build software together. Over 4 million people use GitHub to share code.
https://github.global.ssl.fastly.net/images/modules/open_graph/github-octocat.png
```

```php
$linkPreview = new LinkPreview('https://www.youtube.com/watch?v=8ZcmTl_1ER8');
$parsed = $linkPreview->getParsed();
foreach ($parsed as $parserName => $link) {
    echo $parserName . PHP_EOL . PHP_EOL;

    echo $link->getUrl() . PHP_EOL;
    echo $link->getRealUrl() . PHP_EOL;
    echo $link->getTitle() . PHP_EOL;
    echo $link->getDescription() . PHP_EOL;
    echo $link->getImage() . PHP_EOL;
    echo $link->getVideoId() . PHP_EOL;
    echo $link->getEmbedCode() . PHP_EOL;
}
```


**Output**

```
youtube

https://www.youtube.com/watch?v=8ZcmTl_1ER8
http://gdata.youtube.com/feeds/api/videos/8ZcmTl_1ER8?v=2&alt=jsonc
Epic sax guy 10 hours
I had to remove my original one so I reuploaded this with much better quality.
(If you want it sound like previous one, try setting quality to 240p)
Yeah, I know that video sucks compared to original but no can do :(
http://i1.ytimg.com/vi/8ZcmTl_1ER8/hqdefault.jpg
8ZcmTl_1ER8
<iframe id="ytplayer" type="text/html" width="640" height="390" src="http://www.youtube.com/embed/8ZcmTl_1ER8" frameborder="0"/>
```

## Todo
1. Add more unit tests
2. Update documentation
3. Add more parsers

## License

The MIT License (MIT)

Copyright (c) 2013 Tadas Juozapaitis <kasp3rito@gmail.com>

Permission is hereby granted, free of charge, to any person obtaining a copy of
this software and associated documentation files (the "Software"), to deal in
the Software without restriction, including without limitation the rights to
use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
the Software, and to permit persons to whom the Software is furnished to do so,
subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
