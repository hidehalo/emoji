<? php
class abstract Adapter 
{
    private $pattern;
    public function getPattern()
    {
        return $this->pattern;
    }
    abstract function unichr($u);
    abstract function entitied($string);
}