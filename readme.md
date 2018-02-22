[![Build Status](https://travis-ci.org/hidehalo/emoji.svg)](https://travis-ci.org/hidehalo/emoji)

# Why
if you do not want to set MySQL Server default character encode and connections of MySQL and etc,or your MySQL do not support utf8mb4 character,you could think about use this library :)
# Features
1. Detected emoji symbols only,and parse to utf-8 bytes or unicode decimal value
2. Replace emoji symbols to other texts and turn it back
3. WYSWYG(What's Your See,What's Your Get)
4. Zero dependence
5. Lightweight

# Install
- composer require hidehalo/emoji

# How to Use

```php
#use composer autoloader
require_once vendor/autoload.php;
use Hidehalo\Emoji\Parser;

#if you want to parse emojis for a text
$parser = new Parser();
$parser->parse($contents);

#if you want to replace those emoji symbols to ohter marked texts and has ability to turn those back,it has a built-in Protocol and Converter could do this
use Hidehalo\Emoji\Converter;

$converter = new Converter($parser);
$encoded = $converter->encode($raw);
$decoded = $converter->decode($encoded);
# and $decoded will equals $raw,it is real very simple
```

# License

The MIT License (MIT)

Copyright (c) Fri Sep 30 2016 hidehao

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
IN AN ACTION OF CONTRACT, TORTOR OTHERWISE, ARISING FROM, OUT OF OR IN
CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

