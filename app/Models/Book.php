<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model {
  protected $fillable = [ 'title', 'price', 'image' ];

  public function update(Array $attributes = array(), Array $options = array()) {
    foreach($attributes as $key => $value){
      if(!is_null($value)) $this->{$key} = $value;
    }

    return $this->save();
  }
}
