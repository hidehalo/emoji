<?php
/**
 * Created by PhpStorm.
 * User: TianChen
 * Date: 16/12/23
 * Time: 00:22
 */

namespace Hidehalo\Emoji\Features;


interface ParserInterface
{
    /**
     * character of unicode symbol convert to unicode value
     * @param string $symbol
     * @param integer $bytes
     * @return integer $ascii
     */
    function getUnicode($symbol,$bytes = 1);

    /**
     * get Unicode symbol bytes number
     * @param string $symbol
     * @return integer $bytesNumber
     */
    function getBytesNumber($symbol);

    /**
     * @param $symbol
     */
    function getBytes($symbol);

    function getSymbol($unicode);
}