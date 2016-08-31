<?php
abstract class Adapter
{
    protected $pattern;
    abstract protected function unichr($u);
    abstract protected function entities($string);
    public function getPattern()
    {
        return $this->pattern;
    }
}