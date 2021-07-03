<?php

  namespace App\Traits;

  trait FileTrait
  {
      function cleanFileName($name){
        $name = str_replace(' ', '_', $name);
        return preg_replace('/[^A-Za-z0-9\-_]/', '', $name);
      }
  }

  ?>