LinkPreview
===========

Link preview library for PHP

# Usage

```php
$linkPreview = new LinkPreview('http://github.com');
$parsed = $link->getParsed();
foreach ($parsed as $parserName => $link) {
    echo $link->getUrl() . PHP_EOL;
    echo $link->getRealUrl() . PHP_EOL;
    echo $link->getTitle() . PHP_EOL;
    echo $link->getDescription() . PHP_EOL;
    echo $link->getImage() . PHP_EOL;
}
```

# Todo
1. Add more comments
2. Add more unit tests
3. Think about what to do
