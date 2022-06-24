<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;

class Attribute extends Model
{
    protected $with = ['attribute_translations'];

    public function getTranslation($field = '', $lang = false){
		$lang = $lang == false ? App::getLocale() : $lang;
		$attribute_translation = $this->hasMany(AttributeTranslation::class)->where('lang', $lang)->first();
		return $attribute_translation != null ? $attribute_translation->$field : $this->$field;
    }

    public function attribute_translations(){
    	return $this->hasMany(AttributeTranslation::class);
    }

    public function attribute_values(){
        return $this->hasmany(AttributeValue::class);
    }
    public function product_values($product_id){
        return $this->hasmany(AttributeValue::class)->where('product_id',$product_id);
    }

}
