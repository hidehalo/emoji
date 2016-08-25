<?php
//need autoload all adapter
 class Emoji
 {
     private $adapter;
     //traits? no!
     public function getAdapter(Adapter $adapter)
     {
         $this->adapter = $adapter;
         return $this;
     }
     
 }