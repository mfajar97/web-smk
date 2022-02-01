<?php 

namespace JustFajar\Belajar\PHP\MVC\App {

  function header(string $value){
    echo $value;
  }

}

namespace JustFajar\Belajar\PHP\MVC\Service {

  function setcookie(string $name, string $value){
    echo "$name: $value";
  }

}

