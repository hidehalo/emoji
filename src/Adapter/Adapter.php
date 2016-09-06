<?php
abstract class Adapter
{
    protected $pattern;

    abstract protected function entities($string);   
//    protected function unichr($u) {
//        $unichar = mb_convert_encoding('&#'.$u.';','UTF-8','HTML-ENTITIES');
//        return $unichar;
//    }
    protected function unichr($i) 
    {
        return iconv('UCS-4LE', 'UTF-8', pack('V', $i));
    }
    public function getPattern()
    {
        return $this->pattern;
    }
}