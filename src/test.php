<meta charset="utf-8">
<?php
require_once "Emoji.php";
require_once "HtmlAdapter.php";
$em = new Emoji(new HtmlAdpater());
$htmlAdapter = new HtmlAdpater();
$htmlAdapter->test();
$text = "大王派我来查Emoji:🌒🌏🍃🇬🇧!?1234567890-=+\\|/?\\";
$match = $em->detect($text);
print_r($match);