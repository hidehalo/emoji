<meta charset="utf-8">
<?php
require_once "Emoji.php";
require_once "Adapter/HtmlAdapter.php";
$em = new Emoji(new HtmlAdpater());
$text = "Emoji：我来组成头部🌒🌏🍃🇬🇧我来组成尾巴！@#$%";
$t = $em->replace($text,'dec');
print_r($t);