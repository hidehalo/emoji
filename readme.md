#Feature
1. detected emoji only
2. replace emoji only
3. store emoji as HTML numeric character (it's meand you do not have to set MySql encode to utf8mb4)

#Use
###surport HTML only now, see the test.php

```
require_once "Emoji.php";
require_once "Adapter/HtmlAdapter.php";
$em = new Emoji(new HtmlAdpater());
$text = "Emoji：我来组成头部🌒🌏🍃🇬🇧我来组成尾巴！@#$%";
$t = $em->replace($text,'dec');
print_r($t);
```
