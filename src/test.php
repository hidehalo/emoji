<?php
require "Emoji.php";
require_once "/Adapter/HtmlAdapter.php";
use Hidehalo\String\Emoji\HtmlAdapter;
use Hidehalo\String\Emoji;
try{
$emoji = new Emoji(new HtmlAdapter());
$str = "无敌:😍";
$str = $emoji->replace($str,'dec');
}catch(Exception $e){
    print $e->getMessage();
}
print $str;