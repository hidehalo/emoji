<?php 
abstract Adapter implements Detector,EmojiUnicode
{
    function detect($emoji){ return '';}
}