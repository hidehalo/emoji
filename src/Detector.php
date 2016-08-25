<?php 
interface Detector
{
    /*  @link{wiki}:
     *  [https://en.wikipedia.org/wiki/Numeric_character_reference
     *  https://en.wikipedia.org/wiki/Unicode#Upluslink
     *  https://en.wikipedia.org/wiki/Unicode_and_HTML#Numeric_character_references
     *  http://stackoverflow.com/questions/35080211/display-u1f603-emoji-icon-in-web-page/35084602#35084602
     *  http://unicode.org/reports/tr51/index.html#Proposals
     *  http://www.unicode.org/Public/emoji/3.0//emoji-data.txt
     *  http://www.unicode.org/reports/tr51/
     *  https://en.wikipedia.org/wiki/Emoji]
     *  @tool:http://www.regexr.com/
     */
    //todo parse emoji unicode only
    function detect($emoji);
    //todo replace emoji unicode to numerical character Hexadecimal in markup
    function toHex();
    //todo not yet
    function toBlob();
    //todo replace emoji unicode to numerical character Hexadecimal in markup
    function toDec();
    //todo replace emoji symbol to Unicode character
    function toUnicode();
    //todo replace emoji Unicode to symbol
    function toSymbol();
}
