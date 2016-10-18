<?php 
namespace Hidehalo\String;
require_once __DIR__.'/Adapter/Adapter.php';
use Hidehalo\String\Emoji\Adapter;

class Emoji
{
    private $adapter;
    public function __construct(Adapter $adpter)
    {
        $this->adapter = $adpter;
    }
    public function detect($text)
    {
        return $this->adapter->detect($text);
    }
    
    public function replace($text,$format=null)
    {
        return $this->adapter->replace($text,$format);
    }

}