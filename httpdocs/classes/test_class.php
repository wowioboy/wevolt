<?php
// Declare a simple class
class TestClass
{
   public $foo;

   public function __construct($foo) {
       $this->foo = 'hello';
   }

 
}

$class = new TestClass();
echo $class;
?>