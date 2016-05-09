# Link Preview 
[![Build Status](https://travis-ci.org/dusterio/link-preview.svg)](https://travis-ci.org/dusterio/link-preview)
[![Code Climate](https://codeclimate.com/github/dusterio/link-preview/badges/gpa.svg)](https://codeclimate.com/github/dusterio/link-preview/badges)
[![Test Coverage](https://codeclimate.com/github/dusterio/link-preview/badges/coverage.svg)](https://codeclimate.com/github/dusterio/link-preview/badges)
[![Total Downloads](https://poser.pugx.org/dusterio/link-preview/d/total.svg)](https://packagist.org/packages/dusterio/link-preview)
[![Latest Stable Version](https://poser.pugx.org/dusterio/link-preview/v/stable.svg)](https://packagist.org/packages/dusterio/link-preview)
[![Latest Unstable Version](https://poser.pugx.org/dusterio/link-preview/v/unstable.svg)](https://packagist.org/packages/dusterio/link-preview)
[![License](https://poser.pugx.org/dusterio/link-preview/license.svg)](https://packagist.org/packages/dusterio/link-preview)

A PHP class that consumes an HTTP(S) link and returns an array of preview information. Think of Facebook sharing -
whenever you paste a link, it goes to specified page and fetches some details.

Initially based on [kasp3r/link-preview](https://github.com/kasp3r/link-preview) that seems to be abandoned.

Includes integrations with: Laravel 5

## Dependencies

* PHP >= 5.5
* Guzzle >= 6.1
* Symfony DomCrawler >= 3.0

## Installation via Composer

To install simply run:

```
composer require dusterio/link-preview
```

Or add it to `composer.json` manually:

```json
{
    "require": {
        "dusterio/link-preview": "~1.2"
    }
}
```

## Direct usage

```php
use Dusterio\LinkPreview\Client;

$previewClient = new Client('https://www.boogiecall.com/en/Melbourne');

// Get previews from all available parsers
$previews = $previewClient->getPreviews();

// Get a preview from specific parser
$preview = $previewClient->getPreview('general');

// Convert output to array
$preview = $preview->toArray();
```

**Output**

```
array(4) {
  ["cover"]=>
  string(94) "https://cdn.boogiecall.com/media/images/872398e3d9598c494a2bed72268bf018_1440575488_7314_s.jpg"
  ["images"]=>
  array(8) {
    [0]=>
    string(94) "https://cdn.boogiecall.com/media/images/872398e3d9598c494a2bed72268bf018_1440575488_7314_s.jpg"
    [1]=>
    string(94) "https://cdn.boogiecall.com/media/images/b18970cd4c808f4dcdf7c319779ab9c6_1457347623_2419_s.jpg"
  }
  ["title"]=>
  string(44) "Events, parties & live concerts in Melbourne"
  ["description"]=>
  string(107) "List of events in Melbourne. Nightlife, best parties and concerts in Melbourne, event listings and reviews."
}
```

## Timeouts and errors

```php
// Default connect timeout is 5 seconds, you can change it to anything you want
$previewClient->getParser('general')->getReader()->config(['connect_timeout' => 3.14]);

// Default maximum redirect count is 10, but you can change it too
$previewClient->getParser('general')->getReader()->config(['allow_redirects' => ['max' => 10]]);

// If there is a network error (DNS, connect, etc), we throw ConnectionErrorException
try {
    $previews = $previewClient->getPreviews();
} catch (\Dusterio\LinkPreview\Exceptions\ConnectionErrorException $e) {
    echo "Oh no!";
}
```

### YouTube example

```php
use Dusterio\LinkPreview\Client;

$previewClient = new LinkPreview('https://www.youtube.com/watch?v=v1uKhwN6FtA');

// Only parse YouTube specific information
$preview = $previewClient->getPreview('youtube');

var_dump($preview->toArray());
```

**Output**

```
array(2) {
  ["embed"]=>
  string(128) "<iframe id="ytplayer" type="text/html" width="640" height="390" src="http://www.youtube.com/embed/v1uKhwN6FtA" frameborder="0"/>"
  ["id"]=>
  string(11) "v1uKhwN6FtA"
}
```

### Usage in Laravel 5

```php
// Add in your config/app.php

'providers' => [
    '...',
    'Dusterio\LinkPreview\Integrations\LaravelServiceProvider',
];

'aliases' => [
    '...',
    'Preview'    => 'Dusterio\LinkPreview\Integrations\LaravelFacade',
];

// Set target url
Preview::setUrl('https://www.boogiecall.com');

// Get parsed HTML tags as a plain array
Preview::getPreview('general')->toArray();

// In case of redirects, see what the final url was
echo Preview::getUrl();
```

## Todo

1. Add more unit and integration tests
2. Update documentation
3. Add more parsers

## License

The MIT License (MIT)
Copyright (c) 2016 Denis Mysenko

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
