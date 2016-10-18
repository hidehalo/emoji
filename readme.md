#Feature
1. detected emoji char only
2. convert emoji charracter to HTML code(it's meand you do not need to set MySql connect and table character set to utf8mb4)
3. WYSWYG(What's Your See,What's Your Get)
4. Zero Dependence
5. Lightweight

#Install
- composer require hidehalo/emoji

#Use
##see the test.php

```
<?php
require "Emoji.php";
require_once __DIR__."/Adapter/HtmlAdapter.php";
use Hidehalo\String\Emoji\HtmlAdapter;
use Hidehalo\String\Emoji;
try {
    $emoji = new Emoji(new HtmlAdapter());
    $str = "无敌abc648@XXX.c0m:😍";
    //convert emoji characters to html code
    $strdec = $emoji->replace($str,'dec');
    $strhex = $emoji->replace($str,'hex');
    $strclean = $emoji->replace($str,'clean');
} catch(Exception $e) {
    print $e->getMessage();
}
print "origin: ".$str.PHP_EOL;
print "convert emoji to decimal html code:".$strdec.PHP_EOL;
print "convert emoji to heximal html code".$strhex.PHP_EOL;
print "no emoji:".$strclean.PHP_EOL;

```

### result on html:
- oriigin: 无敌abc648@XXX.c0m:😍
- convert emoji to decimal html code:无敌abc648@XXX.c0m:&#128525;
- convert emoji to heximal html code无敌abc648@XXX.c0m:&#x1f60d;
- no emoji:无敌abc648@XXX.c0m:

### result on cli:
```
origin: 无敌abc648@XXX.c0m:😍
convert emoji to decimal html code:无敌abc648@XXX.c0m:&#128525;
convert emoji to heximal html code无敌abc648@XXX.c0m:&#x1f60d;
no emoji:无敌abc648@XXX.c0m:

```

#License

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

