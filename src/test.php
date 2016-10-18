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