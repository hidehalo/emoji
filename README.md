# Emoji

[![Build Status](https://travis-ci.org/hidehalo/emoji.svg)](https://travis-ci.org/hidehalo/emoji)

If you want help with parse and store emoji symbol characters,you could think about use this library :)

## Features

1. Detected emoji symbols only
2. Replace emoji symbols to other texts and turn it back
3. Zero dependence
4. Lightweight and fast

## Install

```bash
$composer require hidehalo/emoji
```

## Usage

### Parser

```php
require vendor/autoload.php;
use Hidehalo\Emoji\Parser;

$parser = new Parser();
$parser->parse($contents);
```

### Converter

```php
# if you want to replace those emoji symbols to ohter marked texts 
# and has ability to turn those back,
# it has a built-in Protocol and Converter could do this
# and $decoded will equals $raw,it is real very simple

use Hidehalo\Emoji\Converter;

$converter = new Converter($parser);
$encoded = $converter->encode($raw);
$decoded = $converter->decode($encoded);

# filter emojis
use Hidehalo\Emoji\Protocol\Filter;

$clean = $converter->encode($raw, new Filter);
```

### Custom protocol

Maybe you want to impl your custom convert protocol,you can make it through implements [ProtocolInterface](src/Protocol/ProtocolInterface.php)

```php


use Hidehalo\Emoji\Protocol\ProtocolInterface as Protocol;
use Hidehalo\Emoji\Protocol\PatternAwareTrait;

class CustomProto implments Protocol
{
    use PatternAwareTrait;

    protected $format = "FORMAT";
    protected $pattern = "/FORMAT/";

    public function encode($contents)
    {
        //your impls
    }

    public function decode($contents)
    {
        //your impls
    }
}
$customProto = new CustomProto;
$customEncoded = $converter->encode($raw, $customProto);
$customDecoded = $converter->decode($customDecoded, $customProto);
```

## Testing

```bash
$./vendor/bin/phpunit
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.