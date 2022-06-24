<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeValueTranslation extends Model
{
  protected $fillable = ['name', 'lang', 'attribute_value_id'];

  public function attribute_value(){
    return $this->belongsTo(AttributeValue::class);
  }
}
