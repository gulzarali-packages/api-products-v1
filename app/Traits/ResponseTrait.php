<?php

  namespace App\Traits;

  trait ResponseTrait
  {
      public $resource_name='resource';
      public function resourceNotFind()
      {
        return json_encode([
          'message'=> $this->resource_name.' Not Found'
        ]);
      }
      public function resourceStored($resource)
      {
        return json_encode([
          'message'=> $this->resource_name.' created',
          'details'=> [$resource]
        ]);
      }
      public function resourceUpdated($resource)
      {
        return json_encode([
          'message'=> $this->resource_name.' updated',
          'details'=> [$resource]
        ]);
      }
      public function resourceDeleted($resource)
      {
        return json_encode([
          'message'=> $this->resource_name.' deleted',
          'details'=> [$resource]
        ]);
      }
  }
