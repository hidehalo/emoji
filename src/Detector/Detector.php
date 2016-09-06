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
     *  https://en.wikipedia.org/wiki/Emoji
     *  http://stackoverflow.com/questions/34956163/htmlentites-not-working-for-emoji
     *  http://stackoverflow.com/questions/10564068/php-find-emoji-update-existing-code]
     */
    //todo parse and replace emoji unicode only
    function detect($text);
    function replace($text,$format);
}
