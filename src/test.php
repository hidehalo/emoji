<?php
require_once "EmojiDetector.php";
$ed = new EmojiDetector();
$text = "大王派我来查Emoji:🌒🌏🍃🇬🇧!?1234567890-=+\\|/?\\";
//var_dump($text);
print '<br/>';
$format = "ncrdec";
//var_dump($ed->replace($text,$format));
print_r($ed->detect($text));
print_r('<br/>');
print_r($ed->detect("\u{1F466}"));
echo "\u{1F466}";